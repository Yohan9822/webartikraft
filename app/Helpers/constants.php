<?php

class AccessCode
{

    const view = 'view';
    const create = 'create';
    const update = 'update';
    const delete = 'delete';
    const history = 'history';
    const release = 'release';
    const unrelease = 'unrelease';

    const updateParam = 'update-param';
}

class CategoryCode
{
    const userType = 'usertype';
    const paymethod = 'paymethod';
    const statusProduction = 'spk-status';
    const rajaOngkirVehicle = 'rajaongkir-vehicle';
    const paymentDelivery = 'payment-delivery';
}

class StatusOrder
{
    const cart = 'cart';
    const waitingPayment = 'waiting-payment';
    const new = 'new';
    const paid = 'paid';
    const verified = 'verified';
    const process = 'on-process';
    const packing = 'on-packing';
    const delivery = 'on-delivery';
    const received = 'received';
}

class NotesOrder
{
    const createCartOrder     = "Pesanan telah ditambahkan ke keranjang";
    const waitingPaymentStatus = "Menunggu pembayaran dari Anda";
    const paidStatus           = "Pembayaran telah diterima";
    const verifiedStatus       = "Pembayaran berhasil diverifikasi";
    const onProcessStatus      = "Pesanan sedang diproses";
    const onPackingStatus      = "Pesanan sedang dikemas";
    const onDeliveryStatus     = "Pesanan sedang dalam perjalanan";
    const receivedStatus       = "Pesanan telah diterima. Terima kasih telah berbelanja!";
}

class StatusDelivery
{
    const reqPickUp = 'do-reqpickup';
    const sent = 'do-sent';
    const received = 'do-received';
}

class StatusProduction
{
    const new = 'new-spk';
    const packing = 'packing';
    const shipping = 'shipping';
}

class StatusReseller
{
    const requested = 'requested';
    const approved = 'approved';
    const rejected = 'rejected';
    const created = 'created';
}

class ConfigCode
{

    const blueStickerApi = 'BLUESTICKER';
    const xenditApi = 'XENDIT_API';
    const googleApi = 'GOOGLE_API';
    const logTable = 'LOG_TABLE';
    const rajaOngkirApi = 'RAJA_ONGKIR_API';
    const general = 'GENERAL_CONFIG';
    const mail = 'MAIL_CONFIG';
}

class OrderType
{
    const byCourier = 'by_courier';
    const selfPickUp = 'self_pickup';
}

class TableName
{
    const msuser = 'master.msuser';
    const msusergroup = 'master.msusergroup';
    const mscompany = 'master.mscompany';
    const msmaterial = 'master.msmaterial';
    const mslamination = 'master.mslamination';
    const msshape = 'master.msshape';
    const mscustomer = 'master.mscustomer';
    const msaddress = 'master.msaddress';
}

class ParameterType
{
    const selling = 'sellingprice';
    const commission = 'commission';
}
