<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/', 'ApplicationController::index');
$routes->post('application/submit', 'ApplicationController::submit');
$routes->get('thank-you', 'ApplicationController::thankYou');
$routes->get('applications', 'ApplicationController::viewApplications');
$routes->get('applications/get-stats', 'ApplicationController::getStats');
$routes->get('admin/applications', 'ApplicationController::viewApplications');
//$routes->post('admin/application/submit', 'ApplicationController::submit');
//$routes->get('admin/thank-you', 'ApplicationController::thankYou');

//login routes
$routes->get('auth/login', 'AuthController::login');
$routes->post('auth/login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->post('admin/auth/login', 'AuthController::login');
$routes->get('auth/logout', 'AuthController::logout');

//status route
$routes->post('applications/update-status', 'ApplicationController::updateStatus');

//Postion
$routes->post('applications/update-position', 'ApplicationController::updatePosition');
$routes->post('admin/applications/update-position', 'ApplicationController::updatePosition');

//Resume viewing route
$routes->get('view-resume/(:segment)', 'ApplicationController::viewResume/$1');

// Settings
$routes->get('admin/settings', 'AdminController::settings');
$routes->post('admin/add-user', 'AdminController::addUser');
$routes->post('admin/delete-user', 'AdminController::deleteUser');
$routes->post('admin/edit-user', 'AdminController::editUser');
$routes->get('superadmin/settings', 'SuperAdminController::settings');
$routes->post('superadmin/add-user', 'SuperAdminController::addUser');
$routes->post('superadmin/delete-user', 'SuperAdminController::deleteUser');
$routes->post('superadmin/edit-user', 'SuperAdminController::editUser');

//ajax for searching....
$routes->get('applications/ajax-applications', 'ApplicationController::ajaxApplications');
$routes->post('applications/update-interview-schedule', 'ApplicationController::updateInterviewSchedule');
$routes->post('applications/assign-interviewer', 'ApplicationController::assignInterviewer');

$routes->get('compose-demo', 'ComposeController::demo');
$routes->post('compose-demo/save', 'ComposeController::save');
$routes->get('admin/applications/ajax-applications', 'ApplicationController::ajaxApplications');
$routes->post('admin/applications/update-interview-schedule', 'ApplicationController::updateInterviewSchedule');
