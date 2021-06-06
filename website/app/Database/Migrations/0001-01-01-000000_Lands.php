<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class Lands
 * @package App\Database\Migrations
 */
class Lands extends Migration
{
    /**
     * @const TABLE string
     */
    public const TABLE = 'lands';

    /**
     * @const FIELDS array
     */
    private const FIELDS = [
        'id' => [
            'type' => 'TINYINT',
            'unsigned' => true,
            'unique' => true,
            'auto_increment' => true
        ],
        'name' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'unique' => true
        ],
        'render' => [
            'type' => 'LONGTEXT',
            'null' => true
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
