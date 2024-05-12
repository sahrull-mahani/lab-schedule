<?php

namespace App\Controllers;

use App\Models\ApiModel;
use App\Models\HomeM;
use App\Models\JadwalM;
use App\Models\KelasM;
use App\Models\LaboratoriumM;
use App\Models\Mata_kuliahM;

class Home extends BaseController
{
    protected $apiModel, $data, $labm, $kelasm, $mkm, $homem, $jadwalm;
    public function __construct()
    {
        $this->apiModel = new ApiModel();
        $this->labm = new LaboratoriumM();
        $this->kelasm = new KelasM();
        $this->mkm = new Mata_kuliahM();
        $this->homem = new HomeM();
        $this->jadwalm = new JadwalM();
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['m_home'] = 'active bg-gradient-primary';
        $data['url'] = 'home/';
        $data['lab'] = $this->labm->countAllResults();
        $data['kelas'] = $this->kelasm->countAllResults();
        $data['mk'] = $this->mkm->countAllResults();
        $data['breadcome'] = 'Home';
        return view('App\Views\template_adminlte\home', $data);
    }
    public function ajax_request()
    {
        $list = $this->homem->get_datatables();
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
            $row['ttdosen_id'] = pegawaiByID($rows->dosentt_id)->nama_penjabat;
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
            "total" => $this->homem->total(),
            "totalNotFiltered" => $this->homem->countAllResults(),
            "rows" => $data,
        );
        echo json_encode($output);
    }
    public function img_thumb($file_name)
    {
        $filepath = WRITEPATH . 'uploads/thumbs/' . $file_name;
        $this->response->setContentType('image/jpg,image/jpeg,image/png');
        header('Content-Disposition: inline; filename=' . $file_name);
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        readfile($filepath);
    }
    public function img_medium($file_name)
    {
        $filepath = WRITEPATH . 'uploads/img/' . $file_name;
        $this->response->setContentType('image/jpg,image/jpeg,image/png');
        header('Content-Disposition: inline; filename=' . $file_name);
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        readfile($filepath);
    }
    public function pdf_view($file_name)
    {
        $filepath = WRITEPATH . 'uploads/pdf/' . $file_name;
        $this->response->setContentType('application/pdf');
        header('Content-Disposition: inline; filename=' . $file_name);
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        readfile($filepath);
    }

    public function export_pdf()
    {
        $jadwal = $this->jadwalm
        ->select('*, case
        when hari = "senin" then 1
        when hari = "selasa" then 2
        when hari = "rabu" then 3
        when hari = "kamis" then 4
        when hari = "jumat" then 5
        when hari = "sabtu" then 6
        when hari = "minggu" then 7
        else 0
        end AS day', false)
        ->orderBy('day', 'asc')
        ->joinLab()->joinMk()->where('status', 'setuju')
        ->where('YEAR(jadwal.created_at)', date('Y'))
        ->findAll();

        $data = [
            'jadwal'=>$jadwal
        ];

        $format = [
            'format'    => 'A4',
            'orientation' => 'L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 30,
            'margin_bottom' => 10,
            'margin_header' => 10,
            'margin_footer' => 9,
        ];
        $mpdf = new \Mpdf\Mpdf($format);

        $mpdf->SetTitle('Laporan jadwal tahun ini');
        $pdfstyle = file_get_contents(__DIR__ . '/../../public/assets/dist/css/pdf.css');
        $mpdf->WriteHTML($pdfstyle, \Mpdf\HTMLParserMode::HEADER_CSS);

        $html = view('App\Views\pdf\laporan-tahunan', $data);
        $mpdf->WriteHTML($html);

        return redirect()->to($mpdf->Output());
    }
}
