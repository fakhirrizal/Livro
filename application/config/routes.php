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
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = 'Auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/* User */
$route['data_peta'] = 'guest/Dashboard/main_map';
$route['data_peta_provinsi/(:any)'] = 'guest/Dashboard/map_province/$1';
$route['data_peta_provinsi'] = 'guest/Dashboard/map_province';
$route['data_peta_kabupaten/(:any)'] = 'guest/Dashboard/map_region/$1';
$route['data_peta_kabupaten'] = 'guest/Dashboard/map_region';
$route['data_peta_kecamatan/(:any)'] = 'guest/Dashboard/map_district/$1';
$route['data_peta_kecamatan'] = 'guest/Dashboard/map_district';
$route['data_grafik'] = 'guest/Dashboard/main_graph';
$route['info'] = 'guest/App/info';

/* Auth */
$route['login'] = 'Auth/login';
$route['login_process'] = 'Auth/login_process';
$route['registrasi'] = 'Auth/registration';
$route['register_process'] = 'Auth/register_process';
$route['logout'] = 'Auth/logout';

/* Admin */
$route['admin_side/launcher'] = 'admin/App/launcher';
$route['admin_side/beranda'] = 'admin/App/home';
$route['admin_side/menu'] = 'admin/App/menu';
$route['admin_side/log_activity'] = 'admin/App/log_activity';
$route['admin_side/cleaning_log'] = 'admin/App/cleaning_log';
$route['admin_side/tentang_aplikasi'] = 'admin/App/about';
$route['admin_side/bantuan'] = 'admin/App/helper';

$route['admin_side/dasbor_peta'] = 'admin/Dashboard';
$route['admin_side/peta_provinsi/(:any)'] = 'admin/Dashboard/province/$1';
$route['admin_side/peta_kabupaten/(:any)'] = 'admin/Dashboard/city/$1';
$route['admin_side/peta_kecamatan/(:any)'] = 'admin/Dashboard/sub_district/$1';

$route['admin_side/dasbor_grafik'] = 'admin/Dashboard/main_graph';
$route['admin_side/dasbor_grafik_provinsi/(:any)/(:any)'] = 'admin/Dashboard/graph_province/$1/$2';
$route['admin_side/dasbor_grafik_kabupaten/(:any)/(:any)'] = 'admin/Dashboard/graph_region/$1/$2';
$route['admin_side/dasbor_grafik_kecamatan/(:any)/(:any)'] = 'admin/Dashboard/graph_district/$1/$2';

$route['admin_side/karyawan'] = 'admin/Master/karyawan_data';
$route['admin_side/tambah_data_karyawan'] = 'admin/Master/add_karyawan_data';
$route['admin_side/simpan_data_karyawan'] = 'admin/Master/save_karyawan_data';
$route['admin_side/detail_data_karyawan/(:any)'] = 'admin/Master/detail_karyawan_data/$1';
$route['admin_side/ubah_data_karyawan/(:any)'] = 'admin/Master/edit_karyawan_data/$1';
$route['admin_side/perbarui_data_karyawan'] = 'admin/Master/update_karyawan_data';
$route['admin_side/atur_ulang_kata_sandi_karyawan/(:any)'] = 'admin/Master/reset_password_karyawan_account/$1';
$route['admin_side/non_aktifkan_akun_karyawan/(:any)'] = 'admin/Master/non_aktifkan_akun_karyawan/$1';
$route['admin_side/hapus_data_karyawan/(:any)'] = 'admin/Master/delete_karyawan_data/$1';

$route['admin_side/barang'] = 'admin/Master/barang_data';
$route['admin_side/tambah_data_barang'] = 'admin/Master/add_barang_data';
$route['admin_side/simpan_data_barang'] = 'admin/Master/save_barang_data';
$route['admin_side/detil_data_barang/(:any)'] = 'admin/Master/detail_barang_data/$1';
$route['admin_side/ubah_data_barang/(:any)'] = 'admin/Master/edit_barang_data/$1';
$route['admin_side/perbarui_data_barang'] = 'admin/Master/update_barang_data';
$route['admin_side/simpan_data_anggota_barang'] = 'admin/Master/save_barang_member';
$route['admin_side/perbarui_data_anggota_barang'] = 'admin/Master/update_barang_member';
$route['admin_side/atur_ulang_kata_sandi_anggota_barang/(:any)'] = 'admin/Master/reset_password_barang_member_account/$1';
$route['admin_side/hapus_data_barang/(:any)'] = 'admin/Master/delete_barang_data/$1';
$route['admin_side/hapus_data_anggota_barang/(:any)'] = 'admin/Master/delete_barang_member/$1';

