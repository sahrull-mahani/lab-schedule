<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 6, 'unsigned' => true, 'auto_increment' => true],
			'ip_address' => ['type' => 'varchar', 'constraint' => 45, 'null' => false],
			'username' => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
			'password' => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
			'email' => ['type' => 'varchar', 'constraint' => 254, 'null' => false],
			'activation_selector' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'activation_code' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'forgotten_password_selector' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'forgotten_password_code' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'forgotten_password_time' => ['type' => 'int', 'constraint' => 11, 'null' => true],
			'remember_selector' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'remember_code' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'created_on' => ['type' => 'int', 'constraint' => 11, 'null' => false],
			'last_login' => ['type' => 'int', 'constraint' => 11, 'null' => true],
			'active' => ['type' => 'tinyint', 'constraint' => 1, 'null' => true],
			'nama_user' => ['type' => 'char', 'constraint' => 50, 'null' => true],
			'phone' => ['type' => 'char', 'constraint' => 15, 'null' => true],
			'img' => ['type' => 'char', 'constraint' => 50, 'null' => true],
			'id_peg' => ['type' => 'int', 'constraint' => 10, 'null' => true, 'unsigned' => true],
        ]);        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_peg', 'pegawai', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
