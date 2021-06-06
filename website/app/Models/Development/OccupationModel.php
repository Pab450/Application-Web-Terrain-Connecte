<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use DateTime;

/**
 * Class OccupationModel
 * @package App\Models\Development
 */
class OccupationModel extends Model
{
    /**
     * @param string $identifierLand
     * @return array
     */
    public function obtain(string $identifierLand) : array
    {
        $dateTime = new DateTime('now');

        $prepare = $this->db->prepare(function(){
            return 'SELECT * FROM occupations WHERE identifierLand = ? AND endDateTime >= ? ORDER BY startDateTime LIMIT 5';
        });

        return $prepare->execute($identifierLand, $dateTime->format('Y-m-d H:i:s'))->getResult();
    }
}
