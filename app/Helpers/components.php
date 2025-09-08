<?php

class ButtonComponents
{

    static public function editModalDataTable($title, $url, $options = [], $icon = "bx bx-edit-alt")
    {
        if (!getAccess(AccessCode::update)) return '';

        $modalSize = isset($options['modalSize']) ? $options['modalSize'] : 'modal-lg';
        $btnStyle = isset($options['class']) ? $options['class'] : 'btn-warning';
        $hyperlink = isset($options['hyperlink']) ? $options['hyperlink'] : false;
        $data = isset($options['data']) ? $options['data'] : [];
        $data = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($data));
        $data = preg_replace('/\"/', "'", $data);

        $visibility = isset($options['visibility']) ? $options['visibility'] : true;

        if (!$visibility) return '';

        if ($hyperlink) return "<a 
            href=\"$url\"
            class=\"btn btn-icon btn-xs $btnStyle\">
            <i class=\"bx bx-edit-alt\"></i>
        </a>";

        return "<button 
            type=\"button\" 
            class=\"btn btn-icon btn-xs $btnStyle\" 
            onclick=\"modalForm('$title', '$modalSize', '$url', $data)\">
            <i class=\"$icon\"></i>
        </button>";
    }

    static public function deleteModalDataTable($title, $url, $options = [])
    {
        if (!getAccess(AccessCode::delete)) return '';

        $id = isset($options['id']) ? $options['id'] : '';
        $pageType = isset($options['pagetype']) ? $options['pagetype'] : 'table';
        $btnStyle = isset($options['class']) ? $options['class'] : 'btn-danger';

        $visibility = isset($options['visibility']) ? $options['visibility'] : true;

        if (!$visibility) return '';

        $actionDelete = "modalDelete('$title', {link: '$url', id: '$id', pagetype: '$pageType'})";

        return "<button 
            type=\"button\" 
            class=\"btn btn-icon btn-xs $btnStyle margin-l-2\" 
            onclick=\"$actionDelete\">
            <i class=\"bx bx-trash\"></i>
        </button>";
    }

    static public function historyDataTable($title, $ref1, $ref2 = [], $options = [])
    {
        if (!getAccess(AccessCode::history)) return '';

        $url = isset($options['url']) ? $options['url'] : getURL('logtable/show-history');
        $modalSize = isset($options['modalSize']) ? $options['modalSize'] : 'modal-xl';
        $btnStyle = isset($options['class']) ? $options['class'] : 'btn-primary';
        $hyperlink = isset($options['hyperlink']) ? $options['hyperlink'] : false;
        $data = isset($options['data']) ? $options['data'] : [];
        $data['ref1'] = $ref1;
        $data['ref2'] = $ref2;

        $data = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($data));
        $data = preg_replace('/\"/', "'", $data);

        if ($hyperlink) return "<a 
            href=\"$url\"
            class=\"btn btn-icon btn-xs $btnStyle\">
            <i class=\"bx bx-edit-alt\"></i>
        </a>";

        $actionEdit = "modalForm('$title', '$modalSize', '$url', $data)";

        return "<button 
            type=\"button\" 
            class=\"btn btn-icon btn-xs $btnStyle\" 
            onclick=\"$actionEdit\">
            <i class=\"bx bx-history\"></i>
        </button>";
    }

    static public function modalDataTable($icon, $title, $url, $options = [])
    {

        $modalSize = isset($options['modalSize']) ? $options['modalSize'] : 'modal-lg';
        $btnStyle = isset($options['class']) ? $options['class'] : 'btn-warning';
        $config = isset($options['config']) ? $options['config'] : '{}';
        $visibility = isset($options['visibility']) ? $options['visibility'] : true;
        $hyperlink = isset($options['hyperlink']) ? $options['hyperlink'] : false;
        $data = isset($options['data']) ? $options['data'] : [];
        $data = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($data));
        $data = preg_replace('/\"/', "'", $data);

        $attributes = isset($options['attributes']) ? $options['attributes'] : [];

        if (!isset($attributes['onclick']))
            $attributes['onclick'] = "modalForm('$title', '$modalSize', '$url', $data, $config)";

        $otherAttributes = implode(
            " ",
            array_map(
                function ($value, $key) {
                    return "$key=\"$value\"";
                },
                $attributes,
                array_keys($attributes)
            )
        );

        if (!$visibility) return '';

        if ($hyperlink) return "<a 
            href=\"$url\"
            class=\"btn btn-icon btn-xs $btnStyle\">
            $icon
        </a>";

        return "<button 
            $otherAttributes
            type=\"button\" 
            class=\"btn btn-icon btn-xs $btnStyle\">
            $icon
        </button>";
    }

    static public function hyperlinkDataTable($icon, $title, $url, $options = [])
    {
        $btnStyle = isset($options['class']) ? $options['class'] : 'btn-warning';
        $visibility = isset($options['visibility']) ? $options['visibility'] : true;

        $attributes = isset($options['attributes']) ? $options['attributes'] : [];

        $otherAttributes = implode(
            " ",
            array_map(
                function ($value, $key) {
                    return "$key=\"$value\"";
                },
                $attributes,
                array_keys($attributes)
            )
        );

        if (!$visibility) return '';

        return "<a 
            href=\"$url\"
            class=\"btn btn-icon btn-xs $btnStyle\"
            $otherAttributes>
            $icon
        </a>";
    }

    static public function buttonDataTable($icon, $title, $url, $options = [])
    {

        $btnStyle = isset($options['class']) ? $options['class'] : 'btn-warning';
        $visibility = isset($options['visibility']) ? $options['visibility'] : true;

        $attributes = isset($options['attributes']) ? $options['attributes'] : [];

        $otherAttributes = implode(
            " ",
            array_map(
                function ($value, $key) {
                    return "$key=\"$value\"";
                },
                $attributes,
                array_keys($attributes)
            )
        );

        if (!$visibility) return '';

        return "<button 
            $otherAttributes
            type=\"button\" 
            class=\"btn btn-icon btn-xs $btnStyle\">
            $icon
        </button>";
    }
}

