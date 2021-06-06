<?php

namespace App\Controllers\Development;

use App\Controllers\BaseController;
use App\Models\Development\LandModel;
use App\Models\Development\SondeCreateModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;
use app\Common;

/**
 * Class HomeController
 * @package App\Controllers\Development
 */
class HomeController extends BaseController
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
        'stylesheet_href' => 'Assets/' . Common::ENVIRONMENT . '/home.css',
        'icon_href' => ''
    ];

    /**
     * @var Session
     */
    private $session;

    /**
     * @var LandModel
     */
    private $landModel;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->landModel = new LandModel();

        //permet de générer des valeurs de sondes aleatoires.
        /*$sondeCreateModel = new SondeCreateModel();

        for($i = 40; $i < 53; $i += 1){
            $humidity = 35 + mt_rand() / mt_getrandmax() * (45 - 35);
            $temperature = 9 + mt_rand() / mt_getrandmax() * (17 - 9);
            $tension = 5 + mt_rand() / mt_getrandmax() * (12 - 5);

            $sondeCreateModel->execute($i, $humidity, $temperature, $tension, "Terrain expérimental");
        }*/
    }

    /**
     * @return RedirectResponse|null
     */
    public function index() : ?RedirectResponse
    {
        if($this->session->get('connected') != true)
        {
            return redirect()->to('/user/login');
        }

        echo view(Common::ENVIRONMENT . '/head', self::HEAD);

        $text = $this->session->getFlashdata('text');
        $lands = $this->session->getFlashdata('lands');

        if($lands === null){
            $lands = $this->landModel->obtain();
        }

        echo view(Common::ENVIRONMENT . "/home", ['lands' => $lands, 'text' => $text]);

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
                $lands = $this->landModel->obtain(...array_values($this->request->getVar()));
            }
            else
            {
                $lands = $this->landModel->obtain();
            }

            $this->session->setFlashdata('lands', $lands);
            $this->session->setFlashdata('text', $this->request->getVar('text'));
        }

        return redirect()->to('/home');
    }
}
