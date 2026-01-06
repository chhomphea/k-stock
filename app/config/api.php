<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: OPTIONS, POST, GET, TRACE, PATCH, PUT, DELETE");
header("Access-Control-Allow-Credentials: true");
/*=====  auth  ======*/
$route['admin/api/v1/auth/login'] = 'api/Auth/login';
$route['admin/api/v1/profile']    = 'api/Profile/index';
/*===============  cart  ==================*/
$route['admin/api/v1/shopping/cart'] = 'api/Cart/index';
$route['admin/api/v1/shopping/cart/add'] = 'api/Cart/store';
$route['admin/api/v1/shopping/cart/edit'] = 'api/Cart/update';
$route['admin/api/v1/shopping/cart/remove'] = 'api/Cart/delete_cart';
$route['admin/api/v1/shopping/cart/clear'] = 'api/Cart/clear_cart';
/*===============  Checkout  ==================*/
$route['admin/api/v1/checkout/prints'] = 'api/Checkout/print';
$route['admin/api/v1/checkout/hell'] = 'api/Checkout/hello';

$route['admin/api/v1/checkout/add'] = 'api/Checkout/index';
$route['admin/api/v1/checkout'] = 'api/Checkout/order_history';
/*===============  Customer  ==================*/
$route['admin/api/v1/customer/search'] = 'api/Customer/search';
$route['admin/api/v1/customer'] = 'api/Customer/index';
$route['admin/api/v1/customer/check'] = 'api/Customer/check';
$route['admin/api/v1/customer/product_bytable'] = 'api/Customer/product_ordered';
$route['admin/api/v1/customer/free'] = 'api/Customer/table_free';
$route['admin/api/v1/customer/transfer'] = 'api/Customer/transfertable';
$route['admin/api/v1/customer/add'] = 'api/Customer/add_customer';
$route['admin/api/v1/customer/edit'] = 'api/Customer/edit_customer';
$route['admin/api/v1/customer/delete'] = 'api/Customer/delete_customer';
$route['admin/api/v1/customer/tablegroup'] = 'api/Customer/grouptable';
$route['admin/api/v1/customer/update_pax'] = 'api/Customer/update_pax';
// =============================Product=============================
$route['admin/api/v1/categories'] = 'api/Main/categories';
$route['admin/api/v1/product'] = 'api/Product/product_category';
$route['admin/api/v1/product_modify'] = 'api/Product/product_modify';