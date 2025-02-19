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
            ],
            'kvk_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'company_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'address' => [
                'type' => 'TEXT',
            ],
            'search_date' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
            ],
        ]);
        $this->forge->addKey('id', true); // Primaire sleutel
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE'); // Foreign key naar users tabel
        $this->forge->createTable('search_history');

        // Trigger toevoegen voor automatische tijdstempel
        $db = \Config\Database::connect();
        $db->query("CREATE TRIGGER set_search_date BEFORE INSERT ON search_history FOR EACH ROW SET NEW.search_date = IFNULL(NEW.search_date, CURRENT_TIMESTAMP);");
    }

    public function down()
    {
        $db = \Config\Database::connect();
        $db->query("DROP TRIGGER IF EXISTS set_search_date");  // Verwijder de trigger als de tabel wordt verwijderd
        $this->forge->dropTable('search_history');
    }
}
