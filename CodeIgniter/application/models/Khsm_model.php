<?php

class Khsm_Model extends CI_Model
{
    public function AmbilKhs($itemget)
    {
        $this->db->where('npm', $itemget->npm);
        $result = $this->db->get('mahasiswa');
        $itemMahasiswa = $result->result();
        $kurikulum = $result->row('kurikulum');
        $this->db->where('status_mk', 'OK');
        $this->db->group_start();
        $this->db->where('kurikulum', $kurikulum);
        $this->db->or_where('kurikulum', 'ALL');
        $this->db->group_end();
        $this->db->order_by('matakuliah.smt', 'ASC');
        $result = $this->db->get('matakuliah');
        $matakuliah = $result->result();
        $this->db->where('status_mk', 'NO');
        $this->db->group_start();
        $this->db->where('kurikulum', $kurikulum);
        $this->db->or_where('kurikulum', 'ALL');
        $this->db->group_end();
        $this->db->order_by('matakuliah.smt', 'ASC');
        $result = $this->db->get('matakuliah');
        $matakuliahNo = $result->result();
        $this->db->where('npm', $itemget->npm);
        $result = $this->db->get('khsm_detail');
        $itemKhsm = $result->result();
        $KhsmData = array(
            'Datas' => array(),
            'IPK' => "",
            'SKS' => ""
        );
        $TotalSks = 0;
        $Totalnxsks = 0;
        foreach ($matakuliah as $valueMatakuliah) {
            $item = array(
                'nmmk' => $valueMatakuliah->nmmk,
                'smt' => $valueMatakuliah->smt,
                'mk_konversi' => $valueMatakuliah->mk_konversi,
                'sks' => $valueMatakuliah->sks,
                'thakademik' => "-",
                'gg' => "-",
                'npm' => "-",
                'kmk' => $valueMatakuliah->kmk,
                'nhuruf' => "-",
                'nxsks' => "-",
                'ket' => "-",
            );
            foreach ($itemKhsm as $key => $valueKhsm) {
                $nilai = 0;
                
                if ($valueMatakuliah->kmk == $valueKhsm->kmk) {
                    if ((int) $valueKhsm->nxsks > $nilai) {
                        $item['thakademik'] = $valueKhsm->thakademik;
                        $item['gg'] = $valueKhsm->gg;
                        $item['npm'] = $valueKhsm->npm;
                        $item['kmk'] = $valueKhsm->kmk;
                        $item['nhuruf'] = $valueKhsm->nhuruf;
                        $item['nxsks'] = $valueKhsm->nxsks;
                        $item['ket'] = $valueKhsm->ket;
                        $nilai = (int) $valueKhsm->nxsks;
                        if($valueKhsm->ket == "L")
                        {
                            $TotalSks+= (int) $valueMatakuliah->sks;
                        }
                    }
                }else{
                    foreach ($matakuliahNo as $valueNo) {
                        if($valueMatakuliah->kmk==$valueNo->mk_konversi){
                            $nilai = 0;
                                if ($valueKhsm->kmk == $valueNo->kmk) {
                                    if ((int) $valueKhsm->nxsks > $nilai) {
                                        $item['thakademik'] = $valueKhsm->thakademik;
                                        $item['gg'] = $valueKhsm->gg;
                                        $item['npm'] = $valueKhsm->npm;
                                        $item['kmk'] = $valueKhsm->kmk;
                                        $item['nhuruf'] = $valueKhsm->nhuruf;
                                        $item['nxsks'] = $valueKhsm->nxsks;
                                        $item['ket'] = $valueKhsm->ket;
                                        $nilai = (int) $valueKhsm->nxsks;
                                        if($valueKhsm->ket == "L")
                                        {
                                            $TotalSks+= (int) $valueMatakuliah->sks;
                                        }
                                    }
                                }
                        }                        
                    }
                }
                $Totalnxsks+= (int)$nilai;
            }
            array_push($KhsmData['Datas'], $item);
            
        }
        $IPK = $Totalnxsks/$TotalSks;
        $KhsmData['IPK'] = $IPK;
        $KhsmData['SKS'] = $TotalSks;
        return $KhsmData;
    }
}
