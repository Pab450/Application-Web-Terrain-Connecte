<?php

namespace App\Controllers\Development;

use App\Controllers\BaseController;
use App\Models\Development\UserCreateModel;
use App\Models\Development\UserLevelModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;
use app\Common;

/**
 * Class UserCreateController
 * @package App\Controllers\Development
 */
class UserCreateController extends BaseController
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
            'rules'  => 'required|min_length[8]',
            'errors' => [
                'required' => 'Aucun mot de passe donné.',
                'min_length' => 'Le mot de passe doit respecter des critères de complexité (8 caractères dont au moins une lettre et au moins un chiffre)'
            ]
        ],
        'confirm_password' => [
            'rules'  => 'required|matches[password]',
            'errors' => [
                'required' => 'Aucun mot de passe donné.',
                'matches' => "Le mot de passe de confirmation n'est pas identique."
            ]
        ],
        'level' => [
            'rules'  => 'required|integer',
            'errors' => [
                'required' => 'Aucune permission selectionné.',
                'integer' => "La permission est invalide."
            ]
        ]
    ];

    /**
     * @const ERRORS array
     */
    private const ERRORS = [
        'creation' => "Une erreur est survenue dans la création de l'utilisateur.",
        'password' => 'Le mot de passe doit respecter des critères de complexité (8 caractères dont au moins une lettre et au moins un chiffre)'
    ];

    /**
     * @const HEAD array
     */
    private const HEAD = [
        'title' => '',
        'stylesheet_href' => 'Assets/' . Common::ENVIRONMENT . '/user_create.css',
        'icon_href' => ''
    ];

    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserLevelModel
     */
    private $userLevelModel;

    /**
     * @var UserCreateModel
     */
    private $userCreateModel;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->userLevelModel = new UserLevelModel();
        $this->userCreateModel = new UserCreateModel();
    }

    /**
     * @return RedirectResponse
     */
    public function index() : ?RedirectResponse
    {
        if($this->session->get('connected') != true or $this->userLevelModel->obtain((string) $this->session->get('email')) <= Common::AGENT)
        {
            return redirect()->to('/user/login');
        }

        echo view(Common::ENVIRONMENT . '/head', self::HEAD);

        $data = [
            'success' => $this->session->getFlashdata('success'),
            'errors' => array_values($this->session->getFlashdata('errors') ?? []),
            'email' => $this->session->getFlashdata('email')
        ];

        echo view(Common::ENVIRONMENT . "/user_create", $data);

        return null;
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
                    if((bool) preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]/", $this->request->getVar('password')) === true)
                    {
                        if($this->userCreateModel->execute(...array_values($this->request->getVar(['email', 'password', 'level']))))
                        {
                            $this->session->setFlashdata('success', true);
                        }
                        else
                        {
                            $this->session->setFlashdata('errors', [self::ERRORS['creation']]);
                        }
                    }
                    else
                    {
                        $this->session->setFlashdata('errors', [self::ERRORS['password']]);
                    }

                    return redirect()->to('/user/create');
                }
                else
                {
                    $this->session->setFlashdata('errors', $validator->getErrors());
                }
            }
        }

        return redirect()->to('/user/create');
    }
}
