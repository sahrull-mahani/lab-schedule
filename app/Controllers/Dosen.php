<?php

namespace App\Controllers;

use App\Models\DosenM;

class Dosen extends BaseController
{
    protected $dosenm, $data, $session;
    function __construct()
    {
        $this->dosenm = new DosenM();
    }
    public function index()
    {
        $this->data = array('title' => 'Dosen | Admin', 'breadcome' => 'Dosen', 'url' => 'dosen/', 'm_dosen' => 'active', 'session' => $this->session);

        echo view('App\Views\dosen\dosen_list', $this->data);
    }

    public function ajax_request()
    {
        $list = $this->dosenm->get_datatables();
        $data = array();
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['jabatan'] = $rows->jabatan;
            $row['kelas_id'] = $rows->kelas_id;
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
            "total" => $this->dosenm->total(),
            "totalNotFiltered" => $this->dosenm->countAllResults(),
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
            $this->data['form_input'][] = view('App\Views\dosen\form_input', $data);
        }
        $status['html']         = view('App\Views\dosen\form_modal', $this->data);
        $status['modal_title']  = 'Tambah Data Dosen';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->data = array('action' => 'update', 'btn' => '<i class="fas fa-edit"></i> Edit');
        foreach ($id as $ids) {
            $get = $this->dosenm->find($ids);
            $data = array(
                'nama' => '<b>' . $get->nama_penjabat . '</b>',
                'get' => $get,
            );
            $this->data['form_input'][] = view('App\Views\dosen\form_input', $data);
        }
        $status['html']         = view('App\Views\dosen\form_modal', $this->data);
        $status['modal_title']  = 'Update Data Dosen';
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
                    $nidn = $this->request->getPost('nomor_induk')[$key];
                    if ($this->dosenm->where('jabatan', 'dosen')->where('nomor_induk', $nidn)->first()) {
                        session()->setFlashdata('errorNIDN', 'NIDN sudah terdaftar');
                        break;
                    }
                    array_push($data, array(
                        'jabatan' => 'dosen',
                        'kelas_id' => null,
                        'nomor_induk' => $nidn,
                        'nama_penjabat' => $this->request->getPost('nama_penjabat')[$key],
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
                if (session()->getFlashdata('errorNIDN')) {
                    $status['type'] = 'error';
                    $status['text'] = ['NIDN' => session()->getFlashdata('errorNIDN')];
                    return json_encode($status);
                }
                if ($this->dosenm->insertBatch($data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Dosen Tersimpan';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->dosenm->errors();
                }
                echo json_encode($status);
                break;
            case 'update':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    $nidn = $this->request->getPost('nomor_induk')[$key];
                    if ($this->dosenm->where('jabatan', 'dosen')->where('nomor_induk', $nidn)->first()) {
                        $nomorDosen = $this->dosenm->where('id', $val)->first()->nomor_induk;
                        if ($nidn !== $nomorDosen) {
                            session()->setFlashdata('errorNIDN', 'NIDN sudah terdaftar');
                            break;
                        }
                    }
                    $nama = $this->request->getPost('nama_penjabat')[$key];
                    array_push($data, array(
                        'id' => $val,
                        'nomor_induk' => $nidn,
                        'nama_penjabat' => $nama,
                        'jk' => $this->request->getPost('jk')[$key],
                        'tempat_lahir' => $this->request->getPost('tempat_lahir')[$key],
                        'tgl_lahir' => get_format_date_sql($this->request->getPost('tgl_lahir')[$key]),
                        'gelar_depan' => $this->request->getPost('gelar_depan')[$key],
                        'gelar_belakang' => $this->request->getPost('gelar_belakang')[$key],
                        'alamat' => $this->request->getPost('alamat')[$key],
                        'pendidikan' => $this->request->getPost('pendidikan')[$key],
                        'lulusan' => $this->request->getPost('lulusan')[$key],
                    ));
                    db_connect()->table('users')->where('id_peg', $val)->set(['username' => $nidn, 'nama_user' => $nama])->update();
                }
                if (session()->getFlashdata('errorNIDN')) {
                    $status['type'] = 'error';
                    $status['text'] = ['NIDN' => session()->getFlashdata('errorNIDN')];
                    return json_encode($status);
                }
                if ($this->dosenm->updateBatch($data, 'id')) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Dosen Telah Di Ubah';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->dosenm->errors();
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->dosenm->delete($this->request->getPost('id'))) {
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

/* End of file Dosen.php */
/* Location: ./app/controllers/Dosen.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-08-18 10:01:17 */
/* http://harviacode.com */