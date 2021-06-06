<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use mysqli_sql_exception;

/**
 * Class LandCreateModel
 * @package App\Models\Development
 */
class LandCreateModel extends Model
{
    /**
     * @param string $name
     * @return bool
     */
    public function execute(string $name) : bool
    {
        $prepare = $this->db->prepare(function(){
            return 'INSERT INTO lands (name) VALUES (?)';
        });

        try
        {
            $prepare->execute($name);
        }
        catch (mysqli_sql_exception $mysqli_sql_exception)
        {
            return false;
        }

        return true;
    }
}