$route['admin_side/laporan_infus'] = 'admin/Report/laporan_infus';
$route['admin_side/tambah_laporan_infus'] = 'admin/Report/tambah_laporan_infus';
$route['admin_side/tambah_laporan_infus_1'] = 'admin/Report/tambah_laporan_infus_1';
$route['admin_side/tambah_barang_infus'] = 'admin/Report/tambah_barang_infus';
$route['admin_side/hapus_barang_infus/(:any)'] = 'admin/Report/hapus_barang_infus/$1';
$route['admin_side/tambah_laporan_infus_2'] = 'admin/Report/tambah_laporan_infus_2';
$route['admin_side/simpan_data_laporan_infus'] = 'admin/Report/simpan_data_laporan_infus';
$route['admin_side/simpan_laporan_stok_infus_barang'] = 'admin/Report/simpan_laporan_stok_infus_barang';
$route['admin_side/detail_data_stok_infus/(:any)'] = 'admin/Report/detail_data_stok_infus/$1';
$route['admin_side/ubah_data_stok_infus/(:any)'] = 'admin/Report/ubah_data_stok_infus/$1';
$route['admin_side/daftar_barang_stok_infus/(:any)'] = 'admin/Report/daftar_barang_stok_infus/$1';
$route['admin_side/perbarui_data_stok_infus'] = 'admin/Report/perbarui_data_stok_infus';
$route['admin_side/perbarui_status_data_stok_infus'] = 'admin/Report/perbarui_status_data_stok_infus';
$route['admin_side/download_rekap_infus_barang'] = 'admin/Report/download_rekap_infus_barang';
$route['admin_side/hapus_data_stok_infus_barang/(:any)'] = 'admin/Report/hapus_data_stok_infus_barang/$1';
$route['admin_side/hapus_data_stok_infus/(:any)'] = 'admin/Report/hapus_data_stok_infus/$1';

$route['admin_side/laporan_opname'] = 'admin/Report/laporan_opname';
$route['admin_side/tambah_laporan_opname'] = 'admin/Report/tambah_laporan_opname';
$route['admin_side/tambah_laporan_opname_1'] = 'admin/Report/tambah_laporan_opname_1';
$route['admin_side/tambah_barang_opname'] = 'admin/Report/tambah_barang_opname';
$route['admin_side/hapus_barang_opname/(:any)'] = 'admin/Report/hapus_barang_opname/$1';
$route['admin_side/tambah_laporan_opname_2'] = 'admin/Report/tambah_laporan_opname_2';
$route['admin_side/simpan_data_laporan_opname'] = 'admin/Report/simpan_data_laporan_opname';
$route['admin_side/detail_data_stok_opname/(:any)'] = 'admin/Report/detail_data_stok_opname/$1';
$route['admin_side/ubah_data_stok_opname/(:any)'] = 'admin/Report/ubah_data_stok_opname/$1';
$route['admin_side/perbarui_data_stok_opname'] = 'admin/Report/perbarui_data_stok_opname';
$route['admin_side/perbarui_status_data_stok_opname'] = 'admin/Report/perbarui_status_data_stok_opname';
$route['admin_side/hapus_data_stok_opname_barang/(:any)'] = 'admin/Report/hapus_data_stok_opname_barang/$1';
$route['admin_side/hapus_data_stok_opname/(:any)'] = 'admin/Report/hapus_data_stok_opname/$1';

/* Head Store */
$route['spv_side/launcher'] = 'spv/App/launcher';
$route['spv_side/beranda'] = 'spv/App/home';
$route['spv_side/menu'] = 'spv/App/menu';
$route['spv_side/log_activity'] = 'spv/App/log_activity';
$route['spv_side/cleaning_log'] = 'spv/App/cleaning_log';
$route['spv_side/tentang_aplikasi'] = 'spv/App/about';
$route['spv_side/bantuan'] = 'spv/App/helper';

$route['spv/barang'] = 'spv/Master/barang_data';
$route['spv/tambah_data_barang'] = 'spv/Master/add_barang_data';
$route['spv/simpan_data_barang'] = 'spv/Master/save_barang_data';
$route['spv/detil_data_barang/(:any)'] = 'spv/Master/detail_barang_data/$1';
$route['spv/ubah_data_barang/(:any)'] = 'spv/Master/edit_barang_data/$1';
$route['spv/perbarui_data_barang'] = 'spv/Master/update_barang_data';
$route['spv/simpan_data_anggota_barang'] = 'spv/Master/save_barang_member';
$route['spv/perbarui_data_anggota_barang'] = 'spv/Master/update_barang_member';
$route['spv/atur_ulang_kata_sandi_anggota_barang/(:any)'] = 'spv/Master/reset_password_barang_member_account/$1';
$route['spv/hapus_data_barang/(:any)'] = 'spv/Master/delete_barang_data/$1';
$route['spv/hapus_data_anggota_barang/(:any)'] = 'spv/Master/delete_barang_member/$1';

