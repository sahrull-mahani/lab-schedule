<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorsM extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'visitors';
    protected $primaryKey       = 'visitor_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    public function counterNews()
    {
        return $this->select('*')->selectCount('referer_page', 'count')->where('referer_page !=', '')->like('referer_page', 'artikeldetail')->groupBy('referer_page')->findAll();
        $db = db_connect();
        return $db->query("SELECT *, COUNT(DISTINCT referer_page) AS count FROM `visitors` WHERE referer_page != '' AND referer_page LIKE '%artikeldetail%' GROUP BY referer_page")->getResult();
    }
    public function counterNew($slug)
    {
        $query = $this->select('*')->selectCount('ip_address', 'count')->where('referer_page !=', '')->like('referer_page', $slug)->first();
        return intval($query->count / 4);
    }
}
