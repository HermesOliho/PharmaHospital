<?php

use HeromTech\Router;

class Conf
{
    static int $debug = 1;
    static $databases = [
        "default" => []
    ];
}

// Routes de l'application
// Home
Router::connect('', 'home/index');
// Auth routes
Router::connect('login', 'auth/login');
Router::connect('login', 'auth/doLogin', 'POST');

// Dashboard routes
Router::connect('dashboard', 'dashboard/index');

// Medicaments' routes
Router::connect('medicaments', 'medicament/list');
Router::connect('medicaments/add', 'medicament/addNew');
Router::connect('medicaments/add', 'medicament/storeNew', 'POST');
Router::connect('medicaments/edit/:id', 'medicament/edit/id:([0-9]+)');
Router::connect('medicaments/edit/:id', 'medicament/update/id:([0-9]+)', 'POST');
Router::connect('medicaments/delete/:id', 'medicament/delete/id:([0-9]+)', 'POST');
