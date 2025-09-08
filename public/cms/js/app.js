const LoadPrivileges = function () {
    this.elements = {
        list: {
            company: $('#list-company'),
            store: $('#list-store'),
            warehouse: $('#list-warehouse'),
            companyPhone: $('#list-company-hp'),
            storePhone: $('#list-store-hp'),
            warehousePhone: $('#list-warehouse-hp'),
        }
    };

    return this;
};

LoadPrivileges.prototype.createItemList = function (id, text, action) {
    return $('<div>', { class: 'dropdown-item dflex item-start', 'data-id': id, 'onclick': action }).append(
        $('<i>', { class: 'bx bx-chevron-right-circle bx-xs margin-r-3' }),
        $('<span>', { class: 'fs-7set text-dark' }).html(text),
    );
};

LoadPrivileges.prototype.init = function () {
    let data = {};
    data[$('meta[name="csrf_header"]').attr('content')] = $('meta[name="csrf"]').attr('content');

    $.ajax({
        url: `${$('base').attr('href')}/personal/getprivileges`,
        type: 'post',
        data: data,
        dataType: 'json',
    }).done((res) => {

        this.elements.list.company.empty();
        this.elements.list.companyPhone.empty();
        res.companies.forEach((company) => {
            this.elements.list.company.append(this.createItemList(company.companyid, company.companyname, 'change_company(this)'));
            this.elements.list.companyPhone.append(this.createItemList(company.companyid, company.companyname, 'change_company(this)'));
        });

        this.elements.list.store.empty();
        this.elements.list.storePhone.empty();
        res.userstores.forEach((store) => {
            this.elements.list.store.append(this.createItemList(store.storeid, store.storename, 'change_store(this)'));
            this.elements.list.storePhone.append(this.createItemList(store.storeid, store.storename, 'change_store(this)'));
        });

        this.elements.list.warehouse.empty();
        this.elements.list.warehousePhone.empty();
        res.warehouses.forEach((warehouse) => {
            this.elements.list.warehouse.append(this.createItemList(warehouse.warehouseid, warehouse.warehousename, 'change_warehouse(this)'));
            this.elements.list.warehousePhone.append(this.createItemList(warehouse.warehouseid, warehouse.warehousename, 'change_warehouse(this)'));
        });
    }).fail(() => { });
};

var notif = new Notyf({
    position: {
        x: 'right',
        y: 'top',
    }
});

function showSuccess(msg) {
    notif.success(msg);
}

function showError(msg) {
    notif.error(msg);
}

function showNotif(type, msg) {
    notif.open({
        type: type,
        message: msg,
    });
}