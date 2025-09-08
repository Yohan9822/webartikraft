<?php

use App\Helpers\Menu\MenuArray;
use App\Helpers\Menu\MenuCollection;

/**
 * @var MenuArray $menus
 */

/**
 * Render view nestable
 *
 * @param MenuArray $menus
 * @param integer $masterid
 * 
 * @return string
 */
function renderNestable(MenuArray $menus, $masterid = 0)
{
    $children = $menus->children($masterid);

    usort($children, function (MenuCollection $a, MenuCollection $b) {
        return $a->getSequence() <=> $b->getSequence();
    });

    $ol = "<ol class=\"dd-list\">";
    foreach ($children as $child) {
        $ol .= "<li class=\"dd-item\" data-menuid=\"" . $child->getMenuId() . "\">";

        $ol .= "<div class=\"dd-wrapper-handle\">
            <div class=\"dd-handle\" style=\"font-weight: normal\">
                <i class=\"" . $child->getMenuIcon('bx bx-circle') . " margin-r-2\"></i>
                " . $child->getMenuName() . "
            </div>
        </div>";

        if ($menus->hasChild($child->getMenuId())) $ol .= renderNestable($menus, $child->getMenuId());

        $ol .= "</li>";
    }
    $ol .= "</ol>";

    return $ol;
}

?>
<div class="dd">
    <form id="form-menu" method="post" action="<?= getURL('cms/menu/update-sort') ?>" style="padding-bottom: 20px">
        <?= renderNestable($menus); ?>
        <?php if (getAccess(AccessCode::update)): ?>
            <div class="floating-action">
                <button type="button" class="btn btn-outline-danger btn-xs btn-icon-text margin-r-1" onclick="close_modal('modaldetail')">
                    <i class="bx bx-x"></i>
                    <span class="fw-normal">Cancel</span>
                </button>
                <button type="submit" class="btn btn-primary btn-xs btn-icon-text margin-l-2" form="form-menu">
                    <i class="bx bx-save"></i>
                    <span class="fw-normal">Save</span>
                </button>
            </div>
        <?php endif ?>
    </form>
</div>
<script type="text/javascript">
    $(function() {
        $('.dd').nestable({
            expandBtnHTML: '',
            collapseBtnHTML: ''
        });

        let elements = {
            form: {
                menu: $('#form-menu'),
            }
        };

        elements.form.menu.formSubmit({
            parentNode: $('.modal'),
            data: (params) => {
                params['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                params.menus = JSON.stringify(extract($('.dd').nestable('serialize')));
                return params;
            },
            successCallback: (res) => {
                showNotif(res.sukses == 1 ? 'success' : 'error', res.pesan);

                if (res.sukses) close_modal('modaldetail');
            },
        });

        function extract(values, menuid = null) {
            let results = [];
            values.forEach((value, i) => {
                results.push({
                    menuid: value.menuid,
                    headerid: menuid,
                    sequence: i + 1,
                });

                if (value.children !== undefined && Array.isArray(value.children)) {
                    extract(value.children, value.menuid).forEach((child) => {
                        results.push({
                            menuid: child.menuid,
                            headerid: child.headerid,
                            sequence: child.sequence,
                        });
                    })
                }
            });

            return results;
        }
    });
</script>