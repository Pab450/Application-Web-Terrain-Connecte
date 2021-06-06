<?php

namespace App\Models\Development;

use CodeIgniter\Model;
use mysqli_sql_exception;

/**
 * Class LandChangeRenderModel
 * @package App\Models\Development
 */
class LandChangeRenderModel extends Model
{
    /**
     * @param string $name
     * @param array $render
     * @return array|bool
     */
    public function execute(string $name, array $render) : bool
    {
        $prepare = $this->db->prepare(function(){
            return 'UPDATE lands SET render=? WHERE name=?';
        });

        try
        {
            $prepare->execute(json_encode($render), $name);
        }
        catch (mysqli_sql_exception $mysqli_sql_exception)
        {
            return false;
        }

        return true;
    }
}
