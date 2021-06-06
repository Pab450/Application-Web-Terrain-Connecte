<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use mysqli_sql_exception;

/**
 * Class UserCreateModel
 * @package App\Models\Development
 */
class UserCreateModel extends Model
{
    /**
     * @param string $email
     * @param string $password
     * @param string $level
     * @return bool
     */
    public function execute(string $email, string $password, string $level) : bool
    {
        $prepare = $this->db->prepare(function(){
            return 'INSERT INTO users (email, password, level) VALUES (?, ?, ?)';
        });

        try
        {
            $prepare->execute($email, md5($password), $level);
        }
        catch (mysqli_sql_exception $mysqli_sql_exception)
        {
            return false;
        }

        return true;
    }
}