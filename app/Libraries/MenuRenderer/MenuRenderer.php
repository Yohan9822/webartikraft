<?php

namespace App\Libraries\MenuRenderer;

use AccessCode;
use App\Helpers\Privileges\PrivilegesUser;
use App\Models\Msaccessmenu;
use App\Models\Msmenu;

class MenuRenderer
{

    public static $instance;

    /**
     * Initialize using static function
     *
     * @param int $groupId
     * @return MenuRenderer
     */
    static public function init($groupId)
    {
        if (is_null(self::$instance))
            self::$instance = new MenuRenderer($groupId);

        self::$instance->initialize();

        return self::$instance;
    }

    /**
     * Model menu
     *
     * @var Msaccessmenu
     */
    protected $accessMenu;

    protected $groupId;

    protected $menuId;

    protected $activeMenus;

    protected $userMenus;

    public function __construct($groupId)
    {
        $this->accessMenu = new Msaccessmenu();

        $this->groupId = $groupId;
        $this->menuId = PrivilegesUser::instance()->getMenuId();
    }

    public function initialize()
    {
        $this->userMenus = PrivilegesUser::instance()->getMenus();
        $this->activeMenus = array_reverse($this->initActiveMenu($this->menuId, []));
    }

    public function initActiveMenu($menuid, $arrays)
    {
        $menu = (new Msmenu)->find($menuid);

        if (!is_null($menu)) {
            $arrays[] = $menu->menuid;

            if (!empty($menu->masterid)) {
                return $this->initActiveMenu($menu->masterid, $arrays);
            }
        }

        return $arrays;
    }

    public function render()
    {
        $masterMenus = $this->children();

        usort(
            $masterMenus,
            function ($a, $b) {
                return $a->sequence <=> $b->sequence;
            }
        );

        $listView = "";

        foreach ($masterMenus as $menu) {
            if ($menu->componentcode != 'view') continue;

            $hasChild = $this->hasChild($menu->menuid);

            $linkMenu = base_url($menu->menulink ?? '/');
            $activeMenu = ($this->activeMenus[0] ?? '') == $menu->menuid;

            $chevron = '';
            $listChildren = '';
            $listChildrenOverlay = '';

            if ($hasChild) {
                $linkMenu = "javascript:void(0)";
                $chevron = "<div class=\"navicon\"><i class=\"bx bx-chevron-right\"></i></div>";
                $listChildren = "<div class=\"submenu\" " . ($activeMenu ? " style=\"display: block\"" : '') . ">" . $this->renderChildren($menu->menuid, 0) . "</div>";
                $listChildrenOverlay = "<div class=\"submenu-div\">" . $this->renderChildrenOverlay($menu->menuid, 0) . "</div>";
            }

            $listView .= "<a href=\"$linkMenu\" class=\"has-parent\">
                <div class=\"sidebar-item side-parent treeview" . ($hasChild ? ' haveChild' : '') . ($activeMenu ? ' active' : '') . "\">
                    <i class=\"$menu->menuicon\"></i>
                    <span class=\"fw-nrmal fs-7\">" . ucwords($menu->menuname) . "</span>
                    $chevron
                    $listChildrenOverlay
                </div>
                $listChildren
            </a>";
        }

        return $listView;
    }

    public function renderChildren($menuid, $deepLevel)
    {
        $deepLevel++;

        $menus = $this->children($menuid);

        usort(
            $menus,
            function ($a, $b) {
                return $a->sequence <=> $b->sequence;
            }
        );

        $listMenu = '';
        foreach ($menus as $menu) {
            $linkMenu = base_url($menu->menulink ?? '/');
            $hasChild = $this->hasChild($menu->menuid);

            $activeMenu = ($this->activeMenus[$deepLevel] ?? '') == $menu->menuid;

            $chevron = '';
            $listChildren = '';
            if ($hasChild) {
                $chevron = "<div class=\"navicon" . ($activeMenu ? ' open' : '') . "\"><i class=\"bx bx-chevron-right\"></i></div>";
                $listChildren = "<div class=\"childSub" . ($activeMenu ? ' active' : '') . "\">" . $this->renderChildren($menu->menuid, $deepLevel) . "</div>";
            }

            $listMenu .= "<div class=\"sub-item submenu-item treeview" . ($hasChild ? ' haveSub' : '') . ($activeMenu ? ' active' : '') . "\" link=\"$linkMenu\" style=\"padding-left: 14px !important;\">
                <span class=\"dflex justify-between\">
                    $menu->menuname
                    $chevron
                </span>
                <div class=\"link-new\">
                    <div class=\"link-item\">
                        <div class=\"fw-normal fs-7set text-primary link-items btn-newtab\" data-link=\"$linkMenu\">Open link in new tab</div>
                        <div class=\"fw-normal fs-7set text-primary link-items btn-copylink\">
                            <input type=\"hidden\" id=\"copys\" value=\"$linkMenu\">
                            Copy link address
                        </div>
                    </div>
                </div>
                $listChildren
            </div>";
        }

        $listMenu .= '';


        return $listMenu;
    }

    public function renderChildrenOverlay($menuid, $deepLevel)
    {
        $deepLevel++;

        $menus = $this->children($menuid);

        usort(
            $menus,
            function ($a, $b) {
                return $a->sequence <=> $b->sequence;
            }
        );

        $listMenu = "<div class=\"submenu-child-div subChild\">";

        foreach ($menus as $menu) {
            $linkMenu = base_url($menu->menulink ?? '/');
            $hasChild = $this->hasChild($menu->menuid);

            $chevron = '';
            $listChildren = '';
            if ($hasChild) {
                $chevron = "<i class=\"bx bxs-right-arrow margin-r-3\" style=\"font-size: 6px;\"></i>";
                $listChildren = $this->renderChildrenOverlay($menu->menuid, $deepLevel);
            }

            $listMenu .= "
            <div class=\"sub-item submenu-item-side fs-7set" . ($hasChild ? ' haveChild' : '') . "\" link=\"$linkMenu\" style=\"padding-left: 14px !important;\">
                <div class=\"dflex align-center\">
                    $chevron
                    $menu->menuname
                </div>
            </div>
            <div id=\"listSub\">
                $listChildren
            </div>";
        }

        $listMenu .= "</div>";

        return $listMenu;
    }

    public function children($parentid = null)
    {
        return array_filter(
            $this->userMenus,
            function ($menu) use ($parentid) {
                return $menu->masterid == $parentid && $menu->componentcode == AccessCode::view;
            }
        );
    }

    public function hasChild($parentid)
    {
        return count($this->children($parentid)) > 0;
    }
}
