<?php

namespace Controllers;

use HeromTech\Controller;
use Models\User;

class AuthController extends Controller
{
    public function login()
    {
        $this->render('login');
    }

    public function doLogin()
    {
        $data = $this->request->body;
        $userModel = new User();
        // Vérifier si l'utilisateur existe
        $user = $userModel->findFirst([
            'conditions' => ['login' => $data['login']]
        ]);
        // Vérifier le mot de passe
        if (!$user || !password_verify($data['password'], $user->password)) {
            $this->set([
                'errorMessage' => "Identifiants incorrects !"
            ]);
            $this->render('/auth/login');
        } else {
            $_SESSION['user'] = $user->name;
            $_SESSION['role'] = $user->role;
            header("Location: /dashboard");
        }
    }
}
