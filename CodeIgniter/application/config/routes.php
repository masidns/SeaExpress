<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['API'] = 'Rest_server';

// penerima
$route['penerima']['get'] = 'api/penerima/getPenerima';
$route['penerima']['post'] = 'api/penerima/insertPenerima';
$route['penerima']['put'] = 'api/penerima/updatePenerima';
$route['penerima']['delete'] = 'api/penerima/deletePenerima';
// pengirim
$route['pengirim']['get'] = 'api/pengirim/getPengirim';
$route['pengirim']['post'] = 'api/pengirim/insertPengirim';
$route['pengirim']['put'] = 'api/pengirim/updatePengirim';
$route['pengirim']['delete'] = 'api/pengirim/deletePengirim';
// barang
$route['barang']['get'] = 'api/barang/getBarang';
$route['barang']['post'] = 'api/barang/insertBarang';
$route['barang']['put'] = 'api/barang/updateBarang';
$route['barang']['delete'] = 'api/barang/deleteBarang';
// Transaksi
$route['transaksi']['get'] = 'api/transaksi/getTransaksi';
$route['transaksi']['post'] = 'api/transaksi/insertTransaksi';
$route['transaksi']['put'] = 'api/transaksi/updateTransaksi';
$route['transaksi']['delete'] = 'api/transaksi/deleteTransaksi';
// Pembayaran
$route['pembayaran']['get'] = 'api/pembayaran/getPembayaran';
$route['pembayaran']['post'] = 'api/pembayaran/insertPembayaran';
$route['pembayaran']['put'] = 'api/pembayaran/updatePembayaran';
$route['pembayaran']['delete'] = 'api/pembayaran/deletePembayaran';
// users
$route['users']['get'] = 'api/users/Login';
// $route['users']['get'] = 'api/users/getUsers';
// $route['users']['post'] = 'api/users/insertUsers';
// $route['users']['put'] = 'api/users/updateUsers';
// $route['users']['delete'] = 'api/users/deleteUsers';
