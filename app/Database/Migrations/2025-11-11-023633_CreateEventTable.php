<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'data' => [
                'type' => 'DATE',
                'null' => false
            ],
            'horario' => [
                'type' => 'TIME',
                'null' => false
            ],
            'local' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'link' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'images' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'imageCard' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'descricao' => [
                'type' => 'VARCHAR',
                'constraint' => 2000,
                'null' => false
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('events');
    }

    public function down()
    {
        $this->forge->dropTable('events');
    }
}
