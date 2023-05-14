<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
session_start();

// Connexion à la base de données MySQL
$conn = mysqli_connect("localhost", "root", "", "telemed");

// Vérification de la connexion à la base de données
if (!$conn) {
    die("Erreur de connexion à la base de données: " . mysqli_connect_error());
}

// Récupération des données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];

// Requête SQL pour vérifier les informations de connexion pour les patients
$query = "SELECT * FROM patients WHERE identifiant = ? AND motdepasse = ?";
$stmt = mysqli_prepare($conn, $query);

// Vérification de la préparation de la requête
if (!$stmt) {
    die("Erreur de préparation de la requête: " . mysqli_error($conn));
}
// Cette ligne prépare une requête SQL avec des paramètres à remplir plus tard
// Le type des paramètres est défini par la chaîne de caractères "ss"
// qui signifie deux chaînes de caractères (string string) sont attendues
mysqli_stmt_bind_param($stmt, "ss", $username, $password);
// Exécute la requête préparée avec les valeurs passées dans la ligne précédente
mysqli_stmt_execute($stmt);

// Cette ligne récupère le résultat de la requête sous forme d'un ensemble de résultats (result set)
$result_patients = mysqli_stmt_get_result($stmt);

// Vérification du résultat de la requête pour les patients
if (mysqli_num_rows($result_patients) == 1) {
    // Authentification réussie, enregistrement du nom d'utilisateur dans la session, de l'id du patient et de son email
    $row = mysqli_fetch_assoc($result_patients);
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['email'] = $row['email'];

    // Génération aléatoire du code de vérification
    $code = rand(100000, 999999);

                // Création du mail 
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'llhkpokh@gmail.com';
                $mail->Password = 'ofrnwycurwmfsznn';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('llhkpokh@gmail.com');
                // Récupération de l'addrese mail de session du patient concerné
                $mail->addAddress($row['email']);

                $mail->isHTML(true);

                $mail->Subject = "Code de verification";
                $mail->Body = $code;

                $mail->send();
                // Enregistrement du code de vérification dans la session
                $_SESSION['verification_code'] = $code;

            


    // Fermeture de la connexion à la base de données
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirection vers la page de verif
    header('Location: verif.php');
    exit;
}

// Requête SQL pour vérifier les informations de connexion pour les médecins
$query = "SELECT * FROM medecins WHERE identifiant = ? AND motdepasse = ?";
$stmt = mysqli_prepare($conn, $query);

// Vérification de la préparation de la requête
if (!$stmt) {
    die("Erreur de préparation de la requête: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ss", $username, $password);
mysqli_stmt_execute($stmt);
$result_medecins = mysqli_stmt_get_result($stmt);

// Vérification du résultat de la requête pour les médecins
if (mysqli_num_rows($result_medecins) == 1) {
    // Authentification réussie, enregistrement du nom d'utilisateur dans la session
    $row = mysqli_fetch_assoc($result_medecins);
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $row['id'];

    // Fermeture de la connexion à la base de données
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirection vers la page des médecins
    header('Location: medecins.php');
    exit;
}

// Requête SQL pour vérifier les informations de connexion pour les utilisateurs
$query = "SELECT * FROM users WHERE identifiant = ? AND motdepasse = ?";
$stmt = mysqli_prepare($conn, $query);

// Vérification de la préparation de la requête
if (!$stmt) {
    die("Erreur de préparation de la requête: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ss", $username, $password);
mysqli_stmt_execute($stmt);
$result_users = mysqli_stmt_get_result($stmt);

// Vérification du résultat de la requête pour l'accueil
if (mysqli_num_rows($result_users) == 1) {
    
    
    // Redirection vers la page d'accueil
    header('Location: accueil.php');
    exit;
    }
    
    // Fermeture de la connexion à la base de données
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    // Authentification échouée, redirection vers la page de connexion avec un message d'erreur
    header('Location: index.php?error=1');
    exit;
    ?>
