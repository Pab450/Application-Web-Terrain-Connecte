<?php

namespace App\Controllers\Development;

use app\Common;
use App\Controllers\BaseController;
use App\Models\Development\SondeModel;
use App\Models\Development\UserLevelModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;

/**
 * Class SondeObtainController
 * @package App\Controllers\Development
 */
class SondeObtainController extends BaseController
{
    /**
     * @const RULES array
     */
    private const RULES = [
        'identifierLand' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Aucun identifiant de terrain donné.',
            ]
        ]
    ];

    /**
     * @const ERRORS array
     */
    private const ERRORS = [
        'obtain' => "Une erreur est survenue pendant l'obtention des sondes du terrain."
    ];

    /**
     * @const SUCCESS string
     */
    private const SUCCESS = "Les sondes du terrain ont bien été obtenue.";

    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserLevelModel
     */
    private $userLevelModel;

    /**
     * @var SondeModel
     */
    private $sondeModel;

    /**
     * ThresholdChangeValuesController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->userLevelModel = new UserLevelModel();
        $this->sondeModel = new SondeModel();
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

                $identifierLand = $this->request->getVar('identifierLand');

                if($validator->withRequest($this->request)->run())
                {
                    if(count($sondes = $this->sondeModel->obtain($identifierLand)) >= 1)
                    {
                        $this->session->setFlashdata('obtain_success', self::SUCCESS);
                        $this->session->setFlashdata('sondes', $sondes);
                    }
                    else
                    {
                        $this->session->setFlashdata('obtain_errors', [self::ERRORS['obtain']]);
                    }
                }
                else
                {
                    $this->session->setFlashdata('obtain_errors', $validator->getErrors());
                }

                $this->session->setFlashdata('identifierLand', $identifierLand);

                return redirect()->to('/land/create');
            }
        }

        return redirect()->to('/user/login');
    }
}