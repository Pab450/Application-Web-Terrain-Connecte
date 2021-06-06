<?php

namespace App\Controllers\Development;

use App\Controllers\BaseController;
use App\Models\Development\UserChangePasswordModel;
use App\Models\Development\UserCreateModel;
use App\Models\Development\UserLoginModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;
use app\Common;

/**
 * Class UserChangePasswordController
 * @package App\Controllers\Development
 */
class UserChangePasswordController extends BaseController
{
    /**
     * @const RULES array
     */
    private const RULES = [
        'old_password' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Aucun mot de passe donné.',
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
        ]
    ];

    /**
     * @const ERRORS array
     */
    private const ERRORS = [
        'old_password' => "L'ancien mot de passe donné ne correspond pas à votre mot de passe actuel.",
        'update' => "Une erreur est survenue pendant la mise à jour du mot de passe de l'utilisateur.",
        'password' => 'Le mot de passe doit respecter des critères de complexité (8 caractères dont au moins une lettre et au moins un chiffre)'
    ];

    /**
     * @const HEAD array
     */
    private const HEAD = [
        'title' => '',
        'stylesheet_href' => 'Assets/' . Common::ENVIRONMENT . '/user_change_password.css',
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
     * @var UserCreateModel
     */
    private $userChangePasswordModel;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->userLoginModel = new UserLoginModel();
        $this->userChangePasswordModel = new UserChangePasswordModel();
    }

    /**
     * @return RedirectResponse
     */
    public function index() : ?RedirectResponse
    {
        if($this->session->get('connected') != true)
        {
            return redirect()->to('/user/change-password');
        }

        echo view(Common::ENVIRONMENT . '/head', self::HEAD);

        $data = [
            'success' => $this->session->getFlashdata('success'),
            'errors' => array_values($this->session->getFlashdata('errors') ?? []),
            'email' => $this->session->get('email')
        ];

        echo view(Common::ENVIRONMENT . "/user_change_password", $data);

        return null;
    }

    /**
     * @return RedirectResponse
     */
    public function request() : RedirectResponse
    {
        if($this->session->get('connected') === true and $this->request->getMethod() === 'post')
        {
            $validator = Services::validation();
            $validator->setRules(self::RULES);

            if($validator->withRequest($this->request)->run())
            {
                $email = (string) $this->session->get('email');

                if($this->userLoginModel->verify($email, $this->request->getVar('old_password')) === false)
                {
                    $this->session->setFlashdata('errors', [self::ERRORS['old_password']]);

                    return redirect()->to('/user/change-password');
                }

                if((bool) preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]/", $this->request->getVar('password')) === true)
                {
                    if($this->userChangePasswordModel->execute($this->request->getVar('password'), $email))
                    {
                        $this->session->setFlashdata('success', true);
                    }
                    else
                    {
                        $this->session->setFlashdata('errors', [self::ERRORS['update']]);
                    }
                }
                else
                {
                    $this->session->setFlashdata('errors', [self::ERRORS['password']]);
                }

                return redirect()->to('/user/change-password');
            }
            else
            {
                $this->session->setFlashdata('errors', $validator->getErrors());
            }
        }

        return redirect()->to('/user/change-password');
    }
}
