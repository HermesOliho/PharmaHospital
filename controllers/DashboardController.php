<?php

namespace Controllers;

use HeromTech\Controller;

class DashboardController extends Controller
{
    public string $layout = "admin";

    public function index()
    {
        if (!isset($_SESSION['user'], $_SESSION['role'])) {
            header('Location: /login');
            exit;
        }
        if (in_array($_SESSION['role'], ['administrateur', 'médecin', 'pharmacien'])) {
            $this->render('index');
        } else {
            header("Location: /login");
            exit;
        }
    }
}
