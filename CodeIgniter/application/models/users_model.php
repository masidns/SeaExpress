<?php
class users_model extends CI_model
{
    public function login($data)
{
    $psw = $data['psw'];
    $username = $data['username'];
    $result = $this->db->query("
        SELECT * FROM users WHERE (NPG = '$username' OR email = '$username') AND psw ='$psw'
    ");
    if($result->num_rows()>0){
        $message =[
            "data"=> $result->result_array(),
            "Status" => true
        ];
        return $message;
    }else{
        $message = [
            "Status" => false
        ];
        return $message;
    }
    }
    // public function insert($data){
    //     $result =$this->db->insert('users', $data);
    //     return $result;
    // }
    // public function update($data){
    //     $this->db->where("idusers", $data->idusers);
    //     $result = $this->db->update("users", $data);
    //     return $result;
    // }
    // public function delete($id){
    //     $result = $this->db->where('idusers', $id['idusers']);
    //     $result = $this->db->delete('users');
    //     return $result;
    // }
}
        
?>
