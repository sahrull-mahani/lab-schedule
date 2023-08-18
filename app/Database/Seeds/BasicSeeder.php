<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BasicSeeder extends Seeder
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
        ];
        $this->db->table('users')->insertBatch($users);

        $usersGroups = [
            [
                'user_id'   => 1,
                'group_id'  => 1
            ],
            [
                'user_id'   => 2,
                'group_id'  => 2
            ],
        ];
        $this->db->table('users_groups')->insertBatch($usersGroups);

        $jabatan = [
            [
                'nama'      => 'Kepala Bagian',
                'created_at'=> date('Y-m-d'),
                'updated_at'=> date('Y-m-d'),
            ],
            [
                'nama'      => 'Kasubbag Bina Produksi',
                'created_at'=> date('Y-m-d'),
                'updated_at'=> date('Y-m-d'),
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
                'gelar_belakang'=> '-',
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
                'gelar_belakang'=> '-',
                'alamat'        => 'Suaka',
                'pendidikan'    => 'SMA/SMK/MA',
                'lulusan'       => 'SMP Kehutanan',
                'created_at'    => date('Y-m-d'),
                'updated_at'    => date('Y-m-d'),
            ],
        ];
        $this->db->table('pegawai')->insertBatch($pegawai);
    }
}
