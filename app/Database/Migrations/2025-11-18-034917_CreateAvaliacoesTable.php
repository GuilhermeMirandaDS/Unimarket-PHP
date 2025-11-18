<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAvaliacoesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user' => [
                'type' => 'INT',
                'constraint' => 20,
                'null' => false,
            ],
            'product' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'comentario' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'estrelas' => [
                'type' => 'INT',
                'constraint' => 1,
                'null' => false,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('avaliacoes');
    }

    public function down()
    {
        $this->forge->dropTable('avaliacoes');
    }
}
