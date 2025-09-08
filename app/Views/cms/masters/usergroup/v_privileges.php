<?php

use App\Helpers\Menu\RenderMenu;

/**
 * @var RenderMenu $menus
 */

?>
<form action="<?= getURL('cms/usergroup/privileges/update') ?>" method="post" id="save-privileges" class="margin-b-2 no-padding">
    <?= $menus->render() ?>
    <div class="floating-action">
        <button type="button" class="btn btn-outline-danger btn-xs btn-icon-text" onclick="close_modal('modaldetail')">
            <i class="bx bx-x"></i>
            <span class="fw-normal">Cancel</span>
        </button>
        <button class="btn btn-primary btn-xs btn-icon-text">
            <i class="bx bx-save"></i>
            <span class="fw-normal">Save Privileges</span>
        </button>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {

        let FormUserGroup = {
            selector: {
                accessGroup: '[data-toggle="access_group"]'
            },
            checkComponentView: (menuid) => {
                let viewComponent = $(`[data-menu-id="${menuid}"][data-component-name="view"]`);
                let childComponents = $(`[data-toggle="access_group"][data-view="${menuid}"]`);

                let viewChecked = false;
                for (let i = 0; i < childComponents.length; i++) {
                    if ($(childComponents[i]).prop('checked')) {
                        viewChecked = true;
                        break;
                    }
                }

                if (!viewComponent.prop('checked') && viewChecked)
                    viewComponent.prop('checked', true);

            },
            checkParentMenu: (masterid) => {
                let $parentView = $(`[data-menu-id="${masterid}"][data-component-name="view"]`);
                let children = $(`[data-parent-id="${masterid}"][data-component-name="view"]`);

                if ($parentView.length > 0) {
                    let viewChecked = false;
                    for (let i = 0; i < children.length; i++) {
                        if ($(children[i]).prop('checked')) {
                            viewChecked = true;
                            break;
                        }
                    }

                    if (!viewChecked && $parentView.prop('checked')) {
                        $parentView.trigger('click')
                    } else $parentView.prop('checked', viewChecked);

                    FormUserGroup.checkParentMenu($parentView.data('parentId'));
                }
            },
            checkChildrenMenu: (menuid, checked) => {
                let children = $(`[data-parent-id="${menuid}"]`);

                for (let i = 0; i < children.length; i++) {
                    let $child = $(children[i]);

                    $child.prop('checked', checked);

                    FormUserGroup.checkChildrenMenu($child.data('menuId'), checked);
                }
            },
            init: () => {

                let $accessGroups = $(FormUserGroup.selector.accessGroup);
                $accessGroups.on('click', function() {
                    let $clicked = $(this);
                    let childComponents = $(`[data-toggle="access_group"][data-view="${$clicked.data('menuId')}"]`);

                    if ($clicked.data('componentName') == 'view') {
                        childComponents.each((index, child) => {
                            $(child).prop('checked', $clicked.prop('checked'));
                        });
                        FormUserGroup.checkChildrenMenu($clicked.data('menuId'), $clicked.prop('checked'));
                    } else {
                        FormUserGroup.checkComponentView($clicked.data('menuId'));
                    }

                    FormUserGroup.checkParentMenu($clicked.data('parentId'));
                });
            }
        };


        FormUserGroup.init();

        $('#save-privileges').formSubmit({
            parentNode: $('#modaldetail'),
            data: function(params) {
                let privileges = $('[data-toggle="access_group"]').get().filter((el, i) => {
                    return $(el).data('accessId') != 0 || $(el).prop('checked');
                });

                params.id = "<?= encrypting($row->groupid) ?>";
                params.privileges = JSON.stringify(
                    privileges.map((el) => {
                        let $el = $(el);

                        return {
                            menuid: $el.data('menuId'),
                            componentid: $el.data('componentId'),
                            accessid: $el.data('accessId'),
                            checked: $el.prop('checked'),
                        };
                    })
                );
                return params;
            },
            successCallback: (res) => {
                showNotif(res.sukses == 1 ? 'success' : 'danger', res.pesan);

                if (res.sukses == 1) close_modal('modaldetail');
            }
        })
    });
</script>