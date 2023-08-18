<?php

namespace App\Models;

class ApiModel
{
    protected $session;
    function __construct()
    {
        $this->session = \Config\Services::session();
    }
    public function getApi($baseURI, $url)
    {
        $options = [
            'baseURI' => $baseURI,
            'timeout' => 30,
        ];
        $client = \Config\Services::curlrequest($options);
        try {
            $res = $client->request('GET', $url, [
                'http_errors' => false
            ]);
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return 500;
        }
        $body = $res->getBody();
        switch ($res->getStatusCode()) {
            case '200':
                $this->session->setFlashdata('success', '200-OK');
                return json_decode($body, true);
                break;

            case '404':
                $this->session->setFlashdata('error', '404 - not found');
                return false;
                break;

            default:
                $this->session->setFlashdata('error', 'undefined error, status : ' . $res->getStatusCode());
                return false;
                break;
        }
    }
}
