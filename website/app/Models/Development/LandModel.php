<?php

namespace App\Models\Development;

use CodeIgniter\Model;

/**
 * Class LandModel
 * @package App\Models\Development
 */
class LandModel extends Model
{
    /**
     * @param string|null $likeName
     * @return array
     */
    public function obtain(string $likeName = null) : array
    {
        if($likeName === null)
        {
            return $this->db->query('SELECT * FROM lands')->getResult();
        }

        $prepare = $this->db->prepare(function(){
            return 'SELECT * FROM lands WHERE name LIKE ?';
        });

        return $prepare->execute('%' . $likeName . '%')->getResult();
    }
}
