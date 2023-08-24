<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeM extends Model
{
    protected $table = 'jadwal';
    protected $returnType     = 'object';
    private function _get_datatables()
    {
        $column_search = array('nama_penjabat', 'nama_mk', 'nama_kelas', 'nama_lab', 'waktu_mulai', 'waktu_selesai', 'hari', 'status');
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

        $this->select('jadwal.*, p.nama_penjabat, mk.nama_mk, k.nama_kelas, l.nama_lab');
        $this->join('penjabat p', 'p.id=jadwal.dosen_id');
        $this->join('mata_kuliah mk', 'mk.id=jadwal.mk_id');
        $this->join('kelas k', 'k.id=jadwal.kelas_id');
        $this->join('laboratorium l', 'l.id=jadwal.lab_id');
        if (in_groups(3)) {
            $this->where('dosen_id', session('id_peg'));
            $this->orWhere('dosen_verify', session('id_peg'));
            $this->orWhere('status', 'pindah jadwal');
            $this->orWhere('status', 'setuju');
        }
        if (in_groups(4)) {
            $this->where('status', 'setuju');
            $this->orWhere('status', 'pindah jadwal');
            $this->orWhere('status', 'dosen setuju');
            $this->where('jadwal.kelas_id', pegawaiByID(session('id_peg'))->kelas_id);
        }
        $this->orderBy('hari,waktu_mulai', 'asc');
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
}
