<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use mysqli_sql_exception;

/**
 * Class OccupationChangeValuesModel
 * @package App\Models\Development
 */
class OccupationChangeValuesModel extends Model
{
    public function execute(string $identifierLand, string $startDateTime, string $endDateTime, string $wording) : bool
    {
        $delete = $this->db->prepare(function(){
            return 'DELETE FROM occupations WHERE identifierLand = ? AND startDateTime = ? AND endDateTime = ?';
        });

        $insert = $this->db->prepare(function(){
            return 'INSERT INTO occupations (identifierLand, startDateTime, endDateTime, wording) VALUES (?, ?, ?, ?)';
        });

        try
        {
            $delete->execute($identifierLand, $startDateTime, $endDateTime);
            $insert->execute($identifierLand, $startDateTime, $endDateTime, $wording);
        }
        catch (mysqli_sql_exception $mysqli_sql_exception)
        {
            return false;
        }

        return true;
    }
}