function refreshRdv() {
    $.ajax({
      url: 'get_rdv.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        // Vider le tableau existant
        $('#rdv-table-body').empty();
        
        // Ajouter chaque rendez-vous au tableau
        $.each(data, function(index, rdv) {
          var row = $('<tr>');
          row.append($('<td>').text(rdv.date_rdv));
          row.append($('<td>').text(rdv.patient_nom));
          row.append($('<td>').text(rdv.status));
          row.append($('<td>').html('<a href="modifier_rdv.php?id=' + rdv.id + '">Modifier</a>'));
          row.append($('<td>').html('<button class="accept-button" data-id="' + rdv.id + '">Accepter</button>'));
          row.append($('<td>').html('<button class="refuse-button" data-id="' + rdv.id + '">Refuser</button>'));
          $('#rdv-table-body').append(row);
        });
      },
      error: function(xhr, status, error) {
        console.log('Erreur AJAX : ' + status + '\n' + 'Message d\'erreur : ' + error);
      }
    });
  }
  

  $(document).ready(function() {
    // Chargement initial des rendez-vous
    refreshRdv();
  
    // Rafraîchissement périodique des rendez-vous
    setInterval(function() {
      refreshRdv();
    }, 5000); // Rafraîchit toutes les 5 secondes
  });


