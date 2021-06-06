<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use mysqli_sql_exception;

/**
 * Class UserChangeLevelModel
 * @package App\Models\Development
 */
class UserChangeLevelModel extends Model
{
    /**
     * @param string $level
     * @param string $email
     * @return bool
     */
    public function execute(string $level, string $email) : bool
    {
        $prepare = $this->db->prepare(function(){
            return 'UPDATE users SET level=? WHERE email=?';
        });

        try
        {
            $prepare->execute($level, $email);
        }
        catch (mysqli_sql_exception $mysqli_sql_exception)
        {
            return false;
        }

        return true;
    }
}