<?php

namespace App\Controllers;

use App\Models\GrafikM;
use Mpdf\Mpdf;

class Grafik extends BaseController
{
    protected $grafikm, $data, $session;
    function __construct()
    {
        $this->grafikm = new GrafikM();
    }
    public function index()
    {
        $this->data = array('title' => 'Grafik | Admin', 'breadcome' => 'Grafik', 'url' => 'grafik/', 'm_grafik' => 'active bg-gradient-primary', 'session' => $this->session, 'chart' => true);

        return view('App\Views\grafik\grafik_list', $this->data);
    }
    public function inflasi_barang()
    {
        $tahun = (int)$this->request->getPost('tahun');
        $bulan = (int)$this->request->getPost('bulan');
        $bahans = $this->request->getPost('bahan');
        if ($bahans != null) {
            $data = $this->inflasi($tahun, $bulan, $bahans);
        } else {
            $data = [];
        }
        return json_encode($data);
    }
    public function printpdf($year, $bulan, $bahan)
    {
        $bahan = explode(',', $bahan);
        $format = [
            'mode' => 'utf-8',
            'format'    => 'Legal',
            'orientation' => 'P',
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

        $inflasi = $this->inflasi($year, $bulan, $bahan);
        $data = [
            'bulan' => $bulan,
            'tahun' => $year,
            'nama' => $inflasi['nama'],
            'satuan' => $inflasi['satuan'],
            'hasil' => $inflasi['hasil'],
        ];

        $mpdf->SetTitle('Grafik LPG');
        $mpdf->SetSubject('Laporan Grafik LPG');
        $mpdf->SetCreator('Diskominfo');
        $mpdf->SetAuthor('Diskominfo');
        $mpdf->SetSubject('Cetak Laporan Grafik LPG');

        $html = view('App\Views\grafik\pdf\pdf-grafik', $data);
        $mpdf->WriteHTML($html);

        return redirect()->to($mpdf->Output());
    }

    public function bahan($bahan, $bulan, $tahun)
    {
        $query = $this->grafikm->approved()->where('bahan', $bahan)->where(['MONTH(tanggal)'=>$bulan, 'YEAR(tanggal)'=>$tahun])->groupBy('nama_barang')->findAll();
        if (count($query) == 0) {
            return json_encode(404);
        }
        return json_encode($query);
    }

    public function inflasi($tahun, $bulan, $bahans)
    {
        $date = $this->grafikm->approved()->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->whereIn('nama_barang', $bahans)->orderBy('tanggal', 'asc')->findAll();
        $barang = $this->grafikm->approved()->select('nama_barang')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->whereIn('nama_barang', $bahans)->groupBy('nama_barang')->orderBy('tanggal', 'asc')->findAll();
        $satuan = $this->grafikm->approved()->select('satuan')->where('MONTH(tanggal)', $bulan)->where('YEAR(tanggal)', $tahun)->whereIn('nama_barang', $bahans)->groupBy('nama_barang')->orderBy('tanggal', 'asc')->findAll();
        $minggu = date('Y') . '-' . sprintf('%02d', $bulan) . '-01';
        $minggu = getWeek($minggu);

        $res = [];
        foreach ($date as $row) {
            array_push($res, [
                'duplicate' => 1,
                'minggu' => getWeek($row->tanggal, true),
                'harga' => $row->harga,
                'nama' => $row->nama_barang,
            ]);
        }

        $arr = [];
        foreach ($res as $row) {
            if (array_key_exists($row['minggu'] . '-' . str_replace(' ', '_', $row['nama']), $arr)) {
                $arr[$row['minggu'] . '-' . str_replace(' ', '_', $row['nama'])]['minggu'] = $row['minggu'];
                $arr[$row['minggu'] . '-' . str_replace(' ', '_', $row['nama'])]['nama'] = $row['nama'];
                $arr[$row['minggu'] . '-' . str_replace(' ', '_', $row['nama'])]['harga'] += $row['harga'];
                $arr[$row['minggu'] . '-' . str_replace(' ', '_', $row['nama'])]['duplicate'] += $row['duplicate'];
            } else {
                $arr[$row['minggu'] . '-' . str_replace(' ', '_', $row['nama'])] = $row;
            }
        }

        $result = [];
        $k = 0;
        foreach ($arr as $key => $row) {
            $result[$k]['minggu'] = $row['minggu'];
            $result[$k]['nama'] = str_replace('_', ' ', preg_replace('/[0-9]+[^a-zA-Z0-9]+/', '', $key));
            $result[$k++]['harga'] = $row['harga'] / $row['duplicate'];
        }

        $same = [];
        foreach ($result as $row) {
            if (array_key_exists($row['minggu'], $same)) {
                $same[$row['minggu']]['minggu'] = $row['minggu'];
                $same[$row['minggu']]['nama'] .= ',' . $row['nama'];
                $same[$row['minggu']]['harga'] .= ',' . $row['harga'];
            } else {
                $same[$row['minggu']] = $row;
            }
        }

        $hasil = [];
        for ($x = 1; $x <= $minggu; $x++) {
            if (array_key_exists($x, $same)) {
                $hasil[] = $same[$x];
            } else {
                $hasil[] = null;
            }
        }

        $data = [
            'nama' => $barang,
            'satuan' => $satuan,
            'hasil' => $hasil
        ];

        return $data;
    }
}

/* End of file Harga_bahan.php */
/* Location: ./app/controllers/Harga_bahan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-07-07 09:31:01 */
/* http://harviacode.com */