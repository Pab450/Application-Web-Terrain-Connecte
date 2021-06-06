<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use mysqli_sql_exception;

/**
 * Class UserLevelModel
 * @package App\Models\Development
 */
class UserLevelModel extends Model
{
    /**
     * @param string $email
     * @return int
     */
    public function obtain(string $email) : int
    {
        $prepare = $this->db->prepare(function(){
            return 'SELECT level FROM users WHERE email=?';
        });

        $result = $prepare->execute($email)->getResult();

        if(count($result) === 1)
        {
            return $result[0]->level;
        }

        return -1;
    }

    /**
     * @param int $level
     * @param string $email
     * @return bool
     */
    public function change(int $level, string $email) : bool
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
