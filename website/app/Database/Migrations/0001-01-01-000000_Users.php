<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class Users
 * @package App\Database\Migrations
 */
class Users extends Migration
{
    /**
     * @const TABLE string
     */
    public const TABLE = 'users';

    /**
     * @const FIELDS array
     */
    private const FIELDS = [
        'email' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'unique' => true
        ],
        'password' => [
            'type' => 'CHAR',
            'constraint' => '32'
        ],
        'level' => [
            'type' => 'TINYINT',
            'unsigned' => true
        ]
    ];

    /**
     * Create a database scheme.
     */
	public function up() : void
	{
	    $this->forge->addField(self::FIELDS);
        $this->forge->createTable(self::TABLE);
	}

    /**
     * Remove the database scheme.
     */
	public function down() : void
	{
        $this->forge->dropTable(self::TABLE);
	}
}
