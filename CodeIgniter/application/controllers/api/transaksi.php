<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

class transaksi extends API_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('transaksi_model', 'transaksimodel');
    }

    public function getTransaksi(){
        $No = $_GET;
        $result = $this->transaksimodel->get($No);
        if(!empty($result)){
            $this->api_return(
                [
                    "data"=>$result
                ], 200
            );
        }else{
                $this->api_return(
                    [
                        "data"=>"data Kosong"
                    ], 400
                );
            }
        }
    
    public function insertTransaksi(){
        $post = json_decode($this->input->raw_input_stream);
        $data = $this->transaksimodel->insert($post);
        if($data){
            $this->api_return(
                [
                    'status'=> true,
                    'data'=>$data
                ],200
            );
        }else{
            $this->api_return(
                [
                    'status'=> false,
                ],400
            );
        }
    }

    public function updateTransaksi(){
        $post = json_decode($this->input->raw_input_stream);
        $data = $this->transaksimodel->update($post);
        if($data){
            $this->api_return(
                [
                    'status'=>true,
                ],200
            );
        }else{
            $this->api_return(
                [
                    'status'=>false,
                ],400
            );
        }
    }

    public function deleteTransaksi(){
        $No = $_GET;
        $result = $this->transaksimodel->delete($No);
        if($result){
            $this->api_return(
                [
                    'status'=>true,
                ],200
            );
        }else{
            $this->api_return(
                [
                    'status'=>false,
                ],400
            );
        }
    }
}



?>