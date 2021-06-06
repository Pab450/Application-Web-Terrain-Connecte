<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class thresholds
 * @package App\Database\Migrations
 */
class Thresholds extends Migration
{
    /**
     * @const TABLE string
     */
    public const TABLE = 'thresholds';

    /**
     * @const FIELDS array
     */
    private const FIELDS = [
        'identifierLand' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'unique' => true
        ],
        'minimalHumidity' => [
            'type' => 'DECIMAL',
            'constraint' => '10,2',
            'null' => false
        ],
        'minimalTension' => [
            'type' => 'DECIMAL',
            'constraint' => '10,2',
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
