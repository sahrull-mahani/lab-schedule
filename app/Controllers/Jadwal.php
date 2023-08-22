<?php

namespace App\Controllers;

use App\Models\DosenM;
use App\Models\JadwalM;
use App\Models\KelasM;
use App\Models\LaboratoriumM;
use App\Models\Mata_kuliahM;

class Jadwal extends BaseController
{
    protected $jadwalm, $data, $session, $dosenm, $mkm, $kelasm, $labm;
    function __construct()
    {
        $this->jadwalm = new JadwalM();
        $this->dosenm = new DosenM();
        $this->mkm = new Mata_kuliahM();
        $this->kelasm = new KelasM();
        $this->labm = new LaboratoriumM();
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
        $color = '';
        foreach ($list as $rows) {
            switch ($rows->status) {
                case 'setuju':
                    $color = 'success';
                    break;
                case 'tidak setuju':
                    $color = 'danger';
                    break;
                case 'belum disetujui':
                    $color = 'secondary';
                    break;
                case 'pindah jadwal':
                    $color = 'info';
                    break;
            }
            if ($rows->dosen_verify !== null && $rows->status == 'pindah jadwal') {
                $dosenVerify  = pegawaiByID($rows->dosen_verify)->nama_penjabat . '<br/>';
            }
            if ($rows->dosen_verify == null && $rows->status == 'pindah jadwal') {
                $pesan = '<br/> Diverifikasi';
            }
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['dosen_id'] = $rows->nama_penjabat;
            $row['mk_id'] = $rows->nama_mk;
            $row['kelas_id'] = $rows->nama_kelas;
            $row['lab_id'] = $rows->nama_lab;
            $row['waktu_mulai'] = $rows->waktu_mulai;
            $row['waktu_selesai'] = $rows->waktu_selesai;
            $row['hari'] = $rows->hari;
            $row['status'] = @$dosenVerify . "<span class='fw-bold rounded px-1 bg-$color text-white'>$rows->status</span>" . @$pesan;
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
            $data['aksi'] = 'tambah';
            $data['dosen'] = $this->dosenm->where('jabatan', 'dosen')->findAll();
            $data['matakuliah'] = $this->mkm->findAll();
            $data['kelas'] = $this->kelasm->findAll();
            $data['laboratorium'] = $this->labm->findAll();
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
            $get = $this->jadwalm->select('jadwal.*, k.nama_kelas')->join('kelas k', 'k.id=jadwal.kelas_id')->find($ids);
            // if ($get->status == 'setuju') {
            //     return json_encode(['html' => 400, 'pesan' => 'data telah di setujui']);
            // }
            $data = array(
                'aksi' => 'edit',
                'nama' => '<b>' . $get->nama_kelas . '</b>',
                'get' => $get,
                'dosen' => $this->dosenm->where('jabatan', 'dosen')->findAll(),
                'matakuliah' => $this->mkm->findAll(),
                'kelas' => $this->kelasm->findAll(),
                'laboratorium' => $this->labm->findAll(),
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
                $nama = $this->request->getPost('id');
                $data = array();
                foreach ($nama as $key => $val) {
                    $labID = $this->request->getPost('lab_id')[$key];
                    $waktu = $this->request->getPost('waktu_mulai')[$key];
                    $waktumulai = explode(':', $waktu);
                    $waktumulai = current($waktumulai);
                    $hari = $this->request->getPost('hari')[$key];
                    if ($this->jadwalm->where('lab_id', $labID)->like('waktu_mulai', $waktumulai, 'after')->where('hari', $hari)->where('status', 'setuju')->first()) {
                        $status['type'] = 'warning';
                        $status['text'] = ['Laboratorium' => 'Telah Terjadwal', 'Waktu Mulai' => 'Telah Terjadwal', 'Hari' => 'Telah Terjadwal'];
                        return json_encode($status);
                    }
                    array_push($data, array(
                        'dosen_id' => $this->request->getPost('dosen_id')[$key],
                        'mk_id' => $this->request->getPost('mk_id')[$key],
                        'kelas_id' => $this->request->getPost('kelas_id')[$key],
                        'lab_id' => $labID,
                        'waktu_mulai' => $waktu,
                        'waktu_selesai' => $this->request->getPost('waktu_selesai')[$key],
                        'hari' => $hari,
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
                    $dosenID = $this->request->getPost('dosen_id')[$key];
                    $dosenPengganti = $this->request->getPost('dosen_verify')[$key];
                    array_push($data, array(
                        'id' => $val,
                        'dosen_id' => $dosenPengganti != '' ? $dosenPengganti : $dosenID,
                        'mk_id' => $this->request->getPost('mk_id')[$key],
                        'kelas_id' => $this->request->getPost('kelas_id')[$key],
                        'lab_id' => $this->request->getPost('lab_id')[$key],
                        'waktu_mulai' => $this->request->getPost('waktu_mulai')[$key],
                        'waktu_selesai' => $this->request->getPost('waktu_selesai')[$key],
                        'hari' => $this->request->getPost('hari')[$key],
                        'status' => $dosenPengganti != '' ? 'pindah jadwal' : 'belum disetujui',
                        'dosen_verify' => $dosenPengganti != '' ? $dosenID : null,
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
            case 'approve':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    $jadwal = $this->jadwalm->find($val);
                    $labID = $jadwal->lab_id;
                    $waktumulai = $jadwal->waktu_mulai;
                    $hari = $jadwal->hari;
                    if ($this->jadwalm->where('lab_id', $labID)->like('waktu_mulai', $waktumulai, 'after')->where('hari', $hari)->where('status', 'setuju')->first()) {
                        $status['type'] = 'warning';
                        $status['text'] = ['Laboratorium' => 'Telah Terjadwal', 'Waktu Mulai' => 'Telah Terjadwal', 'Hari' => 'Telah Terjadwal'];
                        return json_encode($status);
                    }
                    array_push($data, array(
                        'id' => $val,
                        'status' => $this->request->getPost('status')[$key],
                    ));
                }
                if ($this->jadwalm->updateBatch($data, 'id')) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Jadwal Berhasil Disetujui';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = 'Gagal merubah status jadwal';
                }
                echo json_encode($status);
                break;
            case 'pindah':
                $id = $this->request->getPost('id');
                if ($this->jadwalm->update($id, ['dosen_verify' => null])) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Jadwal Berhasil Disetujui';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = 'Gagal merubah status jadwal';
                }
                echo json_encode($status);
                break;
            case 'tolak':
                $id = $this->request->getPost('id');
                $get = $this->jadwalm->find($id);
                $data = [
                    'dosen_id'      => $get->dosen_verify,
                    'status'        => 'setuju',
                    'dosen_verify'  => null
                ];
                if ($this->jadwalm->update($id, $data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Jadwal Berhasil Disetujui';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = 'Gagal merubah status jadwal';
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
/* Generated by Harviacode Codeigniter CRUD Generator 2023-08-19 11:40:00 */
/* http://harviacode.com */