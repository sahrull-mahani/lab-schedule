<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pangkalan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'desa_id' => ['type' => 'char', 'constraint' => 10],
            'nama_pangkalan' => ['type'=>'char', 'constraint'=>200],
            'id_registrasi' => ['type'=>'char', 'constraint'=>200],
            'created_at' => ['type'=>'date'],
            'updated_at' => ['type'=>'date'],
            'deleted_at' => ['type'=>'date', 'null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pangkalan', true);
    }

    public function down()
    {
        $this->forge->dropTable('pangkalan', true);
    }
}
