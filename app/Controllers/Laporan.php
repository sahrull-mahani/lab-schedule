<?php

namespace App\Controllers;

use App\Models\KuotaM;
use App\Models\PangkalanM;
use Mpdf\Mpdf;

class Laporan extends BaseController
{
    protected $kuotam, $pangkalanm, $data, $session;
    function __construct()
    {
        $this->kuotam = new KuotaM();
        $this->pangkalanm = new PangkalanM();
    }
    public function index()
    {
        $this->data = array('title' => 'Laporan | Admin', 'breadcome' => 'Laporan', 'url' => 'laporan/', 'm_laporan' => 'active bg-gradient-primary', 'session' => $this->session);

        echo view('App\Views\kuota\laporan_list', $this->data);
    }

    public function ajax_request()
    {
        $list = $this->kuotam->get_datatablesLaporan();
        $data = array();
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['pangkalan_id'] = $rows->nama_pangkalan;
            $row['jumlah-perminggu'] = $rows->jumlah_perminggu;
            $row['jumlah-perbulan'] = $rows->jumlah_perbulan;
            $row['jumlah-kk'] = $rows->jumlah_kk;
            $row['bulan'] = getBulan(date('m', strtotime($rows->created_at))) . ' ' . date('Y', strtotime($rows->created_at));
            $row['status'] = $rows->approved_at == null ? '<span class="badge bg-danger">belum disetujui</span>' : '<span class="badge bg-success">setujui</span>';
            $data[] = $row;
        }
        $output = array(
            "total" => $this->kuotam->totalLaporan(),
            "totalNotFiltered" => $this->kuotam->countAllResults(),
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
            $data['pangkalan'] = $this->pangkalanm->findAll();
            $this->data['form_input'][] = view('App\Views\kuota\form_input', $data);
        }
        $status['html']         = view('App\Views\kuota\form_modal', $this->data);
        $status['modal_title']  = 'Tambah Data Kuota';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->data = array('action' => 'update', 'btn' => '<i class="fas fa-edit"></i> Edit');
        foreach ($id as $ids) {
            $get = $this->kuotam->find($ids);
            $data = array(
                'nama' => '<b>' . $get->nama . '</b>',
                'get' => $get,
                'pangkalan' => $this->pangkalanm->findAll(),
            );
            $this->data['form_input'][] = view('App\Views\kuota\form_input', $data);
        }
        $status['html']         = view('App\Views\kuota\form_modal', $this->data);
        $status['modal_title']  = 'Update Data Kuota';
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
                        'pangkalan_id' => $this->request->getPost('pangkalan_id')[$key],
                        'jumlah_perminggu' => $this->request->getPost('jumlah_perminggu')[$key],
                        'jumlah_perbulan' => $this->request->getPost('jumlah_perbulan')[$key],
                        'jumlah_kk' => $this->request->getPost('jumlah_kk')[$key],
                    ));
                }
                if ($this->kuotam->insertBatch($data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Kuota Tersimpan';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->kuotam->errors();
                }
                echo json_encode($status);
                break;
            case 'update':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    array_push($data, array(
                        'id' => $val,
                        'pangkalan_id' => $this->request->getPost('pangkalan_id')[$key],
                        'jumlah_perminggu' => $this->request->getPost('jumlah_perminggu')[$key],
                        'jumlah_perbulan' => $this->request->getPost('jumlah_perbulan')[$key],
                        'jumlah_kk' => $this->request->getPost('jumlah_kk')[$key],
                    ));
                }
                if ($this->kuotam->updateBatch($data, 'id')) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Kuota Telah Di Ubah';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->kuotam->errors();
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->kuotam->delete($this->request->getPost('id'))) {
                    $status['type'] = 'success';
                    $status['text'] = '<strong>Deleted..!</strong>Berhasil dihapus';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = '<strong>Oh snap!</strong> Proses hapus data gagal.';
                }
                echo json_encode($status);
                break;
            case 'approve':
                $data = $this->request->getPost('data');

                $year = explode(' ', end($data));
                $year = end($year);

                $month = explode(' ', current($data));
                $month = current($month);
                $month = getBulan($month, 'huruf');
                $date = "$year-$month";
                if ($this->kuotam->setujui($date)) {
                    $status['type'] = 'success';
                    $status['text'] = '<strong>Berhasil..!</strong>Berhasil di setujui';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = '<strong>Oh snap!</strong> Data gagal di setujui.';
                }
                echo json_encode($status);
                break;
        }
    }
    public function printpdf($year, $bulan, $kecamatan)
    {
        if ($kecamatan == 'Filter By kecamatan') {
            return '<h1 align="center">Pilih kecamatan terlebih Dahulu</h1>';
        }
        $date = "$year-$bulan";
        // $result = $this->kuotam->select('kuota.*, p.nama_pangkalan, p.id_registrasi, p.desa_id')->join('pangkalan p', 'p.id= kuota.pangkalan_id')->like('approved_at', $date)->findAll();
        // foreach ($result as $row) {
        //     $desa[] = getDesa($row->desa_id)->nama;
        // }
        $data = [
            'data' => $this->kuotam->select('kuota.*, p.nama_pangkalan, p.id_registrasi, p.desa_id')->join('pangkalan p', 'p.id= kuota.pangkalan_id')->like('approved_at', $date)->findAll(),
            'kecamatan' => $kecamatan,
        ];

        $format = [
            'mode' => 'utf-8',
            'format'    => 'Legal',
            'orientation' => 'L',
            'default_font' => 'tahoma',
            'default_font_size' => 12,
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_header' => 10,
            'margin_footer' => 9,
        ];
        $mpdf = new Mpdf($format);
        $pdfstyle = file_get_contents(__DIR__ . '/../../public/assets/dist/css/pdf.css');
        $mpdf->WriteHTML($pdfstyle, \Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->SetTitle('Kuota LPG');
        $mpdf->SetSubject('Laporan Kuota LPG');
        $mpdf->SetCreator('Diskominfo');
        $mpdf->SetAuthor('Diskominfo');
        $mpdf->SetSubject('Cetak Laporan Kuota LPG');

        $html = view('App\Views\kuota\pdf\pdf-kuota', $data);
        $mpdf->WriteHTML($html);

        return redirect()->to($mpdf->Output());
        // $this->response->setContentType('application/pdf');
        // $mpdf->Output("Laporan Kuota LPG bulan $date.pdf", 'I');
    }
}

/* End of file Kuota.php */
/* Location: ./app/controllers/Kuota.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-06-08 09:58:35 */
/* http://harviacode.com */