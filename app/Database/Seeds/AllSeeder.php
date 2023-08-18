<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AllSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            [
                'name'          => 'admin',
                'description'   => 'Administrator'
            ],
            [
                'name'          => 'operator',
                'description'   => 'Kepala Bidang'
            ],
            [
                'name'          => 'verifikator',
                'description'   => 'Verifikator'
            ],
            [
                'name'          => 'pimpinan',
                'description'   => 'Pimpinan SKPD'
            ],
        ];
        $this->db->table('groups')->insertBatch($groups);


        $users = [
            [
                'ip_address'        => '127.0.0.1',
                'username'          => 'administrator',
                'password'          => '$2y$10$KwpwKG15gc4fPUDDYhUkluvhymHNbAx4daEZjWFBIaeIfnP3yTw.m',
                'email'             => 'admin@admin.com',
                'created_on'        => 1268889823,
                'last_login'        => 1661586883,
                'active'            => 1,
                'nama_user'         => 'administrator',
                'phone'             => '08',
                'id_peg'            => null,
            ],
            [
                'ip_address'        => '127.0.0.1',
                'username'          => 'operator',
                'password'          => '$2y$10$KwpwKG15gc4fPUDDYhUkluvhymHNbAx4daEZjWFBIaeIfnP3yTw.m',
                'email'             => 'operator@mail.go.id',
                'created_on'        => 1268889823,
                'last_login'        => 1661586883,
                'active'            => 1,
                'nama_user'         => 'Operator',
                'phone'             => '08',
                'id_peg'            => null,
            ],
            [
                'ip_address'        => '127.0.0.1',
                'username'          => 'verifikator',
                'password'          => '$2y$10$KwpwKG15gc4fPUDDYhUkluvhymHNbAx4daEZjWFBIaeIfnP3yTw.m',
                'email'             => 'verifikator@mail.go.id',
                'created_on'        => 1268889823,
                'last_login'        => 1661586883,
                'active'            => 1,
                'nama_user'         => 'Verifikator',
                'phone'             => '08',
                'id_peg'            => null,
            ],
            [
                'ip_address'        => '127.0.0.1',
                'username'          => 'pimpinan',
                'password'          => '$2y$10$KwpwKG15gc4fPUDDYhUkluvhymHNbAx4daEZjWFBIaeIfnP3yTw.m',
                'email'             => 'pimpinan@mail.go.id',
                'created_on'        => 1268889823,
                'last_login'        => 1661586883,
                'active'            => 1,
                'nama_user'         => 'Pimpinan',
                'phone'             => '08',
                'id_peg'            => null,
            ],
        ];
        $this->db->table('users')->insertBatch($users);

        $usersGroups = [
            [
                'user_id'   => 1,
                'group_id'  => 1
            ],
            [
                'user_id'   => 1,
                'group_id'  => 2
            ],
            [
                'user_id'   => 1,
                'group_id'  => 3
            ],
            [
                'user_id'   => 1,
                'group_id'  => 4
            ],
            [
                'user_id'   => 2,
                'group_id'  => 2
            ],
            [
                'user_id'   => 3,
                'group_id'  => 3
            ],
            [
                'user_id'   => 4,
                'group_id'  => 4
            ],
        ];
        $this->db->table('users_groups')->insertBatch($usersGroups);

        $jabatan = [
            [
                'nama'      => 'Kepala Bagian',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'nama'      => 'Kasubbag Bina Produksi',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'nama'      => 'Kasubbag Bina Verifikator',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
        ];
        $this->db->table('jabatan')->insertBatch($jabatan);

        $pegawai = [
            [
                'jab_id'        => 1,
                'nama'          => 'User Kosong Satu',
                'jk'            => 'Perempuan',
                'tempat_lahir'  => 'Madagaskar',
                'tgl_lahir'     => '1998-03-26',
                'gelar_depan'   => '-',
                'gelar_belakang' => '-',
                'alamat'        => 'Suaka',
                'pendidikan'    => 'SMA/SMK/MA',
                'lulusan'       => 'SMP Kehutanan',
                'created_at'    => date('Y-m-d'),
                'updated_at'    => date('Y-m-d'),
            ],
            [
                'jab_id'        => 2,
                'nama'          => 'User Kosong Dua',
                'jk'            => 'Perempuan',
                'tempat_lahir'  => 'Madagaskar',
                'tgl_lahir'     => '1999-05-11',
                'gelar_depan'   => '-',
                'gelar_belakang' => '-',
                'alamat'        => 'Suaka',
                'pendidikan'    => 'SMA/SMK/MA',
                'lulusan'       => 'SMP Kehutanan',
                'created_at'    => date('Y-m-d'),
                'updated_at'    => date('Y-m-d'),
            ],
            [
                'jab_id'        => 3,
                'nama'          => 'User Kosong Tiga',
                'jk'            => 'Perempuan',
                'tempat_lahir'  => 'Madagaskar',
                'tgl_lahir'     => '1999-05-11',
                'gelar_depan'   => '-',
                'gelar_belakang' => '-',
                'alamat'        => 'Suaka',
                'pendidikan'    => 'SMA/SMK/MA',
                'lulusan'       => 'SMP Kehutanan',
                'created_at'    => date('Y-m-d'),
                'updated_at'    => date('Y-m-d'),
            ],
        ];
        $this->db->table('pegawai')->insertBatch($pegawai);

        $pangkalan = [
            [
                'desa_id'           => 7108062015,
                'nama_pangkalan'    => 'SAFRIL TULANELENGGI',
                'id_registrasi'     => '795765822203001',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062020,
                'nama_pangkalan'    => 'KADIR HASANI',
                'id_registrasi'     => '795765822203002',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062008,
                'nama_pangkalan'    => 'SUWARNO PATAJENU',
                'id_registrasi'     => '795765822203199',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062002,
                'nama_pangkalan'    => 'RONNY HANGKIHO',
                'id_registrasi'     => '795765822203011',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062014,
                'nama_pangkalan'    => 'KARAMA DESEI',
                'id_registrasi'     => '795765822203013',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062005,
                'nama_pangkalan'    => 'YUNITA PATILIMA',
                'id_registrasi'     => '795765822203014',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062003,
                'nama_pangkalan'    => 'YANSEN PALANDI',
                'id_registrasi'     => '795765822203015',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062017,
                'nama_pangkalan'    => 'BUMDES HELUMA',
                'id_registrasi'     => '795765822203026',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062012,
                'nama_pangkalan'    => 'TAHIR ANTULE',
                'id_registrasi'     => '795765822203067',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062004,
                'nama_pangkalan'    => 'KOPERASI BUNDES',
                'id_registrasi'     => '795765822203073',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062019,
                'nama_pangkalan'    => 'RUSLI RAUF',
                'id_registrasi'     => '795765822203078',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062011,
                'nama_pangkalan'    => 'MASITA TALANGO',
                'id_registrasi'     => '795765822203079',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062010,
                'nama_pangkalan'    => 'EXPORIUS MARTHIN',
                'id_registrasi'     => '795765822203100',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062013,
                'nama_pangkalan'    => 'MARIAM LAKORO',
                'id_registrasi'     => '795765822203107',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062007,
                'nama_pangkalan'    => 'SAHIAR ADE',
                'id_registrasi'     => '795765822203109',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062009,
                'nama_pangkalan'    => 'BUMDES BENIH HARAPAN',
                'id_registrasi'     => '795765822203111',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062016,
                'nama_pangkalan'    => 'ZAINUDIN DUNGGIO',
                'id_registrasi'     => '795765822203112',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062006,
                'nama_pangkalan'    => 'ABDUL IZMAL BUKOTING',
                'id_registrasi'     => '795765822203113',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062021,
                'nama_pangkalan'    => 'YUSNA HAJU',
                'id_registrasi'     => '795765822203114',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062001,
                'nama_pangkalan'    => 'RENI TAHULENDING',
                'id_registrasi'     => '795765822203115',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062018,
                'nama_pangkalan'    => 'KARMILA TAMBUAN',
                'id_registrasi'     => '795766822203189',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'desa_id'           => 7108062022,
                'nama_pangkalan'    => 'SUTINA PAKAYA',
                'id_registrasi'     => '795766822203190',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
        ];
        $this->db->table('pangkalan')->insertBatch($pangkalan);

        $pangkalantotal = $this->db->table('pangkalan')->countAll();
        $kuota = [];
        $jumlah = [25, 33, 15, 23, 29];
        for ($i = 1; $i <= $pangkalantotal; $i++) {
            $jmlrand = rand($jumlah[0], end($jumlah));
            $perweek = $jmlrand;
            $permonth = $perweek * 4;
            array_push($kuota, [
                'pangkalan_id'      => $i,
                'jumlah_perminggu'  => $perweek,
                'jumlah_perbulan'   => $permonth,
                'jumlah_kk'         => $perweek,
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ]);
        }
        $this->db->table('kuota')->insertBatch($kuota);
    }
}
