<?php

use App\Models\ApiModel;

function getTableWhere($table, $where, $column = null)
{
    $db = \Config\Database::connect();
    $query = $db->table($table)->getWhere($where)->getRow();
    if ($query->getNumRows() !== 0) {
        return isset($column) ? $query->{$column} : $query;
    } else {
        return false;
    }
}
function get_format_date_sql($date)
{
    $tgl = new DateTime($date);
    return $tgl->format("Y-m-d");
}
function get_format_date($date)
{
    $tgl = new DateTime($date);
    return $tgl->format("d-m-Y");
}
function GetDateNow()
{
    $tgl = new DateTime("now");
    return $tgl->format("d-m-Y");
}
function getDateTime($date)
{
    $tgl = new DateTime($date);
    return $tgl->format("Y-m-d H:i:s");
}
function getTime($date)
{
    $tgl = new DateTime($date);
    return $tgl->format("H:i:s");
}
function arrBulan()
{
    $bulan = array(
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    );
    return $bulan;
}
function getBulan($bulan, $type = 'number')
{
    if ($type == 'number') {
        switch ($bulan) {
            case "01":
                $bln = 'Januari';
                break;
            case "02":
                $bln = 'Februari';
                break;
            case "03":
                $bln = 'Maret';
                break;
            case "04":
                $bln = 'April';
                break;
            case "05":
                $bln = 'Mei';
                break;
            case "06":
                $bln = 'Juni';
                break;
            case "07":
                $bln = 'Juli';
                break;
            case "08":
                $bln = 'Agustus';
                break;
            case "09":
                $bln = 'September';
                break;
            case "10":
                $bln = 'Oktober';
                break;
            case "11":
                $bln = 'November';
                break;
            case "12":
                $bln = 'Desember';
                break;
        }
    } else {
        switch ($bulan) {
            case "Januari":
                $bln = '01';
                break;
            case "Februari":
                $bln = '02';
                break;
            case "Maret":
                $bln = '03';
                break;
            case "April":
                $bln = '04';
                break;
            case "Mei":
                $bln = '05';
                break;
            case "Juni":
                $bln = '06';
                break;
            case "Juli":
                $bln = '07';
                break;
            case "Agustus":
                $bln = '08';
                break;
            case "September":
                $bln = '09';
                break;
            case "Oktober":
                $bln = '10';
                break;
            case "November":
                $bln = '11';
                break;
            case "Desember":
                $bln = 'Desember';
                break;
        }
    }

    return $bln;
}
function hari($tgl)
{
    $dayList = array(
        'Sun' => 'Ahad',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    );
    $hari = date('D', strtotime($tgl));
    return $dayList[$hari];
}
function addTgl($date)
{
    $date = new DateTime($date);
    $date = $date->modify('+1 day');
    return $date->format('d-m-Y');
}
function loop_tanggal($begin, $end)
{
    $begin = new DateTime($begin);
    $end = new DateTime($end);
    $end = $end->modify('+1 day');

    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval, $end);

    return $daterange;
}
function getLastDate($bulan)
{
    $tgl_terakhir = date('m-t', strtotime(date("Y-" . $bulan . "-d")));
    return date('Y-' . $tgl_terakhir);
}
function ddBulan()
{
    foreach (arrBulan() as $key => $val) {
        $isi[$key] = $val;
    }
    return $isi;
}
// function getSetting($id, $skpd_id, $column = 'value')
// {
//     $db = \Config\Database::connect();
//     // $query = $db->query("SELECT $column FROM setting WHERE js_id = '$id' AND skpd_id = $skpd_id");
//     $query = $db->table('setting')->select($column)->join('jenis_setting', 'jenis_setting.id = setting.js_id', 'INNER')->where('setting.skpd_id', $skpd_id)->where('setting.js_id', $id)->get();
//     if ($query->getNumRows() !== 0) {
//         return $query->getRow()->{$column};
//     } else {
//         return false;
//     }
// }
// function getSelisihWaktu($idSet, $skpd_id)
// {
//     $begin = new DateTime(getSetting($idSet, $skpd_id));
//     $end = new DateTime(getTime('now'));
//     $diff = $begin->diff($end);
//     return $diff->format("%h jam %i menit %s detik");
// }
function rupiah($angka)
{
    $format_rupiah = "Rp. " . number_format($angka, 0, ',', '.');
    return $format_rupiah;
}
function rerupiah($angka)
{
    $rerupiah = preg_replace("/[^0-9]/", "", $angka);
    return $rerupiah;
}

