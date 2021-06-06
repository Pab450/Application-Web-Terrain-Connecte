<?php

namespace App\Controllers\Development;

use App\Controllers\BaseController;
use App\Models\Development\LandModel;
use App\Models\Development\OccupationModel;
use App\Models\Development\SondeModel;
use App\Models\Development\ThresholdModel;
use App\Models\Development\UserLevelModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;
use app\Common;

/**
 * Class LandManagementController
 * @package App\Controllers\Development
 */
class LandManagementController extends BaseController
{
    /**
     * @const HEAD array
     */
    private const HEAD = [
        'title' => '',
        'stylesheet_href' => 'Assets/' . Common::ENVIRONMENT . '/land_management.css',
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
     * @var LandModel
     */
    private $landModel;

    /**
     * @var ThresholdModel;
     */
    private $thresholdsModel;

    /**
     * @var SondeModel
     */
    private $sondeModel;

    /**
     * @var OccupationModel
     */
    private $occupationModel;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->landModel = new LandModel();
        $this->userLevelModel = new UserLevelModel();
        $this->thresholdsModel = new ThresholdModel();
        $this->sondeModel = new SondeModel();
        $this->occupationModel = new OccupationModel();
    }

    /**
     * @param string $identifierLand
     * @return RedirectResponse
     */
    public function index(string $identifierLand) : ?RedirectResponse
    {
        if($this->session->get('connected') != true or $this->userLevelModel->obtain((string) $this->session->get('email')) <= Common::AGENT)
        {
            return redirect()->to('/user/login');
        }

        echo view(Common::ENVIRONMENT . '/head', self::HEAD);

        $land = $this->landModel->obtain($identifierLand);

        if(count($land) !== 1){
            return redirect()->to('/home');
        }

        $data = [
            'identifierLand' => $identifierLand,
            'thresholds' => $this->thresholdsModel->obtain($identifierLand)[0],
            'threshold_success' => $this->session->getFlashdata('threshold_success'),
            'threshold_errors' => array_values($this->session->getFlashdata('threshold_errors') ?? []),
            'render' => json_decode($land[0]->render),
            'sondes' => $this->sondeModel->obtain($identifierLand),
            'occupation' => $this->occupationModel->obtain($identifierLand),
            'occupation_success' => $this->session->getFlashdata('occupation_success'),
            'occupation_errors' => array_values($this->session->getFlashdata('occupation_errors') ?? []),
        ];

        echo view(Common::ENVIRONMENT . "/land_management", $data);

        return null;
    }
}
