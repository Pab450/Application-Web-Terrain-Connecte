<?php

namespace App\Controllers\Development;

use app\Common;
use App\Controllers\BaseController;
use App\Models\Development\UserChangeLevelModel;
use App\Models\Development\UserLevelModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;

/**
 * Class UserChangeLevelController
 * @package App\Controllers\Development
 */
class UserChangeLevelController extends BaseController
{
    /**
     * @const RULES array
     */
    private const RULES = [
        'level' => [
            'rules'  => 'required|integer',
            'errors' => [
                'required' => 'Aucun level donné.',
                'integer' => 'Le type du level est invalide.'
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'Aucun email donné.',
                'valid_email' => "L'email est invalide."
            ]
        ]
    ];

    /**
     * @const ERRORS array
     */
    private const ERRORS = [
        'level' => "Le niveau n'a pas été trouvé.",
        'update' => "Une erreur est survenue pendant la mise à jour du niveau de l'utilisateur.",
    ];

    /**
     * @const SUCCESS string
     */
    private const SUCCESS = "Le niveau de l'utilisateur à bien été modifié.";

    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserLevelModel
     */
    private $userLevelModel;

    /**
     * @var UserChangeLevelModel
     */
    private $userChangeLevelModel;

    /**
     * UserChangeLevelController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->userLevelModel = new UserLevelModel();
        $this->userChangeLevelModel = new UserChangeLevelModel();
    }

    /**
     * @return RedirectResponse
     */
    public function request() : RedirectResponse
    {
        if($this->session->get('connected') === true and $this->request->getMethod() === 'post')
        {
            if($this->userLevelModel->obtain((string) $this->session->get('email')) >= Common::ADMINISTRATOR)
            {
                $validator = Services::validation();
                $validator->setRules(self::RULES);

                if($validator->withRequest($this->request)->run())
                {
                    if(in_array((int) $this->request->getVar('level'), array_keys(Common::LEVELS)))
                    {
                        if($this->userChangeLevelModel->execute(...array_values($this->request->getVar(['level', 'email']))) === true)
                        {
                            $this->session->setFlashdata('success', self::SUCCESS);
                        }
                        else
                        {
                            $this->session->setFlashdata('errors', [self::ERRORS['update']]);
                        }
                    }
                    else
                    {
                        $this->session->setFlashdata('errors', [self::ERRORS['level']]);
                    }
                }
                else
                {
                    $this->session->setFlashdata('errors', $validator->getErrors());
                }

                return redirect()->to('/user/management');
            }
        }

        return redirect()->to('/user/login');
    }
}