$route['spv_side/laporan_infus'] = 'spv/Report/laporan_infus';
$route['spv_side/tambah_laporan_infus'] = 'spv/Report/tambah_laporan_infus';
$route['spv_side/tambah_laporan_infus_1'] = 'spv/Report/tambah_laporan_infus_1';
$route['spv_side/tambah_barang_infus'] = 'spv/Report/tambah_barang_infus';
$route['spv_side/hapus_barang_infus/(:any)'] = 'spv/Report/hapus_barang_infus/$1';
$route['spv_side/tambah_laporan_infus_2'] = 'spv/Report/tambah_laporan_infus_2';
$route['spv_side/simpan_data_laporan_infus'] = 'spv/Report/simpan_data_laporan_infus';
$route['spv_side/simpan_laporan_stok_infus_barang'] = 'spv/Report/simpan_laporan_stok_infus_barang';
$route['spv_side/detail_data_stok_infus/(:any)'] = 'spv/Report/detail_data_stok_infus/$1';
$route['spv_side/ubah_data_stok_infus/(:any)'] = 'spv/Report/ubah_data_stok_infus/$1';
$route['spv_side/daftar_barang_stok_infus/(:any)'] = 'spv/Report/daftar_barang_stok_infus/$1';
$route['spv_side/perbarui_data_stok_infus'] = 'spv/Report/perbarui_data_stok_infus';
$route['spv_side/perbarui_status_data_stok_infus'] = 'spv/Report/perbarui_status_data_stok_infus';
$route['spv_side/hapus_data_stok_infus_barang/(:any)'] = 'spv/Report/hapus_data_stok_infus_barang/$1';
$route['spv_side/hapus_data_stok_infus/(:any)'] = 'spv/Report/hapus_data_stok_infus/$1';

$route['spv_side/laporan_opname'] = 'spv/Report/laporan_opname';
$route['spv_side/tambah_laporan_opname'] = 'spv/Report/tambah_laporan_opname';
$route['spv_side/tambah_laporan_opname_1'] = 'spv/Report/tambah_laporan_opname_1';
$route['spv_side/tambah_barang_opname'] = 'spv/Report/tambah_barang_opname';
$route['spv_side/hapus_barang_opname/(:any)'] = 'spv/Report/hapus_barang_opname/$1';
$route['spv_side/tambah_laporan_opname_2'] = 'spv/Report/tambah_laporan_opname_2';
$route['spv_side/simpan_data_laporan_opname'] = 'spv/Report/simpan_data_laporan_opname';
$route['spv_side/detail_data_stok_opname/(:any)'] = 'spv/Report/detail_data_stok_opname/$1';
$route['spv_side/ubah_data_stok_opname/(:any)'] = 'spv/Report/ubah_data_stok_opname/$1';
$route['spv_side/perbarui_data_stok_opname'] = 'spv/Report/perbarui_data_stok_opname';
$route['spv_side/perbarui_status_data_stok_opname'] = 'spv/Report/perbarui_status_data_stok_opname';
$route['spv_side/hapus_data_stok_opname_barang/(:any)'] = 'spv/Report/hapus_data_stok_opname_barang/$1';
$route['spv_side/hapus_data_stok_opname/(:any)'] = 'spv/Report/hapus_data_stok_opname/$1';

/* Member a.k.a Karyawan */
$route['member_side/launcher'] = 'member/App/launcher';
$route['member_side/beranda'] = 'member/App/home';
$route['member_side/menu'] = 'member/App/menu';
$route['member_side/log_activity'] = 'member/App/log_activity';
$route['member_side/cleaning_log'] = 'member/App/cleaning_log';
$route['member_side/tentang_aplikasi'] = 'member/App/about';
$route['member_side/bantuan'] = 'member/App/helper';

$route['spv/barang'] = 'spv/Master/barang_data';
$route['spv/tambah_data_barang'] = 'spv/Master/add_barang_data';
$route['spv/simpan_data_barang'] = 'spv/Master/save_barang_data';
$route['spv/detil_data_barang/(:any)'] = 'spv/Master/detail_barang_data/$1';
$route['spv/ubah_data_barang/(:any)'] = 'spv/Master/edit_barang_data/$1';
$route['spv/perbarui_data_barang'] = 'spv/Master/update_barang_data';
$route['spv/simpan_data_anggota_barang'] = 'spv/Master/save_barang_member';
$route['spv/perbarui_data_anggota_barang'] = 'spv/Master/update_barang_member';
$route['spv/atur_ulang_kata_sandi_anggota_barang/(:any)'] = 'spv/Master/reset_password_barang_member_account/$1';
$route['spv/hapus_data_barang/(:any)'] = 'spv/Master/delete_barang_data/$1';
$route['spv/hapus_data_anggota_barang/(:any)'] = 'spv/Master/delete_barang_member/$1';

