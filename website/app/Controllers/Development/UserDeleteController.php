<?php

namespace App\Controllers\Development;

use app\Common;
use App\Controllers\BaseController;
use App\Models\Development\UserDeleteModel;
use App\Models\Development\UserLevelModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;

/**
 * Class UserDeleteController
 * @package App\Controllers\Development
 */
class UserDeleteController extends BaseController
{
    /**
     * @const RULES array
     */
    private const RULES = [
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
        'delete' => "Une erreur est survenue pendant la suppression de l'utilisateur.",
    ];

    /**
     * @const SUCCESS string
     */
    private const SUCCESS = "L'utilisateur à bien été supprimé.";

    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserLevelModel
     */
    private $userLevelModel;

    /**
     * @var UserDeleteModel
     */
    private $userDeleteModel;

    /**
     * UserChangeLevelController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->userLevelModel = new UserLevelModel();
        $this->userDeleteModel = new UserDeleteModel();
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
                    if($this->userDeleteModel->execute($this->request->getVar('email')) === true)
                    {
                        $this->session->setFlashdata('success', self::SUCCESS);
                    }
                    else
                    {
                        $this->session->setFlashdata('errors', [self::ERRORS['delete']]);
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