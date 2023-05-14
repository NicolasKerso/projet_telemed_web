<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Patients</title>
    <link rel="stylesheet" type="text/css" href="med_patients.css">
    <script type="text/javascript" src="med_patients.js"></script>
</head>
<body>
<div class="background-container" style="opacity: 0.8"></div>
    <div style="text-align: center;">
        <img src="logo2.png" alt="logo">
    </div>

<h1 style="color : white">Ma liste de patients</h1>

<table>
  <tr>
    <th>ID DU Patient</th>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Email</th>
    <th>Date de naissance</th>
    <th>Numéro de téléphone</th>
    <th>Genre</th>
    <th>Ajouter des observations</th>
    <th>Afficher les observations</th>
  </tr>
  
  <?php
// Charger le contenu du fichier med_patients.json
$med_patients_json = file_get_contents("med_patients.json");

// Convertir le contenu JSON en tableau associatif PHP
$med_patients = json_decode($med_patients_json, true);

// ID du médecin
session_start();
$med_id = $_SESSION['user_id'];

// Parcourir chaque élément du tableau
foreach ($med_patients as $patient) {
    // Vérifier si la clé "Associate" existe et correspond à l'ID du médecin
    if (isset($patient[array_key_first($patient)]['Associate']) && in_array($med_id, $patient[array_key_first($patient)]['Associate'])) {
        // Vérifier si l'ID du médecin connecté est dans la liste des associés pour le patient en cours
        $associates = $patient[array_key_first($patient)]['Associate'];
        if (!isset($associates[$med_id]) || !$associates[$med_id]) {
            // Ignorer ce patient et passer au suivant
            continue;
        }
        
        // Afficher les informations du patient
        echo "<tr>";
        echo "<td>" . array_key_first($patient) . "</td>";
        echo "<td>" . $patient[array_key_first($patient)]['LastName'] . "</td>";
        echo "<td>" . $patient[array_key_first($patient)]['FirstName'] . "</td>";
        echo "<td>" . $patient[array_key_first($patient)]['Email'] . "</td>";
        echo "<td>" . $patient[array_key_first($patient)]['BirthDate'] . "</td>";
        echo "<td>" . $patient[array_key_first($patient)]['PhoneNumber'] . "</td>";
        echo "<td>" . $patient[array_key_first($patient)]['Gender'] . "</td>";
        echo "<td><button onclick='openModal(\"" . array_key_first($patient) . "\")'>Ajouter des observations</button></td>";
        echo "<td><button onclick='showObservations(\"" . array_key_first($patient) . "\")'>Afficher les observations</button></td>";
        echo "</tr>";
    }
}
?>

</table>

<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <form onsubmit="saveObservations(event)">
      <h2>Ajouter des observations</h2>
      <label for="observations">Observations:</label>
      <textarea id="observations" name="observations"></textarea>
      <input type="submit" value="Sauvegarder">
    </form>
  </div>
</div>

<a class="retour-link" href="medecins.php">
  <span class="icon"></span>
  Retour
</a>


</body>
</html>