$route['member_side/laporan_infus'] = 'member/Report/laporan_infus';
$route['member_side/tambah_laporan_infus'] = 'member/Report/tambah_laporan_infus';
$route['member_side/tambah_laporan_infus_1'] = 'member/Report/tambah_laporan_infus_1';
$route['member_side/tambah_barang_infus'] = 'member/Report/tambah_barang_infus';
$route['member_side/hapus_barang_infus/(:any)'] = 'member/Report/hapus_barang_infus/$1';
$route['member_side/tambah_laporan_infus_2'] = 'member/Report/tambah_laporan_infus_2';
$route['member_side/simpan_data_laporan_infus'] = 'member/Report/simpan_data_laporan_infus';
$route['member_side/detail_data_stok_infus/(:any)'] = 'member/Report/detail_data_stok_infus/$1';
$route['member_side/ubah_data_stok_infus/(:any)'] = 'member/Report/ubah_data_stok_infus/$1';
$route['member_side/perbarui_data_stok_infus'] = 'member/Report/perbarui_data_stok_infus';
$route['member_side/perbarui_data_barang_request_stok_infus'] = 'member/Report/perbarui_data_barang_request_stok_infus';
$route['member_side/hapus_data_stok_infus_barang/(:any)'] = 'member/Report/hapus_data_stok_infus_barang/$1';
$route['member_side/hapus_data_stok_infus/(:any)'] = 'member/Report/hapus_data_stok_infus/$1';

$route['member_side/laporan_opname'] = 'member/Report/laporan_opname';
$route['member_side/tambah_laporan_opname'] = 'member/Report/tambah_laporan_opname';
$route['member_side/tambah_laporan_opname_1'] = 'member/Report/tambah_laporan_opname_1';
$route['member_side/tambah_barang_opname'] = 'member/Report/tambah_barang_opname';
$route['member_side/hapus_barang_opname/(:any)'] = 'member/Report/hapus_barang_opname/$1';
$route['member_side/tambah_laporan_opname_2'] = 'member/Report/tambah_laporan_opname_2';
$route['member_side/simpan_data_laporan_opname'] = 'member/Report/simpan_data_laporan_opname';
$route['member_side/detail_data_stok_opname/(:any)'] = 'member/Report/detail_data_stok_opname/$1';
$route['member_side/ubah_data_stok_opname/(:any)'] = 'member/Report/ubah_data_stok_opname/$1';
$route['member_side/perbarui_data_stok_opname'] = 'member/Report/perbarui_data_stok_opname';
$route['member_side/perbarui_status_data_stok_opname'] = 'member/Report/perbarui_status_data_stok_opname';
$route['member_side/hapus_data_stok_opname_barang/(:any)'] = 'member/Report/hapus_data_stok_opname_barang/$1';
$route['member_side/hapus_data_stok_opname/(:any)'] = 'member/Report/hapus_data_stok_opname/$1';

/* REST API */
$route['api'] = 'Rest_server/documentation';

$route['api/login'] = 'api/auth/Login';
$route['api/change_password'] = 'api/auth/Change_password';

$route['api/indikator'] = 'api/master/Indikator';
$route['api/user_data'] = 'api/master/User_data';
$route['api/device'] = 'api/master/Device';
$route['api/provinsi'] = 'api/master/Provinsi';
$route['api/kabupaten'] = 'api/master/Kabupaten';
$route['api/kecamatan'] = 'api/master/Kecamatan';
$route['api/desa'] = 'api/master/Desa';

$route['api/barang'] = 'api/barang/Master';
$route['api/anggota_barang'] = 'api/barang/Member';
$route['api/laporan_barang'] = 'api/barang/Report';

$route['api/rutilahu'] = 'api/rutilahu/Master';
$route['api/anggota_rutilahu'] = 'api/rutilahu/Member';
$route['api/laporan_rutilahu'] = 'api/rutilahu/Report';

$route['api/sarling'] = 'api/sarling/Master';
$route['api/anggota_sarling'] = 'api/sarling/Member';
$route['api/laporan_sarling'] = 'api/sarling/Report';

$route['api/hapus_laporan'] = 'api/Other/delete_report';

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8