<!-- Styles -->
<link rel="stylesheet" href="/assets/styles/login_page.css">
<!-- Proper content -->
<div class="container d-flex justify-content-center">
    <div class="login-container">
        <h3 class="text-center mb-4">Connexion à <span style="color: #004080;">PharmaHôpital</span></h3>

        <form id="loginForm" method="POST" action="/login">

            <input
                type="text"
                name="login"
                id="login"
                class="form-control"
                placeholder="Num de téléphone ou Adresse mail"
                required />
            <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                placeholder="Mot de passe"
                required />

            <div id="errorMessage" class="error">
                <?php if (isset($errorMessage)) echo $errorMessage; ?>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Connexion
            </button>
        </form>
    </div>
</div>

<!-- Scripts -->
<!-- <script>
    const form = document.getElementById("loginForm");
    const role = document.getElementById("role");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const errorMessage = document.getElementById("errorMessage");

    form.addEventListener("submit", function(e) {
        e.preventDefault(); // Empêche l'envoi du formulaire

        // Réinitialise les messages d'erreur
        errorMessage.textContent = "";

        // Validation simple
        if (
            email.value.trim() === "" ||
            password.value.trim() === ""
        ) {
            errorMessage.textContent =
                "Tous les champs sont obligatoires.";
            return;
        }
        submit()

    });
</script> -->