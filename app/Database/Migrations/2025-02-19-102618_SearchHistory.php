<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSearchHistoryTable extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // Optioneel als gebruikers niet altijd ingelogd zijn
            ],
            'kvk_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'company_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 200, // 200 tekens is meestal voldoende
            ],
            'address' => [
                'type' => 'TEXT',
            ],
            'search_date' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => null,
            ],

        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('search_history');
    }

    public function down()
    {
        $this->forge->dropTable('search_history');
    }
}
