<?php

namespace App\Controllers;

use App\Models\JabatanM;

class Jabatan extends BaseController
{
    protected $jabatanm, $data, $session;
    function __construct()
    {
        $this->jabatanm = new JabatanM();
    }
    public function index()
    {
        $this->data = array('title' => 'Jabatan | Admin', 'breadcome' => 'Jabatan', 'url' => 'jabatan/', 'm_jabatan' => 'active bg-gradient-primary', 'session' => $this->session);

        echo view('App\Views\jabatan\jabatan_list', $this->data);
    }

    public function ajax_request()
    {
        $list = $this->jabatanm->get_datatables();
        $data = array();
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['level'] = $rows->level;
            $row['nama'] = $rows->nama;
            $data[] = $row;
        }
        $output = array(
            "total" => $this->jabatanm->total(),
            "totalNotFiltered" => $this->jabatanm->countAllResults(),
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
            $this->data['form_input'][] = view('App\Views\jabatan\form_input', $data);
        }
        $status['html']         = view('App\Views\jabatan\form_modal', $this->data);
        $status['modal_title']  = 'Tambah Data Jabatan';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->data = array('action' => 'update', 'btn' => '<i class="fas fa-edit"></i> Edit');
        foreach ($id as $ids) {
            $get = $this->jabatanm->find($ids);
            $data = array(
                'nama' => '<b>' . $get->nama . '</b>',
                'get' => $get,
            );
            $this->data['form_input'][] = view('App\Views\jabatan\form_input', $data);
        }
        $status['html']         = view('App\Views\jabatan\form_modal', $this->data);
        $status['modal_title']  = 'Update Data Jabatan';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function save()
    {
        switch ($this->request->getPost('action')) {
            case 'insert':
                $nama = $this->request->getPost('nama');
                $data = array();
                foreach ($nama as $key => $val) {
                    $level = $this->request->getPost('level1')[$key] .'.'. $this->request->getPost('level2')[$key] .'.'. $this->request->getPost('level3')[$key];
                    array_push($data, array(
                        'level' => $level,
                        'nama' => $this->request->getPost('nama')[$key],
                    ));
                }
                if ($this->jabatanm->insertBatch($data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Jabatan Tersimpan';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->jabatanm->errors();
                }
                echo json_encode($status);
                break;
            case 'update':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    $level = $this->request->getPost('level1')[$key] .'.'. $this->request->getPost('level2')[$key] .'.'. $this->request->getPost('level3')[$key];
                    array_push($data, array(
                        'id' => $val,
                        'level' => $level,
                        'nama' => $this->request->getPost('nama')[$key],
                    ));
                }
                if ($this->jabatanm->updateBatch($data, 'id')) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Jabatan Telah Di Ubah';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->jabatanm->errors();
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->jabatanm->delete($this->request->getPost('id'))) {
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

/* End of file Jabatan.php */
/* Location: ./app/controllers/Jabatan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-03-08 01:48:08 */
/* http://harviacode.com */