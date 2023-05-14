<?php
$conn = mysqli_connect('localhost', 'root', '', 'telemed');

if (!$conn) {
  die("Connexion échouée : " . mysqli_connect_error());
}

$idRdv = $_POST['id'];

$sql = "DELETE FROM rendez_vous WHERE id = $idRdv";
$result = mysqli_query($conn, $sql);

if (!$result) {
  echo mysqli_error($conn);
}
?>
