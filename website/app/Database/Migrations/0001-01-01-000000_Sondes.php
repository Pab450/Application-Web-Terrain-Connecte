<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class Sondes
 * @package App\Database\Migrations
 */
class Sondes extends Migration
{
    /**
     * @const TABLE string
     */
    public const TABLE = 'sondes';

    /**
     * @const FIELDS array
     */
    private const FIELDS = [
        'identifierSonde' => [
            'type' => 'INT',
            'unsigned' => true,
            'null' => false
        ],
        'humidity' => [
            'type' => 'DECIMAL',
            'constraint' => '10,2',
            'null' => false
        ],
        'temperature' => [
            'type' => 'DECIMAL',
            'constraint' => '10,2',
            'null' => false
        ],
        'tension' => [
            'type' => 'DECIMAL',
            'constraint' => '10,2',
            'null' => false
        ],
        'identifierLand' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'null' => false
        ],
        'dateTime' => [
            'type' => 'TIMESTAMP',
            'null' => false
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
