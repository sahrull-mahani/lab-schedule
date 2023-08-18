<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Peagawai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'jabatan' => ['type' => 'enum', 'constraint' => ['k-lab', 'dosen', 'mahasiswa']],
            'kelas_id' => ['type' => 'int', 'constraint' => 6, 'null' => true, 'unsigned' => true],
            'nomor_induk' => ['type' => 'char', 'constraint' => 25],
            'nama_penjabat' => ['type' => 'char', 'constraint' => 100],
            'jk' => ['type' => 'enum', 'constraint' => ['Laki-laki', 'Perempuan']],
            'tempat_lahir' => ['type' => 'char', 'constraint' => 50],
            'tgl_lahir' => ['type' => 'date'],
            'gelar_depan' => ['type' => 'char', 'constraint' => 25, 'null' => true],
            'gelar_belakang' => ['type' => 'char', 'constraint' => 25, 'null' => true],
            'alamat' => ['type' => 'text'],
            'pendidikan' => ['type' => 'enum', 'constraint' => ['S3', 'S2', 'S1/D4', 'D3', 'D2', 'D1', 'SMA/SMK/MA']],
            'lulusan' => ['type' => 'char', 'constraint' => 100, 'null' => true],
            'created_at' => ['type' => 'date'],
            'updated_at' => ['type' => 'date'],
            'deleted_at' => ['type' => 'date', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'set null', 'cascade');
        $this->forge->createTable('penjabat', true);
    }

    public function down()
    {
        $this->forge->dropTable('penjabat', true);
    }
}
