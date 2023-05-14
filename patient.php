<!DOCTYPE html>
<html>
<head>
    <title>Patient</title>
    <link rel="stylesheet" type="text/css" href="patientt.css">
    <script type="text/javascript" src="modif_mdp.js"></script>
    <script type="text/javascript" src="patient.js"></script>
</head>
<body>

<div class="navbar">
    <div class="hamburger">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
    <div class="menu">
        <a href="rdv_patient.php">Prendre rendez-vous</a>
        <a href="logout.php">Se déconnecter</a>
    </div>
</div>

<div style="text-align: center;">
    <img src="logo2.png" alt="logo">
</div>
<h1 class="title"  >Bienvenue sur la page des patients</h1>
<br>
<p class="welcome-message" >Vous êtes connecté en tant qu'utilisateur "<?php
session_start();
 echo $_SESSION['username'];
 ; ?>".</p>
 

<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupérer l'identifiant du patient à partir de la variable de session
$id_patient = $_SESSION['user_id'];

// Charger le fichier JSON
$json_file = file_get_contents('patient.json');
$json_data = json_decode($json_file, true);

// Vérifier si les données du patient sont présentes dans le fichier JSON
$patient_found = false;
foreach ($json_data as $patient_group) {
    foreach ($patient_group as $patient_id => $patient_data) {
        if ($patient_id == $id_patient) {
            $patient_found = true;
            break 2;
        }
    }
}

// Rediriger si le patient n'est pas trouvé
if (!$patient_found) {
    header('Location: login.html');
    exit;
}

// Afficher les données du patient
$patient_data = $json_data[array_search(strval($id_patient), array_keys($json_data))][strval($id_patient)]
?>

<table>
  <thead>
    <tr>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Email</th>
      <th>Date de naissance</th>
      <th>Numéro de téléphone</th>
      <th>Genre</th>
      <th>Mot de passe</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $patient_data['LastName']; ?></td>
      <td><?php echo $patient_data['FirstName']; ?></td>
      <td><?php echo $patient_data['Email']; ?></td>
      <td><?php echo $patient_data['BirthDate']; ?></td>
      <td><?php echo $patient_data['PhoneNumber']; ?></td>
      <td><?php echo $patient_data['Gender']; ?></td>
      <td><?php echo $_SESSION['password']; ?></td>
    </tr>
  </tbody>
</table>





<button onclick="openPasswordForm()">Modifier son mot de passe</button>
<div class="password-form-container">
  <form class="password-form">
    <label for="current-password">Mot de passe actuel :</label>
    <input type="password" id="current-password" name="current-password"><br><br>
    <label for="new-password">Nouveau mot de passe :</label>
    <input type="password" id="new-password" name="new-password"><br><br>
    <button type="submit">Modifier le mot de passe</button>
  </form>
</div>





</body>
</html>