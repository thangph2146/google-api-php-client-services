<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGoogleIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'google_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'username'
            ],
            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'google_id'
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'avatar'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['google_id', 'avatar', 'full_name']);
    }
} 