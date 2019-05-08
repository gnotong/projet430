<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = "login";
$route['404_override'] = 'login/error';


/*********** USER DEFINED ROUTES *******************/

$route['dashboard'] = 'home';
$route['login'] = 'login/connect';
$route['logout'] = 'login/logout';

/*********** ADMIN CONTROLLER ROUTES *******************/
$route['noaccess'] = 'login/noaccess';
$route['user_list'] = 'admin/userList';
$route['user_list/(:num)'] = "admin/userList/$1";
$route['add_user'] = "admin/addUser";
$route['edit_user/(:num)'] = "admin/editUser/$1";
$route['delete_user'] = "admin/deleteUser";

/*********** RESOURCE CONTROLLER ROUTES *******************/
$route['resources'] = "resource/list";
$route['add_resource'] = "resource/create";
$route['edit_resource/(:num)'] = "resource/editResource/$1";
$route['deleteResource/(:num)'] = "resource/deleteResource/$1";

/*********** USER CONTROLLER ROUTES *******************/
$route['changePassword'] = "user/changePassword";
$route['not_found'] = "user/pageNotFound";
$route['check_email'] = "user/checkEmailExists";
$route['endResource/(:num)'] = "user/endResource/$1";
$route['eresource'] = "user/eresource";
$route['user_edit_profile'] = "user/editProfile";

/*********** FAKER *******************/
$route['fake_users'] = "fake/seedUser";
$route['fake_resources'] = "fake/seedResource";
$route['fake_categories'] = "fake/seedCategory";