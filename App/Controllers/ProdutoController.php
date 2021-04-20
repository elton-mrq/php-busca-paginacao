<?php

namespace App\Controllers;

use App\Models\DAO\ProdutoDAO;

class ProdutoController extends Controller
{
    public function index(){
        $this->render('produto/index');
    }

}