<?php

namespace App\Controllers\Development;

use App\Controllers\BaseController;
use App\Models\Development\LandChangeRenderModel;
use App\Models\Development\LandCreateModel;
use App\Models\Development\SondeModel;
use App\Models\Development\ThresholdCreateModel;
use App\Models\Development\ThresholdModel;
use App\Models\Development\UserLevelModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;
use app\Common;

/**
 * Class LandCreateController
 * @package App\Controllers\Development
 */
class LandCreateController extends BaseController
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
        'creation' => "Le terrain est déjà existant.",
        'render' => "Une erreur est survenue durant le rendu du terrain.",
        'threshold' => "Une erreur est survenue durant la génération du seuil des sondes."
    ];

    /**
     * @const HEAD array
     */
    private const HEAD = [
        'title' => '',
        'stylesheet_href' => 'Assets/' . Common::ENVIRONMENT . '/land_create.css',
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
     * @var SondeModel
     */
    private $sondeModel;

    /**
     * @var LandCreateModel
     */
    private $landCreateModel;

    /**
     * @var LandChangeRenderModel
     */
    private $landChangeRenderModel;

    /**
     * @var ThresholdModel
     */
    private $thresholdCreateModel;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->userLevelModel = new UserLevelModel();
        $this->sondeModel = new SondeModel();
        $this->landCreateModel = new landCreateModel();
        $this->landChangeRenderModel = new LandChangeRenderModel();
        $this->thresholdCreateModel = new ThresholdCreateModel();
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
            'obtain_success' => $this->session->getFlashdata('obtain_success'),
            'obtain_errors' => $this->session->getFlashdata('obtain_errors'),
            'identifierLand' => $this->session->getFlashdata('identifierLand'),
            'sondes' => $this->session->getFlashdata('sondes'),
            'create_errors' => $this->session->getFlashdata('create_errors')
        ];

        echo view(Common::ENVIRONMENT . "/land_create", $data);

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

                $array = $this->request->getVar();
                $identifierLand = $array['identifierLand'] ?? '';

                if($validator->withRequest($this->request)->run())
                {
                    $render = [];

                    foreach($this->sondeModel->obtain($identifierLand) as $sonde){
                        if(in_array($sonde->identifierSonde, array_keys($array))){
                            $value = $array[$sonde->identifierSonde];

                            if($value != 0){
                                $render [$sonde->identifierSonde] = $value;
                            }
                        }
                    }

                    if($this->landCreateModel->execute($identifierLand))
                    {
                        $errors = [];

                        if($this->landChangeRenderModel->execute($identifierLand, $render) !== true)
                        {
                            $errors[] = self::ERRORS['render'];
                        }

                        if($this->thresholdCreateModel->execute($identifierLand) !== true)
                        {
                            $errors[] = self::ERRORS['threshold'];
                        }

                        if(count($errors) == 0){
                            return redirect()->to('/land/management/' . $identifierLand);
                        }else{
                            $this->session->setFlashdata('create_errors', $errors);
                        }
                    }else{
                        $this->session->setFlashdata('create_errors', [self::ERRORS['creation']]);
                    }
                }else{
                    $this->session->setFlashdata('create_errors', $validator->getErrors());
                }

                $this->session->setFlashdata('identifierLand', $identifierLand);
            }
        }

        return redirect()->to('/land/create');
    }
}
