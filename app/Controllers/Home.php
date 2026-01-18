<?php

namespace App\Controllers;

use App\Models\Donnees;

class Home extends BaseController
{
    public function __construct()
    {
        $this->donneesModel = new Donnees();
    }
    
    public function index()
    {

        $data = [
            'cssPage' => 'accueil.css',
            'titrePage' => 'accueil',
            'categories' => $this->donneesModel->getCategories(),
            'exercices' => $this->donneesModel->getExercices(),
        ];

        return view('v_accueil', $data);
    }

    public function general()
    {

        $data = [
            'cssPage' => 'general.css',
            'titrePage' => 'general',
            'categories' => $this->donneesModel->getCategories(),
            'exercices' => $this->donneesModel->getExercices(),
        ];

        return view('v_general', $data);
    }
}