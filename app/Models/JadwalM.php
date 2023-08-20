<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalM extends Model
{
    protected $table = 'jadwal';
    protected $allowedFields = array('dosen_id', 'mk_id', 'kelas_id', 'lab_id', 'waktu_mulai', 'waktu_selesai', 'hari', 'status');
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'dosen_id' => 'required|max_length[6]',
        'mk_id' => 'required|max_length[6]',
        'kelas_id' => 'required|max_length[6]',
        'lab_id' => 'required|max_length[6]',
        'waktu_mulai' => 'required',
        'waktu_selesai' => 'required',
        'hari' => 'required',
    ];

    protected $validationMessages = [
        'dosen_id' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 6 Karakter'],
        'mk_id' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 6 Karakter'],
        'kelas_id' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 6 Karakter'],
        'lab_id' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 6 Karakter'],
        'waktu_mulai' => ['required' => 'tidak boleh kosong'],
        'waktu_selesai' => ['required' => 'tidak boleh kosong'],
        'hari' => ['required' => 'tidak boleh kosong'],
    ];
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
/* End of file JadwalM.php */
/* Location: ./app/models/JadwalM.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-08-19 11:40:00 */