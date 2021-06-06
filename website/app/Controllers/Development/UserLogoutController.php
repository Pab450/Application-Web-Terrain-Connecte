<?php

namespace App\Controllers\Development;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;

/**
 * Class UserLogoutController
 * @package App\Controllers\Development
 */
class UserLogoutController extends BaseController
{
    /**
     * @var Session
     */
    private $session;

    /**
     * DisconnectController constructor.
     */
    public function __construct()
    {
        $this->session = session();
    }

    /**
     * @return RedirectResponse
     */
    public function index() : RedirectResponse
    {
        if($this->session->get('connected') === true)
        {
            $this->session->destroy();
        }

        return redirect()->to('/user/login');
    }
}