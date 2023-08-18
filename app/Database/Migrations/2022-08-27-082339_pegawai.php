<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Peagawai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'jab_id' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true],
            'nama' => ['type' => 'char', 'constraint' => 100, 'null' => false],
            'jk' => ['type' => 'enum', 'constraint' => ['Laki-laki','Perempuan']],
            'tempat_lahir' => ['type' => 'char', 'constraint' => 50],
            'tgl_lahir' => ['type' => 'date'],
            'gelar_depan' => ['type' => 'char', 'constraint' => 25],
            'gelar_belakang' => ['type' => 'char', 'constraint' => 25],
            'alamat' => ['type' => 'text'],
            'pendidikan' => ['type' => 'enum', 'constraint' => ['S3','S2','S1/D4','D3','D2','D1','SMA/SMK/MA']],
            'lulusan' => ['type' => 'char', 'constraint' => 100],
            'created_at' => ['type' => 'date'],
            'updated_at' => ['type' => 'date'],
            'deleted_at' => ['type' => 'date', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('jab_id', 'jabatan', 'id', 'cascade', 'cascade');
        $this->forge->createTable('pegawai', true);
    }

    public function down()
    {
        $this->forge->dropTable('pegawai', true);
    }
}
