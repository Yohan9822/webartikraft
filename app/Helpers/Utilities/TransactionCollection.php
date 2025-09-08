<?php

namespace App\Helpers\Utilities;

use App\Constants\TransactionType;

/**
 * Transaction Collection Global
 * 
 * @method int getId(mixed $default = null)
 * @method string getCode(mixed $default = null)
 * @method string getRemark(mixed $default = null)
 * @method string getDate(mixed $default = null)
 * @method int getTransTypeId(mixed $default = null)
 * @method string getTransType(mixed $default = null)
 * @method int getUserId(mixed $default = null)
 * @method int getCompanyId(mixed $default = null)
 * @method int getStoreId(mixed $default = null)
 * @method int getWarehouseId(mixed $default = null)
 */
class TransactionCollection
{
    use StaticCollection;

    /**
     * Relation of transaction
     *
     * @var TransactionCollection
     */
    protected $relation;

    /**
     * Set relation of transaction
     *
     * @param TransactionCollection $relation
     * @return TransactionCollection
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;

        return $this;
    }

    public function getRelation()
    {
        return is_null($this->relation) ? $this : $this->relation;
    }

    public static function goodsReceipt($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::goodsReceiptId,
            'transtype' => TransactionType::goodsReceipt,
            'typeid' => TransactionType::goodsReceiptId,
            'type' => TransactionType::goodsReceipt,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => $storeid ?? getSession('storeid'),
        ]);
    }

    public static function cashBank($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::cashBankId,
            'transtype' => TransactionType::cashBank,
            'typeid' => TransactionType::cashBankId,
            'type' => TransactionType::cashBank,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => $storeid ?? getSession('storeid'),
        ]);
    }

    public static function purchaseOrder($id, $code = null, $date = null, $remark = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::purchaseOrderId,
            'transtype' => TransactionType::purchaseOrder,
            'typeid' => TransactionType::purchaseOrderId,
            'type' => TransactionType::purchaseOrder,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => getSession('storeid'),
        ]);
    }

    public static function dpAccountPayment($id, $code = null, $date = null, $remark = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::dpAccountPaymentId,
            'transtype' => TransactionType::dpAccountPayment,
            'typeid' => TransactionType::dpAccountPaymentId,
            'type' => TransactionType::dpAccountPayment,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => getSession('storeid'),
        ]);
    }

    public static function dpAccountReceipt($id, $code = null, $date = null, $remark = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::dpAccountReceiptId,
            'transtype' => TransactionType::dpAccountReceipt,
            'typeid' => TransactionType::dpAccountReceiptId,
            'type' => TransactionType::dpAccountReceipt,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => getSession('storeid'),
        ]);
    }

    public static function deliveryOrder($id, $code = null, $date = null, $remark = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::deliveryOrderId,
            'transtype' => TransactionType::deliveryOrder,
            'typeid' => TransactionType::deliveryOrderId,
            'type' => TransactionType::deliveryOrder,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => getSession('storeid'),
        ]);
    }

    public static function invoiceAr($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::invoiceId,
            'transtype' => TransactionType::invoice,
            'typeid' => TransactionType::invoiceId,
            'type' => TransactionType::invoice,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => is_null($storeid) ? getSession('storeid') : $storeid,
        ]);
    }

    public static function paymentAr($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::paymentArId,
            'transtype' => TransactionType::paymentAr,
            'typeid' => TransactionType::paymentArId,
            'type' => TransactionType::paymentAr,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => is_null($storeid) ? getSession('storeid') : $storeid,
        ]);
    }

    public static function invoiceAp($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::invoiceApId,
            'transtype' => TransactionType::invoiceAp,
            'typeid' => TransactionType::invoiceApId,
            'type' => TransactionType::invoiceAp,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => $storeid ?? getSession('storeid'),
        ]);
    }

    public static function paymentAp($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::paymentApId,
            'transtype' => TransactionType::paymentAp,
            'typeid' => TransactionType::paymentApId,
            'type' => TransactionType::paymentAp,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => $storeid ?? getSession('storeid'),
        ]);
    }

    public static function pointOfSales($id, $code = null, $date = null, $remark = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::pointOfSalesId,
            'transtype' => TransactionType::pointOfSales,
            'typeid' => TransactionType::pointOfSalesId,
            'type' => TransactionType::pointOfSales,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => getSession('storeid'),
        ]);
    }

    public static function paymentPos($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::paymentArId,
            'transtype' => TransactionType::paymentAr,
            'typeid' => TransactionType::paymentArId,
            'type' => TransactionType::paymentAr,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => is_null($storeid) ? getSession('storeid') : $storeid,
        ]);
    }

    public static function salesRetail($id, $code = null, $date = null, $remark = null, $storeid = null, $warehouseid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::salesRetailId,
            'transtype' => TransactionType::salesRetail,
            'typeid' => TransactionType::salesRetailId,
            'type' => TransactionType::salesRetail,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => $storeid ?? getSession('storeid'),
            'warehouseid' => $warehouseid ?? getSession('warehouseid')
        ]);
    }

    public static function franchiseGoodsReceipt($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::franchiseGoodsReceiptId,
            'transtype' => TransactionType::franchiseGoodsReceipt,
            'typeid' => TransactionType::franchiseGoodsReceiptId,
            'type' => TransactionType::franchiseGoodsReceipt,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => is_null($storeid) ? getSession('storeid') : $storeid,
        ]);
    }

    public static function saldoAwal($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::saldoAwalId,
            'transtype' => TransactionType::saldoAwal,
            'typeid' => TransactionType::saldoAwalId,
            'type' => TransactionType::saldoAwal,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => is_null($storeid) ? getSession('storeid') : $storeid,
        ]);
    }

    public static function stockConversion($id, $code = null, $date = null, $remark = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::stockConversionId,
            'transtype' => TransactionType::stockConversion,
            'typeid' => TransactionType::stockConversionId,
            'type' => TransactionType::stockConversion,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => getSession('storeid'),
        ]);
    }

    public static function stockAdjustment($id, $code = null, $date = null, $remark = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::stockAdjustmentId,
            'transtype' => TransactionType::stockAdjustment,
            'typeid' => TransactionType::stockAdjustmentId,
            'type' => TransactionType::stockAdjustment,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => getSession('storeid'),
        ]);
    }

    public static function pettyCash($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::pettyCashId,
            'transtype' => TransactionType::pettyCash,
            'typeid' => TransactionType::pettyCashId,
            'type' => TransactionType::pettyCash,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => $storeid ?? getSession('storeid'),
        ]);
    }

    public static function picking($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::pickingId,
            'transtype' => TransactionType::picking,
            'typeid' => TransactionType::pickingId,
            'type' => TransactionType::picking,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => $storeid ?? getSession('storeid'),
        ]);
    }

    public static function returnPos($id, $code = null, $date = null, $remark = null, $storeid = null)
    {
        return new TransactionCollection([
            'id' => $id,
            'code' => $code,
            'date' => $date,
            'remark' => $remark,
            'transtypeid' => TransactionType::posReturnId,
            'transtype' => TransactionType::posReturn,
            'typeid' => TransactionType::posReturnId,
            'type' => TransactionType::posReturn,
            'userid' => getSession('userid'),
            'companyid' => getSession('companyid'),
            'storeid' => $storeid ?? getSession('storeid'),
        ]);
    }
}