function pegawai()
{
    $db = db_connect();
    $query = $db->table('pegawai')->select('pegawai.*')->join('users', 'users.id_peg = pegawai.id')->where('deleted_at', null)->get();
    if ($query->getNumRows() !== 0) {
        foreach ($query->getResult() as $row) {
            $isi[$row->id] = $row->nama;
        }
    } else {
        $isi[''] = "Tidak Ada Data";
    }
    return $isi;
}
function ddNotInUser()
{
    $db = \Config\Database::connect();
    $query = $db->query("SELECT * FROM pegawai WHERE id NOT IN (SELECT id_peg FROM users WHERE id_peg IS NOT NULL) AND deleted_at IS NULL");;
    if ($query->getNumRows() !== 0) {
        foreach ($query->getResult() as $row) {
            $isi[$row->id] = $row->nama;
        }
    } else {
        $isi[''] = "Tidak Ada Data";
    }
    return $isi;
}
function pegawaiById($id)
{
    $db = \Config\Database::connect();
    $query = $db->query("SELECT * FROM pegawai WHERE id=$id AND deleted_at IS NULL");
    if ($query->getNumRows() !== 0) {
        return $query->getRow();
    } else {
        return "Tidak Ada Data";
    }
}
function jabatan()
{
    $db = \Config\Database::connect();
    $query = $db->query('SELECT * FROM jabatan');
    if ($query->getNumRows() !== 0) {
        foreach ($query->getResult() as $row) {
            $isi[$row->id] = $row->nama;
        }
    } else {
        $isi[''] = "Tidak Ada Data";
    }
    return $isi;
}
// function skpd()
// {
//     $db = \Config\Database::connect();
//     $query = $db->query('SELECT * FROM skpd');
//     if ($query->getNumRows() !== 0) {
//         foreach ($query->getResult() as $row) {
//             $isi[$row->id] = $row->nama;
//         }
//     } else {
//         $isi[''] = "Tidak Ada Data";
//     }
//     return $isi;
// }
function jenisSetting($action)
{
    $query = ($action == 'update') ? 'SELECT * FROM jenis_setting' : 'SELECT * FROM jenis_setting WHERE id NOT IN (SELECT js_id FROM setting)';
    $db = \Config\Database::connect();
    $query = $db->query($query);
    if ($query->getNumRows() !== 0) {
        foreach ($query->getResult() as $row) {
            $isi[$row->id] = $row->nama;
        }
    } else {
        $isi[''] = "Tidak Ada Data";
    }
    return $isi;
}
function jenisKaryawan($id)
{
    $arr = ['1', '2', '3', '4', '5'];
    if (in_array((string)$id, $arr)) {
        return 'pegawai';
    }
    return 'ta';
}
function getPresensi($pegawaiId, $tgl)
{
    $db = \Config\Database::connect();
    $builder = $db->table('presensi');
    $builder->where('pegawai_id', $pegawaiId);
    $builder->where('tgl', $tgl);
    return $builder->get()->getRow();
}

function getIdByUserID($id, $table)
{
    $db = db_connect();
    return $db->table($table)->where('user_id', $id)->get()->getRow();
}

function getApi($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($result, true);
    return $result;
}

