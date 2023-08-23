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
                case 'dosen setuju':
                    $color = 'info';
                    break;
            }
            if ($rows->status == 'pindah jadwal' || $rows->status == 'dosen setuju') {
                $dosenVerify  = $rows->nama_penjabat . '<br/>';
            }
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['dosen_id'] = ($rows->status == 'pindah jadwal' || $rows->status == 'dosen setuju') ? pegawaiByID($rows->dosen_verify)->nama_penjabat : $rows->nama_penjabat;
            $row['mk_id'] = $rows->nama_mk;
            $row['kelas_id'] = $rows->nama_kelas;
            $row['lab_id'] = $rows->nama_lab;
            $row['waktu_mulai'] = $rows->waktu_mulai;
            $row['waktu_selesai'] = $rows->waktu_selesai;
            $row['hari'] = $rows->hari;
            $row['status'] = @$dosenVerify . "<span class='fw-bold rounded px-1 bg-$color text-white'>$rows->status</span>";
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
                        'dosen_id' => is_admin() ? $this->request->getPost('dosen_id')[$key] : session('id_peg'),
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
                    $get = $this->jadwalm->find($val);
                    $dosenPengganti = $this->request->getPost('dosen_verify')[$key] ?? '';
                    if (is_admin()) {
                        $dosenID = $this->request->getPost('dosen_id')[$key];
                        $dosen_id = $dosenPengganti != '' ? $dosenPengganti : $dosenID;
                        $dosen_verify = $dosenPengganti != '' ? $dosenID : null;
                    } else {
                        $dosen_id = $dosenPengganti != '' ? session('id_peg') : $get->dosen_id;
                        $dosen_verify = $dosenPengganti != '' ? $get->dosen_id : null;
                    }

                    array_push($data, array(
                        'id' => $val,
                        'dosen_id' => $dosen_id,
                        'mk_id' => $this->request->getPost('mk_id')[$key] ?? $get->mk_id,
                        'kelas_id' => $this->request->getPost('kelas_id')[$key] ?? $get->kelas_id,
                        'lab_id' => $this->request->getPost('lab_id')[$key] ?? $get->lab_id,
                        'waktu_mulai' => $this->request->getPost('waktu_mulai')[$key] ?? $get->waktu_mulai,
                        'waktu_selesai' => $this->request->getPost('waktu_selesai')[$key] ?? $get->waktu_selesai,
                        'hari' => $this->request->getPost('hari')[$key] ?? $get->hari,
                        'status' => $dosenPengganti != '' ? 'pindah jadwal' : 'belum disetujui',
                        'dosen_verify' => $dosen_verify,
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
                    if ($jadwal->status == 'pindah jadwal') {
                        $status['type'] = 'warning';
                        $status['text'] = ['Dosen yang bersangkutan belum menyetujui!',' Anda belum bisa mengganti status!'];
                        return json_encode($status);
                    }
                    array_push($data, array(
                        'id' => $val,
                        'status' => $this->request->getPost('status')[$key],
                        'dosen_verify' => null,
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
                if ($this->jadwalm->update($id, ['status' => 'dosen setuju'])) {
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
                $id = $this->request->getPost('id');
                if (in_groups(3)) {
                    foreach ($this->jadwalm->whereIn('id', $id)->findAll() as $row) {
                        $status['type'] = 'warning';
                        $status['text'] = ['<strong>Oh snap!</strong> Proses hapus data gagal, Karena data ada yang sudah disetujui!.'];
                        if ($row->status == 'setuju') return json_encode($status);
                    }
                }
                if ($this->jadwalm->delete($id)) {
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