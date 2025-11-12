<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
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
                'constraint' => 200,
                'null' => false,
            ],
            'descricao' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'categoria' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'images' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'preco' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'estoque' => [
                'type' => 'INT',
                'null' => false,
            ],
            'vendedor' => [
                'type' => 'INT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'tags' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('vendedor', 'users', 'ra', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('categoria', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
