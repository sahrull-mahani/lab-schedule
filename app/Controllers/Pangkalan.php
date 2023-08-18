<?php

namespace App\Controllers;

use App\Models\PangkalanM;

class Pangkalan extends BaseController
{
    protected $pangkalanm, $data, $session;
    function __construct()
    {
        $this->pangkalanm = new PangkalanM();
    }
    public function index()
    {
        $this->data = array('title' => 'Pangkalan | Admin', 'breadcome' => 'Pangkalan', 'url' => 'pangkalan/', 'm_pangkalan' => 'active bg-gradient-primary', 'session' => $this->session);

        echo view('App\Views\pangkalan\pangkalan_list', $this->data);
    }

    public function ajax_request()
    {
        $list = $this->pangkalanm->get_datatables();
        $data = array();
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['desa_id'] = getDesa($rows->desa_id)->nama;
            $row['nama_pangkalan'] = $rows->nama_pangkalan;
            $row['id_registrasi'] = $rows->id_registrasi;
            $data[] = $row;
        }
        $output = array(
            "total" => $this->pangkalanm->total(),
            "totalNotFiltered" => $this->pangkalanm->countAllResults(),
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
            $data['key'] = $x;
            $this->data['form_input'][] = view('App\Views\pangkalan\form_input', $data);
        }
        $status['html']         = view('App\Views\pangkalan\form_modal', $this->data);
        $status['modal_title']  = 'Tambah Data Pangkalan';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->data = array('action' => 'update', 'btn' => '<i class="fas fa-edit"></i> Edit');
        foreach ($id as $key => $ids) {
            $get = $this->pangkalanm->find($ids);
            $data = array(
                'nama' => '<b>' . getDesa($get->desa_id)->nama . '</b>',
                'get' => $get,
                'desa_id' => $get->desa_id,
                'key' => $key,
            );
            $this->data['form_input'][] = view('App\Views\pangkalan\form_input', $data);
        }
        $status['html']         = view('App\Views\pangkalan\form_modal', $this->data);
        $status['modal_title']  = 'Update Data Pangkalan';
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
                        'desa_id' => $this->request->getPost('desa_id')[$key],
                        'nama_pangkalan' => $this->request->getPost('nama_pangkalan')[$key],
                        'id_registrasi' => $this->request->getPost('id_registrasi')[$key],
                    ));
                }
                if ($this->pangkalanm->insertBatch($data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Pangkalan Tersimpan';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->pangkalanm->errors();
                }
                echo json_encode($status);
                break;
            case 'update':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    array_push($data, array(
                        'id' => $val,
                        'desa_id' => $this->request->getPost('desa_id')[$key],
                        'nama_pangkalan' => $this->request->getPost('nama_pangkalan')[$key],
                        'id_registrasi' => $this->request->getPost('id_registrasi')[$key],
                    ));
                }
                if ($this->pangkalanm->updateBatch($data, 'id')) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Pangkalan Telah Di Ubah';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->pangkalanm->errors();
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->pangkalanm->delete($this->request->getPost('id'))) {
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

/* End of file Pangkalan.php */
/* Location: ./app/controllers/Pangkalan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-06-08 09:39:24 */
/* http://harviacode.com */