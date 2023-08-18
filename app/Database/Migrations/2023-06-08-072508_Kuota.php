<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kuota extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'pangkalan_id' => ['type' => 'int', 'constraint' => 10, 'unsigned' => true,],
            'jumlah_perminggu' => ['type' => 'mediumint', 'constraint' => 15],
            'jumlah_perbulan' => ['type' => 'mediumint', 'constraint' => 15],
            'jumlah_kk' => ['type' => 'mediumint', 'constraint' => 15],
            'verified_at' => ['type' => 'date', 'null' => true],
            'approved_at' => ['type' => 'date', 'null' => true],
            'created_at' => ['type' => 'date'],
            'updated_at' => ['type' => 'date'],
            'deleted_at' => ['type' => 'date', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pangkalan_id', 'pangkalan', 'id', 'cascade', 'cascade');
        $this->forge->createTable('kuota', true);
    }

    public function down()
    {
        $this->forge->dropTable('kuota', true);
    }
}
