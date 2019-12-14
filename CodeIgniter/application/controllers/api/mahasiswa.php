<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';
class Mahasiswa extends API_Controller
{
public function __construct() {
parent::__construct();
}
public function Panggil()
{
$message = [
'NPM' => '201911xxxx',
'Nama' => 'Anthoneta',
'Jenis Kelamin' => "Tidak Jelas",
'Alamat' => 'Tidak Tau',
'Pekerjaan' => 'Kupu-kupu'
];
$this->api_return(
[
'status' => true,
"result" => $message
],
200);
}
}<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';
class Mahasiswa extends API_Controller
{
public function __construct() {
parent::__construct();
$this->load->model('Mahasiswa_model', 'MahasiswaModel');
}
public function Panggil()
{
$Output = $this->MahasiswaModel->GetMahasiswa();
$this->api_return(
[
'status' => true,
"result" => $Output
],
200);
}