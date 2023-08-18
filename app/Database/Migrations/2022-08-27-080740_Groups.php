<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Groups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'mediumint', 'constraint' => 8, 'unsigned' => true, 'auto_increment' => true],
			'name' => ['type' => 'varchar', 'constraint' => 20, 'null' => false],
			'description' => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
        ]);        
        $this->forge->addKey('id', true);
        $this->forge->createTable('groups', true);
    }

    public function down()
    {
        $this->forge->dropTable('groups', true);
    }
}
