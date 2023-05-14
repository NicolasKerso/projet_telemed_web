<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Prise de rdv</title>
    <link rel="stylesheet" type="text/css" href="rdv_patientt.css">
</head>
<body>
<div class="background-container" style="opacity: 0.9"></div>
    <div style="text-align: center;">
        <img src="logo2.png" alt="logo">
    </div>

<?php
session_start();
// récupération de l'identifiant de l'utilisateur connecté 
$id_patient = $_SESSION['user_id'];

// chargement du contenu du fichier patient.json
$patient_data = file_get_contents('patient.json');

// conversion du contenu JSON en tableau PHP
$patient_array = json_decode($patient_data, true);

// recherche de l'utilisateur correspondant à l'identifiant
$user_data = null;
foreach ($patient_array as $patient) {
    if (isset($patient[$id_patient])) {
        $user_data = $patient[$id_patient];
        break;
    }
}

// vérification si l'utilisateur a été trouvé
if ($user_data === null) {
    die("Utilisateur non trouvé.");
}

// récupération du nom de l'utilisateur
$user_last_name = $user_data['LastName'];
// récupération de l'adresse e-mail de l'utilisateur
$user_email = $user_data['Email'];


// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "", "telemed");
mysqli_set_charset($conn, "utf8");
// Vérification de la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Exécution de la requête SQL pour récupérer les informations des médecins
$sql = "SELECT id, nom, prenom, specialite FROM medecins";
$result = mysqli_query($conn, $sql);

// Vérification de la requête
if (!$result) {
    die("Erreur de requête SQL : " . mysqli_error($conn));
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>


<form action="traitement_rendez_vous.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $user_last_name; ?>" required>

        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email"  value="<?php echo $user_email; ?>" required>

        <label for="medecin">Médecin :</label>
        <select id="medecin" name="medecin" required>
            <option value="">Sélectionnez un médecin</option>
            <?php
            // Parcours des résultats de la requête
            while ($row = mysqli_fetch_assoc($result)) {
                // Affichage de chaque médecin dans une option du select
                echo '<option value="' . strval($row["id"]) . '">' . $row["nom"] . ' ' . $row["prenom"] . ' - ' . $row["specialite"] . '</option>';
            }
            ?>
        </select>

        <label for="date_rdv">Date et heure du rendez-vous :</label>
        <input type="datetime-local" id="date_rdv" name="date_rdv" required>

        <input type="submit" value="Demander un rendez-vous">
    </form>

    <a class="retour-link" href="patient.php">
  <span class="icon"></span>
  Retour
</a>
</body>
</html>