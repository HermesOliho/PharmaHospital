<?php

namespace Controllers;

use HeromTech\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->render('index', [
            'title' => 'Welcome to PharmaHospital',
            'message' => 'This is the home page of the PharmaHospital application.'
        ]);
    }
}
