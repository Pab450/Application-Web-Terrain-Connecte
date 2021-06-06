<?php

namespace App\Models\Development;

use CodeIgniter\Model;

/**
 * Class SondeModel
 * @package App\Models\Development
 */
class SondeModel extends Model
{
    /**
     * @param string $identifierLand
     * @return array
     */
    public function obtain(string $identifierLand) : array
    {
        $prepare = $this->db->prepare(function(){
            return 'SELECT *, MAX(dateTime) FROM sondes WHERE identifierLand = ? GROUP BY identifierSonde';
        });

        return $prepare->execute($identifierLand)->getResult();
    }
}
