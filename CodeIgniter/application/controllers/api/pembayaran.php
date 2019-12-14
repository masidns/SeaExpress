<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

class pembayaran extends API_Controller
{
    public function __construct(){
        parent::__construct();
            $this->load->model('pembayaran_model', 'pembayaranmodel');
        }
    
    public function getPembayaran(){
        $id = $_GET;
        $result = $this->pembayaranmodel->get($id);
        if(!empty($result)){
            $this->api_return(
                [
                    'status'=> $result
                ],200
            );
        }else{
            $this->api_return(
                [
                    'status'=>"data kosong"
                ],400
            );
        }    
    }

    public function insertPembayaran(){
        $post = json_decode($this->input->raw_input_stream);
        $data = $this->pembayaranmodel->insert($post);
        if($data){
            $this->api_return(
                [
                    'status'=> true,
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

    public function updatePembayaran(){
        $post =json_decode($this->input->raw_input_stream);
        $data = $this->pembayaranmodel->update($post);
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

    public function deletePembayaran(){
        $id = $_GET;
        $result = $this->pembayaranmodel->delete($id);
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