<?php

namespace App\Models;

use CodeIgniter\Model;

class KuotaM extends Model
{
    protected $table = 'kuota';
    protected $allowedFields = array('pangkalan_id', 'jumlah_perminggu', 'jumlah_perbulan', 'jumlah_kk', 'verified_at', 'approved_at');
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'pangkalan_id' => 'required|max_length[10]',
        'jumlah_perminggu' => 'required|max_length[15]',
        'jumlah_perbulan' => 'required|max_length[15]',
        'jumlah_kk' => 'required|max_length[15]',
    ];

    protected $validationMessages = [
        'pangkalan_id' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 10 Karakter'],
        'jumlah_perminggu' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 15 Karakter'],
        'jumlah_perbulan' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 15 Karakter'],
        'jumlah_kk' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 15 Karakter'],
    ];
    private function _get_datatables()
    {
        $column_search = array('nama_pangkalan', 'jumlah_perminggu', 'jumlah_perbulan', 'jumlah_kk');
        $i = 0;
        foreach ($column_search as $item) { // loop column 
            if ($_GET['search']) {
                if ($i === 0) {
                    $this->groupStart();
                    $this->like($item, $_GET['search']);
                } else {
                    $this->orLike($item, $_GET['search']);
                }
                if (count($column_search) - 1 == $i)
                    $this->groupEnd();
            }
            $i++;
        }
        if (isset($_GET['order'])) {
            $this->orderBy($_GET['sort'], $_GET['order']);
        } else {
            $this->orderBy('id', 'asc');
        }

        $this->select('kuota.*, p.nama_pangkalan');
        $this->join('pangkalan p', 'kuota.pangkalan_id = p.id');
        $this->where('verified_at', null);
        if (isset($_GET['tahun']) && isset($_GET['bulan'])) {
            $this->like('kuota.created_at', $_GET['tahun']);
            $this->like('kuota.created_at', $_GET['bulan']);
        }
        $kecamatan = $_GET['kecamatan'];
        if ($kecamatan != 'none') {
            $this->like('p.desa_id', $kecamatan);
        }
    }
    public function get_datatables()
    {
        $this->_get_datatables();
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
        return $this->findAll($limit, $offset);
    }
    public function total()
    {
        $this->_get_datatables();
        if ($this->tempUseSoftDeletes) {
            $this->where($this->table . '.' . $this->deletedField, null);
        }
        return $this->get()->getNumRows();
    }

    private function _get_datatablesLaporan()
    {
        $column_search = array('nama_pangkalan', 'jumlah_perminggu', 'jumlah_perbulan', 'jumlah_kk');
        $i = 0;
        foreach ($column_search as $item) { // loop column 
            if ($_GET['search']) {
                if ($i === 0) {
                    $this->groupStart();
                    $this->like($item, $_GET['search']);
                } else {
                    $this->orLike($item, $_GET['search']);
                }
                if (count($column_search) - 1 == $i)
                    $this->groupEnd();
            }
            $i++;
        }
        if (isset($_GET['order'])) {
            $this->orderBy($_GET['sort'], $_GET['order']);
        } else {
            $this->orderBy('id', 'asc');
        }

        $this->select('kuota.*, p.nama_pangkalan');
        $this->join('pangkalan p', 'kuota.pangkalan_id = p.id');
        $this->where('verified_at !=', null);
        if (isset($_GET['tahun']) && isset($_GET['bulan'])) {
            $this->like('kuota.created_at', $_GET['tahun']);
            $this->like('kuota.created_at', $_GET['bulan']);
        }
        $kecamatan = $_GET['kecamatan'];
        if ($kecamatan != 'none') {
            $this->like('p.desa_id', $kecamatan);
        }
    }
    public function get_datatablesLaporan()
    {
        $this->_get_datatablesLaporan();
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
        return $this->findAll($limit, $offset);
    }
    public function totalLaporan()
    {
        $this->_get_datatablesLaporan();
        if ($this->tempUseSoftDeletes) {
            $this->where($this->table . '.' . $this->deletedField, null);
        }
        return $this->get()->getNumRows();
    }

    public function verifikasi($date)
    {
        $this->like('created_at', $date);
        $this->set('verified_at', date('Y-m-d'));
        $this->update();
        return true;
    }
    public function setujui($date)
    {
        $this->like('created_at', $date);
        $this->set('approved_at', date('Y-m-d'));
        $this->update();
        return true;
    }
}
/* End of file KuotaM.php */
/* Location: ./app/models/KuotaM.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-06-08 09:58:35 */