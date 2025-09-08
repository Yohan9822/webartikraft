<?php if (getAccess(AccessCode::create)) : ?>
    <form action="<?= getURL('cms/user/access/add') ?>" id="form-submit" style="padding-inline: 0px;">
        <input type="hidden" name="userid" value="<?= encrypting($userid) ?>" id="userid">
        <div class="form-group">
            <label for="usergroupid">Usergroup</label>
            <select name="usergroupid" id="usergroupid" style="width: 100% !important" required>
                <option value=""></option>
            </select>
        </div>
        <div class="form-group">
            <label for="usergroupid">Company :</label>
            <select name="companyid" id="companyid" style="width: 100% !important" required>
                <option value=""></option>
            </select>
        </div>
        <div class="form-group">
            <label>Usertype :</label>
            <select name="usertype" id="usertype" style="width: 100% !important" required>
                <option value=""></option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success btn-icon-text btn-xs" id="button_add">
                <i class="bx bxs-plus-circle"></i>
                <span>ADD</span>
            </button>
        </div>
    </form>
<?php endif; ?>
<table class="table table-bordered table-hover table-striped table-head-fixed w-100 table-sm" id="accessgrouptable">
    <thead>
        <tr>
            <th data-width="30" data-orderable="false">#</th>
            <th data-order="asc">User Group</th>
            <th>User Type</th>
            <th data-orderable="false">Menu</th>
            <th>Company</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<script type="text/javascript">
    $('#usergroupid').initSelect2({
        dropdownParent: $('#modaldetail'),
        url: '<?= getURL('cms/api/getusergroup') ?>',
    });

    $('#usertype').initSelect2({
        dropdownParent: $('#modaldetail'),
        url: '<?= getURL('cms/api/getusertype') ?>',
    });

    $('#companyid').initSelect2({
        dropdownParent: $('#modaldetail'),
        url: '<?= getURL('cms/api/getcompany') ?>',
    });

    var tableGroups = $('#accessgrouptable').initDataTable({
        url: '<?= getURL('cms/user/access/table') ?>',
        data: (params) => {
            params.userid = '<?= encrypting($userid) ?>';
            return params;
        }
    });

    $('#form-submit').formSubmit({
        parentNode: $('#modaldetail'),
        successCallback: (res) => {
            showNotif(res.sukses ? 'success' : 'error', res.pesan);

            tableGroups.ajax.reload(null, false);

            if (res.sukses) {
                $('#usergroupid').val(null).trigger('change');
                $('#usertype').val(null).trigger('change');
                $('#companyid').val(null).trigger('change');
            }
        }
    })

    function change_default(angka, accessgroupid) {

        $('.centang').prop('checked', false);
        $('#centang' + angka).prop('checked', true);
        $.ajax({
            type: 'post',
            url: "<?= getURL('cms/user/access/update') ?>",
            data: {
                accessid: accessgroupid,
                userid: "<?= encrypting($userid) ?>",
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(response) {
                showSuccess(response.pesan);
                tableGroups.ajax.reload(null, false);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                showError(thrownError + ", please contact administrator for the further");
            }
        });
    }

    function deleteAccess(accessgroupid, userid) {
        var data = {
            accessgroupid: accessgroupid,
            userid: userid,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        }
        var link = "<?= getURL('cms/user/access/delete') ?>";
        var process = "Hapus"
        $.ajax({
            type: 'post',
            url: link,
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.sukses == '1') {
                    showSuccess(response.pesan);
                    tableGroups.ajax.reload(null, false);
                } else {
                    showNotif('error', response.pesan);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                showError(thrownError + ", please contact administrator for the further");
            }
        });
    }
</script>