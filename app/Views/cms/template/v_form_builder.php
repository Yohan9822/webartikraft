<script type="text/javascript">
    let FormSubmit = {
        init: function(options = {}) {
            let $el = $(this);

            return $el.on('submit', async function(e) {
                e.stopPropagation();
                e.preventDefault();

                $el.find('[type="submit"]').attr('disabled', 'disabled');

                if (options.beforeSubmit !== undefined) {
                    if (await options.beforeSubmit(this)) FormSubmit._onSubmit($el, options);
                    return;
                }

                FormSubmit._onSubmit($el, options);
            });
        },
        _onSubmit: function($el, options) {
            let dataType = options.dataType !== undefined ? options.dataType : 'json';
            if ($el.data('type') !== undefined) dataType = $el.data('type');

            let url = options.url !== undefined ? options.url : null;
            if ($el.attr('action') !== undefined) url = $el.attr('action');

            let method = options.method !== undefined ? options.method : 'post';
            if ($el.attr('method') !== undefined) method = $el.attr('method');

            let data = (params) => {
                params['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';

                if (options.data !== undefined &&
                    typeof options.data === 'function') return options.data(params);

                return params;
            };

            let parentNode = options.parentNode !== undefined ? $(options.parentNode) : $el;

            let formData = new FormData($el.get(0));
            Object.keys(data({})).forEach(key => {
                formData.append(key, data({})[key]);
            });

            parentNode.addClass('refresh');

            return $.ajax({
                url: url,
                type: method,
                data: formData,
                dataType: dataType,
                contentType: false,
                processData: false,
                success: (res) => {
                    parentNode.removeClass('refresh');
                    $el.find('[type="submit"]').removeAttr('disabled');

                    setTimeout(() => {
                        if (res.redirect !== undefined)
                            window.location.href = res.redirect;

                        if (res.open !== undefined)
                            window.open(res.open, '_blank');
                    }, 500);

                    if (options.successCallback !== undefined) options.successCallback(res);
                },
                error: (xhr) => {
                    parentNode.removeClass('refresh');
                    $el.find('[type="submit"]').removeAttr('disabled');

                    if (options.errorCallback !== undefined) options.errorCallback(xhr);
                    else if (xhr.responseJSON !== undefined) {
                        if (xhr.responseJSON.pesan !== undefined) showError(xhr.responseJSON.pesan);
                        else showError('Invalid response from server');


                        if (xhr.responseJSON.redirect !== undefined) {
                            setTimeout(() => window.location.href = xhr.responseJSON.redirect, 1000);
                        }
                    } else showError('Invalid response from server');
                }
            });
        }
    };

    $.fn.formSubmit = FormSubmit.init;

    let FormsBuilder = {
        typingTimer: null,
        initSelect2: function(options = {}, value = null) {
            let selector = options.selector !== undefined ? options.selector : '[data-toggle="select2"]';

            let $elements = $(this);
            if (this.select2 === undefined) $elements = $(selector);

            if (options == 'data' && $elements.data('options') !== undefined) {
                let oldOptions = $elements.data('options');

                if (value != null) {

                    oldOptions.items = value.map((val) => {
                        if (val.selected === undefined) val.selected = false;
                        return val;
                    });

                    $elements.initSelect2(oldOptions);
                } else {
                    if ($elements.attr('multiple') === undefined &&
                        $elements.select2('data').length > 0) return $elements.select2('data')[0];

                    if ($elements.attr('multiple') === undefined &&
                        $elements.select2('data').length == 0) return null;

                    return $elements.select2('data');
                }

                return;
            } else if (options == 'reInit' && $elements.data('options') !== undefined) {
                let oldOptions = $elements.data('options');
                if (value !== null) oldOptions = $.extend(oldOptions, value);

                $elements.initSelect2(oldOptions);

                return;
            }

            $elements.each((i, el) => {
                let $el = $(el);

                let cache = options.cache !== undefined ? options.cache : false;

                let allowClear = options.allowClear !== undefined ? options.allowClear : true;
                let dropdownParent = options.dropdownParent !== undefined ? options.dropdownParent : null;

                let items = options.items !== undefined ? options.items : null;

                let placeholder = options.placeholder !== undefined ? options.placeholder : 'Choose option';
                if ($el.data('placeholder') !== undefined) placeholder = $el.data('placeholder');

                let theme = options.theme != undefined ? options.theme : 'default';
                if ($el.data('theme') !== undefined) theme = $el.data('theme');

                let search = options.search != undefined ? options.search : true;
                if ($el.data('search') !== undefined) search = $el.data('search');

                let containerCssClass = options.containerCssClass != undefined ? options.containerCssClass : 'default';
                if ($el.data('containerCssClass') !== undefined) containerCssClass = $el.data('containerCssClass');

                let width = options.width !== undefined ? options.width : '100%';
                if ($el.data('width') !== undefined) width = $el.data('width');

                let minimumInputLength = options.minimumInputLength !== undefined ? options.minimumInputLength : null;
                let templateResult = options.templateResult !== undefined ? options.templateResult : (state) => {
                    return state.text;
                };
                let templateSelection = options.templateSelection != undefined ? options.templateSelection : (state) => {
                    return state.text;
                };

                let config = {
                    cache: cache,
                    data: items,
                    allowClear: allowClear,
                    placeholder: placeholder,
                    width: width,
                    dropdownParent: dropdownParent,
                    theme: theme,
                    containerCssClass: containerCssClass,
                    minimumInputLength: minimumInputLength,
                    minimumResultsForSearch: search,
                    templateResult: templateResult,
                    templateSelection: templateSelection,
                    language: {
                        loadingMore: () => '<i class="bx bx-loader-circle spin"></i> Loading more results',
                        searching: () => 'Searching',
                    }
                };

                let url = options.url !== undefined ? options.url : null;
                if ($el.data('url') !== undefined) $el.data('url');

                if (url !== null) {

                    let cache = options.cache !== undefined ? options.cache : true;
                    let processResults = options.processResults !== undefined ? options.processResults : function(response) {

                        $("#csrf_token").val(response.csrfToken);
                        return {
                            results: response.data
                        };
                    };
                    let data = (params) => {
                        params.searchTerm = params.term;
                        params['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';

                        if ($el.attr('multiple') !== undefined) params.ids = $el.val();

                        let pdata = options.data;
                        if (options.data !== undefined) {
                            if (typeof options.data === 'function') pdata = options.data(params);
                        }

                        console.log($.extend(params, pdata));

                        return params;
                    };
                    if (options.length !== undefined) {
                        processResults = function(response, params) {
                            let more, datas;

                            params.page = params.page || 1;
                            params.length = options.length;

                            more = {
                                more: (params.page * options.length) < response.count_total,
                            };

                            datas = [];
                            response.data.forEach((item) => {
                                datas.push(item);
                            });

                            return {
                                results: datas,
                                pagination: more,
                            };
                        };
                    }

                    config.ajax = {
                        url: url,
                        type: 'post',
                        data: data,
                        dataType: 'json',
                        cache: false,
                        delay: 500,
                        processResults: processResults,
                    };
                }

                $el.data('options', options);

                $el.select2(config);
                $el.on('select2:open', () => {
                    if ($el.attr('id') !== undefined)
                        $(`[aria-controls="select2-${$el.attr('id')}-results"]`).get(0).focus();
                });

                $el.next().on('click', (e) => {
                    e.stopPropagation();
                });
            })
        },
        initDateRangePicker: function(options = {}, value = null) {
            let $elements = $(this);
            if (options.selector !== undefined) $elements = $(options.selector);

            if ($elements.data('dateRangePickerOptions') !== undefined) {
                let dataOptions = $elements.data('dateRangePickerOptions');

                if (options == 'setDate') {
                    $elements.daterangepicker('setDate', value);
                    return;
                } else if (options == 'startDate') {
                    $elements.data('daterangepicker').setStartDate(value);
                    return;
                } else if (options == 'endDate') {
                    $elements.data('daterangepicker').setEndDate(value);
                    return;
                }

                if (value != null) {
                    if (options == 'minDate')
                        dataOptions.minDate = value;
                    else if (options == 'maxDate')
                        dataOptions.maxDate = value;

                    $elements.initDateRangePicker(dataOptions);
                }

                return;
            }

            let autoUpdateInput = options.autoUpdateInput !== undefined ? options.autoUpdateInput : true;
            let datePicker = options.datePicker !== undefined ? options.datePicker : true;
            let timePicker = options.timePicker !== undefined ? options.timePicker : false;
            let singleDatePicker = options.singleDatePicker !== undefined ? options.singleDatePicker : false;
            let autoApply = options.autoApply !== undefined ? options.autoApply : false;
            if (singleDatePicker) autoApply = true;
            let parentEl = options.parentEl !== undefined ? options.parentEl : null;
            let onChange = options.onChange !== undefined ? options.onChange : null;
            let minDate = options.minDate !== undefined ? options.minDate : null;
            let maxDate = options.maxDate !== undefined ? options.maxDate : null;
            let format = options.format !== undefined ? options.format : 'DD/MM/YYYY';
            let ranges = options.ranges ?? undefined;
            let showDropdowns = options.showDropdowns ?? true;

            $elements.each((i, el) => {
                let $el = $(el);

                $el.attr('autocomplete', 'off');

                let dateRangePickerConfig = {
                    parentEl: parentEl,
                    autoApply: autoApply,
                    autoUpdateInput: autoUpdateInput,
                    datePicker: datePicker,
                    timePicker: timePicker,
                    showDropdowns: showDropdowns,
                    singleDatePicker: singleDatePicker,
                    cancelClass: 'btn-outline-primary',
                    locale: {
                        cancelLabel: 'Clear',
                        format: format
                    },
                    ranges: ranges,
                };
                if (minDate !== null) dateRangePickerConfig.minDate = minDate;

                if (maxDate !== null) dateRangePickerConfig.maxDate = maxDate;

                $el.daterangepicker(dateRangePickerConfig, function(start, end, label) {

                    if (singleDatePicker) {
                        $el.val(`${start.format('DD/MM/YYYY')}`);
                    } else {
                        $el.val(`${start.format('DD/MM/YYYY')} - ${end.format('DD/MM/YYYY')}`);
                    }

                    if (onChange !== null) onChange(start, end, label);
                });

                $el.data('dateRangePickerOptions', options);
            })
        },
        doneTyping: function(callback, options = {}) {
            var $input = $(this);

            $input.each((i, input) => {
                let typingTimer = null;
                var interval = options.interval !== undefined ? options.interval : 500;

                $(input).on('keydown', function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(() => {
                        clearTimeout(typingTimer);
                        callback($(input));
                    }, interval);
                });

                $(input).on('keyup', function() {
                    // clearTimeout(FormsBuilder.typingTimer);
                });
            })


        },
        initNumberFormat: function(options = {}) {
            let $elements = $(this);
            if (options.selector !== undefined) $elements = $(options.selector);

            let decimal = options.decimal !== undefined ? options.decimal : 2;

            $elements.number(true, decimal);
        },
        formEditable: function(options = {}, param = null) {
            let $elements = $(this);
            if (options.selector !== undefined) $elements = $(options.selector);

            if ($elements.data('formEditable') !== undefined) {
                let oldOptions = $elements.data('formEditable');

                let $parentEl = oldOptions.parentSelector == null ? $elements : $elements.closest(oldOptions.parentSelector);

                if (options == 'processing') {
                    if (param) {
                        $parentEl.addClass('load');
                        $elements.attr('disabled', 'disabled');
                    } else {
                        $parentEl.removeClass('load');
                        $elements.removeAttr('disabled');
                    }
                }

                return $elements;
            }

            let action = options.action !== undefined ? options.action : 'blur';
            let formSelectors = options.formSelectors !== undefined ? options.formSelectors : ['input', 'select'];
            if (!Array.isArray(formSelectors)) formSelectors = [formSelectors];

            let parentSelector = options.parentSelector !== undefined ? options.parentSelector : null;

            let url = options.url !== undefined ? options.url : null;
            let successCallback = options.successCallback !== undefined ? options.successCallback : (res) => {};
            let errorCallback = options.errorCallback !== undefined ? options.errorCallback : (xhr) => {};
            let value = options.value !== undefined ? options.value : ($form, $el) => $form.val();
            let setValue = options.setValue !== undefined ? options.setValue : ($form, value, $el) => $form.val(value);
            let loaderPosition = options.loaderPosition !== undefined ? options.loaderPosition : '';

            let ajaxOptions = {
                type: 'post',
                url: url,
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                dataType: 'json',
            };

            let ajax = options.ajax !== undefined ? $.extend(ajaxOptions, options.ajax) : ajaxOptions;

            let $loader = $('<div>').addClass('form-editable-loader ' + loaderPosition)
                .append($('<i>').addClass('bx bx-loader spin'));

            $elements.each((i, el) => {
                let $el = $(el);

                let $parentEl = parentSelector == null ? $el : $el.closest(parentSelector);
                let $formEl = $parentEl.find(formSelectors.join(','));
                $parentEl.append($loader.clone());

                $formEl.each((j, form) => {
                    let $form = $(form);

                    let oldValue = $form.attr('old-value');
                    if ([null, undefined].includes(oldValue)) {
                        oldValue = value($form, $el);
                        $form.attr('old-value', oldValue);
                    }

                    $form.on('keydown', function(e) {
                        e = e || window.event;

                        if (e.keyCode == 13) {
                            e.preventDefault();

                            $(e.currentTarget).trigger(action);

                            return false;
                        }
                    });

                    $form.on('click', function(e) {
                        e.stopPropagation();
                    });

                    $form.on(action, function(e) {
                        oldValue = $form.attr('old-value');

                        let newValue = value($form, $el).toString();

                        if (newValue !== oldValue && url) {
                            $parentEl.addClass('load');

                            $form.attr('disabled', 'disabled');
                            $form.addClass('disabled');

                            let formData = {
                                ...$form.data()
                            };
                            ['select2', 'select2Id', 'options'].forEach((key) => {
                                delete formData[key];
                            });

                            $.ajax($.extend(ajax, {
                                data: $.extend(
                                    ajax.data,
                                    formData, {
                                        value: newValue
                                    }
                                ),
                                success: (res) => {
                                    $parentEl.removeClass('load');

                                    $form.removeAttr('disabled', 'disabled');
                                    $form.removeClass('disabled');

                                    oldValue = newValue;
                                    $form.attr('old-value', oldValue);

                                    showNotif(res.sukses == 1 ? 'success' : 'error', res.pesan);

                                    successCallback(res);
                                },
                                error: (xhr) => {
                                    $parentEl.removeClass('load');

                                    $form.removeAttr('disabled', 'disabled');
                                    $form.removeClass('disabled');

                                    setValue($form, oldValue, $el);

                                    if (xhr.responseJSON !== undefined) {
                                        if (xhr.responseJSON.pesan !== undefined) showError(xhr.responseJSON.pesan);
                                        else showError('Invalid response from server');
                                    } else showError('Invalid response from server');

                                    errorCallback(xhr);
                                },
                            }));
                        }
                    });
                });

                $el.data('formEditable', options);
            });

            return $elements;
        },
        formRelease: function(options = {}) {
            let $elements = $(this);
            if (options.selector !== undefined) $elements = $(options.selector);
        },
        inputDiscount: function(options = {}, value = null) {

            let $elements = $(this);
            if (options.selector !== undefined) $elements = $(options.selector);

            let onChange = options.onChange !== undefined ? options.onChange : (type, value) => {};

            let toggleAction = ($el) => {
                let $labelAmount = $el.find('[data-name="amount"]');
                let $labelPercentage = $el.find('[data-name="percentage"]');
                let $labelToggle = $el.find('[data-name="label-toggle"]');
                let $input = $($el.find('input'));

                let $toggleAmount = $('<div>').addClass('nav-link').text('Change discount to amount');
                let $togglePercentage = $('<div>').addClass('nav-link').text('Change discount to percentage');

                if ($labelAmount.hasClass('hiding')) {
                    $labelToggle.html($toggleAmount);
                }

                if ($labelPercentage.hasClass('hiding')) {
                    $labelToggle.html($togglePercentage);
                }

                $togglePercentage.on('click', () => {
                    $labelPercentage.removeClass('hiding');
                    $labelAmount.addClass('hiding');

                    toggleAction($el);

                    onChange('percentage', $input.val());
                });

                $toggleAmount.on('click', () => {
                    $labelAmount.removeClass('hiding');
                    $labelPercentage.addClass('hiding');

                    toggleAction($el);

                    onChange('amount', $input.val());
                });
            };

            if (options == 'data') {
                let $labelAmount = $elements.find('[data-name="amount"]');
                let $labelPercentage = $elements.find('[data-name="percentage"]');
                let $input = $($elements.find('input'));

                let discountType = null;
                if ($labelAmount.hasClass('hiding')) discountType = 'percentage';

                else if ($labelPercentage.hasClass('hiding')) discountType = 'amount';

                if (value == null) return {
                    type: discountType,
                    value: $input.val().toString().removeIdr(),
                };

                if (value.type !== undefined && value.value !== undefined) {
                    if (value.type == 'percentage') {
                        $labelAmount.addClass('hiding');
                        $labelPercentage.removeClass('hiding');
                    } else if (value.type == 'amount') {
                        $labelPercentage.addClass('hiding');
                        $labelAmount.removeClass('hiding');
                    }

                    toggleAction($elements);

                    $input.val(value.value);

                    return;
                }

                return null;
            } else if (options == 'calc') {
                let $labelAmount = $elements.find('[data-name="amount"]');
                let $labelPercentage = $elements.find('[data-name="percentage"]');
                let $input = $($elements.find('input'));

                // let discountType = null;
                // if ($labelAmount.hasClass('hiding')) discountType = 'percentage';

                // if ($labelPercentage.hasClass('hiding')) discountType = 'amount';

                // if ([null, undefined].includes(value)) return console.error("Invalid calculation " + (typeof value));

                // if (discountType == 'percentage') return {
                //     value: parseFloat($input.val()) / 100 * parseFloat(value),
                //     result: parseFloat(value) - parseFloat($input.val()) / 100 * parseFloat(value)
                // }

                // if (discountType == 'amount') return {
                //     value: parseFloat($input.val()),
                //     result: parseFloat(value) - parseFloat($input.val()),
                // }

                return {
                    value: 0,
                    result: 0,
                };
            } else if (options == 'focus') {
                let $input = $($elements.find('input'));
                setTimeout(() => $input.get(0).focus(), 100);
            }

            $elements.each((i, el) => {
                let $el = $(el);

                toggleAction($el);

                let $labelAmount = $el.find('[data-name="amount"]');
                let $labelPercentage = $el.find('[data-name="percentage"]');

                $labelAmount.on('click', () => onChange('amount', $input.val()));

                $labelPercentage.on('click', () => onChange('percentage', $input.val()));

                let $input = $($el.find('input'));
                $input.number(true);

                $input.doneTyping(() => {
                    if ($labelAmount.hasClass('hiding')) {
                        if ($input.val().toString().removeIdr() > 100) {
                            showNotif('error', 'Percentage value maximum is 100');
                            $input.val(100);
                        }

                        onChange('percentage', $input.val());
                    } else if ($labelPercentage.hasClass('hiding')) {
                        onChange('amount', $input.val());
                    }

                    if ($input.val().toString().removeIdr() < 0) {
                        showNotif("error", "Value cannot be less than 0");
                        $input.val(0);
                    }

                })
            });

        },
        inputFile: function(options = {}, value = null) {
            lightbox.option({
                'alwaysShowNavOnTouchDevices': true,
                'resizeDuration': 200,
                'imageFadeDuration': 0,
                'fadeDuration': 200
            });

            let $elements = $(this);
            if (options.selector !== undefined) $elements = $(options.selector);

            if (typeof options == 'string' && $elements.data('inputfile') !== undefined) {
                let oldOptions = $elements.data('inputfile');

                if (options == 'files' && value != null) {
                    oldOptions.files = value;
                    $elements.inputFile(oldOptions);
                } else if (options == 'validate') {
                    let required = oldOptions.required ? oldOptions.required : null;
                    let maxFiles = oldOptions.maxFiles ? oldOptions.maxFiles : null;

                    let countImage = $(`[name="${name}"]`).length;

                    if (required || (required && countImage <= maxFiles)) {
                        showNotif("error", "File is required");
                        return false;
                    }

                    return true;
                }

                return;
            }

            let name = options.name !== undefined ? options.name : null;
            let hiddenName = options.hiddenName ?? `${name}_value`;
            let width = options.width !== undefined ? options.width : 100;
            let height = options.height !== undefined ? options.height : 150;
            let multiple = options.multiple !== undefined ? options.multiple : false;
            let fit = options.fit !== undefined ? options.fit : 'fill';
            let allowed = options.allowed !== undefined ? options.allowed : [];
            let previewRatio = options.previewRatio !== undefined ? options.previewRatio : 1;
            let files = options.files !== undefined ? options.files : [];
            let placeholder = options.placeholder ? options.placeholder : null;
            let maxFiles = options.maxFiles ? options.maxFiles : null;
            let required = options.required ? options.required : null;
            let readonly = options.readonly ?? false;

            let onClear = options.onClear !== undefined ? options.onClear : (data, i, callback) => callback();

            let $inputPlaceholder = $('<div>').addClass('input-file-item dflex justify-center align-center')
                .html(`<span class="text-center">${placeholder != null ? placeholder : `${width} x ${height}`}</span>`)
                .css({
                    width: width / previewRatio,
                    height: height / previewRatio
                });

            let getValue = (file) => {
                if (file.constructor.name == 'File') {
                    return URL.createObjectURL(file);
                } else if (file.constructor.name == 'Object' && file.url !== undefined) {
                    return file.url;
                }

                return file;
            };

            let renderImg = (file) => {
                let $img = $('<img>');
                let $lightboxImg = $('<a>');
                $lightboxImg.attr('data-lightbox', name);
                $lightboxImg.attr('data-title', file.name);
                $lightboxImg.attr('href', getValue(file));

                $img.attr('alt', file.name);
                $img.attr('width', width / previewRatio);
                $img.attr('height', height / previewRatio);
                $img.attr('src', getValue(file));
                $img.css({
                    objectFit: fit,
                    borderRadius: 5
                });

                return $lightboxImg.html($img);
            }

            let renderFiles = ($elm, $elPlaceholder, _files, withInput = true) => {

                for (let i = 0; i < _files.length; i++) {
                    let file = _files[i];

                    if (maxFiles != null && $(`[name="${name}"]`).length + 1 > maxFiles) {
                        showNotif("error", `Maximum uploaded ${maxFiles} file`);
                        $elPlaceholder.addClass('hiding');
                        return;
                    }

                    if (!multiple) $elPlaceholder.addClass('hiding');

                    let $currentInputFile = $('<input>', {
                        type: 'file',
                        class: 'hiding',
                    });
                    $currentInputFile.attr('accept', allowed.join(','));
                    $currentInputFile.attr('name', name);

                    let $currentInputFileName = $('<input>', {
                        type: 'hidden',
                        name: hiddenName,
                    });
                    $currentInputFileName.val(JSON.stringify(file));

                    if (withInput) {
                        let dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);

                        $currentInputFile.prop('files', dataTransfer.files);

                        $currentInputFile.insertBefore($elPlaceholder);
                    }

                    let $change = $('<span>').addClass('text-primary').text('Change');
                    let $remove = $('<span>').addClass('text-danger').text('Clear');

                    let $previewImage = $inputPlaceholder.clone();
                    $previewImage.html(renderImg(file));

                    if (!readonly)

                        $('<div>').addClass('input-preview')
                        .append($currentInputFileName, $previewImage, $change, $remove)
                        .insertBefore($elPlaceholder)

                    else $('<div>').addClass('input-preview')
                        .append($currentInputFileName, $previewImage)
                        .insertBefore($elPlaceholder);

                    $change.on('click', () => {
                        $currentInputFile.trigger('click');
                    });

                    $currentInputFile.on('change', () => {
                        $previewImage.html(renderImg($currentInputFile.get(0).files[0]));
                        if (!withInput) $currentInputFile.insertBefore($elPlaceholder);
                    });

                    $remove.on('click', (e) => {
                        $(e.currentTarget).closest('.input-preview').find('.input-file-item').addClass('refresh');

                        onClear(files[i], i, (success) => {
                            $remove.closest('.input-preview').remove();

                            if ((maxFiles != null && $(`[name="${name}"]`).length < maxFiles) || multiple == false) {
                                $elPlaceholder.removeClass('hiding');
                            }

                            $(e.currentTarget).closest('.input-preview').find('.input-file-item').removeClass('refresh');
                        });
                    });
                }
            };

            let $wrapper = $('<div>').addClass('dflex justify-start align-start flex-column overflow-x-auto')
                .css({
                    width: 'fit-content'
                });

            $elements.each((i, elm) => {
                let $elm = $(elm);
                let $elPlaceholder = $inputPlaceholder.clone();
                let $elWrapper = $wrapper.clone();

                if (!readonly)
                    $elm.html($elPlaceholder);

                $elWrapper.css({
                    maxHeight: (height / previewRatio) + 50
                });

                if (readonly)
                    $elPlaceholder.addClass('hiding');

                $elWrapper.html($elPlaceholder);

                $elPlaceholder.on('click', () => {
                    let $inputFile = $('<input>', {
                        type: 'file',
                        class: 'hiding'
                    });

                    $inputFile.attr('accept', allowed.join(','));
                    $inputFile.attr('multiple', multiple);

                    $inputFile.trigger('click');

                    $inputFile.on('change', () => {

                        if ((maxFiles != null && $(`[name="${name}"]`)).length + 1 == maxFiles || multiple == false) {
                            if (multiple == false)
                                $elm.children().filter('.input-preview').remove();

                            $elPlaceholder.addClass('hiding');
                        }

                        renderFiles($elm, $elPlaceholder, $inputFile.get(0).files);
                    });

                });

                renderFiles($elm, $elPlaceholder, files, false);

                $elm.append($elWrapper);

                $elements.data('inputfile', options);
            });
        },
        filterPills: function(options = {}, value = null) {
            let $elements = $(this);
            if (options.selector !== undefined) $elements = $(options.selector);

            if (options == 'data') {
                if ($elements.data('pillStatus') !== undefined) {
                    let currentOptions = $elements.data('pillStatus');

                    if (value == null) {
                        let children = $elements.children('.pill-label');

                        if (!(currentOptions.multiple ?? false)) {
                            let indexActive = children.get().findIndex((child) => $(child).hasClass('active'));

                            let checked = $(children.get(indexActive)).data('value');

                            return checked != 'all' ? checked : null;
                        }

                        return children.filter((i, child) => $(child).hasClass('active'))
                            .filter((child) => $(child).data('value') !== 'all')
                            .map((i, child) => $(child).data('value'))
                            .get();
                    }
                }

                return;
            } else if (options == 'reInit') {
                if ($elements.data('pillStatus') !== undefined) {
                    return $elements.filterPills($elements.data('pillStatus'));
                }

                return;
            } else if (options == 'clear') {
                if ($elements.data('pillStatus') !== undefined) {
                    let currentOptions = $elements.data('pillStatus');

                    $elements.each((i, el) => {
                        let $el = $(el);
                        let children = $el.children('.pill-label');
                        children.removeClass('active');
                    });

                    $elements.filterPills('reInit');
                }

                return;
            }

            let showAll = options.showAll !== undefined ? options.showAll : true;
            let multiple = options.multiple !== undefined ? options.multiple : false;
            let url = options.url !== undefined ? options.url : null;
            let data = options.data !== undefined ? options.data : {};
            if (typeof data === 'function') data = data({});

            let onChange = options.onChange !== undefined ? options.onChange : () => {};
            let processResults = options.processResults !== undefined ? options.processResults : (res) => res;


            let $pillElement = $('<div>', {
                class: 'label label-md pill-label pill-primary'
            });
            let $skeletonElement = $('<div>').addClass('label pill-label margin-l-3 skeleton-box');
            let $allPill = $pillElement.clone()
                .data('value', 'all')
                .text('All');

            $elements.each((i, el) => {
                let $el = $(el);

                let children = $el.children('.pill-label');
                let indexActive = children.get().findIndex((child) => $(child).hasClass('active'));

                $el.empty();
                if (showAll) {

                    if (indexActive == -1) $allPill.addClass('active');

                    if (indexActive > -1) {
                        if ($(children[indexActive]).text() == 'All')
                            $allPill.addClass('active');
                    }

                    $el.append($allPill);
                }

                for (let i = 0; i < 3; i++) {
                    $el.append($skeletonElement.clone());
                }

                $.ajax({
                    url: url,
                    type: 'post',
                    data: $.extend(data, {
                        '<?= csrf_token() ?>': decrypter($("#csrf_token").val()),
                    }),
                    dataType: 'json',
                }).done(res => {
                    $el.find('.skeleton-box').remove();
                    $el.find('.pill-label').remove();

                    $el.append($allPill);

                    $allPill.on('click', () => {
                        $el.find('.pill-label').removeClass('active');
                        $allPill.addClass('active');

                        onChange($allPill);
                    });

                    processResults(res).forEach((status, i) => {

                        let $pillStatus = $pillElement.clone()
                            .addClass('margin-l-3')
                            .text(status.text)
                            .data('value', status.id);

                        let currentIndex = i;
                        if (showAll) currentIndex = i + 1;

                        if (currentIndex == indexActive)
                            $pillStatus.addClass('active');

                        if (status.count_results > 0)
                            $pillStatus.append(
                                $('<span>').addClass('pill-badge')
                                .text(status.count_results <= 99 ? status.count_results : '99+')
                            );

                        $pillStatus.on('click', () => {

                            if (multiple === false)
                                $el.find('.pill-label').removeClass('active');

                            if (multiple) {

                                if ($pillStatus.hasClass('active')) $pillStatus.removeClass('active');
                                else $pillStatus.addClass('active');

                                if (showAll) {
                                    let activeChildren = $el.find('.pill-label').filter('.active');

                                    if (activeChildren.length > 0) $allPill.removeClass('active');
                                    else $allPill.addClass('active');
                                }
                            } else $pillStatus.addClass('active');

                            onChange($pillStatus);
                        });

                        $el.append($pillStatus);
                    });
                }).fail((xhr) => {
                    $el.find('.skeleton-box').remove();

                    if (xhr.responseJSON !== undefined) {
                        if (xhr.responseJSON.pesan === undefined) $el.html($('<small>', {
                            class: 'text-danger'
                        }).html('Invalid response from server'));
                        else $el.html(xhr.responseJSON.pesan);


                        if (xhr.responseJSON.redirect !== undefined) {
                            setTimeout(() => window.location.href = xhr.responseJSON.redirect, 1000);
                        }
                    } else $el.html($('<small>', {
                        class: 'text-danger'
                    }).html('Invalid response from server'));
                });

                $el.find('.pill-label').on('click', (e) => {

                    $el.find('.pill-label').removeClass('active');
                    $(e.currentTarget).addClass('active');

                    onChange($(e.currentTarget));
                });

                $el.data('pillStatus', options);
            });
        },
        initDataTable: function(options = {}, value = null) {
            let $elements = $(this);
            if (options.selector !== undefined) $elements = $(options.selector);

            if (options == 'reload') {
                $elements.each((i, table) => {
                    let $table = $(table);
                });

                return;
            }

            let url = options.url ?? '<?= current_url(true) ?>/table';

            let serverSide = options.serverSide ?? true;
            let destroy = options.destroy ?? true;
            let autoWidth = options.autoWidth ?? false;
            let dom = options.dom ?? '<"row gutter-sm margin-t-14p"<"col-6"l><"col-6"f><"col-12"<"table-responsive"rt>><"col-6"i><"col-6"p>>';
            let data = options.data;
            let columns = options.columns ?? [];

            let rowCallback = options.rowCallback ?? undefined;
            let drawCallback = options.drawCallback ?? undefined;

            $elements.each((i, table) => {

                let $table = $(table);
                let headers = $table.find('thead > tr').children();

                let orders = headers
                    .map((i, head) => {
                        let $head = $(head);

                        return {
                            index: i,
                            order: $head.data('order')
                        };
                    })
                    .filter((i, order) => order.order !== undefined)
                    .map((i, order) => [
                        [order.index, order.order]
                    ])
                    .get();

                let columnConfig = headers.map((i, head) => {
                    let $head = $(head);

                    let searchIndex = columns.findIndex((val) => {
                        if (Array.isArray(val.targets)) {
                            return val.targets.include(i);
                        }

                        return val.targets == i;
                    });

                    let columnVar = {
                        targets: i,
                        data: $head.data('data')
                    };

                    if (searchIndex != -1) {
                        columnVar.data = columns[searchIndex].data;
                        columnVar.render = columns[searchIndex].render;
                    }

                    return columnVar;
                }).get();


                let datatableConfig = {
                    serverSide: serverSide,
                    destroy: destroy,
                    autoWidth: autoWidth,
                    processing: true,
                    order: orders.length > 0 ? orders : undefined,
                    dom: dom,
                    language: {
                        processing: '<div class="dflex flex-column box-loader"><i class="bx bx-loader-alt spin"></i><span>Please Wait</span></div>'
                    },
                    columns: columnConfig,
                    rowCallback: rowCallback,
                    drawCallback: drawCallback,
                };

                if (serverSide) {
                    datatableConfig.ajax = {
                        url: url,
                        type: 'post',
                        dataType: 'json',
                        data: function(params) {
                            let data = options.data ?? {};
                            if (typeof data == 'function') data = options.data({});

                            params["<?= csrf_token() ?>"] = '<?= csrf_hash() ?>';

                            for (let d in data) {
                                params[d] = data[d];
                            }

                            return params;
                        },
                    };
                } else if (!serverSide && data) {
                    datatableConfig.data = data;
                }

                let datatable = $table.DataTable(datatableConfig);

                $table.data('initDataTable', datatable);
            });

            if ($elements.length == 1) return $elements.data('initDataTable');

            return $elements.map((i, table) => {
                let $table = $(table);
                return $table.data('initDataTable');
            });
        },
        initTimePicker: function(options = {}, value = null) {
            let $elements = $(this);
            if (options.selector !== undefined) $elements = $(options.selector);

            $elements.attr('autocomplete', 'off');

            let timeFormat = options.timeFormat ?? 'HH:mm';
            let interval = options.interval ?? undefined;
            let minTime = options.minTime ?? undefined;
            let maxTime = options.maxTime ?? undefined;
            let defaultTime = options.defaultTime ?? undefined;
            let startTime = options.startTime ?? undefined;
            let dynamic = options.dynamic ?? false;
            let dropdown = options.dropdown ?? true;
            let scrollbar = options.scrollbar ?? true;
            let zindex = options.zindex ?? 9999;

            return $elements.timepicker({
                timeFormat: timeFormat,
                interval: interval,
                minTime: minTime,
                maxTime: maxTime,
                defaultTime: defaultTime,
                startTime: startTime,
                dynamic: dynamic,
                dropdown: dropdown,
                scrollbar: scrollbar,
                zindex: zindex,
            });
        }
    };

    $.fn.initSelect2 = FormsBuilder.initSelect2;
    $.fn.initDateRangePicker = FormsBuilder.initDateRangePicker;
    $.fn.doneTyping = FormsBuilder.doneTyping;
    $.fn.initNumberFormat = FormsBuilder.initNumberFormat;
    $.fn.formEditable = FormsBuilder.formEditable;
    $.fn.formRelease = FormsBuilder.formRelease;
    $.fn.inputDiscount = FormsBuilder.inputDiscount;
    $.fn.inputFile = FormsBuilder.inputFile;
    $.fn.filterPills = FormsBuilder.filterPills;
    $.fn.initDataTable = FormsBuilder.initDataTable;
    $.fn.initTimePicker = FormsBuilder.initTimePicker;

    FormsBuilder.initDateRangePicker({
        selector: '[data-toggle="daterangepicker"]'
    });

    FormsBuilder.initNumberFormat({
        selector: '[data-toggle="input-currency"]',
    });

    FormsBuilder.inputDiscount({
        selector: '[data-toggle="input-discount"]'
    });
</script>