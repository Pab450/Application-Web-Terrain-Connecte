<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use mysqli_sql_exception;

/**
 * Class UserChangePasswordModel
 * @package App\Models\Development
 */
class UserChangePasswordModel extends Model
{
    /**
     * @param string $password
     * @param string $email
     * @return bool
     */
    public function execute(string $password, string $email) : bool
    {
        $prepare = $this->db->prepare(function(){
            return 'UPDATE users SET password=? WHERE email=?';
        });

        try
        {
            $prepare->execute(md5($password), $email);
        }
        catch (mysqli_sql_exception $mysqli_sql_exception)
        {
            return false;
        }

        return true;
    }
}