<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LoginAttemps extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 6, 'unsigned' => true, 'auto_increment' => true],
			'ip_address' => ['type' => 'varchar', 'constraint' => 45, 'null' => false],
			'login' => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
			'time' => ['type' => 'int', 'constraint' => 11, 'null' => true],
        ]);        
        $this->forge->addKey('id', true);
        $this->forge->createTable('login_attempts', true);
    }

    public function down()
    {
        $this->forge->dropTable('login_attempts', true);
    }
}
