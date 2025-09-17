<?php

use App\Helpers\DataTypeConfig;
use App\Helpers\Privileges\PrivilegesUser;
use App\Libraries\Config\BlueStickerConfig;
use App\Libraries\Config\XenditApiConfig;
use App\Libraries\Config\XenditConfig;
use App\Models\Cmsproduct;
use App\Models\CmsSlides;
use App\Models\Cmsupdates;
use App\Models\Master\Msmoduledt;
use App\Models\Master\Msmodulehd;
use App\Models\Transaction\Trorder;
use App\Models\Transaction\Trorderstatus;
use CodeIgniter\Files\File;

function getURL($param = "")
{
    return base_url($param);
}

function base_encode($text)
{
    $txt = $text;
    for ($n = 0; $n < 6; $n++) {
        $txt = base64_encode($txt);
    }
    return $txt;
}

function base_decode($text)
{
    $txt = $text;
    for ($n = 0; $n < 6; $n++) {
        $txt = base64_decode($txt);
    }
    return $txt;
}

function encrypting($teks = '')
{
    if ($teks == '') {
        return '';
    }
    $enkripsi = \Config\Services::encrypter();
    $base62 = new Tuupola\Base62;
    try {
        $result = $base62->encode($enkripsi->encrypt("$teks"));
    } catch (Exception $e) {
        $result = $teks;
    }
    return $result;
}

function decrypting($teks = '', $default = '')
{
    if ($teks == '') {
        return $default;
    }
    $enkripsi = \Config\Services::encrypter();
    $base62 = new Tuupola\Base62;
    try {
        $result = $enkripsi->decrypt($base62->decode($teks));
    } catch (Exception $e) {
        $result = $teks;
    }
    return $result;
}

function getSession($key = null)
{
    return session()->get($key);
}
function setSession($key, $value)
{
    return session()->set($key, $value);
}

function removeSession($key)
{
    return session()->remove($key);
}

function destroySession()
{
    return session()->destroy();
}

function dateFormat($date = null, $format = 'd M Y H:i:s', $interval = '')
{
    if (empty($date)) return '';

    $date = str_replace('/', '-', $date);

    return date($format, strtotime("$date $interval"));
}

function dbDate($date, $format = 'Y-m-d H:i:s')
{
    return dateFormat($date, $format);
}

function defaultTimestamp()
{
    return date('Y-m-d H:i:s');
}

function getAccess($code)
{
    $privileges = PrivilegesUser::instance();
    return $privileges->has($code);
}

function sessionMenu($link)
{
    return PrivilegesUser::setRoute($link);
}

function numericSearchQuery($query, $field, $data)
{
    if (empty($data)) return $query;

    return $query->orLike("TRIM(LOWER($field::text))", $data);
}

function booleanSearchQuery($query, $field, $data)
{
    if (empty($data)) return $query;

    return $query->orLike("TRIM(LOWER($field::text))", $data);
}

function dateSearchQuery($query, $field, $data)
{

    return $query->orLike("TO_CHAR($field, 'DD Mon YYYY')", dateFormat($data, 'd M Y'));
}

function parseFloat($value, $decimal = 2, $default = null)
{
    $value = trim($value);

    if ($value == '') return $default;

    return round(floatval($value), $decimal);
}

function currency($value, $decimal = 2, $decimal_separator = '.', $thousand_separator = ',')
{
    $value = parseFloat(trim($value));

    if ($value == '' || is_null($value)) return 0;

    return number_format($value, $decimal, $decimal_separator, $thousand_separator);
}

function parseCurrency($value, $decimal = 2, $decimal_separator = '.', $thousand_separator = ',', $symbol = 'Rp')
{
    return $symbol . currency($value, $decimal, $decimal_separator, $thousand_separator);
}

function htmlCurrency($value, $decimal = 2, $decimal_separator = '.', $thousand_separator = ',', $symbol = 'Rp')
{
    return "<div class=\"text-end fw-prebold\">" . parseCurrency($value) . "</div>";
}

function idrHtml($value, $decimal = 2, $decimal_separator = '.', $thousand_separator = ',', $symbol = 'Rp')
{
    return htmlCurrency($value, $decimal, $decimal_separator, $thousand_separator, $symbol);
}

function removeIdr($value)
{
    return floatval(str_replace(",", "", $value));
}

function app_config($code = null, $key = null, $default = null)
{
    $appConfig = AppsConfig::instance();
    return $appConfig->get($code, $key, $default);
}

