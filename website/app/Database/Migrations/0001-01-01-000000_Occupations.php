<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class Occupations
 * @package App\Database\Migrations
 */
class Occupations extends Migration
{
    /**
     * @const TABLE string
     */
    public const TABLE = 'occupations';

    /**
     * @const FIELDS array
     */
    private const FIELDS = [
        'identifierLand' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => false,
        ],
        'startDateTime' => [
            'type' => 'TIMESTAMP',
            'null' => false
        ],
        'endDateTime' => [
            'type' => 'TIMESTAMP',
            'null' => false
        ],
        'wording' => [
            'type' => 'LONGTEXT',
            'null' => false
        ],
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
