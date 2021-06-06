<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use mysqli_sql_exception;

/**
 * Class UserDeleteModel
 * @package App\Models\Development
 */
class UserDeleteModel extends Model
{
    /**
     * @param string $email
     * @return bool
     */
    public function execute(string $email) : bool
    {
        $prepare = $this->db->prepare(function(){
            return 'DELETE FROM users WHERE email=?';
        });

        try
        {
            $prepare->execute($email);
        }
        catch (mysqli_sql_exception $mysqli_sql_exception)
        {
            return false;
        }

        return true;
    }
}