<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CrudModel;

class IndicadorController extends Controller
{
    public function index()
    {        
        return view('indicador_view');
    }
}
