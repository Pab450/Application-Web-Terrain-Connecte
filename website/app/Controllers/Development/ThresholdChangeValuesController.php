<?php

namespace App\Controllers\Development;

use App\Controllers\BaseController;
use App\Models\Development\ThresholdChangeValuesModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;

/**
 * Class ThresholdChangeValuesController
 * @package App\Controllers\Development
 */
class ThresholdChangeValuesController extends BaseController
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
        ],
        'minimalHumidity' => [
            'rules' => 'required|decimal',
            'errors' => [
                'required' => "Aucune valeur d'humidité minimale donnée.",
                'decimal' => "L'humidité minimale n'est pas une valeur décimale"
            ]
        ],
        'minimalTension' => [
            'rules' => 'required|decimal',
            'errors' => [
                'required' => "Aucune valeur de tension minimale donnée.",
                'decimal' => "La tension minimale n'est pas une valeur décimale"
            ]
        ]
    ];

    /**
     * @const ERRORS array
     */
    private const ERRORS = [
        'update' => "Une erreur est survenue pendant la mise à jour des valeurs de seuil."
    ];

    /**
     * @const SUCCESS string
     */
    private const SUCCESS = "Les valeurs ont bien été modifiées.";

    /**
     * @var Session
     */
    private $session;

    /**
     * @var ThresholdChangeValuesModel
     */
    private $thresholdsChangeValuesModel;

    /**
     * ThresholdChangeValuesController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->thresholdsChangeValuesModel = new ThresholdChangeValuesModel();
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
                if($this->thresholdsChangeValuesModel->execute(...array_values($this->request->getVar(['identifierLand', 'minimalHumidity', 'minimalTension']))) === true)
                {
                    $this->session->setFlashdata('threshold_success', self::SUCCESS);
                }
                else
                {
                    $this->session->setFlashdata('threshold_errors', [self::ERRORS['update']]);
                }
            }
            else
            {
                $this->session->setFlashdata('threshold_errors', $validator->getErrors());
            }

            return redirect()->to('/land/management/' . $this->request->getVar('identifierLand'));
        }

        return redirect()->to('/user/login');
    }
}