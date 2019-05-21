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
$route['load_user_ajax/(:num)'] = "admin/userAjax/$1";
$route['add_user'] = "admin/addUser";
$route['edit_user/(:num)'] = "admin/editUser/$1";
$route['delete_user'] = "admin/deleteUser";

/*********** RESOURCE CONTROLLER ROUTES *******************/

$route['lessons'] = "lesson/list";
$route['add_lesson'] = "lesson/add";
$route['load_lesson_ajax/(:num)'] = "lesson/getDataAjax/$1";
$route['edit_lesson/(:num)'] = "lesson/edit/$1";
$route['delete_lesson/(:num)'] = "lesson/delete/$1";

$route['levels'] = "level/list";
$route['add_level'] = "level/add";
$route['edit_level/(:num)'] = "level/edit/$1";
$route['delete_level/(:num)'] = "level/delete/$1";

$route['semesters'] = "semester/list";
$route['add_semester'] = "semester/add";
$route['edit_semester/(:num)'] = "semester/edit/$1";
$route['data_semester/(:num)'] = "semester/getSemesterDatesAjax/$1";
$route['delete_semester/(:num)'] = "semester/delete/$1";

$route['resources'] = "resource/list";
$route['add_resource'] = "resource/create";
$route['load_rooms_ajax'] = "resource/getRoomsAjax";
$route['edit_resource/(:num)'] = "resource/editResource/$1";
$route['deleteResource/(:num)'] = "resource/deleteResource/$1";

/*********** USER CONTROLLER ROUTES *******************/
$route['changePassword'] = "user/changePassword";
$route['not_found'] = "user/pageNotFound";
$route['check_email'] = "user/checkEmailExists";
$route['endResource/(:num)'] = "user/endResource/$1";
$route['eresource'] = "user/eresource";
$route['user_edit_profile'] = "user/editProfile";


/*********** CALENDAR EVENTS *******************/
$route['resource_allocation'] = 'resourceAllocation';
$route['edit_allocation'] = 'resourceAllocation/edit';
$route['add_allocation'] = 'resourceAllocation/add';
$route['delete_allocation/(:num)'] = 'resourceAllocation/delete/$1';

/*********** FAKER *******************/
$route['fake_users'] = "fake/seedUser";
$route['fake_resources'] = "fake/seedResource";
$route['fake_categories'] = "fake/seedCategory";
