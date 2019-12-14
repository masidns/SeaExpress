<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

class barang extends API_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('barang_model', 'barangmodel');
    }

    public function getBarang(){
        $No = $_GET;
        $result = $this->barangmodel->get($No);
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
    
    public function insertBarang(){
        $post = json_decode($this->input->raw_input_stream);
        $data = $this->barangmodel->insert($post);
        if($data){
            $this->api_return(
                [
                    'status'=> true,
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

    public function updateBarang(){
        $post = json_decode($this->input->raw_input_stream);
        $data = $this->barangmodel->update($post);
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

    public function deleteBarang(){
        $No = $_GET;
        $result = $this->barangmodel->delete($No);
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