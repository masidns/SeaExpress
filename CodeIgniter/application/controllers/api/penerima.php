<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

class penerima extends API_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('penerima_model', 'penerimamodel');
    }
    public function getPenerima(){
        $id = $_GET;
        $result = $this->penerimamodel->get($id);
        if(!empty($result)){
            $this->api_return(
                [
                    "data"=>$result
                ], 200
            );
        }else{
            $this->api_return(
                [
                    "data" => "Data Kosong"
                ], 400
            );
        }
        
    }
    Public function insertPenerima(){
        $post = json_decode($this->input->raw_input_stream);
        $data = $this->penerimamodel->insert($post);
        if($data){
            $this->api_return(
                [
                    'status' => true,
                ], 
                200); 
        }else{
            $this->api_return(
                [
                    'status' => false,
                ], 400);
        }
   }
    public function updatePenerima(){
        $data = json_decode($this->input->raw_input_stream);
        $result = $this->penerimamodel->update($data);
        if($result){
            $this->api_return(
                [
                    'status' => true,
                ], 
                200); 
        }else{
            $this->api_return(
                [
                    'status' => false,
                ], 400);
        }  
    }
    public function deletePenerima(){
        $id = $_GET;
        $result = $this->penerimamodel->delete($id);
        if($result){
            $this->api_return(
                [
                    'status' => true
                ], 200
            );
        }else{
            $this->api_return(
                [
                    'status' => false
                ],400
            );
            }
    }
}

    