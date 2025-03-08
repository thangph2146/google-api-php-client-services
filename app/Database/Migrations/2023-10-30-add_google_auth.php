<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGoogleAuth extends Migration
{
    public function up()
    {
        // Shield already has identities table for external providers
        // We just need to ensure it exists
        if (!$this->db->tableExists('auth_identities')) {
            $this->forge->addField([
                'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
                'type' => ['type' => 'varchar', 'constraint' => 255],
                'name' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
                'secret' => ['type' => 'varchar', 'constraint' => 255],
                'secret2' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
                'expires' => ['type' => 'datetime', 'null' => true],
                'extra' => ['type' => 'text', 'null' => true],
                'force_reset' => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
                'last_used_at' => ['type' => 'datetime', 'null' => true],
                'created_at' => ['type' => 'datetime', 'null' => true],
                'updated_at' => ['type' => 'datetime', 'null' => true],
            ]);
            $this->forge->addPrimaryKey('id');
            $this->forge->addKey('user_id');
            $this->forge->addKey(['user_id', 'type', 'secret']);
            $this->forge->createTable('auth_identities');
        }
    }

    public function down()
    {
        // We don't want to drop the identities table as it might be used by Shield
        // So we do nothing in down()
    }
}
