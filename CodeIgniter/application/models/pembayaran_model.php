<?php
class pembayaran_model extends CI_model
{
    public function Get($id){
        if ($id != null){
        $id=  $id['idPembayaran'];
        $result = $this->db->query("
        SELECT
        *
      FROM
        `transaksi`
        RIGHT JOIN `pembayaran` ON `transaksi`.`NoStt` = `pembayaran`.`NoStt`
            WHERE idPembayaran = '$id'"
        );
        return $result->result_array();
    }
    else{
        $result = $this->db->query("
        SELECT
        *
      FROM
        `transaksi`
        RIGHT JOIN `pembayaran` ON `transaksi`.`NoStt` = `pembayaran`.`NoStt`"
        );
        return $result->result_array();
     }
    }

    public function insert($data){
        $result = $this->db->insert('pembayaran', $data);
        return $result;
    }

    public function update($data){
        $this->db->where("idPembayaran", $data->idPembayaran);
        $result = $this->db->update('pembayaran', $data);
        return $result;
    }

    public function delete($id){
        $result = $this->db->where('idPembayaran', $id['idPembayaran']);
        $result = $this->db->delete('pembayaran');
        return $result;
    }
}


?>