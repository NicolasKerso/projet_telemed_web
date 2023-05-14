<!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="inscriptiiion.css">
	<script type="text/javascript" src="inscription.js"></script>
</head>
<body>
<div class="background-container"></div>
    <div style="text-align: center;">
        <img src="logo2.png" alt="logo">
    </div>
	<h1>Inscription</h1>
	<form action="traitement_inscription.php" method="POST" onsubmit="return validateForm()">
		<label for="prenom">Prénom</label>
		<input type="text" id="prenom" name="prenom" required>

		<label for="nom">Nom</label>
		<input type="text" id="nom" name="nom" required>


		<label for="datenaissance">Date de naissance</label>
		<input type="date" id="datenaissance" name="datenaissance" required>

		<label for="telephone">Numéro de téléphone</label>
		<input type="tel" id="telephone" name="telephone" required>

        <label for="email">Email</label>
<input type="email" id="email" name="email" required>

<div>
	<label for="genre">Genre </label>
	<input type="radio" id="genre-f" name="genre" value="F" required>
	<label for="genre-f">Femme</label>
	<input type="radio" id="genre-h" name="genre" value="H" required>
	<label for="genre-h">Homme</label>
	<input type="radio" id="genre-n" name="genre" value="N" required>
	<label for="genre-n">Non genré</label>
</div>


		<label for="type">Est ce que c'est un / une  </label>
		<select id="type" name="type" onchange="showFields()">
			<option value="medecin">Médecin</option>
			<option value="patient">Patient</option>
		</select>

		<div id="specialite-div" style="display: none;">
			<label for="specialite">Spécialité :</label>
			<input type="text" id="specialite" name="specialite">
		</div>

		<div id="antecedents-div" style="display: none;">
			<label for="antecedents">Antécédents :</label>
			<textarea id="antecedents" name="antecedents"></textarea>
		</div>

		<input type="submit" value="S'inscrire">
	</form>
    <a class="logout-link" href="logout.php">Se déconnecter</a>
	<a class="retour-link" href="accueil.php">
  <span class="icon"></span>
  Retour
</a>

</body>
</html>
