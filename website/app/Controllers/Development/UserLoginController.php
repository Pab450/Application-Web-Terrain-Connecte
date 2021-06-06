<?php

namespace App\Controllers\Development;

use app\Common;
use App\Controllers\BaseController;
use App\Models\Development\UserLevelModel;
use App\Models\Development\UserLoginModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;

/**
 * Class UserLoginController
 * @package App\Controllers\Development
 */
class UserLoginController extends BaseController
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
        ],
        'password' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Aucun mot de passe donné.'
            ]
        ]
    ];

    /**
     * @const ERRORS array
     */
    private const ERRORS = [
        'invalid_email_or_password' => "L'email ou le mot de passe est incorrect."
    ];

    /**
     * @const HEAD array
     */
    private const HEAD = [
        'title' => '',
        'stylesheet_href' => 'Assets/' . Common::ENVIRONMENT . '/login.css',
        'icon_href' => ''
    ];

    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserLoginModel
     */
    private $userLoginModel;

    /**
     * @var UserLevelModel
     */
    private $userLevelModel;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->userLoginModel = new UserLoginModel();
        $this->userLevelModel = new UserLevelModel();
    }

    /**
     * @return RedirectResponse|null
     */
    public function index() : ?RedirectResponse
    {
        if($this->session->get('connected') === true)
        {
            return redirect()->to('/home');
        }

        echo view(Common::ENVIRONMENT . '/head', self::HEAD);

        $data = [
            'errors' => array_values($this->session->getFlashdata('errors') ?? []),
            'email' => $this->session->getFlashdata('email')
        ];

        echo view(Common::ENVIRONMENT. '/login', $data);

        return null;
    }

    /**
     * @return RedirectResponse
     */
    public function request() : RedirectResponse
    {
        if($this->request->getMethod() === 'post')
        {
            $validator = Services::validation();
            $validator->setRules(self::RULES);

            if($validator->withRequest($this->request)->run())
            {
                if($this->userLoginModel->verify(...array_values($this->request->getVar(['email', 'password']))) === true)
                {
                    $email = $this->request->getVar('email');

                    $this->session->set('email', $email);
                    $this->session->set('level', $this->userLevelModel->obtain($email));
                    $this->session->set('connected', true);

                    return redirect()->to('/home');
                }

                $this->session->setFlashdata('errors', [self::ERRORS['invalid_email_or_password']]);
            }
            else
            {
                $this->session->setFlashdata('errors', $validator->getErrors());
            }
        }

        $this->session->setFlashdata('email', $this->request->getVar('email'));

        return redirect()->to('/user/login');
    }
}
