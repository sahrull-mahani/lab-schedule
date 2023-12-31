<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenM extends Model
{
    protected $table = 'penjabat';
    protected $allowedFields = array('jabatan', 'kelas_id', 'nomor_induk', 'nama_penjabat', 'jk', 'tempat_lahir', 'tgl_lahir', 'gelar_depan', 'gelar_belakang', 'alamat', 'pendidikan', 'lulusan');
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'nama_penjabat' => 'required|max_length[100]',
        'jk' => 'required|max_length[9]',
        'tempat_lahir' => 'required|max_length[50]',
        'gelar_depan' => 'max_length[25]',
        'gelar_belakang' => 'max_length[25]',
        'alamat' => 'required|max_length[65535]',
        'pendidikan' => 'required|max_length[10]',
        'lulusan' => 'max_length[100]',
    ];

    protected $validationMessages = [
        'nomor_induk' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 25 Karakter'],
        'nama_penjabat' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 100 Karakter'],
        'jk' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 9 Karakter'],
        'tempat_lahir' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 50 Karakter'],
        'gelar_depan' => ['max_length' => 'Maximal 25 Karakter'],
        'gelar_belakang' => ['max_length' => 'Maximal 25 Karakter'],
        'alamat' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 65535 Karakter'],
        'pendidikan' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 10 Karakter'],
        'lulusan' => ['max_length' => 'Maximal 100 Karakter'],
    ];
    private function _get_datatables()
    {
        $column_search = array('nomor_induk', 'nama_penjabat', 'jk', 'tempat_lahir', 'tgl_lahir', 'gelar_depan', 'gelar_belakang', 'alamat', 'pendidikan', 'lulusan');
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

        $this->where('jabatan', 'dosen');
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
/* End of file DosenM.php */
/* Location: ./app/models/DosenM.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-08-18 10:01:17 */