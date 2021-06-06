<?php

namespace App\Models\Development;

use CodeIgniter\Model;

/**
 * Class UserModel
 * @package App\Models\Development
 */
class UserModel extends Model
{
    /**
     * @param string|null $likeEmail
     * @return array
     */
    public function obtain(string $likeEmail = null) : array
    {
        if($likeEmail === null)
        {
            return $this->db->query('SELECT * FROM users')->getResult();
        }

        $prepare = $this->db->prepare(function(){
            return 'SELECT * FROM users WHERE email LIKE ?';
        });

        return $prepare->execute('%' . $likeEmail . '%')->getResult();
    }
}