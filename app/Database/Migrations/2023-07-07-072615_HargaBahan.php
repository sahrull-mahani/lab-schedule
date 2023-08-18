<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HargaBahan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'bahan' => ['type' => 'enum', 'constraint' => ['pokok', 'penting']],
            'nama' => ['type' => 'char', 'constraint' => 150],
            'nama_barang' => ['type' => 'char', 'constraint' => 200],
            'harga' => ['type' => 'mediumint', 'constraint' => 15, 'default' => 0],
            'satuan' => ['type' => 'char', 'constraint' => 50],
            'tanggal' => ['type' => 'date'],
            'verified_at' => ['type' => 'date', 'null' => true],
            'approved_at' => ['type' => 'date', 'null' => true],
            'created_at' => ['type' => 'date'],
            'updated_at' => ['type' => 'date'],
            'deleted_at' => ['type' => 'date', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('harga_bahan', true);
    }

    public function down()
    {
        $this->forge->dropTable('harga_bahan', true);
    }
}
