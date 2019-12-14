<?php
class penerima_model extends CI_model
{
    public function Get($id){
        if ($id != null){
            $this->db->where('id_penerima', $id['id_penerima']);
            $result = $this->db->get('penerima');
            return $result->result_array();
        }
        else{
            $result = $this->db->get('penerima');
            return $result->result_array();
        }
    }
    public function insert($data){
        $result =$this->db->insert('penerima', $data);
        return $result;
    }
    public function update($data){
        $this->db->where("idPenerima", $data->idPenerima);
        $result = $this->db->update("penerima", $data);
        return $result;
    }
    public function delete($id){
        $result = $this->db->where('idPenerima', $id['idPenerima']);
        $result = $this->db->delete('Penerima');
        return $result;
    }
    
}
