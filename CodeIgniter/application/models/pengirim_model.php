<?php
class pengirim_model extends CI_model
{
    public function Get($id){
        if ($id != null){
            $this->db->where('idPengirim', $id['idPengirim']);
            $result = $this->db->get('pengirim');
            return $result->result_array();
        }
        else{
            $result = $this->db->get('pengirim');
            return $result->result_array();
        }
    }
    public function insert($data){
        $result =$this->db->insert('pengirim', $data);
        return $result;
    }
    public function update($data){
        $this->db->where("idPengirim", $data->idPengirim);
        $result = $this->db->update("pengirim", $data);
        return $result;
    }
    public function delete($id){
        $result = $this->db->where('idPengirim', $id['idPengirim']);
        $result = $this->db->delete('pengirim');
        return $result;
    }
    
}
?>
