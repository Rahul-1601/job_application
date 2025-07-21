<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApplicationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'auto_increment' => true],
            'first_name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'last_name'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'             => ['type' => 'VARCHAR', 'constraint' => 100],
            'experience_level'  => ['type' => 'VARCHAR', 'constraint' => 50],
            'last_salary'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'total_experience'  => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'resume'            => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'status'            => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Pending'],
            'interview_date'    => ['type' => 'DATE', 'null' => true],
            'interview_time'    => ['type' => 'TIME', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('applications');
    }

    public function down()
    {
        $this->forge->dropTable('applications');
    }
}