/**
 * Data type configt
 *
 * @param string|null $code
 * @return DataTypeConfig
 */
function datatype_config($code = null)
{
    $typeCode = DataTypeConfig::instance();
    if (!is_null($code)) return $typeCode->find($code);

    return $typeCode;
}

function init_xendit()
{
    return XenditApiConfig::instance()->init();
}

function first_files_preview($json, $doctype = 'image')
{
    $blueSticker = BlueStickerConfig::instance();

    $files = files_preview($json, $doctype);

    $file = array_shift($files);

    if (is_null($file) && !is_null($blueSticker->getNoImage()[0]))
        return file_preview($blueSticker->getNoImage()[0]);

    return $file;
}

function files_preview($json, $doctype = 'image')
{
    $data = $json;
    if (!is_array($json)) {
        $data = json_decode($json ?? '[]');
        if (is_object($data)) {
            $data = [$data];
        }
    }

    $files = array_map(
        function ($file) use ($doctype) {
            return file_preview($file, $doctype);
        },
        $data
    );

    return $files;
}

function file_preview_arr($files, $index = null)
{
    if (!is_null($index)) return $files[$index];

    return array_shift($files);
}

function file_preview($file, $doctype = 'image')
{
    if (empty($file->directory) && empty($file->filename)) return null;

    if (is_object($file)) {
        $fileInfo = new File(WRITEPATH . DIRECTORY_SEPARATOR . $file->directory . DIRECTORY_SEPARATOR . $file->filename);
        $extension = $fileInfo->getExtension();

        if (in_array($extension, ['.png', '.svg', '.jpg', '.jpeg', '.gif'])) {
            return sprintf(
                "%s-%s/%s/preview/%s",
                getURL('api'),
                $doctype,
                preg_replace(
                    [
                        '/(\\\)|(\/)/'
                    ],
                    [
                        '-'
                    ],
                    $file->directory
                ),
                $file->filename
            );
        } else {
            return sprintf(
                "%s-%s/%s/preview/%s",
                getURL('api'),
                $doctype,
                preg_replace(
                    [
                        '/(\\\)|(\/)/'
                    ],
                    [
                        '-'
                    ],
                    $file->directory
                ),
                $file->filename
            );
        }
    }

    return $file;
}

function no_image()
{
    $blueSticker = BlueStickerConfig::instance();
    return first_files_preview($blueSticker->getNoImage());
}

// Customer
function cust_base_url($param = null)
{
    $blueSticker = BlueStickerConfig::instance();

    return $blueSticker->getCustomerUrl() . '/' . $param;
}

function cust_files_preview($json, $index = null, $doctype = 'image')
{
    $blueSticker = BlueStickerConfig::instance();

    $data = $json;
    if (!is_array($json)) $data = json_decode($json ?? '[]');

    $files = array_map(
        function ($file) use ($doctype) {
            return cust_file_preview($file, $doctype);
        },
        $data
    );

    if (!is_null($index)) return $files[$index];

    $file = array_shift($files);

    if (!empty($file)) return $file;

    if (empty($file) && isset($blueSticker->getNoImage()[0]))
        return cust_file_preview($blueSticker->getNoImage()[0]);

    return null;
}

function cust_no_image()
{
    $blueSticker = BlueStickerConfig::instance();
    return cust_files_preview($blueSticker->getNoImage());
}

function cust_file_preview($file, $doctype = 'image')
{
    $blueSticker = BlueStickerConfig::instance();

    if (is_object($file)) {
        if (!empty($file->mimetype)) {;
            if (preg_match('/image\/\w+/i', $file->mimetype)) {
                return sprintf(
                    "%s/%s/%s/preview/%s",
                    $blueSticker->getCustomerUrl(),
                    $doctype,
                    preg_replace(
                        [
                            '/(\\\)|(\/)/'
                        ],
                        [
                            '-'
                        ],
                        $file->directory
                    ),
                    $file->filename
                );
            }

            return null;
        } else {
            return sprintf(
                "%s/%s/%s/preview/%s",
                $blueSticker->getCustomerUrl(),
                $doctype,
                preg_replace(
                    [
                        '/(\\\)|(\/)/'
                    ],
                    [
                        '-'
                    ],
                    $file->directory
                ),
                $file->filename
            );
        }
    }

    return $file;
}

