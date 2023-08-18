<?php

namespace App\Controllers;

use App\Models\IonAuthModel;
use App\Models\JabatanM;
use App\Models\PegawaiM;

class Pegawai extends BaseController
{
    protected $pegawaim, $jabatanm, $ionAuth, $data, $session;
    function __construct()
    {
        $this->pegawaim = new PegawaiM();
        $this->jabatanm = new JabatanM();
        $this->ionAuth = new IonAuthModel();
    }
    public function index()
    {
        $this->data = array('title' => 'Pegawai | Admin', 'breadcome' => 'Pegawai', 'url' => 'pegawai/', 'm_pegawai' => 'active bg-gradient-primary', 'session' => $this->session);

        echo view('App\Views\pegawai\pegawai_list', $this->data);
    }

    public function ajax_request()
    {
        $list = $this->pegawaim->get_datatables();
        $data = array();
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['jab_id'] = ucwords($rows->nama_jabatan);
            $row['nama'] = ucwords($rows->nama);
            $row['jk'] = $rows->jk;
            $row['tempat_lahir'] = $rows->tempat_lahir;
            $row['tgl_lahir'] = get_format_date($rows->tgl_lahir);
            $row['gelar_depan'] = $rows->gelar_depan;
            $row['gelar_belakang'] = $rows->gelar_belakang;
            $row['alamat'] = $rows->alamat;
            $row['pendidikan'] = $rows->pendidikan;
            $row['lulusan'] = $rows->lulusan;
            $data[] = $row;
        }
        $output = array(
            "total" => $this->pegawaim->total(),
            "totalNotFiltered" => $this->pegawaim->countAllResults(),
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
            $data['jabatan'] = $this->jabatanm->findAll();
            $this->data['form_input'][] = view('App\Views\pegawai\form_input', $data);
        }
        $status['html']         = view('App\Views\pegawai\form_modal', $this->data);
        $status['modal_title']  = 'Tambah Data Pegawai';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->data = array('action' => 'update', 'btn' => '<i class="fas fa-edit"></i> Edit');
        foreach ($id as $ids) {
            $get = $this->pegawaim->find($ids);
            $data = array(
                'nama' => '<b>' . $get->nama . '</b>',
                'get' => $get,
                'jabatan' => $this->jabatanm->findAll(),
            );
            $this->data['form_input'][] = view('App\Views\pegawai\form_input', $data);
        }
        $status['html']         = view('App\Views\pegawai\form_modal', $this->data);
        $status['modal_title']  = 'Update Data Pegawai';
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
                        'jab_id' => $this->request->getPost('jab_id')[$key],
                        'nama' => $this->request->getPost('nama')[$key],
                        'jk' => $this->request->getPost('jk')[$key],
                        'tempat_lahir' => $this->request->getPost('tempat_lahir')[$key],
                        'tgl_lahir' => get_format_date_sql($this->request->getPost('tgl_lahir')[$key]),
                        'gelar_depan' => $this->request->getPost('gelar_depan')[$key],
                        'gelar_belakang' => $this->request->getPost('gelar_belakang')[$key],
                        'alamat' => $this->request->getPost('alamat')[$key],
                        'pendidikan' => $this->request->getPost('pendidikan')[$key],
                        'lulusan' => $this->request->getPost('lulusan')[$key],
                    ));
                }
                if ($this->pegawaim->insertBatch($data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Pegawai Tersimpan';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->pegawaim->errors();
                }
                echo json_encode($status);
                break;
            case 'update':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    array_push($data, array(
                        'id' => $val,
                        'jab_id' => $this->request->getPost('jab_id')[$key],
                        'nama' => $this->request->getPost('nama')[$key],
                        'jk' => $this->request->getPost('jk')[$key],
                        'tempat_lahir' => $this->request->getPost('tempat_lahir')[$key],
                        'tgl_lahir' => get_format_date_sql($this->request->getPost('tgl_lahir')[$key]),
                        'gelar_depan' => $this->request->getPost('gelar_depan')[$key],
                        'gelar_belakang' => $this->request->getPost('gelar_belakang')[$key],
                        'alamat' => $this->request->getPost('alamat')[$key],
                        'pendidikan' => $this->request->getPost('pendidikan')[$key],
                        'lulusan' => $this->request->getPost('lulusan')[$key],
                    ));
                }
                if ($this->pegawaim->updateBatch($data, 'id')) {
                    if ($this->request->getPost('session') == 'true') {
                        $this->ionAuth->update(session('user_id'), ['nama_user'=>$this->request->getPost('nama')[0]]);
                        $this->session->remove('nama_user');
                        $this->session->set('nama_user', $this->request->getPost('nama')[0]);
                    }
                    $status['type'] = 'success';
                    $status['text'] = 'Data Pegawai Telah Di Ubah';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->pegawaim->errors();
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->pegawaim->delete($this->request->getPost('id'))) {
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

/* End of file Pegawai.php */
/* Location: ./app/controllers/Pegawai.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-03-07 03:01:11 */
/* http://harviacode.com */