<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/API_Controller.php';

class users extends API_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('users_model', 'usersmodel');
    }

    public function Login(){
        $data = $_GET;
        $result = $this->usersmodel->login($data);
        if($result["Status"]==true){
            $this->api_return(
                [
                    "data"=>$result
                ], 200
            );
        }else{
            $this->api_return(
                [
                    "data"=>$result
                ], 401
            );
        }
        
    
    }
//     public function getUsers(){
//         $id = $_GET;
//         $result = $this->users_model->get($id);
//         if(!empty($result)){
//             $this->api_return(
//                 [
//                     "data"=>$result
//                 ], 200
//             );
//         }else{
//             $this->api_return(
//                 [
//                     "data" => "Data Kosong"
//                 ], 400
//             );
//         }
        
//     }
//     Public function insertUsers(){
//         $post = json_decode($this->input->raw_input_stream);
//         $data = $this->Usersmmodel->insert($post);
//         if($data){
//             $this->api_return(
//                 [
//                     'status' => true,
//                 ], 
//                 200); 
//         }else{
//             $this->api_return(
//                 [
//                     'status' => false,
//                 ], 400);
//         }
//    }
//     public function updateUsers(){
//         $data = json_decode($this->input->raw_input_stream);
//         $result = $this->Usersmodel->update($data);
//         if($result){
//             $this->api_return(
//                 [
//                     'status' => true,
//                 ], 
//                 200); 
//         }else{
//             $this->api_return(
//                 [
//                     'status' => false,
//                 ], 400);
//         }  
//     }
//     public function deleteUsers(){
//         $id = $_GET;
//         $result = $this->Usersmodel->delete($id);
//         if($result){
//             $this->api_return(
//                 [
//                     'status' => true
//                 ], 200
//             );
//         }else{
//             $this->api_return(
//                 [
//                     'status' => false
//                 ],400
//             );
//             }
//     }
}




?>
    