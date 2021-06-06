<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use mysqli_sql_exception;

/**
 * Class SondeCreateModel
 * @package App\Models\Development
 */
class SondeCreateModel extends Model
{
    /**
     * @param int $identifierSonde
     * @param float $humidity
     * @param float $temperature
     * @param float $tension
     * @param string $identifierLand
     * @return bool
     */
    public function execute(int $identifierSonde, float $humidity, float $temperature, float $tension, string $identifierLand) : bool
    {
        $prepare = $this->db->prepare(function(){
            return "INSERT INTO `sondes` (`identifierSonde`, `humidity`, `temperature`, `tension`, `identifierLand`, `dateTime`) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP);";
        });

        try
        {
            $prepare->execute($identifierSonde, $humidity, $temperature, $tension, $identifierLand);
        }
        catch (mysqli_sql_exception $mysqli_sql_exception)
        {
            return false;
        }

        return true;
    }
}
