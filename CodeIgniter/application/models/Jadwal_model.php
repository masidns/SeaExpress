<?php

class Jadwal_Model extends CI_Model
{
    protected $JadwalTable = 'jadwal_kuliah';
    protected $TahunAkademikTable = 'tahun_akademik';
    protected $MahasiswaTable = 'mahasiswa';
    protected $TemKrsmTable = 'tem_krsm';
    protected $TemDetailKrsmTable = 'tem_detail_krsm';
    protected $KrsmTable = 'krsm';
    protected $DetailKrsmTable = 'krsm_detail';
    // protected $UserinRoleTable = 'userinrole';
    // protected $RoleTable = 'role';
    // protected $PegawaiTable = 'pegawai';
    public function insert_user(array $UserData)
    {
        $this->db->insert($this->UserTable, $UserData);
        return $this->db->insert_id();
    }

    public function getAllJadwal(Type $var = null)
    {
        $this->db->select("`jadwal_kuliah`.*, `matakuliah`.`smt`");
        $this->db->from('`jadwal_kuliah`, tahun_akademik, matakuliah');
        $this->db->where('matakuliah`.`kmk` = `jadwal_kuliah`.`kmk`');
        $this->db->where('`tahun_akademik`.`thakademik` = `jadwal_kuliah`.`thakademik`');
        $this->db->where('`tahun_akademik`.`gg` = `jadwal_kuliah`.`gg`');
        $this->db->where('`tahun_akademik`.`status`', 'AKTIF');
        $this->db->order_by('matakuliah.smt', 'ASC');
        $hasil = $this->db->get();
        if($hasil->num_rows())
        {
            return $hasil->result_object();
        }
    }

    public function getjadwalmahasiswa($IdUser)
    {
        $this->db->select('*');
        $this->db->where('IdUser', $IdUser);
        $Mahasiswa = $this->db->get($this->MahasiswaTable);
        $StatusTA = "AKTIF";
        foreach ($Mahasiswa->result() as $value) {
            $DataMahasiswa = $value;
        }
        $this->db->select('*');
        $this->db->where('status', $StatusTA);
        $DataTahunAkademik = $this->db->get($this->TahunAkademikTable);
        foreach ($DataTahunAkademik->result() as $value) {
            $DataTA = $value;
        }
        if ($Mahasiswa->num_rows()) {
            if ($DataMahasiswa->statuskul == "TIDAK AKTIF" ||
                $DataMahasiswa->statuskul == "TRANSFER" ||
                $DataMahasiswa->statuskul == "CUTI") {
                $this->db->where('npm', $DataMahasiswa->npm);
                $this->db->where('thakademik', $DataTA->thakademik);
                $this->db->where('gg', $DataTA->gg);
                $resultTemKrsm = $this->db->get($this->TemKrsmTable);
                if ($resultTemKrsm->num_rows()) {
                    $this->db->where('IdKrsm', $resultTemKrsm->row('Id'));
                    $resultDetailKrsm = $this->db->get($this->TemDetailKrsmTable);
                    $Datas = array(
                        'TemKrsm' => $resultTemKrsm->result(),
                        'TemDetailKrsm' => $resultDetailKrsm->result(),
                        'message' => "TemKrsm",
                    );
                    return $Datas;
                } else {
                    if ($DataTahunAkademik->num_rows()) {
                        $this->db->select('*');
                        $this->db->join('matakuliah', 'matakuliah.kmk = jadwal_kuliah.kmk', 'left');
                        $this->db->where('jadwal_kuliah.kdps', $DataMahasiswa->kdps);
                        $this->db->where('jadwal_kuliah.thakademik', $DataTA->thakademik);
                        $this->db->where('jadwal_kuliah.gg', $DataTA->gg);
                        $this->db->where('kelas', $DataMahasiswa->kelas);
                        $this->db->group_start();
                        $this->db->where('kurikulum', $DataMahasiswa->kurikulum);
                        $this->db->or_where('kurikulum', 'ALL');
                        $this->db->group_end();
                        $this->db->order_by('matakuliah.smt', 'ASC');
                        $ItemJadwal = $this->db->get($this->JadwalTable);
                        if ($ItemJadwal->num_rows()) {
                            $DataJadwal = array(
                                'Jadwal' => $ItemJadwal->result(),
                                'message' => 'Jadwal',
                                'status' => true
                            );
                            return $DataJadwal;
                        }else{
                            $DataJadwal = array(
                                'message' => 'Jadwal',
                                'status' => false
                            );
                            return $DataJadwal;
                        }
                    }
                }
            } else {
                $this->db->where('npm', $DataMahasiswa->npm);
                $this->db->where('thakademik', $DataTA->thakademik);
                $this->db->where('gg', $DataTA->gg);
                $resultKrsm = $this->db->get($this->KrsmTable);
    
                if ($resultKrsm->num_rows()) {
                    $this->db->where('npm', $DataMahasiswa->npm);
                    $this->db->where('thakademik', $DataTA->thakademik);
                    $this->db->where('gg', $DataTA->gg);
                    $resultDetailKrsm = $this->db->get($this->DetailKrsmTable);
                    $DataKrsm = array(
                        'Krsm' => $resultKrsm->result(),
                        'DetailKrsm' => $resultDetailKrsm->result(),
                        'message' => 'Krms',
                    );
                }
                return $DataKrsm;
            }
        } 
    }