class FormComponents
{
    static public function checkbox($id, $options = [])
    {
        $label = isset($options['label']) ? $options['label'] : null;
        $desc = isset($options['desc']) ? $options['desc'] : null;
        $checked = isset($options['checked']) ? ($options['checked'] ? 'checked' : '') : null;
        $name = isset($options['name']) ? $options['name'] : null;
        $visibility = isset($options['visibility']) ? $options['visibility'] : true;
        $visibilityText = isset($options['visibilityText']) ? $options['visibilityText'] : '';

        $attributes = isset($options['attributes']) ? $options['attributes'] : [];

        $value = isset($options['value']) ? $options['value'] : '';
        if ($value != '') $attributes['value'] = $value;

        $onclick = isset($options['onclick']) ? $options['onclick'] : '';
        if ($onclick != '') $attributes['onclick'] = $onclick;

        if (!is_null($name)) $attributes['name'] = $name;

        $otherAttributes = implode(
            " ",
            array_map(
                function ($value, $key) {
                    return "$key=\"$value\"";
                },
                $attributes,
                array_keys($attributes)
            )
        );

        if (!$visibility) return $visibilityText;

        if (!is_null($label))
            return "<div class=\"form-check\">
                <div class='dflex align-center'>
                    <input type=\"checkbox\" class=\"form-check-input\" id=\"$id-check\" $checked $otherAttributes>
                    <label for=\"$id-check\" class=\"form-check-label\">
                        <div class='dflex align-center fs-7'>$label " . (!is_null($desc) ? $desc : '') . "</div class='dflex align-center'>
                    </label>
                </div>
            </div>";

        return "<div class=\"text-center\">
            <input type=\"checkbox\" class=\"form-check-input\" id=\"$id-check\" $checked $otherAttributes>
        </div>";
    }

    static public function builder($name, $element, $options = [])
    {

        $attributes = isset($options['attributes']) ? $options['attributes'] : [];
        $attributes['data-toggle'] = $name;

        $otherAttributes = implode(
            " ",
            array_map(
                function ($value, $key) {
                    return "$key=\"$value\"";
                },
                $attributes,
                array_keys($attributes)
            )
        );

        return "<div class=\"form-editable\" $otherAttributes>$element</div>";
    }
}

class LabelComponents
{
    static public function released($released)
    {
        if ($released)
            return "<div class=\"dflex justify-center\">
                <div class=\"label label-warning\">
                    <i class=\"bx bxs-lock\"></i>
                    <span>Released</span>
                </div>
            </div>";

        return null;
    }
}
