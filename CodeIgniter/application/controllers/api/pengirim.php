<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

class pengirim extends API_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('pengirim_model', 'pengirimmodel');
    }
    public function getPengirim(){
        $id = $_GET;
        $result = $this->pengirimmodel->get($id);
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
    Public function insertPengirim(){
        $post = json_decode($this->input->raw_input_stream);
        $data = $this->pengirimmodel->insert($post);
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
    public function updatePengirim(){
        $data = json_decode($this->input->raw_input_stream);
        $result = $this->pengirimmodel->update($data);
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
    public function deletePengirim(){
        $id = $_GET;
        $result = $this->pengirimmodel->delete($id);
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




?>