<?php

namespace App\Models\Development;

use CodeIgniter\Model;

/**
 * Class ThresholdModel
 * @package App\Models\Development
 */
class ThresholdModel extends Model
{
    /**
     * @param string $identifierLand
     * @return array
     */
    public function obtain(string $identifierLand) : array
    {
        $prepare = $this->db->prepare(function(){
            return 'SELECT * FROM thresholds WHERE identifierLand = ?';
        });

        return $prepare->execute($identifierLand)->getResult();
    }
}
