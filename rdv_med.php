
<!DOCTYPE html>
<html>
<head>
    <title>Liste des rendez-vous</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="rdv.js"></script> -->
    <link rel="stylesheet" type="text/css" href="rdv_medd.css">
</head>
<body>

<div class="background-container" style="opacity: 0.8"></div>
    <div style="text-align: center;">
        <img src="logo2.png" alt="logo">
    </div>

<h1>Liste des rendez-vous</h1>

<table>
  <thead>
    <tr>
      <th>Date et heure</th>
      <th>Patient</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="rdv-table-body">
    <?php
    session_start();

    $conn = mysqli_connect('localhost', 'root', '', 'telemed');
    
    // Vérification de la connexion
    if (!$conn) {
      die("Connexion échouée : " . mysqli_connect_error());
    }
    
    // Récupération de l'id du médecin dans le base de donnée
    $id_med = $_SESSION['user_id'];
    
    // Récupération des rendez-vous pour le médecin connecté
    $sql = "SELECT * FROM rendez_vous WHERE medecin_id = $id_med";
    $result = mysqli_query($conn, $sql);
    

      if (mysqli_num_rows($result) > 0) {
        // Affichage des rendez-vous dans le tableau HTML
        while ($row = mysqli_fetch_assoc($result)) {
          //Afficher seulement les rendez-vous du médecin connecté
          if ($row['medecin_id'] == $_SESSION['user_id']) {
            echo '<tr>';
            echo '<td>' . $row['date_rdv'] . '</td>';
            $sql_pat = "SELECT nom FROM patients WHERE id = " . $row['patient_id'];
$result_pat = mysqli_query($conn, $sql_pat);
$row_pat = mysqli_fetch_assoc($result_pat);
$nom_patient = $row_pat['nom'];

echo '<td>' . $nom_patient . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '<td>';
            if ($row['status'] == 'en_attente') {
              echo '<button class="accept-button" data-id="' . $row['id'] . '">Accepter</button>';
              echo '<button class="refuse-button" data-id="' . $row['id'] . '">Refuser</button>';
            }
            echo '</td>';
            echo '</tr>';
          }
        }
      } else {
        // Affichage d'un message si aucun rendez-vous trouvé
        echo '<tr><td colspan="4">Aucun rendez-vous trouvé.</td></tr>';
      }
    ?>
  </tbody>
</table>

<script>

    // Fonction pour mettre à jour le statut du rendez-vous dans la base de données
function acceptRdv(idRdv) {
  $.ajax({
    url: 'update_rdv.php',
    type: 'POST',
    data: {id: idRdv, status: 'accepte'},
    success: function(response) {
      // Remplacement des boutons par un message de confirmation
      var message = '<span class="rdv-accepted">Le rendez-vous a été accepté.</span>';
      $('button[data-id="' + idRdv + '"]').parent().html(message);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
}

// Fonction pour supprimer le rendez-vous de la base de données
function refuseRdv(idRdv) {
  $.ajax({
    url: 'delete_rdv.php',
    type: 'POST',
    data: {id: idRdv},
    success: function(response) {
      // Suppression de la ligne du tableau correspondant au rendez-vous
      $('button[data-id="' + idRdv + '"]').parents('tr').remove();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
}

// Gestion du clic sur le bouton Accepter
$(document).on('click', '.accept-button', function() {
  var idRdv = $(this).data('id');
  acceptRdv(idRdv);
});

// Gestion du clic sur le bouton Refuser
$(document).on('click', '.refuse-button', function() {
  var idRdv = $(this).data('id');
  refuseRdv(idRdv);
});


</script>


</body>
</html>
