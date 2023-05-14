<!DOCTYPE html>
<html>
<head>
<title>Inscription traité</title>
<link rel="stylesheet" type="text/css" href="traiteement.css">
<style>
    .btn-retour {
  display: inline-block;
  background-color: #4CAF50;
  color: #fff;
  text-align: center;
  padding: 12px 24px;
  text-decoration: none;
  border-radius: 6px;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

.btn-retour:hover {
  background-color: #3e8e41;
}
</style>
</head>
<body>
<div class="background-container" style="opacity: 0.9"></div>
    <div style="text-align: center;">
        <img src="logo2.png" alt="logo">
    </div>
<a class="retour-link" href="accueil.php">Retour</a>
<a href="accueil.php" class="btn-retour">Retour à l'accueil</a>
<a href="inscription.php" class="btn-retour">Réeinscrire une personne</a>

    <?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "telemed";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }

    // Récupération des données du formulaire
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $motdepasse = $_POST['datenaissance'];
    $datenaissance = $_POST['datenaissance'];
    $telephone = $_POST['telephone'];
    $type = $_POST['type'];
    $genre = $_POST['genre'];

    // Création de l'identifiant
    $identifiant = strtolower($prenom . '.' . $nom);

    // Connexion à la base de données
    $connexion = new PDO('mysql:host=localhost;dbname=telemed', 'root', '');

    // Insertion des données dans la table correspondante
    if ($type == 'medecin') {
        $specialite = $_POST['specialite'];
        $requete = $connexion->prepare("INSERT INTO medecins (identifiant, email, motdepasse, specialite,nom,prenom) VALUES (:identifiant, :email, :motdepasse, :specialite, :nom, :prenom)");
        $requete->bindParam(':identifiant', $identifiant);
        $requete->bindParam(':email', $email);
        $requete->bindParam(':motdepasse', $motdepasse);
        $requete->bindParam(':specialite', $specialite);
        $requete->bindParam(':nom', $nom);
        $requete->bindParam(':prenom', $prenom);
    } else {
        $antecedents = $_POST['antecedents'];
        $requete = $connexion->prepare("INSERT INTO patients (identifiant, email, motdepasse, antecedents,nom,prenom) VALUES (:identifiant, :email, :motdepasse, :antecedents, :nom, :prenom)");
        $requete->bindParam(':identifiant', $identifiant);
        $requete->bindParam(':email', $email);
        $requete->bindParam(':motdepasse', $motdepasse);
        $requete->bindParam(':antecedents', $antecedents);
        $requete->bindParam(':nom', $nom);
        $requete->bindParam(':prenom', $prenom);
        ;
    }

    if ($requete->execute()) {
        $identifiant = strtolower($prenom) . "." . strtolower($nom);
        $mdp = str_replace('/', '', $datenaissance);
        echo '<script>alert("Inscription réussie. Votre nom d\'utilisateur est : ' . $identifiant . ' et votre mot de passe est : ' . $mdp . '");</script>';
    } else {
        echo "Erreur lors de l'inscription";
    }

    if ($type == 'patient') {
        // Chargement du contenu du fichier JSON existant
        $json = file_get_contents('patient.json');
        $patients = json_decode($json, true);

        // Calcul de l'ID du nouveau patient
        $newPatientID = count($patients);

        // Création de l'entrée pour le nouveau patient
        $data = array(
            'LastName' => $nom,
            'FirstName' => $prenom,
            'Email' => $email,
            'BirthDate' => $datenaissance,
            'PhoneNumber' => $telephone,
            'Gender' => $genre
        );

        // Ajout du nouvel utilisateur au tableau avec l'ID
        $patients[$newPatientID] = array($newPatientID => $data);

        // Encodage du tableau en JSON et enregistrement dans le fichier
        file_put_contents('patient.json', json_encode($patients, JSON_PRETTY_PRINT));
    } else {
        exit;
    }

    
   




