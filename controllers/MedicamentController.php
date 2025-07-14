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

    public function edit(int $id)
    {
        // Récupérer le médicament
        $medicamentModel = new Medicament();
        $medicament = $medicamentModel->findFirst([
            "conditions" => ['id' => $id]
        ]);
        if (!$medicament) {
            $this->render('/errors/e404');
            exit;
        }
        // Mettre en place la vue
        $this->set('medicament', $medicament);
        $this->render('/medicaments/edit');
    }

    public function update(int $id)
    {
        // Récupérer le médicament
        $medicamentModel = new Medicament();
        $medicament = $medicamentModel->findFirst([
            "conditions" => ['id' => $id]
        ]);
        if ($medicament) { // Mettre à jour le médicament
            $data = $this->request->body;
            $updated = $medicamentModel->update([
                'name' => $data['name'],
                'description' => $data['description'],
            ], "id = $id");
            if (!$updated) {
                $this->set('medicament', $medicament);
                $this->set('errorMessage', "Une erreur est survenue lors de la modification !");
                $this->render('/medicaments/edit');
                exit;
            }
        }
        // Rédiriger à la liste des médicaments
        header("Location: /medicaments");
    }

    public function delete(int $id)
    {
        // Récupérer le médicament
        $medicamentModel = new Medicament();
        $medicament = $medicamentModel->findFirst([
            'fields' => ['id'],
            'conditions' => ['id' => $id]
        ]);
        if ($medicament) {
            $medicamentModel->delete("id = $id");
        }
        header("Location: /medicaments");
    }
}
