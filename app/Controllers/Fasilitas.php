<?php

namespace App\Controllers;

use App\Models\FasilitasM;

class Fasilitas extends BaseController
{
    protected $fasilitasm, $data, $session;
    function __construct()
    {
        $this->fasilitasm = new FasilitasM();
    }
    public function index()
    {
        $this->data = array('title' => 'Fasilitas | Admin', 'breadcome' => 'Fasilitas', 'url' => 'fasilitas/', 'm_fasilitas' => 'active', 'session' => $this->session);

        echo view('App\Views\fasilitas\fasilitas_list', $this->data);
    }

    public function ajax_request()
    {
        $list = $this->fasilitasm->get_datatables();
        $data = array();
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['lab'] = $rows->lab;
            $row['nama_fasilitas'] = $rows->nama_fasilitas;
            $row['jumlah'] = $rows->jumlah;
            $row['status'] = $rows->status;
            $row['keterangan'] = $rows->keterangan;
            $data[] = $row;
        }
        $output = array(
            "total" => $this->fasilitasm->total(),
            "totalNotFiltered" => $this->fasilitasm->countAllResults(),
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
            $this->data['form_input'][] = view('App\Views\fasilitas\form_input', $data);
        }
        $status['html']         = view('App\Views\fasilitas\form_modal', $this->data);
        $status['modal_title']  = 'Tambah Data Fasilitas';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->data = array('action' => 'update', 'btn' => '<i class="fas fa-edit"></i> Edit');
        foreach ($id as $ids) {
            $get = $this->fasilitasm->find($ids);
            $data = array(
                'nama' => '<b>' . $get->nama . '</b>',
                'get' => $get,
            );
            $this->data['form_input'][] = view('App\Views\fasilitas\form_input', $data);
        }
        $status['html']         = view('App\Views\fasilitas\form_modal', $this->data);
        $status['modal_title']  = 'Update Data Fasilitas';
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
                    array_push($data, array(
                        'lab' => $this->request->getPost('lab')[$key],
                        'nama_fasilitas' => $this->request->getPost('nama_fasilitas')[$key],
                        'jumlah' => $this->request->getPost('jumlah')[$key],
                        'status' => $this->request->getPost('status')[$key],
                        'keterangan' => $this->request->getPost('keterangan')[$key],
                    ));
                }
                if ($this->fasilitasm->insertBatch($data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Fasilitas Tersimpan';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->fasilitasm->errors();
                }
                echo json_encode($status);
                break;
            case 'update':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    array_push($data, array(
                        'id' => $val,
                        'lab' => $this->request->getPost('lab')[$key],
                        'nama_fasilitas' => $this->request->getPost('nama_fasilitas')[$key],
                        'jumlah' => $this->request->getPost('jumlah')[$key],
                        'status' => $this->request->getPost('status')[$key],
                        'keterangan' => $this->request->getPost('keterangan')[$key],
                    ));
                }
                if ($this->fasilitasm->updateBatch($data, 'id')) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Fasilitas Telah Di Ubah';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->fasilitasm->errors();
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->fasilitasm->delete($this->request->getPost('id'))) {
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

/* End of file Fasilitas.php */
/* Location: ./app/controllers/Fasilitas.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-08-18 10:32:13 */
/* http://harviacode.com */