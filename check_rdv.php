<?php
// Connexion à la base de données
$conn = mysqli_connect('localhost', 'root', '', 'telemed');

// Vérification de la connexion
if (!$conn) {
  die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
}

// Requête SQL pour vérifier s'il y a un nouveau rendez-vous en attente
$sql = 'SELECT * FROM rendez_vous WHERE status = "en_attente" ORDER BY date_rdv DESC LIMIT 1';
$result = mysqli_query($conn, $sql);

// Si un nouveau rendez-vous est en attente, on récupère les informations du patient et du médecin associés
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $patient_id = $row['patient_id'];
  $medecin_id = $row['medecin_id'];
  $date_rdv = $row['date_rdv'];

  // Requête SQL pour récupérer le nom du patient
  $sql = 'SELECT nom FROM patients WHERE id = ' . $patient_id;
  $result = mysqli_query($conn, $sql);
  if (!$result) {
    die('Erreur MySQL : ' . mysqli_error($conn));
  }
  
  $row = mysqli_fetch_assoc($result);
  $patient_nom = $row['nom'];

  // Requête SQL pour récupérer les informations du médecin
  $sql = 'SELECT nom, prenom FROM medecins WHERE id = ' . $medecin_id;
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $medecin_nom = $row['nom'] . ' ' . $row['prenom'];

  // Fermeture de la connexion à la base de données
  mysqli_close($conn);

  // Envoi des données en JSON
  $response = array(
    'new_rdv' => true,
    'patient_nom' => $patient_nom,
    'medecin_nom' => $medecin_nom,
    'date_rdv' => $date_rdv
  );
  echo json_encode($response);
} else {
  // Fermeture de la connexion à la base de données
  mysqli_close($conn);

  // Envoi des données en JSON
  $response = array(
    'new_rdv' => false
  );
  echo json_encode($response);
}


?>