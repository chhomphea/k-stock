<?php
$config['csrf_exclude_uris'] = array(
    'payments/paypalipn', 
    'payments/skrillipn',
     'welcome/image_upload',
     'sales/get_sale_payment',
     'admin/pos/save_receipt',
     'admin/pos/save_receiptsec',
    // api v1
    'api/v1/auth/login',
    'api/v1/auth/register',
    'api/v1/profile/edit',
    'api/v1/security/change-password',
    'api/v1/security/forgot-password',
    'api/v1/security/confirmation-code',
    'api/v1/security/create-password',
    'api/v1/auth/confirmation-register',
    'api/v1/auth/resent-verification-code',

    'api/v1/checkout/shipping/address/add',
    'api/v1/security/change-username',
    'api/v1/checkout/shipping/address/delete',
    'api/v1/checkout/shipping/address/update',
    'api/v1/checkout/add',
    'api/v1/checkout/save-receipt',
    'api/v1/favorite/toggle',
    'api/v1/favorite/clear',
    'api/v1/product/reviews/add',
    'api/v1/product/reviews/delete',
    'api/v1/product/reviews/update',
    'api/v1/buy/add',
    'api/v1/message/add_message',
    'api/v1/message/add_message',

    'admin/api/v1/auth/login',
    // ===============Card======================
    'admin/api/v1/shopping/cart/edit',
    'admin/api/v1/shopping/cart/add',
    'admin/api/v1/shopping/cart/remove',
    'admin/api/v1/shopping/cart/clear',

    // ===============Checkout==================

    'admin/api/v1/checkout/add',
    // 'admin/api/v1/checkout/print',
    
    // ================Customer===================
    'admin/api/v1/customer/add',
    'admin/api/v1/customer/edit',
    'admin/api/v1/customer/delete',
);
