<?php

namespace Controllers;

use HeromTech\Controller;
use Models\Medicament;

class MedicamentController extends Controller
{
    public function list()
    {
        // Récupérer les médicaments
        $medicamentModel = new Medicament();
        $medicaments = $medicamentModel->find();
        // Mettre en place la vue
        $this->set('medicaments', $medicaments);
        $this->render('/medicaments/list');
    }

    public function addNew()
    {
        $this->render('/medicaments/edit');
    }

    public function storeNew()
    {
        $data = $this->request->body;
        $medicamentModel = new Medicament();
        $added = $medicamentModel->create([
            "name" => trim(ucwords($data['name'])),
            "description" => trim($data['description'])
        ]);
        if ($added) {
            header("Location: /medicaments");
        } else {
            header("Location: /medicaments/add");
        }
    }
}
