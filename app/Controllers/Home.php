<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

        $data = [
            'cssPage' => 'accueil.css',
            'titrePage' => 'accueil',
        ];

        return view('v_accueil', $data);
    }
}