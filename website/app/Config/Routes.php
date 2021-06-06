<?php namespace Config;

// Create a new instance of our RouteCollection class.
use app\Common;

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->addRedirect('/', 'home/');

$routes->get('user/login/', Common::ENVIRONMENT . '\UserLoginController::index');
$routes->post('user/login/request/', Common::ENVIRONMENT . '\UserLoginController::request');

$routes->get('home/', Common::ENVIRONMENT . '\HomeController::index');
$routes->post('home/request', Common::ENVIRONMENT . '\HomeController::request');

$routes->get('user/logout/', Common::ENVIRONMENT . '\UserLogoutController::index');

$routes->get('user/create/', Common::ENVIRONMENT . '\UserCreateController::index');
$routes->post('user/create/request/', Common::ENVIRONMENT . '\UserCreateController::request');

$routes->get('user/change-password/', Common::ENVIRONMENT . '\UserChangePasswordController::index');
$routes->post('user/change-password/request/', Common::ENVIRONMENT . '\UserChangePasswordController::request');

$routes->post('user/change-level/request/', Common::ENVIRONMENT . '\UserChangeLevelController::request');
$routes->post('user/delete/request/', Common::ENVIRONMENT . '\UserDeleteController::request');

$routes->get('user/management/', Common::ENVIRONMENT . '\UserManagementController::index');
$routes->post('user/management/request/', Common::ENVIRONMENT . '\UserManagementController::request');

$routes->get('land/create/', Common::ENVIRONMENT . '\LandCreateController::index');
$routes->post('land/create/request/', Common::ENVIRONMENT . '\LandCreateController::request');

$routes->addRedirect('land/management/', 'home/');
$routes->get('land/management/(:any)', Common::ENVIRONMENT . '\LandManagementController::index/$1');

$routes->post('threshold/change-values/request/', Common::ENVIRONMENT . '\ThresholdChangeValuesController::request');

$routes->post('sonde/obtain/request/', Common::ENVIRONMENT . '\SondeObtainController::request');

$routes->post('occupation/change-values/request/', Common::ENVIRONMENT . '\OccupationChangeValuesController::request');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
