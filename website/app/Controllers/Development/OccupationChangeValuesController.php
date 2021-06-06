<?php

namespace App\Controllers\Development;

use App\Controllers\BaseController;
use App\Models\Development\OccupationChangeValuesModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Session\Session;

/**
 * Class OccupationChangeValuesController
 * @package App\Controllers\Development
 */
class OccupationChangeValuesController extends BaseController
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
    ];

    /**
     * @const ERRORS array
     */
    private const ERRORS = [
        'file' => 'Aucun fichier csv donné.',
        'import' => "Une erreur est survenue pendant l'importation du fichier csv.",
    ];

    /**
     * @const SUCCESS string
     */
    private const SUCCESS = "Le fichier csv a bien été importé.";

    /**
     * @var Session
     */
    private $session;

    /**
     * @var OccupationChangeValuesModel
     */
    private $OccupationChangeValuesModel;

    /**
     * ThresholdChangeValuesController constructor.
     */
    public function __construct()
    {
        $this->session = session();
        $this->OccupationChangeValuesModel = new OccupationChangeValuesModel();
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
                $file = $this->request->getFile('file');

                if($file->guessExtension() !== 'csv'){
                    $this->session->setFlashdata('occupation_errors', [self::ERRORS['file']]);
                }
                else
                {
                    $file->move(WRITEPATH . 'uploads/', true);
                    $fopen = fopen(WRITEPATH . 'uploads/' . $file->getName(), 'r');

                    $content = [];

                    while(($column = fgetcsv($fopen)) !== FALSE)
                    {
                        $content[] = $column;
                    }

                    unset($content[0]);

                    foreach ($content as $item){
                        if($this->OccupationChangeValuesModel->execute($this->request->getVar('identifierLand'), $item[0], $item[1], $item[2]) === false)
                        {
                            $this->session->setFlashdata('occupation_errors', [self::ERRORS['import']]);

                            return redirect()->to('/land/management/' . $this->request->getVar('identifierLand'));
                        }
                    }

                    $this->session->setFlashdata('occupation_success', self::SUCCESS);
                }
            }
            else
            {
                $this->session->setFlashdata('occupation_errors', $validator->getErrors());
            }

            return redirect()->to('/land/management/' . $this->request->getVar('identifierLand'));
        }

        return redirect()->to('/user/login');
    }
}