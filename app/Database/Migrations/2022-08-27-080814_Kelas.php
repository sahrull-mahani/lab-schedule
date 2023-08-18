<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'nama_kelas' => ['type' => 'char', 'constraint' => 100],
            'created_at' => ['type' => 'date'],
            'updated_at' => ['type' => 'date'],
            'deleted_at' => ['type' => 'date', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kelas', true);
    }

    public function down()
    {
        $this->forge->dropTable('kelas', true);
    }
}
