<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaHospital</title>
    <!-- Include Bootstrap's style -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="overlay"></div>

    <!-- NAVIGATION -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand ms-3" href="/#" style="color: #004080">
            <img
                src="/assets/images/logo.png"
                alt="Logo"
                width="40"
                height="40"
                class="d-inline-block align-text-top" />
            PharmaHôpital
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#" style="color: #004080">Accueil</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="#"
                        style="color: #004080"
                        data-bs-toggle="modal"
                        data-bs-target="#aproposModal">À propos</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="#"
                        style="color: #004080"
                        data-bs-toggle="modal"
                        data-bs-target="#contactModal">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Main content -->
    <?= $content_for_layout; ?>

    <!-- Footer and other components -->


    <!-- SCRIPTS -->
    <!-- Bootstrap's scripts -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="/assets/bootstrap/js/bootstrap/bundle.min.js" defer></script>

</body>

</html>