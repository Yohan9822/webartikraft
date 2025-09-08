<?php

namespace App\Helpers\Menu;

use App\Helpers\Utilities\StaticCollection;

/**
 * @method int getMenuId()
 * @method string getMenuName()
 * @method string getMenuLink()
 * @method int getSequence()
 * @method int getMenuIcon($default = null)
 * @method int getMasterId()
 */
class MenuCollection
{
    use StaticCollection;
}
