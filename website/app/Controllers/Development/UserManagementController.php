<?php

namespace App\Controllers\Development;

use App\Controllers\BaseController;
use App\Models\Development\UserCreateModel;
use App\Models\Development\UserLevelModel;
use App\Models\Development\UserModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;
use app\Common;

/**
 * Class UserManagementController
 * @package App\Controllers\Development
 */
class UserManagementController extends BaseController
{
    /**
     * @const RULES array
     */
    private const RULES = [
        'text' => [
            'rules' => 'required',
        ]
    ];

    /**
     * @const HEAD array
     */
    private const HEAD = [
        'title' => '',
        'stylesheet_href' => 'Assets/' . Common::ENVIRONMENT . '/user_management.css',
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
    private $userModel;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->userLevelModel = new UserLevelModel();
        $this->userModel = new UserModel();
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

        $users = $this->session->getFlashdata('users');

        if($users === null){
            $users = $this->userModel->obtain();
        }

        $data = [
            'text' => $this->session->getFlashdata('text'),
            'users' => $users,
            'levels' => Common::LEVELS,
            'success' => $this->session->getFlashdata('success'),
            'errors' => array_values($this->session->getFlashdata('errors') ?? [])
        ];

        echo view(Common::ENVIRONMENT . "/user_management", $data);

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
                    $users = $this->userModel->obtain($this->request->getVar('text'));
                }
                else
                {
                    $users = $this->userModel->obtain();
                }

                $this->session->setFlashdata('users', $users);
                $this->session->setFlashdata('text', $this->request->getVar('text'));
            }
        }

        return redirect()->to('/user/management');
    }
}
