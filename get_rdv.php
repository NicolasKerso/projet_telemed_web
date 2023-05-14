<?php
// Connexion à la base de données
$conn = mysqli_connect('localhost', 'root', '', 'telemed');

// Vérification de la connexion
if (!$conn) {
  die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
}

// Requête SQL pour récupérer les rendez-vous
$sql = 'SELECT rendez_vous.*, patients.nom AS patient_nom FROM rendez_vous INNER JOIN patients ON rendez_vous.patient_id = patients.id ORDER BY rendez_vous.date_rdv DESC';
$result = mysqli_query($conn, $sql);

// Création du tableau de rendez-vous
$rdvs = array();
while ($row = mysqli_fetch_assoc($result)) {
  $rdvs[] = array(
    'id' => $row['id'],
    'date_rdv' => $row['date_rdv'],
    'patient_nom' => $row['patient_nom'],
    'status' => $row['status']
  );
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);

// Envoi des données en JSON
echo json_encode($rdvs);
?>
