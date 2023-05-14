<!DOCTYPE html>
<html>
<head>
    <title>RDV</title>
    <link rel="stylesheet" type="text/css" href="traitement_rdv.css">
<body>
</head>



<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "telemed");

// Vérification de la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Préparation de la requête SQL avec des paramètres à remplacer par des valeurs
$stmt = mysqli_prepare($conn, "INSERT INTO rendez_vous (medecin_id, patient_id, date_rdv, status) VALUES (?, ?, ?, ?)");

// Vérification de la préparation de la requête
if (!$stmt) {
    die("Erreur de préparation de la requête : " . mysqli_error($conn));
}

// Liaison des paramètres à des variables
mysqli_stmt_bind_param($stmt, "iiss", $medecin_id, $patient_id, $date_rdv, $status);

// Remplacement des paramètres par les valeurs correspondantes
$medecin_id = $_POST["medecin"];
$patient_id = $_SESSION["user_id"];
$date_rdv = $_POST["date_rdv"];
$status = "en_attente";

// Exécution de la requête
if (mysqli_stmt_execute($stmt)) {
    echo "Le rendez-vous a été ajouté avec succès.";
} else {
    echo "Erreur d'ajout du rendez-vous : " . mysqli_stmt_error($stmt);
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>

<body>

<div class="background-container" style="opacity: 0.9"></div>
    <div style="text-align: center;">
        <img src="logo2.png" alt="logo">
    </div>
<a href="rdv_patient.php" class="btn-retour">Retour à la prise de rdv</a>
<a href="patient.php" class="btn-retour">Retour au menu</a>
</body>

