<?php
$patient_id = $_POST["patient_id"];
$observations = $_POST["observations"];
$med_patients_json = file_get_contents("med_patients.json");
$med_patients = json_decode($med_patients_json, true);

// On soustrait 1 à l'id du patient pour avoir l'indice correspondant dans le tableau
$patient_index = $patient_id - 1;

if (!isset($med_patients[$patient_index]["Observations"])) {
  $med_patients[$patient_index]["Observations"] = array();
}

$existing_observations = $med_patients[$patient_index]["Observations"];
$existing_observations[] = array(
  "Date" => date("Y-m-d H:i:s"),
  "Observations" => $observations
);
$med_patients[$patient_index]["Observations"] = $existing_observations;
$med_patients_json = json_encode($med_patients, JSON_PRETTY_PRINT);
file_put_contents("med_patients.json", $med_patients_json);
$response = array("success" => true);
echo json_encode($response);
?>
