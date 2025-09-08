<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style="overflow-y: auto;">
    <div class="modal-dialog" id="modaldetail-size" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" name="modaldetail-id" id="modaldetail-id" />
                <input type="hidden" name="modaldetail-link" id="modaldetail-link" />
                <div class="dflex justify-between align-center" style="width: 100%;border-bottom: 1px solid rgba(25, 75, 120, 0.15); padding-block: 4px;">
                    <span class="modal-title fs-6set fw-normal text-dark" id="modaldetail-title"></span>
                    <button type="button" class="btn text-dark" style="height:max-content;font-size: 24px;padding: 0px !important;padding-block: 0px !important;" id="btn-close-modaldetail" onclick="close_modal('modaldetail')">&times;</button>
                </div>
            </div>
            <div class="modal-body margin-t-2" id="modaldetail-form">

            </div>
        </div>
    </div>
</div>
<!-- Modal Delete -->
<div class="modal fade" id="modaldel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 2147483647 !important" data-bs-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="dflex justify-between align-center" style="width: 100%">
                    <div class="spans">
                        <span class="modal-title fs-6set fw-normal" id="modaldel-title"></span>
                    </div>
                    <button type="button" class="btn text-dark" style="font-size: 24px" onclick="close_modal('modaldel')">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <span class="fw-normal fs-7set text-dark">Are you sure to delete this data ?</span>
                <div class="plus-message">

                </div>
                <div id="modaldel-assets">

                </div>
            </div>
            <div class="modal-footer margin-t-2 p-x-2">
                <button type="button" class="btn btn-secondary" id="cancel-delete" onclick="close_modal('modaldel')"><span class="fw-normal fs-7">No, Keep It</span></button>
                <button type="button" class="btn btn-danger" id="confirm-delete"><span class="fw-normal fs-7">Yes, Delete It</span></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalrel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 2147483647 !important" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="dflex justify-between align-center" style="width: 100%">
                    <div class="spans">
                        <span class="modal-title fs-6set fw-normal" id="modalrel-title"></span>
                    </div>
                    <button type="button" class="btn text-dark" style="font-size: 24px" onclick="close_modal('modalrel')">&times;</button>
                </div>
            </div>
            <div class="modal-body margin-b-1">
                <span class="fw-normal fs-7set text-dark">Are you sure to <span id="type-release"></span> this data ?</span>
                <div class="plus-message"></div>
                <div id="modalrel-assets"></div>
            </div>
            <div class="modal-footer margin-t-2 p-x-2">
                <button type="button" class="btn btn-outline-danger btn-icon-text btn-xs" id="cancel-release" onclick="close_modal('modalrel')"><span class="fw-normal fs-7">No, Cancel</span></button>
                <button type="button" class="btn btn-primary btn-icon-text btn-xs" id="confirm-release"><span class="fw-normal fs-7">Yes, Continue</span></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function modalForm(title, size, link, datas = {}, config = {}) {
        if (config.group !== undefined)
            $('#modaldetail').data('group', config.group);

        let onShowModal = config.onShowModal !== undefined ? config.onShowModal : (modal, data) => {};
        let onHiddenModal = config.onHiddenModal !== undefined ? config.onHiddenModal : (modal, data) => {};

        if ((config.hideHeader ?? false)) $('#modaldetail .modal-header').hide();

        $("#modaldetail").data('onShowModal', onShowModal);
        $('#modaldetail').data('onHiddenModal', onHiddenModal);

        $('body').addClass('refresh');

        datas["<?= csrf_token() ?>"] = '<?= csrf_hash() ?>';
        datas['title'] = title;

        $("button.btn").attr('disabled', 'disabled');

        $.ajax({
            url: link,
            type: 'post',
            data: datas,
            dataType: 'json',
            success: function(res) {
                $('body').removeClass('refresh');

                $("button.btn").removeAttr('disabled');

                if (res.error != undefined) {
                    showError(res.error);
                } else {
                    $('#modaldetail-title').html("");
                    $(`#modaldetail-size`).removeClass("modal-lg", "modal-sm", "modal-md", "modal-xl");
                    $("#btn-close-modaldetail").removeClass('lost-elem')
                    if (datas.nonclose != undefined) {
                        $("#btn-close-modaldetail").addClass('lost-elem')
                    }
                    $(`#modaldetail-size`).addClass(size)
                    $("#modaldetail-title").html(`<h4>${title}</h4>`);
                    $("#modaldetail-form").html(res.view)
                    $(`#modaldetail`).modal("show");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('body').removeClass('refresh');

                if (xhr.responseJSON !== undefined) {
                    if (xhr.responseJSON.pesan !== undefined) showError(xhr.responseJSON.pesan);
                    else showError(thrownError);


                    if (xhr.responseJSON.redirect !== undefined) {
                        setTimeout(() => window.location.href = xhr.responseJSON.redirect, 1000);
                    }
                } else showError('Invalid response from server');

                $("button.btn").removeAttr('disabled');
            }
        })
    }

    function toPage(url, blank) {
        if (blank == 'blank' || blank == '_blank') {
            window.open(url, blank);
        } else {
            window.location.href = url;
        }
    }

    function modalDelete(title, datas, successCallback = null, errorCallback = null) {
        $("#modaldel-title").html(`<h4>${title}</h4>`);
        $(`#modaldel`).modal("show");
        $("#modaldel-assets").html("");
        let keys = Object.keys(datas);
        // console.log(keys)
        for (let x of keys) {
            if (x == 'plus-message') {
                $('.plus-message').html(datas[x]);
                continue;
            }
            $("#modaldel-assets").append(`<span class="re-set" key="${x}" vals="${datas[x]}"></span>`);

        }
        $('#modaldel').data('onSuccessCallback', successCallback);
        $('#modaldel').data('onErrorCallback', errorCallback);
    }

    function close_modal(modalid) {
        $("#" + modalid).modal('hide');
        if (modalid == 'modaldel') {
            $("#modaldel-assets").html("");
            $("#modaldel-title").text("")
            // regenerate_dropdown()
        } else if (modalid == 'modaldetail') {
            $("#modaldetail-size").removeClass("modal-lg modal-md modal-sm modal-xl");
            $("#btn-close-modaldetail").removeClass('lost-elem')
            $("#modaldetail-title").text("")
            $("#modaldetail-form").html("")
        }
        // console.log($("#modaldetail-form").html())   

        refresh_tablemaster();
    }

    let tablemasters = $('.table-master').initDataTable();

    function refresh_tablemaster(index = null) {
        if (Array.isArray(tablemasters)) {
            if (index == null) {
                tablemasters.forEach((tablemaster) => {
                    tablemaster.ajax.reload(null, false);
                });
            } else {
                tablemasters[index].ajax.reload(null, false);
            }
        } else {
            if (tablemasters.constructor.name == 'D') tablemasters.ajax.reload(null, false);
        }
    }

    function loadButton(element) {
        let oldHtml = $(element).html();
        $(element).html(`<div class='dflex align-center justify-center w-100'><i class="bx bx-loader-alt bx-spin text-white margin-r-3"></i><span class="text-white">Processing...</span></div>`);
        $(element).attr('disabled', true);
        $('button, a').attr('disabled', true);
        return oldHtml;
    }

    function unloadButton(element, oldHtml) {
        $(element).removeAttr('disabled');
        $('button, a').attr('disabled', false);
        $(element).html(oldHtml);
    }

    // Delete Button
    $("#confirm-delete").on('click', function() {
        let link = "";
        let id = null;
        let pagetype = "";
        let reloadpage = "";
        let reloadurl = "";
        let table_cls = "";
        let data = {};
        $(".re-set").each(function() {
            let k = $(this).attr('key');
            let v = $(this).attr('vals');
            if (k == 'link') {
                link = v
            } else if (k == 'id') {
                id = v;
            } else if (k == 'pagetype') {
                pagetype = v;
            } else if (k == 'reloadpage') {
                reloadpage = v;
            } else if (k == 'reloadurl') {
                reloadurl = v;
            } else if (k == 'table-cls') {
                table_cls = v;
            } else if (k == 'data') {
                data = JSON.parse(v);
            }
        })

        let tempContent = $("#confirm-delete").html();
        $("#confirm-delete").html('<i class="bx bx-loader bx-spin"></i>');

        $('#modaldel').find('button').attr('disabled', 'disabled');

        $.ajax({
            url: link,
            type: 'post',
            data: $.extend(data, {
                id: id,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            }),
            dataType: 'json',
            success: function(res) {
                $('#modaldel').find('button').removeAttr('disabled');
                $("#confirm-delete").html(tempContent);

                close_modal('modaldel');
                showNotif(res.sukses == 1 ? 'success' : 'error', res.pesan);
                if (pagetype == 'formcard') {
                    if (typeof tablecard !== "undefined") {
                        tablecard.ajax.reload();
                    }
                }
                if (typeof tableSpk !== "undefined") {
                    tableSpk.ajax.reload();
                }
                refresh_tablemaster();

                let onSuccessCallback = $('#modaldel').data('onSuccessCallback');
                if (onSuccessCallback) onSuccessCallback(res);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                showError(thrownError);
                $("#confirm-delete").html(tempContent);
                $('#modaldel').find('button').removeAttr('disabled');

                let onErrorCallback = $('#modaldel').data('onErrorCallback');
                if (onErrorCallback) onErrorCallback();
            }
        })
    })

    let Tabs = {
        register: {}
    };

    $('[data-bs-toggle="pill"]').click((e) => {
        let $clicked = $(e.currentTarget);
        let target = $clicked.data('target');
        let href = $clicked.attr('href');
        let currentUrl = window.location.href;
        let baseUrl = currentUrl.substring(0, currentUrl.indexOf('#'));
        if (currentUrl.indexOf('#') == -1) baseUrl = window.location.href;

        window.history.pushState(null, null, baseUrl + href);

        if (Tabs.register[target] !== undefined) Tabs.register[target]();

        let targetAction = $clicked.attr('href').replace('#', '');
        let $actions = $(`.tab-actions`).children();
        let $actionsTarget = $actions.filter(`[data-tab-action="${targetAction}"]`);

        $actions.removeClass('active');

        if ($actionsTarget.length > 0) {
            if ($actionsTarget.hasClass('active')) {
                $actionsTarget.removeClass('active');
            } else {
                $actionsTarget.addClass('active');
            }
        }
    });

    var url = window.location.href;
    var activeTab = url.substring(url.indexOf("#") + 1);

    if (url.indexOf("#") != -1) {

        $('[data-bs-toggle="pill"]').removeClass('active');
        $('[data-bs-toggle="pill"]').filter(`[href="#${activeTab}"]`).addClass('active');

        $('.tab-pane').removeClass('show active');
        $('.tab-pane').filter(`#${activeTab}`).addClass('show active');
    }

    let $actions = $(`.tab-actions`).children().removeClass('active');

    setTimeout(() => {
        let $currentActive = $('[data-bs-toggle="pill"]').filter(`.active`);
        if ($currentActive.length == 0) {
            $currentActive = $($('[data-bs-toggle="pill"]').get(0));
            $currentActive.addClass('active');
            $(`#${$currentActive.data('target')}`).addClass('show active');
        }

        let target = $currentActive.data('target');

        if (Tabs.register[target] !== undefined) Tabs.register[target]();

        if ($currentActive.length > 0) {
            let targetAction = $currentActive.attr('href').replace('#', '');
            let $actions = $(`.tab-actions`).children();
            let $actionsTarget = $actions.filter(`[data-tab-action="${targetAction}"]`);

            $actions.removeClass('active');

            if ($actionsTarget.length > 0) {
                if ($actionsTarget.hasClass('active')) {
                    $actionsTarget.removeClass('active');
                } else {
                    $actionsTarget.addClass('active');
                }
            }
        }
    }, 1);

    let fetch = {
        post: (url, options = {}) => fetch._fetch('post', url, options),
        get: (url, options = {}) => fetch._fetch('get', url, options),
        _fetch: (method, url, options = {}) => {
            let data = options.data ?? {};

            if (typeof data == 'function') data = data({});

            if (data.constructor.name == 'FormDate') {
                data.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            } else {
                data['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
            }

            let headers = options.headers ?? undefined;
            let contentType = options.contentType;
            let processData = options.processData;

            let successCallback = options.successCallback ?? function(res) {};
            let errorCallback = options.errorCallback ?? function(xhr) {};


            return $.ajax({
                url: url,
                type: method,
                headers: headers,
                contentType: contentType,
                processData: processData,
                data: data,
                dataType: 'json',
                success: (res) => successCallback(res),
                error: (xhr) => {
                    errorCallback(xhr);

                    if (xhr.responseJSON !== undefined) {
                        if (xhr.responseJSON.pesan !== undefined) showError(xhr.responseJSON.pesan);
                        else showError('Invalid response from server');


                        if (xhr.responseJSON.redirect !== undefined) {
                            setTimeout(() => window.location.href = xhr.responseJSON.redirect, 1000);
                        }
                    } else showError('Invalid response from server');
                }
            })
        }
    };

    (function($) {
        $.fn.doneTyping = function(callback, timeout = 500) {
            return this.each(function() {
                let $el = $(this);
                let typingTimer;

                $el.on('keyup', function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(() => callback($el), timeout);
                });

                $el.on('keydown', function() {
                    clearTimeout(typingTimer);
                });
            });
        };
    })(jQuery);

    let relElement = {
        modal: $('#modalrel'),
        modaltitle: $('#modalrel-title'),
        typerelease: $('#type-release'),
        confirm: $('#confirm-release'),
    };

    relElement.confirm.on('click', () => {
        let config = relElement.modal.data('config');
        console.log(config);

        if (config === undefined) return;

        let url = config.url ?? null;
        let title = config.title ?? null;
        let type = config.type ?? null;
        let data = config.data ?? {};

        let onConfirm = config.onConfirm ?? null;
        let onConfirmSuccess = config.onConfirmSuccess ?? null;

        let btnHtml = relElement.confirm.html();
        relElement.confirm.attr('disabled', 'disabled');
        relElement.confirm.html('Processing ...');

        fetch.post(url, {
            data: data
        }).done((response) => {
            relElement.modal.modal('hide');

            if (response.csrfToken !== undefined)
                $("#csrf_token").val(encrypter(response.csrfToken));

            relElement.confirm.html(btnHtml);
            relElement.confirm.removeAttr('disabled');

            let pesan = response.pesan;
            let notif = 'success'
            if (response.sukses != 1) {
                notif = 'error';
            }

            if (response.pesan != undefined) {
                pesan = response.pesan;
            }

            if (response.redirect !== undefined)
                window.location.href = response.redirect;

            showNotif(notif, pesan);

            if (onConfirmSuccess !== null)
                onConfirmSuccess(response, element);
        }).fail((xhr) => {
            relElement.confirm.html(btnHtml);
            relElement.confirm.removeAttr('disabled');
        });
    });

    function onRelease(config) {
        relElement.modal.data('config', config);

        let url = config.url ?? null;
        let title = config.title ?? null;
        let type = config.type ?? null;

        relElement.modal.modal('show');
        relElement.modaltitle.text(title);
        relElement.typerelease.text(type);
        relElement.modal.on('shown.bs.modal', () => {
            if (url === null) {
                relElement.modal.modal('hide');
                alert('Relase action url is not defined');
            }
        });
    }

    function price_keyup(elem, decimal = 0) {
        let value = $(elem).val();
        $(elem).val(formatCustomNumber(value));
    }

    function formatCustomNumber(evt) {
        var nilai = evt.toString();
        let val = nilai.replace(/[^0-9.\-]/g, '');
        if (val.indexOf('-') > 0) {
            val = val.replace(/-/g, '');
        } else if (val.indexOf('-') === 0) {
            val = '-' + val.slice(1).replace(/-/g, '');
        }

        if (val != "") {
            let valArr = val.split('.');
            valArr[0] = valArr[0].replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            val = valArr.join('.');
        }

        return val;
    }
</script>