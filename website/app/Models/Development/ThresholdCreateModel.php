<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use mysqli_sql_exception;

/**
 * Class ThresholdCreateModel
 * @package App\Models\Development
 */
class ThresholdCreateModel extends Model
{
    /**
     * @param string $identifierLand
     * @return bool
     */
    public function execute(string $identifierLand) : bool
    {
        $prepare = $this->db->prepare(function(){
            return 'INSERT INTO thresholds (identifierLand, minimalHumidity, minimalTension) VALUES (?, ?, ?)';
        });

        try
        {
            $prepare->execute($identifierLand, 0, 0);
        }
        catch (mysqli_sql_exception $mysqli_sql_exception)
        {
            return false;
        }

        return true;
    }
}
