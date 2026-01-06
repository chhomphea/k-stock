<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] 	= 'welcome';
$route['404_override'] 			= '';
$route['translate_uri_dashes'] 	= FALSE;
$route['users'] 				= 'auth/users';
$route['login'] 				= 'auth/login';
$route['logout'] 				= 'auth/logout';
$route['language/(:any)'] 		= 'auth/language/$1';
$route['users'] 				= 'auth/users';
$route['pos/(:num)'] 			= 'pos/index/$1';
$route['users/add'] 			= 'auth/create_user';
$route['logout/(:any)'] 		= 'auth/logout/$1';
$route['users/profile/(:num)'] 	= 'auth/profile/$1';
include 'api.php';
