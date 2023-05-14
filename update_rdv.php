<?php
// update_rdv.php

$conn = mysqli_connect('localhost', 'root', '', 'telemed');

if (!$conn) {
  die("Connexion échouée : " . mysqli_connect_error());
}

$idRdv = $_POST['id'];
$status = $_POST['status'];

$sql = "UPDATE rendez_vous SET status = '$status' WHERE id = $idRdv";
$result = mysqli_query($conn, $sql);

if (!$result) {
  echo mysqli_error($conn);
}

?>
