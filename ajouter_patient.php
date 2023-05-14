<?php
// Récupération de l'id du médecin dans la base de données
session_start();
$id_med = $_SESSION['user_id'];

// Chargement du contenu du fichier JSON existant
$json = file_get_contents('patient.json');
$patients = json_decode($json, true);

// Construire un tableau avec l'ID du patient comme clé
$patientsById = [];
foreach ($patients as $patientArray) {
    foreach ($patientArray as $id => $patient) {
        $patientsById[$id] = $patient;
    }
}

// Si le tableau est vide, initialiser avec un tableau vide
if (!count($patientsById)) {
    $patientsById = [];
}

// Récupération de l'id du patient sélectionné
$id_patient = isset($_POST['id_patient']) && is_numeric($_POST['id_patient']) ? (int)$_POST['id_patient'] : 0;


// Vérification si le patient est déjà associé à un médecin
$json_med_patients = file_get_contents('med_patients.json');
$med_patients = json_decode($json_med_patients, true);
$patientFound = false;
foreach ($med_patients as &$med_patient) {
    if (array_key_exists($id_patient, $med_patient)) {
        $patientFound = true;
        if (isset($med_patient[$id_patient]['Associate']) && is_array($med_patient[$id_patient]['Associate'])) {
            // Le patient est déjà associé à un ou plusieurs médecins, on vérifie si le nouveau médecin est déjà dans la liste
            if (!isset($med_patient[$id_patient]['Associate'][$id_med])) {
                // Le nouveau médecin n'est pas dans la liste, on l'ajoute
                $med_patient[$id_patient]['Associate'][$id_med] = true;
            } else {
                // Le nouveau médecin est déjà dans la liste, on affiche un message d'erreur et on redirige le médecin
                $_SESSION['error_message'] = "Vous avez déjà associé ce patient.";
                header('Location: medecins.php');
                exit();
            }
        } else {
            // Le patient est associé à un seul médecin, on transforme la valeur en tableau contenant les deux médecins
            $med_patient[$id_patient]['Associate'] = [$med_patient[$id_patient]['Associate'], $id_med => true];
        }
    }
}

// Si le patient n'a pas été trouvé dans le fichier "med_patients.json", on l'ajoute avec le nouveau médecin associé
if (!$patientFound) {
    $last_patient = end($patientsById);
    $new_id = isset($last_patient['ID']) ? $last_patient['ID'] + 1 : 1;
    $patient = $patientsById[$id_patient];
    $patient['ID'] = $new_id;
    $patient['Associate'] = [$id_med => true];
    $med_patients[] = [$id_patient => $patient];
}

// Sauvegarde des modifications dans le fichier "med_patients.json"
file_put_contents('med_patients.json', json_encode($med_patients, JSON_PRETTY_PRINT));

// Redirection vers la page principale du médecin
header('Location: medecins.php');
?>
