<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGoogleIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'google_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'id',
            ],
        ]);

        // Add index for faster lookups
        $this->forge->addKey('google_id', false);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'google_id');
    }
}
