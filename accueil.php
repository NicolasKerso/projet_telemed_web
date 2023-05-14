<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
    <link rel="stylesheet" type="text/css" href="acueill.css">
</head>
<body>

<script>


    document.addEventListener("DOMContentLoaded", function() {
    var hamburger = document.querySelector(".hamburger");
    var menu = document.querySelector(".menu");

    hamburger.addEventListener("click", function() {
        this.classList.toggle("active");
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });
});


</script>


<div class="navbar">
    <div class="hamburger">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
    <div class="menu">
        <a href="inscription.php">S'inscrire</a>
        <a href="logout.php">Se déconnecter</a>
    </div>
</div>


<!-- <div class="dropdown">
    <button class="dropbtn">Menu</button>
    <div class="dropdown-content">
        <a href="inscription.php">S'inscrire</a>
        <a href="logout.php">Se déconnecter</a>
    </div>
</div> -->

<div class="background-container" style="opacity: 0.9"></div>
    <div style="text-align: center;">
        <img src="logo2.png" alt="logo">
    </div>
    <h1>Bienvenue sur la page d'accueil</h1>
    <p style="text-align : center">Vous êtes connecté en tant qu'utilisateur "accueil".</p>
    <!-- <a class="logout-link" href="logout.php">Se déconnecter</a> -->
    <link rel="stylesheet" type="text/css" href="accueill.css">
    <!-- <a href="inscription.php">S'inscrire</a> -->

    <h2>Recherche de patients</h2>

<form method="post">
    <label for="recherche">Recherche :</label>
    <input style="color: black" type="text" name="recherche" id="recherche" >
    <button type="submit">Rechercher</button>
</form>

    <br>

    <?php
    // Chargement du contenu du fichier JSON existant
    $json = file_get_contents('patient.json');
    $patients = json_decode($json, true);

    // Vérification si la recherche a été soumise
    if (isset($_POST['recherche'])) {
        $recherche = $_POST['recherche'];
        $patients = array_filter($patients, function ($patient) use ($recherche) {
            // Vérification si le prénom ou le nom du patient contient la recherche
            $found = false;
            foreach ($patient as $patientInfo) {
                if (strpos(strtolower($patientInfo['LastName']), strtolower($recherche)) !== false
                    || strpos(strtolower($patientInfo['FirstName']), strtolower($recherche)) !== false) {
                    $found = true;
                    break;
                }
            }
            return $found;
        });
    }
    

    echo '<ul>';

    foreach ($patients as $patientArray) {
        foreach ($patientArray as $id => $patient) {
            echo '<li>';
            echo '<strong>ID : '.$id.'</strong><br>';
            echo 'Nom : '.$patient['LastName'].'<br>';
            echo 'Prénom : '.$patient['FirstName'].'<br>';
            echo 'Email : '.$patient['Email'].'<br>';
            echo 'Date de naissance : '.$patient['BirthDate'].'<br>';
            echo 'Téléphone : '.$patient['PhoneNumber'].'<br>';
            echo 'Genre : '.$patient['Gender'].'<br>';
            echo '</li>';
        }
    }

    echo '</ul>';
    ?>




</body>
</html>
