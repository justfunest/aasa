<?php

namespace App\Controllers;

use App\Validation\ValidationRules;
use App\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class LoanController
 * @package App\Controllers
 */
class LoanController extends Controller
{

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function index(Request $request, Response $response)
    {

        $files = $this->container->get('storage')->listContents('/loans/');
        $loans = [];
        foreach ($files as $fileData) {
            if ($fileData['extension'] == 'csv') {
                $fileContent = $this->container->get('storage')->read($fileData['path']);
                $lines = explode("\n", $fileContent);
                $csv = array_map('str_getcsv', $lines);
                $csv = array_combine($csv[0], $csv[1]);
                $loans[] = $csv;
            }
        }
        return $this->container->view->render('/loans/index.twig', array('loans' => $loans));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function create(Request $request, Response $response)
    {
        return $this->container->view->render('/loans/create.twig');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function store(Request $request, Response $response)
    {
        $validator = new Validator();
        $isValid = $validator->validateRequest($request,[
            'name' => ValidationRules::fullName(),
            'personal_code' => ValidationRules::personalCode(),
            'amount' => ValidationRules::between(1000, 10000),
            'period' => ValidationRules::between(6,24),
            'purpose' => ValidationRules::contains('puhkus')
                ->contains('remont')
                ->contains('koduelktroonika')
                ->contains('pulmad')
                ->contains('rent')
                ->contains('auto')
                ->contains('kool')
                ->contains('investeering')
                ->setMatchingCondition(ValidationRules::MATCH_ONE)
        ]);

        if (!$isValid) {
            return $response->withRedirect($this->container->router->pathFor('loans.create'));
        }

        $this->saveRequestToFile($request);

        return $response->withRedirect($this->container->router->pathFor('loans.index'));

    }

    /**
     * Saves loan request to csv file
     *
     * @param Request $request
     */
    private function saveRequestToFile(Request $request) {
        $date = new \DateTime();
        $fileName = $date->getTimestamp(). '_' . uniqid() . '.csv';

        $temp = tmpfile();
        fputcsv($temp, array_keys($request->getParams()));
        fputcsv($temp, $request->getParams());
        fseek($temp, 0);
        $data =  fread($temp, 1024);
        fclose($temp); // this removes the file
        $this->container->get('storage')->write('/loans/'. $fileName, $data);
    }
}