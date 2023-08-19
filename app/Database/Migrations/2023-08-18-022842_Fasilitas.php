<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Fasilitas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 6, 'unsigned' => true, 'auto_increment' => true],
            'lab_id' => ['type' => 'int', 'constraint' => 6, 'unsigned' => true],
            'nama_fasilitas' => ['type' => 'char', 'constraint' => 100],
            'jumlah' => ['type' => 'tinyint', 'constraint' => 25],
            'status' => ['type' => 'enum', 'constraint' => ['layak','tidak layak']],
            'keterangan' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'date'],
            'updated_at' => ['type' => 'date'],
            'deleted_at' => ['type' => 'date', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('lab_id', 'laboratorium', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('fasilitas', true);
    }

    public function down()
    {
        $this->forge->dropTable('fasilitas', true);
    }
}
