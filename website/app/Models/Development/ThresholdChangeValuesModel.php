<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use mysqli_sql_exception;

/**
 * Class ThresholdChangeValuesModel
 * @package App\Models\Development
 */
class ThresholdChangeValuesModel extends Model
{
    /**
     * @param string $identifierLand
     * @param float $minimalHumidity
     * @param float $minimalTension
     * @return bool
     */
    public function execute(string $identifierLand, float $minimalHumidity, float $minimalTension) : bool
    {
        $prepare = $this->db->prepare(function(){
            return 'UPDATE thresholds SET minimalHumidity = ? , minimalTension = ? WHERE identifierLand = ?';
        });

        try
        {
            $prepare->execute($minimalHumidity, $minimalTension, $identifierLand);
        }
        catch (mysqli_sql_exception $mysqli_sql_exception)
        {
            return false;
        }

        return true;
    }
}
