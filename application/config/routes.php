<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//API routes


//user routes
$route['default_controller'] = 'pages/view';

$route['users/register'] = 'users/register';
$route['users/dashboard'] = 'users/dashboard';
$route['users/change-password'] = 'users/change_password';
$route['users/import'] = 'users/uploadCsv';
$route['users/cars'] = 'users/get_cars';
$route['users/cars/update/(:any)'] = 'users/update_cars/$1';
$route['users/forget-password'] = 'users/forget_password';
$route['users/reset-password/(:any)'] = 'users/reset_password/$1';

//admin routs
$route['administrator'] = 'administrator/view';
$route['administrator/cars'] = 'administrator/get_cars';
$route['administrator/cars/update/(:any)'] = 'administrator/update_cars/$1';
$route['administrator/models'] = 'administrator/get_cars';
$route['administrator/models/update/(:any)'] = 'administrator/update_cars/$1';
$route['administrator/dealers'] = 'administrator/get_dealers';
$route['administrator/dealers/update/(:any)'] = 'administrator/update_dealers/$1';
$route['administrator/category'] = 'administrator/get_category';
$route['administrator/category/update/(:any)'] = 'administrator/update_category/$1';


$route['administrator/import'] = 'administrator/uploadCsv';
$route['administrator/readcsv'] = 'administrator/readcsv';


$route['administrator/home'] = 'administrator/home';
$route['administrator/index'] = 'administrator/view';
$route['administrator/forget-password'] = 'administrator/forget_password';
$route['administrator/reset-password/(:any)'] = 'administrator/reset_password/$1';

$route['administrator/dashboard'] = 'administrator/dashboard';

$route['administrator/change-password'] = 'administrator/get_admin_data';
$route['administrator/update-profile'] = 'administrator/update_admin_profile';

$route['administrator/users/add-user'] = 'administrator/add_user';
$route['administrator/users'] = 'administrator/users';
$route['administrator/users/update-user/(:any)'] = 'administrator/update_user/$1';


$route['(:any)'] = 'pages/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;










