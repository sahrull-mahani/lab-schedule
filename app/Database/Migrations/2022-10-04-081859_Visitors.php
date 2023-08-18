<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Visitors extends Migration
{
    public function up()
    {
        $this->forge->dropTable('visitors', true);
        // Table data 'visitors'
        $this->forge->addField([
            'visitor_id' => [
                'type'           => 'INT',
                'constraint'     => '10',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'no_of_visits' => [
                'type'       => 'INT',
                'constraint' => '10',
                'unsigned'   => TRUE
            ],
            'ip_address' => [
                'type'       => 'CHAR',
                'constraint' => '20',
            ],
            'requested_url' => [
                'type'       => 'TINYTEXT',
            ],
            'referer_page' => [
                'type'       => 'TINYTEXT',
            ],
            'page_name' => [
                'type'       => 'TINYTEXT',
            ],
            'query_string' => [
                'type'       => 'TINYTEXT',
            ],
            'user_agent' => [
                'type'       => 'TINYTEXT',
            ],
            'is_unique' => [
                'type'       => 'TINYINT',
                'constraint' => 4
            ],
            'access_date' => [
                'type'         => 'TIMESTAMP',
            ]
        ]);
        $this->forge->addKey('visitor_id', true);
        $this->forge->createTable('visitors');

        $this->forge->dropTable('visitor_log', true);
        // Table data 'visitor_log'
        $this->forge->addField([
            'id_visitor' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ip_address' => [
                'type'       => 'CHAR',
                'constraint' => '20',
                'null'         => TRUE
            ],
            'user_agent' => [
                'type'       => 'TINYTEXT',
                'null'         => TRUE
            ],
            'access_date' => [
                'type'         => 'TIMESTAMP',
            ]
        ]);
        $this->forge->addKey('id_visitor', true);
        $this->forge->createTable('visitor_log');
    }

    public function down()
    {
        $this->forge->dropTable('visitors');
		$this->forge->dropTable('visitor_log');
    }
}
