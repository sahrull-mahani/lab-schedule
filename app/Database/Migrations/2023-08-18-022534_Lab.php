<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lab extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 6, 'unsigned' => true, 'auto_increment' => true],
            'nama_lab' => ['type' => 'char', 'constraint' => 100],
            'created_at' => ['type' => 'date'],
            'updated_at' => ['type' => 'date'],
            'deleted_at' => ['type' => 'date', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('laboratorium', true);
    }

    public function down()
    {
        $this->forge->dropTable('laboratorium', true);
    }
}