function isJson($string)
{
    if (empty($string)) return true;

    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

function generateSpkNumber()
{
    $db = db_connect();
    $date = date('Ymd');
    $prefix = 'SPK/' . date('Ymd') . '/';
    $number = 1;
    $spkNumber = '';

    do {
        $spkNumber = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);

        $exists = $db->table('transaction.trproduction')
            ->where('spknumber', $spkNumber)
            ->countAllResults();

        if ($exists == 0) {
            break;
        }

        $number++;
    } while (true);

    return $spkNumber;
}

function getTypeId($typename, $catname)
{
    $db = db_connect();

    $row = $db->table('master.sttype as st')
        ->join('master.stcategory as sc', 'sc.catid=st.catid')
        ->where("lower(sc.catname) like '%" . strtolower($catname) . "%'")->where("lower(st.typename) like '%" . strtolower($typename) . "%'");

    if (empty($row)) return null;

    return $row->get()->getRowObject();
}

function getTypeIdByCode($typecode, $catcode)
{
    $db = db_connect();

    $row = $db->table('master.sttype as st')
        ->join('master.stcategory as cat', 'cat.catid = st.catid')
        ->where('st.typecode', $typecode)
        ->where('cat.catcode', $catcode)
        ->get()
        ->getFirstRow();

    return ($row ?? (object) ['typeid' => null])->typeid;
}

function validate_dir($dir)
{
    if (!file_exists($dir)) mkdir($dir, 0777, true);
    return true;
}

function getCode($code, $date, $company)
{
    $modhd = new Msmodulehd();
    $moddt = new Msmoduledt();
    $get_header = $modhd->getByCode($code, $company);
    if (!$get_header) {
        return 404;
    }
    $periodtype = $get_header['periodtype'];
    $check_detail = $moddt->getDetail($get_header['id'], $date);
    if ($code == 'BATCH') {
        $check_detail = $moddt->getDetailBatch($get_header['id'], $date);
    }
    if ($check_detail) {
        $lastnumber = $check_detail['lastnumber'] + 1;
        if ($lastnumber >= $check_detail['warning']) {
            $limit = str_repeat(9, $check_detail['digit']);
            if ($lastnumber > $limit) {
                return 509;
            }
        }
        $moddt->edit([
            'lastnumber' => $lastnumber
        ], $check_detail['id']);
        return trim(generateCode($check_detail['formatnumber'], $date, $code, $lastnumber, $check_detail['digit']));
    } else {
        $warn = str_repeat(9, $get_header['digit']) - 9;
        $fromdate = "";
        $todate = "";
        $exp_date = explode('-', $date);
        if ($periodtype == 'Y') {
            $fromdate = date($exp_date[0] . '-1-1');
            $todate = date($exp_date[0] . '-12-t');
        } elseif ($periodtype == 'M') {
            $fromdate = date($exp_date[0] . '-' . $exp_date[1] . '-1');
            $todate = date($exp_date[0] . '-' . $exp_date[1] . '-t');
        } elseif ($periodtype == 'D') {
            $fromdate = formatDate('Y-m-d', $date);
            $todate = formatDate('Y-m-d', $date);
        }
        $data = [
            'headerid' => $get_header['id'],
            'formatnumber' => $get_header['formatnumber'],
            'digit' => $get_header['digit'],
            'lastnumber' => $get_header['nextnumber'],
            'warning' => $warn,
            'fromdate' => $fromdate,
            'todate' => $todate
        ];
        $moddt->store($data);
        return trim(generateCode($get_header['formatnumber'], $date, $code, $get_header['nextnumber'], $get_header['digit']));
    }
}

function generateCode($format, $date, $code, $lastnumber, $digit)
{
    $formatnumber = $format;
    $previewText = "";
    $text_schema = $formatnumber;
    $exp_sch = explode('||', $text_schema);
    $o = 0;
    foreach ($exp_sch as $sc) {
        $txt_preview = $sc;
        if ($sc == '{ date }') {
            $o++;
            $txt_preview = formatDate('Y-m-d', $date);
        } else if ($sc == '{ module }') {
            $o++;
            $txt_preview = $code;
        } else if ($sc == '{ day_alphabet }') {
            $o++;
            $txt_preview = formatDate('D', $date);
        } else if ($sc == '{ day }') {
            $o++;
            $txt_preview = formatDate('d', $date);
        } else if ($sc == '{ month_alphabet }') {
            $o++;
            $txt_preview = formatDate('M', $date);
        } else if ($sc == '{ month }') {
            $o++;
            $txt_preview = formatDate('m', $date);
        } else if ($sc == '{ year }') {
            $o++;
            $txt_preview = formatDate('Y', $date);
        } else if ($sc == '{ year2 }') {
            $o++;
            $txt_preview = formatDate('y', $date);
        } else if ($sc == '{ numbering }') {
            $o++;
            $txt_preview = str_pad($lastnumber, $digit, '0', STR_PAD_LEFT);
        }
        $previewText .= $txt_preview;
    }
    return $previewText;
}

