<?php

session_start();

// Vérifier si le code de vérification a été soumis
if (isset($_POST['verification_code']) && !empty($_POST['verification_code'])) {

    // Vérifier si le code de vérification est correct
    if ($_POST['verification_code'] == $_SESSION['verification_code']) {
        // Si le code de vérification est correct, afficher un message de réussite
            header('Location: patient.php');
            exit();
    } else {
        // Si le code de vérification est incorrect, afficher un message d'erreur
        echo '<div class="container"><h1>Code de vérification incorrect</h1></div>';

    }
    } else {

    // Si le code de vérification n'a pas été soumis, afficher le formulaire de vérification
    echo '
    <!DOCTYPE html>
<html>
<head>
    <title>Vérification du code de connexion</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Vérification du code de connexion</h1>
        <p>Un code de vérification a été envoyé à votre adresse e-mail. Entrez le code ci-dessous pour vérifier votre compte.</p>
        <form method="post" action="verif.php">
            <label>Code de vérification :</label>
            <input type="text" name="verification_code">
            <input type="submit" value="Vérifier">
        </form>
        <a href="index.html" class="button">Accueil</a>
    </div>
</body>
</html>

    ';

}

?>