function get_visitor_for_today()
{
    $db = db_connect();
    $query = $db->query('SELECT Count(ip_address) as visits FROM visitor_log WHERE CURDATE()=DATE(access_date)')->getRow();
    return $query->visits;
}
function get_visitor_for_last_week()
{
    $db = db_connect();
    // $query = $db->query('SELECT Count(ip_address) as visits FROM visitor_log  WHERE DATE(access_date) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+6 DAY AND DATE(access_date) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-1 DAY')->getRow();
    $query = $db->query('SELECT Count(ip_address) as visits FROM visitor_log  WHERE DATE(access_date) >= CURDATE() - 7')->getRow();
    return $query->visits;
}
function get_total_visitor()
{
    $db = db_connect();
    $query = $db->query('SELECT Count(ip_address) as visits FROM visitor_log')->getRow();
    return $query->visits;
}
function get_hit_for_today()
{
    $db = db_connect();
    $query = $db->query('SELECT SUM(no_of_visits) as hits FROM visitors WHERE CURDATE()=DATE(access_date)')->getRow();
    return $query->hits;
}
function get_hit_for_last_week()
{
    $db = db_connect();
    // $query = $db->query('SELECT SUM(no_of_visits) as hits FROM visitors  WHERE DATE(access_date) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+6 DAY AND DATE(access_date) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-1 DAY')->getRow();
    $query = $db->query('SELECT SUM(no_of_visits) as hits FROM visitors  WHERE DATE(access_date) >= CURDATE() - 7')->getRow();
    return $query->hits;
}
function get_total_hit()
{
    $db = db_connect();
    $query = $db->query('SELECT SUM(no_of_visits) as hits FROM visitors')->getRow();
    return $query->hits;
}
function getCountBerita($like)
{
    $db = db_connect();
    // $query = $db->query('SELECT SUM(no_of_visits) as hits FROM visitors WHERE requested_url LIKE ')->getRow();
    $query = $db->table('visitors')->selectSum('no_of_visits', 'hits')->like('requested_url', $like)->get()->getRow();
    return $query->hits;
}

function getPegawai($id)
{
    $db = db_connect();
    return $db->table('pegawai')->where('id', $id)->get()->getRow();
}

function namaAkun($nama)
{
    $namas = explode(' ', $nama);

    if (count($namas) > 1) {
        foreach ($namas as $key => $row) {
            $name[] = $key == 0 ? substr($row, 0, 1) . '. ' : $row;
        }

        $nama = implode(' ', $name);
    }

    return $nama;
}
function getJabatan($string)
{
    switch ($string) {
        case "kadis":
            return ['1.0.0'];
            break;
        case "sekertaris":
            return ['2.0.0'];
            break;
        case "kabid":
            for ($i = 3; $i <= 9; $i++) {
                $jab[] = "$i.0.0";
            }
            return $jab;
            break;
        default:
            for ($i = 1; $i <= 9; $i++) {
                $jab[] = "$i.0.0";
            }
            return $jab;
            break;
    }
}
function getLevel($level, $id)
{
    $lvl = (int)str_replace('.', '', $level);
    if ($level == '1.0.0') {
        return [1, 0, null]; //KADIS
    } else if ($lvl == 200) {
        return [2, 1, ['assistant']]; // SEKERTARIS
    } else if ($lvl > 200 && $lvl < 300) { // DIBAWAH SEK KASUBAG
        return [(int)(explode('.', $level)[0] . $id), 2, ['right-partner']];
    } else if ((int)explode('.', $level)[0] > 2 && (int)explode('.', $level)[1] == 0 && (int)explode('.', $level)[2] == 0) {
        return [(int)explode('.', $level)[0], 1, null]; //KABID
    } else if ((int)explode('.', $level)[0] > 2 && (int)explode('.', $level)[1] != 0 && (int)explode('.', $level)[2] == 0) {
        return [(int)(explode('.', $level)[0] . explode('.', $level)[1] . $id), (int)explode('.', $level)[0], null]; //KASIE
    } else if ((int)explode('.', $level)[0] > 2 && (int)explode('.', $level)[1] != 0 && (int)explode('.', $level)[2] != 0) {
        return [(int)(explode('.', $level)[0] . explode('.', $level)[1] . explode('.', $level)[2]), (int)(explode('.', $level)[0] . explode('.', $level)[1] . $id - explode('.', $level)[2]), null]; //staff dibawah kasie
    } else {
        return [(int)(explode('.', $level)[0] . explode('.', $level)[1] . explode('.', $level)[2]), (int)explode('.', $level)[0], null]; //staff
    }
}
function clearLink($text)
{
    return str_replace('ppid.bolmutkab.go.id —–» ', '', strip_tags($text));
}
function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function getCreateUpdate($created, $updated)
{
    if ($created == $updated) {
        return ['Dibuat', $created];
    } else {
        return ['Diperbaharui', $updated];
    }
}

function getFullName($nama)
{
    return ucwords(str_replace('-', '', $nama));
}
function getUserByID($id)
{
    return db_connect()->table('users')->getWhere(['id' => $id])->getRow();
}
function getUserByEmail($identity)
{
    return db_connect()->table('users u')->join('users_groups ug', 'ug.user_id = u.id')->join('groups g', 'g.id = ug.group_id')->Where('u.email', $identity)->orWhere('u.username', $identity)->get()->getRow();
}