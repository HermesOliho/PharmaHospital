<section class="w-100 d-flex justify-content-center align-items-center bg-light" style="min-height: calc(100dvh - 4.5rem);">
    <form action="" method="POST" class="shadow rounded p-4 m-2 bg-white" style="width: 100%; max-width: 800px;">
        <h3 class="text-center mb-4">Ajouter un médicament à la pharmacie</h3>
        <div class="form-group mb-3">
            <label for="name" class="form-label">Nom du médicament</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                placeholder="Entrez le nom du médicament... " />
        </div>
        <div class="form-group mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea
                name="description"
                id="description"
                class="form-control"
                cols="40"
                rows="10"
                placeholder="Entrez une courte description du médicament... "></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                Sauvegarder
            </button>
        </div>
    </form>
</section>