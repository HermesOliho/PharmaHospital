<section class="container mb-3 pt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Médicaments</h3>
        <a
            href="/medicaments/add"
            title="Ajouter un médicament"
            class="btn btn-primary">
            Ajouter
        </a>
    </div>
    <hr>
</section>
<section class="container">
    <?php if (isset($medicaments) && count($medicaments) > 0): ?>
        <form action="#">
            <input
                type="search"
                name="search_medicament"
                id="medicament"
                placeholder="Chercher un médicament..."
                class="form-control mb-3" />
        </form>
        <table class="table table-striped">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
                <th scope="col" class="text-end">Actions</th>
            </thead>
            <tbody>
                <?php foreach ($medicaments as $index => $medicament): ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= $medicament->name; ?></td>
                        <td><?= $medicament->description; ?></td>
                        <td class="text-end">
                            <a href="/medicaments/edit/<?= $medicament->id ?>" class="btn btn-outline-success btn-sm me-2">
                                Éditer
                            </a>
                            <form
                                action="/medicaments/delete/<?= $medicament->id; ?>"
                                id="deleteMedicament<?= $medicament->id; ?>"
                                class="d-inline-block"
                                method="POST">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    Supprimer
                                </button>
                                <script>
                                    document.getElementById("deleteMedicament<?= $medicament->id; ?>")
                                        .addEventListener("submit", event => {
                                            event.preventDefault()
                                            if (confirm("Voulez-vous vraiment Retirer ce médicament ?"))
                                                event.target.submit();
                                        })
                                </script>

                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">
            Aucun médicament pour le moment !
        </div>
    <?php endif; ?>
</section>