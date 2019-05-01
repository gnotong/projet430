<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = "login";
$route['404_override'] = 'login/error';


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';

/*********** ADMIN CONTROLLER ROUTES *******************/
$route['noaccess'] = 'login/noaccess';
$route['user_list'] = 'admin/userList';
$route['user_list/(:num)'] = "admin/userList/$1";
$route['add_user'] = "admin/addUser";
$route['edit_user/(:num)'] = "admin/editUser/$1";
$route['deleteUser'] = "admin/deleteUser";

/*********** RESOURCE CONTROLLER ROUTES *******************/
$route['resources'] = "resource/list";
$route['add_resource'] = "resource/create";
$route['edit_resource/(:num)'] = "resource/editResource/$1";
$route['deleteResource/(:num)'] = "resource/deleteResource/$1";

/*********** USER CONTROLLER ROUTES *******************/
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['endResource/(:num)'] = "user/endResource/$1";
$route['eresource'] = "user/eresource";
$route['user_edit_profile'] = "user/editProfile";

/*********** LOGIN CONTROLLER ROUTES *******************/
$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

/*********** FAKER *******************/
$route['fake_users'] = "fake/seedUser";
$route['fake_resources'] = "fake/seedResource";
$route['fake_categories'] = "fake/seedCategory";