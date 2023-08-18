<?php

namespace App\Controllers;

use App\Models\KelasM;
use App\Models\MahasiswaM;

class Mahasiswa extends BaseController
{
    protected $mahasiswam, $data, $session, $kelasm;
    function __construct()
    {
        $this->mahasiswam = new MahasiswaM();
        $this->kelasm = new KelasM();
    }
    public function index()
    {
        $this->data = array('title' => 'Mahasiswa | Admin', 'breadcome' => 'Mahasiswa', 'url' => 'mahasiswa/', 'm_mahasiswa' => 'active', 'session' => $this->session);

        echo view('App\Views\mahasiswa\mahasiswa_list', $this->data);
    }

    public function ajax_request()
    {
        $list = $this->mahasiswam->get_datatables();
        $data = array();
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['jabatan'] = $rows->jabatan;
            $row['kelas_id'] = $rows->nama_kelas;
            $row['nomor_induk'] = $rows->nomor_induk;
            $row['nama_penjabat'] = $rows->nama_penjabat;
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
            "total" => $this->mahasiswam->total(),
            "totalNotFiltered" => $this->mahasiswam->countAllResults(),
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
            $data['kelas'] = $this->kelasm->findAll();
            $this->data['form_input'][] = view('App\Views\mahasiswa\form_input', $data);
        }
        $status['html']         = view('App\Views\mahasiswa\form_modal', $this->data);
        $status['modal_title']  = 'Tambah Data Mahasiswa';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->data = array('action' => 'update', 'btn' => '<i class="fas fa-edit"></i> Edit');
        foreach ($id as $ids) {
            $get = $this->mahasiswam->find($ids);
            $data = array(
                'nama' => '<b>' . $get->nama_penjabat . '</b>',
                'get' => $get,
                'kelas' => $this->kelasm->findAll(),
            );
            $this->data['form_input'][] = view('App\Views\mahasiswa\form_input', $data);
        }
        $status['html']         = view('App\Views\mahasiswa\form_modal', $this->data);
        $status['modal_title']  = 'Update Data Mahasiswa';
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
                    $nim = $this->request->getPost('nomor_induk')[$key];
                    if ($this->mahasiswam->where('jabatan', 'mahasiswa')->where('nomor_induk', $nim)->first()) {
                        session()->setFlashdata('errorNIM', 'NIM sudah terdaftar');
                        break;
                    }
                    array_push($data, array(
                        'jabatan' => 'mahasiswa',
                        'kelas_id' => $this->request->getPost('kelas_id')[$key],
                        'nomor_induk' => $this->request->getPost('nomor_induk')[$key],
                        'nama_penjabat' => $this->request->getPost('nama_penjabat')[$key],
                        'jk' => $this->request->getPost('jk')[$key],
                        'tempat_lahir' => $this->request->getPost('tempat_lahir')[$key],
                        'tgl_lahir' => get_format_date_sql($this->request->getPost('tgl_lahir')[$key]),
                        'alamat' => $this->request->getPost('alamat')[$key],
                    ));
                }
                if (session()->getFlashdata('errorNIM')) {
                    $status['type'] = 'error';
                    $status['text'] = ['NIM' => session()->getFlashdata('errorNIM')];
                    return json_encode($status);
                }
                if ($this->mahasiswam->insertBatch($data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Mahasiswa Tersimpan';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->mahasiswam->errors();
                }
                echo json_encode($status);
                break;
            case 'update':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    $nim = $this->request->getPost('nomor_induk')[$key];
                    if ($this->mahasiswam->where('jabatan', 'mahasiswa')->where('nomor_induk', $nim)->first()) {
                        $nomorMahasiswa = $this->mahasiswam->where('id', $val)->first()->nomor_induk;
                        if ($nim !== $nomorMahasiswa) {
                            session()->setFlashdata('errorNIM', 'NIM sudah terdaftar');
                            break;
                        }
                    }
                    array_push($data, array(
                        'id' => $val,
                        'kelas_id' => $this->request->getPost('kelas_id')[$key],
                        'nomor_induk' => $this->request->getPost('nomor_induk')[$key],
                        'nama_penjabat' => $this->request->getPost('nama_penjabat')[$key],
                        'jk' => $this->request->getPost('jk')[$key],
                        'tempat_lahir' => $this->request->getPost('tempat_lahir')[$key],
                        'tgl_lahir' => get_format_date_sql($this->request->getPost('tgl_lahir')[$key]),
                        'alamat' => $this->request->getPost('alamat')[$key],
                    ));
                }
                if (session()->getFlashdata('errorNIM')) {
                    $status['type'] = 'error';
                    $status['text'] = ['NIM' => session()->getFlashdata('errorNIM')];
                    return json_encode($status);
                }
                if ($this->mahasiswam->updateBatch($data, 'id')) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Mahasiswa Telah Di Ubah';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->mahasiswam->errors();
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->mahasiswam->delete($this->request->getPost('id'))) {
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

/* End of file Mahasiswa.php */
/* Location: ./app/controllers/Mahasiswa.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-08-18 10:05:14 */
/* http://harviacode.com */