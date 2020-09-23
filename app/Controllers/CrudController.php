<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CrudModel;

class CrudController extends Controller
{
    public function __construct()
{
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    parent::__construct();
}
    public function index()
    {
        helper(['form', 'url']);
        $this->CrudModel = new CrudModel();
        $data['ufs'] = $this->CrudModel->get_all_uf();
        return view('uf_view', $data);
    }

    public function consumir_api($apiUrl)
    {
        if (ini_get('allow_url_fopen')) {
            $json = file_get_contents($apiUrl);
        } else {
            $curl = curl_init($apiUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            curl_close($curl);
        }
        return json_decode($json);
    }

    public function sincronizar($tipo)
    {
        $this->CrudModel = new CrudModel();
        $this->CrudModel->drop_basededatos();
        if ($tipo == 1) {
            $apiUrl = 'https://mindicador.cl/api/uf';
            $dailyIndicators = $this->consumir_api($apiUrl);
            $this->CrudModel->refill($dailyIndicators);
        } else if ($tipo == 2) {
            $apiUrl = 'https://mindicador.cl/api/uf/2020';
            $dailyIndicators = $this->consumir_api($apiUrl);
            $this->CrudModel->refill($dailyIndicators);
        } else if ($tipo == 3) {
            for ($i = 1977; $i < 2020; $i++) {
                $apiUrl = 'https://mindicador.cl/api/uf/' . $i;
                $dailyIndicators = $this->consumir_api($apiUrl);
                $this->CrudModel->refill($dailyIndicators);
            }
        }
    }

    public function uf_add()
    {
        helper(['form', 'url']);
        $this->CrudModel = new CrudModel();

        $data = array(
            'valor' => $this->request->getPost('valor'),
            'fecha' => $this->request->getPost('fecha')
        );
        $insert = $this->CrudModel->uf_add($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($id)
    {
        $this->CrudModel = new CrudModel();
        $data = $this->CrudModel->get_by_id($id);
        echo json_encode($data);
    }

    public function uf_update()
    {
        helper(['form', 'url']);
        $this->CrudModel = new CrudModel();
        $data = array(
            'valor' => $this->request->getPost('valor'),
            'fecha' => $this->request->getPost('fecha')
        );
        $this->CrudModel->uf_update(array('id' => $this->request->getPost('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function uf_delete($id)
    {
        helper(['form', 'url']);
        $this->CrudModel = new CrudModel();
        $this->CrudModel->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
