<?php

namespace App\Helpers\Menu;

use App\Helpers\Utilities\StaticArray;

class MenuArray
{
    use StaticArray;

    public function __collection($data)
    {
        return new MenuCollection($data);
    }

    /**
     * Get children of menu
     *
     * @param integer $masterid
     * 
     * @return MenuCollection[]
     */
    public function children($masterid = 0)
    {
        return $this->filter(
            function (MenuCollection $menu) use ($masterid) {
                return $menu->getMasterId() == $masterid;
            }
        );
    }

    /**
     * Check if has child
     *
     * @param integer $masterid
     * @return boolean
     */
    public function hasChild($masterid = 0)
    {
        return count($this->children($masterid)) > 0;
    }
}
