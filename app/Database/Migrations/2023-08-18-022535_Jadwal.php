<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jadwal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 6, 'unsigned' => true, 'auto_increment' => true],
            'dosen_id' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true,],
            'mk_id' => ['type' => 'int', 'constraint' => 6, 'unsigned' => true,],
            'kelas_id' => ['type' => 'int', 'constraint' => 6, 'unsigned' => true,],
            'lab_id' => ['type' => 'int', 'constraint' => 6, 'unsigned' => true,],
            'waktu_mulai' => ['type' => 'time'],
            'waktu_selesai' => ['type' => 'time'],
            'hari' => ['type' => 'enum', 'constraint' => ['senin', 'selasa', 'rabu', 'kamis', 'jumat']],
            'status' => ['type' => 'enum', 'constraint' => ['setuju', 'tidak setuju', 'belum disetujui', 'pindah jadwal'], 'default' => 'belum disetujui'],
            'dosen_verify' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'date'],
            'updated_at' => ['type' => 'date'],
            'deleted_at' => ['type' => 'date', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('dosen_id', 'penjabat', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('mk_id', 'mata_kuliah', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('lab_id', 'laboratorium', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dosen_verify', 'penjabat', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('jadwal', true);
    }

    public function down()
    {
        $this->forge->dropTable('jadwal', true);
    }
}
