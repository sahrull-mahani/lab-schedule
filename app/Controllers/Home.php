<?php

namespace App\Controllers;

use App\Models\ApiModel;
use App\Models\KuotaM;
use App\Models\PangkalanM;

class Home extends BaseController
{
    protected $apiModel, $data, $pangkalanm, $kuotam;
    public function __construct()
    {
        $this->apiModel = new ApiModel();
        $this->pangkalanm = new PangkalanM();
        $this->kuotam = new KuotaM();
        $this->apiModel = new ApiModel();
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['m_home'] = 'active bg-gradient-primary';
        $data['breadcome'] = 'Home';
        $data['pokok'] = count($this->apiModel->getApi('https://sibakti.perdaginkop.bolmutkab.go.id/', 'api-harga/pokok/true')['text']) ?? 0;
        $data['penting'] = count($this->apiModel->getApi('https://sibakti.perdaginkop.bolmutkab.go.id/', 'api-harga/penting/true')['text']) ?? 0;
        $data['kuota'] = $this->kuotam->selectSum('jumlah_perminggu', 'total')->first();
        $data['pangkalan'] = $this->kuotam->countAllResults();
        return view('App\Views\template_adminlte\home', $data);
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
}
