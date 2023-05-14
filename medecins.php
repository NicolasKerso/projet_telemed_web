<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="medecins.js"></script>
    <link rel="stylesheet" type="text/css" href="medeciins.css">
    <title>Médecins</title>

    <style>
    ul li a {
      color: white;
    }
  </style>
</head>
<body>


<div class="navbar">
    <div class="hamburger">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
    <div class="menu">
        <a href="med_patients.php">Voir mes patients</a>
        <a href="rdv_med.php">Voir mes rendez-vous</a>
        <a href="logout.php">Se déconnecter</a>
    </div>
</div>

<div class="background-container" style="opacity: 0.8"></div>
    <div style="text-align: center;">
        <img src="logo2.png" alt="logo">
    </div>
    <br>
    <h1>Bienvenue sur la page des médecins</h1>

    
    <p style="text-align : center" class="welcome-message" >Vous êtes connecté en tant qu'utilisateur "<?php
session_start();
 echo $_SESSION['username'];
 
 ; ?>".</p>

    <h2>Recherche de patients</h2>

<form method="post">
    <label for="recherche">Recherche :</label>
    <input style="color: black" type="text" name="recherche" id="recherche" >
    <button type="submit">Rechercher</button>
</form>
    <br>
    <?php
    
    // Récupération de l'id du médecin dans le base de donnée
    $id_med = $_SESSION['user_id'];

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
?>
    <form id="form_patient" method="post" action="ajouter_patient.php">
    <input type="hidden" name="id_patient" value="">
    <?php
    echo '<ul>';
    // On parcourt tout le fichier JSON pour afficher tout les patients un par un
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
            // Ajout de l'événement onclick pour afficher l'alerte de confirmation
            echo '<button class="select-button" onclick="confirmerSelection('.$id.')">Sélectionner</button>';
            echo '</li>';
            // Construire un tableau avec l'ID du patient comme clé
            $patientsById[$id] = $patient;
        }
    }
    echo '</ul>';
    ?>
    </form>

</body>
</html>
