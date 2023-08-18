<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersGroups extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 6, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'int', 'constraint' => 6, 'null' => false, 'unsigned' => true,],
            'group_id' => ['type' => 'mediumint', 'constraint' => 8, 'null' => false, 'unsigned' => true,],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('group_id', 'groups', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users_groups', true);
    }

    public function down()
    {
        $this->forge->dropTable('users_groups', true);
    }
}
