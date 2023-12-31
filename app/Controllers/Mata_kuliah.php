<?php

namespace App\Controllers;

use App\Models\Mata_kuliahM;

class Mata_kuliah extends BaseController
{
    protected $mata_kuliahm, $data, $session;
    function __construct()
    {
        $this->mata_kuliahm = new Mata_kuliahM();
    }
    public function index()
    {
        $this->data = array('title' => 'Mata_kuliah | Admin', 'breadcome' => 'Mata Kuliah', 'url' => 'mata_kuliah/', 'm_mata_kuliah' => 'active', 'session' => $this->session);

        echo view('App\Views\mata_kuliah\mata_kuliah_list', $this->data);
    }

    public function ajax_request()
    {
        $list = $this->mata_kuliahm->get_datatables();
        $data = array();
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['kode_mk'] = $rows->kode_mk;
            $row['nama_mk'] = $rows->nama_mk;
            $data[] = $row;
        }
        $output = array(
            "total" => $this->mata_kuliahm->total(),
            "totalNotFiltered" => $this->mata_kuliahm->countAllResults(),
            "rows" => $data,
        );
        echo json_encode($output);
    }
    public function create()
    {
        $this->data = array('action' => 'insert', 'btn' => '<i class="fas fa-save"></i> Save');
        $num_of_row = $this->request->getPost('num_of_row');
        for ($x = 1; $x <= $num_of_row; $x++) {
            $data['nama'] = 'Data ' . $x;
            $this->data['form_input'][] = view('App\Views\mata_kuliah\form_input', $data);
        }
        $status['html']         = view('App\Views\mata_kuliah\form_modal', $this->data);
        $status['modal_title']  = 'Tambah Data Mata_kuliah';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->data = array('action' => 'update', 'btn' => '<i class="fas fa-edit"></i> Edit');
        foreach ($id as $ids) {
            $get = $this->mata_kuliahm->find($ids);
            $data = array(
                'nama' => '<b>' . $get->nama_mk . '</b>',
                'get' => $get,
            );
            $this->data['form_input'][] = view('App\Views\mata_kuliah\form_input', $data);
        }
        $status['html']         = view('App\Views\mata_kuliah\form_modal', $this->data);
        $status['modal_title']  = 'Update Data Mata_kuliah';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function save()
    {
        switch ($this->request->getPost('action')) {
            case 'insert':
                $nama = $this->request->getPost('id');
                $data = array();
                foreach ($nama as $key => $val) {
                    array_push($data, array(
                        'kode_mk' => $this->request->getPost('kode_mk')[$key],
                        'nama_mk' => $this->request->getPost('nama_mk')[$key],
                    ));
                }
                if ($this->mata_kuliahm->insertBatch($data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Mata_kuliah Tersimpan';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->mata_kuliahm->errors();
                }
                echo json_encode($status);
                break;
            case 'update':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    array_push($data, array(
                        'id' => $val,
                        'kode_mk' => $this->request->getPost('kode_mk')[$key],
                        'nama_mk' => $this->request->getPost('nama_mk')[$key],
                    ));
                }
                if ($this->mata_kuliahm->updateBatch($data, 'id')) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Mata_kuliah Telah Di Ubah';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->mata_kuliahm->errors();
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->mata_kuliahm->delete($this->request->getPost('id'))) {
                    $status['type'] = 'success';
                    $status['text'] = '<strong>Deleted..!</strong>Berhasil dihapus';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = '<strong>Oh snap!</strong> Proses hapus data gagal.';
                }
                echo json_encode($status);
                break;
        }
    }
}

/* End of file Mata_kuliah.php */
/* Location: ./app/controllers/Mata_kuliah.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-08-19 11:17:53 */
/* http://harviacode.com */