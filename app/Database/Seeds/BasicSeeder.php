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
                'name'          => 'k-lab',
                'description'   => 'Kepala Laboratorium Komputer'
            ],
            [
                'name'          => 'dosen',
                'description'   => 'Dosen Pengajar'
            ],
            [
                'name'          => 'mahasiswa',
                'description'   => 'Mahasiswa'
            ],
        ];
        $this->db->table('groups')->insertBatch($groups);

        $penjabat = [
            [
                'jabatan'           => 'k-lab',
                'nomor_induk'       => '7350708',
                'nama_penjabat'     => 'nama kapala lab',
                'jk'                => 'Laki-laki',
                'tempat_lahir'      => 'Makassar',
                'tgl_lahir'         => '1983-05-17',
                'gelar_depan'       => null,
                'gelar_belakang'    => 'S.Kom, M.Kom',
                'alamat'            => 'Kota Gorontalo, Jln. Setapak, 698871',
                'pendidikan'        => 'S2',
                'lulusan'           => 'Unhas Makassar',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'jabatan'           => 'dosen',
                'nomor_induk'       => '7550101',
                'nama_penjabat'     => 'nama dosen',
                'jk'                => 'Laki-laki',
                'tempat_lahir'      => 'Gorontalo',
                'tgl_lahir'         => '1988-08-17',
                'gelar_depan'       => 'Drs',
                'gelar_belakang'    => 'S.Kom, M.Kom',
                'alamat'            => 'Kota Gorontalo, Jln. Setapak, 698871',
                'pendidikan'        => 'S3',
                'lulusan'           => 'Unsrat Manado',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
            [
                'jabatan'           => 'mahasiswa',
                'nomor_induk'       => '2023001',
                'nama_penjabat'     => 'nama mahasiswa',
                'jk'                => 'Laki-laki',
                'tempat_lahir'      => 'Gorontalo',
                'tgl_lahir'         => '2002-01-27',
                'gelar_depan'       => null,
                'gelar_belakang'    => null,
                'alamat'            => 'Kab Gorontalo, Jln. Hubulo, 96288',
                'pendidikan'        => '',
                'lulusan'           => 'SMK N 1 Limboto',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
            ],
        ];
        $this->db->table('penjabat')->insertBatch($penjabat);
        
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
                'username'          => '7350708',
                'password'          => '$2y$10$KwpwKG15gc4fPUDDYhUkluvhymHNbAx4daEZjWFBIaeIfnP3yTw.m',
                'email'             => 'kepala-lab@mail.go.id',
                'created_on'        => 1268889823,
                'last_login'        => 1661586883,
                'active'            => 1,
                'nama_user'         => 'Kelapa Laboratorium',
                'phone'             => '08',
                'id_peg'            => '1',
            ],
            [
                'ip_address'        => '127.0.0.1',
                'username'          => '7550101',
                'password'          => '$2y$10$KwpwKG15gc4fPUDDYhUkluvhymHNbAx4daEZjWFBIaeIfnP3yTw.m',
                'email'             => 'dosen@mail.go.id',
                'created_on'        => 1268889823,
                'last_login'        => 1661586883,
                'active'            => 1,
                'nama_user'         => 'Nama Dosen',
                'phone'             => '08',
                'id_peg'            => '2',
            ],
            [
                'ip_address'        => '127.0.0.1',
                'username'          => '2023001',
                'password'          => '$2y$10$KwpwKG15gc4fPUDDYhUkluvhymHNbAx4daEZjWFBIaeIfnP3yTw.m',
                'email'             => 'mahasiswa@mail.go.id',
                'created_on'        => 1268889823,
                'last_login'        => 1661586883,
                'active'            => 1,
                'nama_user'         => 'Nama Mahasiswa',
                'phone'             => '08',
                'id_peg'            => '3',
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
                'user_id'   => 2,
                'group_id'  => 1
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
    }
}
