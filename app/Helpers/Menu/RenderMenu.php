<?php

namespace App\Helpers\Menu;

class RenderMenu
{

    protected $menus = [];

    public function __construct($menus)
    {
        $this->menus = $menus;
    }

    /**
     * Get children of menu
     *
     * @param integer $menuid
     * @return Object[]
     */
    public function getChildren($menuid = 0)
    {
        $results = array_filter(
            $this->menus,
            function ($menu) use ($menuid) {
                return $menu->masterid == $menuid;
            }
        );

        usort($results, function ($a, $b) {
            return $a->sequence > $b->sequence;
        });

        return $results;
    }

    public function render($masterid = 0)
    {
        $HTMLMenu  = "<ul style=\"padding: 10px 20px;margin: 0;list-style: none;font-size: 14px\">";

        foreach ($this->getChildren($masterid) as $child) {

            $components = json_decode($child->components);

            usort($components, function ($a, $b) {
                return $a->componentid > $b->componentid;
            });

            $HTMLComponents = '<div style="width: calc(100% - 200px);" class="dflex">';
            foreach ($components as $component) {
                if (empty($component->componentcode) && empty($component->componentid)) continue;

                $attributeId = sprintf("%s.%s", $component->componentid, $child->menuid);
                $checked = !is_null($component->accessid) ? "checked" : "";

                $dataView = $component->componentname != 'VIEW' ? "data-view=\"$child->menuid\"" : "";

                $HTMLComponents .= "<div class=\"form-check margin-r-3\" style=\"margin-right: 15px!important;\">
                    <input 
                        class=\"form-check-input\" 
                        type=\"checkbox\"
                        data-toggle=\"access_group\" 
                        data-access-id=\"$component->accessid\" 
                        data-parent-id=\"$child->masterid\"
                        data-menu-id=\"$child->menuid\" 
                        data-component-name=\"$component->componentcode\"
                        data-component-id=\"$component->componentid\" 
                        data-label=\"Verbose\" 
                        data-icon=\"bx bx-check\" 
                        $dataView
                        id=\"$attributeId\" 
                        $checked
                    >
                    <label class=\"form-check-label dflex align-center\" for=\"$attributeId\">
                        $component->componentname
                    </label>
                </div>";
            }
            $HTMLComponents .= "</div>";


            $children = $this->getChildren($child->menuid);

            $HTMLChildren = "";
            if (count($children) > 0)
                $HTMLChildren = $this->render($child->menuid);

            $fontWeight = "normal!important";
            if (count($children) > 0) $fontWeight = "bold!important";

            $HTMLMenu .= "<li>
                <div class=\"dflex\">
                    <div style=\"width: 200px;font-weight: $fontWeight\">$child->menuname</div>
                    $HTMLComponents
                </div>
                $HTMLChildren
            </li>";
        }

        $HTMLMenu .= "</ul>";

        return $HTMLMenu;
    }
}
