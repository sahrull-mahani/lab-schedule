<?php

namespace App\Controllers;

use App\Models\JadwalM;

class Jadwal extends BaseController
{
    protected $jadwalm, $data, $session;
    function __construct()
    {
        $this->jadwalm = new JadwalM();
    }
    public function index()
    {
        $this->data = array('title' => 'Jadwal | Admin', 'breadcome' => 'Jadwal', 'url' => 'jadwal/', 'm_jadwal' => 'active', 'session' => $this->session);

        echo view('App\Views\jadwal\jadwal_list', $this->data);
    }

    public function ajax_request()
    {
        $list = $this->jadwalm->get_datatables();
        $data = array();
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['dosen_id'] = $rows->nama_penjabat;
            $row['mk_id'] = $rows->nama_mk;
            $row['kelas_id'] = $rows->nama_kelas;
            $row['jam'] = "$rows->jam_mulai - $rows->jam_akhir";
            $row['tanggal'] = get_format_date($rows->tanggal);
            $data[] = $row;
        }
        $output = array(
            "total" => $this->jadwalm->total(),
            "totalNotFiltered" => $this->jadwalm->countAllResults(),
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
            $this->data['form_input'][] = view('App\Views\jadwal\form_input', $data);
        }
        $status['html']         = view('App\Views\jadwal\form_modal', $this->data);
        $status['modal_title']  = 'Tambah Data Jadwal';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->data = array('action' => 'update', 'btn' => '<i class="fas fa-edit"></i> Edit');
        foreach ($id as $ids) {
            $get = $this->jadwalm->find($ids);
            $data = array(
                'nama' => '<b>' . $get->nama . '</b>',
                'get' => $get,
            );
            $this->data['form_input'][] = view('App\Views\jadwal\form_input', $data);
        }
        $status['html']         = view('App\Views\jadwal\form_modal', $this->data);
        $status['modal_title']  = 'Update Data Jadwal';
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
                        'dosen_id' => $this->request->getPost('dosen_id')[$key],
                        'mk_id' => $this->request->getPost('mk_id')[$key],
                        'kelas_id' => $this->request->getPost('kelas_id')[$key],
                        'jam_mulai' => $this->request->getPost('jam_mulai')[$key],
                        'jam_akhir' => $this->request->getPost('jam_akhir')[$key],
                        'tanggal' => get_format_date_sql($this->request->getPost('tanggal')[$key]),
                    ));
                }
                if ($this->jadwalm->insertBatch($data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Jadwal Tersimpan';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->jadwalm->errors();
                }
                echo json_encode($status);
                break;
            case 'update':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    array_push($data, array(
                        'id' => $val,
                        'dosen_id' => $this->request->getPost('dosen_id')[$key],
                        'mk_id' => $this->request->getPost('mk_id')[$key],
                        'kelas_id' => $this->request->getPost('kelas_id')[$key],
                        'jam_mulai' => $this->request->getPost('jam_mulai')[$key],
                        'jam_akhir' => $this->request->getPost('jam_akhir')[$key],
                        'tanggal' => get_format_date_sql($this->request->getPost('tanggal')[$key]),
                    ));
                }
                if ($this->jadwalm->updateBatch($data, 'id')) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Jadwal Telah Di Ubah';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->jadwalm->errors();
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->jadwalm->delete($this->request->getPost('id'))) {
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

/* End of file Jadwal.php */
/* Location: ./app/controllers/Jadwal.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-08-18 10:27:15 */
/* http://harviacode.com */