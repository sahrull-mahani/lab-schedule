<?php

namespace App\Models;

use CodeIgniter\Model;

class Mata_kuliahM extends Model
{
    protected $table = 'mata_kuliah';
    protected $allowedFields = array('kode_mk', 'nama_mk');
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'kode_mk' => 'required|max_length[8]',
        'nama_mk' => 'required|max_length[100]',
    ];

    protected $validationMessages = [
        'kode_mk' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 8 Karakter'],
        'nama_mk' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 100 Karakter'],
    ];
    private function _get_datatables()
    {
        $column_search = array('kode_mk', 'nama_mk');
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
/* End of file Mata_kuliahM.php */
/* Location: ./app/models/Mata_kuliahM.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-08-19 11:17:53 */