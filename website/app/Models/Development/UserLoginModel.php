<?php

namespace App\Models\Development;

use CodeIgniter\Model;

/**
 * Class UserLoginModel
 * @package App\Models\Development
 */
class UserLoginModel extends Model
{
    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function verify(string $email, string $password) : bool
    {
        $prepare = $this->db->prepare(function(){
            return 'SELECT email FROM users WHERE email=? and password=?';
        });

        if(count($prepare->execute($email, md5($password))->getResult()) === 1)
        {
            return true;
        }

        return false;
    }
}