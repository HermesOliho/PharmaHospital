<!-- Styles -->
<link rel="stylesheet" href="/assets/styles/home_page.css">
<!-- Proper content -->
<div class="content">
    <h1 class="display-4">
        <span id="typed-text">Bienvenue sur</span>
        <strong>PharmaHôpital</strong>
    </h1>
    <p class="lead">
        Votre plateforme de gestion médicale et pharmaceutique
    </p>
    <a href="/login" class="btn btn-success btn-connect">Se connecter</a>
</div>
<!-- Scripts -->
<!-- Our scripts -->
<script>
    // Animation de texte type machine à écrire
    const textElement = document.getElementById("typed-text");
    const fullText = "Bienvenue sur";
    let index = 0;

    function type() {
        if (index < fullText.length) {
            textElement.textContent += fullText.charAt(index);
            index++;
            setTimeout(type, 100);
        }
    }

    textElement.textContent = ""; // Clear initial text
    type();
</script>