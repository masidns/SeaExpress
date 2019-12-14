<?php
class barang_model extends CI_model
{
    public function Get($No){
        if ($No != null){
        $this->db->where('NoDo', $No['NoDo']);
        $result = $this->db->get('barang');
        return $result->result_array();
    }
    else{
        $result = $this->db->get('barang');
        return $result->result_array();
     }
    }

    public function insert($data){
        $result = $this->db->insert('barang', $data);
        return $result;
    }

    public function update($data){
        $this->db->where("NoDo", $data->NoDo);
        $result = $this->db->update('barang', $data);
        return $result;
    }

    public function delete($No){
        $result = $this->db->where('NoDo', $No['NoDo']);
        $result = $this->db->delete('barang');
        return $result;
    }
}


?>