    public function user_login($Username, $Password)
    {
        $Pass = md5($Password);
        $this->db->select("user.Id, user.Username, user.Password, user.Email, role.Nama as RoleName");
        // $this->db->from('user');
        $this->db->join('userinrole', 'userinrole.IdUser = user.Id', 'left');
        $this->db->join('role', 'role.Id = userinrole.RoleId', 'left');
        $this->db->where('Email', $Username);
        $this->db->or_where('Username', $Username);
        $this->db->where('Password', $Pass);
        $q = $this->db->get($this->UserTable);

        if ($q->num_rows()) {
            $a = $q->row();
            $Id = $q->row('Id');
            $this->db->select('*');
            $this->db->join('role', 'role.Id=userinrole.RoleId', 'left');
            $this->db->where('IdUser', $q->row('Id'));
            $roleinuser = $this->db->get($this->UserinRoleTable);
            $Tampung = $roleinuser->result_array();
            if ($roleinuser->num_rows()) {
                $this->db->where('Id', $roleinuser->row('RoleId'));
                $role = $this->db->get($this->RoleTable);
                if ($role->row('Nama') == 'Mahasiswa') {
                    $this->db->where('IdUser', $q->row('Id'));
                    $Biodata = $this->db->get($this->MahasiswaTable);
                    if ($Biodata->num_rows()) {
                        $roleitem = array('Role' => array());
                        $item = array('Nama' => $role->row('Nama'));
                        array_push($roleitem['Role'], $item);
                        $Nama = "NamaUser";
                        $Role = "role";
                        $a->$Nama = $Biodata->row('nmmhs');
                        $a->$Role = (object) $roleitem;
                    }
                } else {
                    $this->db->where('IdUser', $q->row('Id'));
                    $Biodata = $this->db->get($this->PegawaiTable);
                    if ($Biodata->num_rows()) {
                        $roleitem = array('Role' => array());
                        foreach ($Tampung as &$value) {
                            $item = array('Nama' => $value['Nama']);
                            array_push($roleitem['Role'], $item);
                        }
                        $Nama = "NamaUser";
                        $Role = "role";
                        $a->$Nama = $Biodata->row('Nama');
                        $a->$Role = (object) $roleitem;
                    }

                }
            }
            return $a;
        } else {
            return false;
        }
    }

    public function Inser_Pengajuan(Type $var = null)
    {
        # code...
    }
}