function formatDate($format, $date = '')
{
    $d = date($format);
    if ($date != '') {
        $d = date($format, strtotime($date));
    }
    return $d;
}

function roundedTime($date, $format = 'H:i', $interval = 30)
{
    $myTime = new DateTime($date);

    // Get the current minutes
    $minutes = (int)$myTime->format('i');

    // Determine the correct 30-minute interval to round down to
    $roundedMinutes = ceil($minutes / $interval) * $interval;

    // Set the time to the calculated interval, and reset seconds to 0
    $myTime->setTime((int)$myTime->format('H'), $roundedMinutes, 0);

    return $myTime->format($format);
}

// function sendNotification($title, $message, $userid)
// {
//     $payload = json_encode([
//         'title' => $title,
//         'message' => $message
//     ]);

//     $ch = curl_init(getenv('urlSocket'));
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
//     curl_setopt($ch, CURLOPT_POST, true);

//     $response = curl_exec($ch);
//     curl_close($ch);
// }

function removeTrailingZero($value)
{
    if (is_numeric($value)) {
        if (floor($value) != $value) {
            return $value * 100;
        }
    }
    return $value;
}

function convertFormatDate($dateString, $fromFormat = 'd/m/Y', $toFormat = 'Y-m-d')
{
    $date_obj = DateTime::createFromFormat($fromFormat, $dateString);
    if ($date_obj === false) {
        return false;
    }
    return $date_obj->format($toFormat);
}

function generateHistoryOrder($orderid, $status, $notes = null)
{
    $statusOrder = new Trorderstatus();
    $orderModel = new Trorder();

    $rowOrder = $orderModel->find($orderid, 'order.id');
    if (!empty($rowOrder)) {
        $statusOrder->store([
            'orderid' => $orderid,
            'status' => $status,
            'notes' => $notes,
            'isactive' => true,
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => 1,
        ]);

        return true;
    } else {
        return false;
    }
}

function getSlideImage()
{
    $slider = new CmsSlides();

    $datas = $slider->getDataTable()->where('s.isactive is true')->get()->getResultObject();
    if (empty($datas)) return null;

    $dts = [];
    foreach ($datas as $dt) {
        $dt->payload = json_decode($dt->payload ?? '{}');

        $logos = files_preview($dt->payload->logo);
        $dt->payload->logo = array_shift($logos);

        $dts[] = [
            'image' => $dt->payload->logo,
            'text' => $dt->caption,
            'position' => $dt->captiontype
        ];
    }

    return $dts;
}

function getProducts()
{
    $product = new Cmsproduct();

    $datas = $product->getDataTable()->where('p.isactive is true')->get()->getResultObject();

    if (empty($datas)) return null;

    $dts = [];
    foreach ($datas as $dt) {
        $dt->payload = json_decode($dt->payload ?? '{}');

        $logos = files_preview($dt->payload->logo);
        $dt->payload->logo = array_shift($logos);

        $dts[] = [
            'image' => $dt->payload->logo,
            'category' => $dt->categoryname,
            'productname' => $dt->productname,
            'dimension' => $dt->dimension,
            'price' => currency($dt->price ?? 0)
        ];
    }

    return $dts;
}

function getUpdates()
{
    $updates = new Cmsupdates();

    $datas = $updates->getDataTable()->where('up.isactive is true')->get()->getResultObject();

    if (empty($datas)) return null;

    $dts = [];
    foreach ($datas as $dt) {
        $dt->payload = json_decode($dt->payload ?? '{}');

        $logos = files_preview($dt->payload->logo);
        $dt->payload->logo = array_shift($logos);

        $dts[] = [
            'image' => $dt->payload->logo,
            'caption' => $dt->caption,
            'date' => date('M d, Y', strtotime($dt->date)),
        ];
    }

    return $dts;
}
