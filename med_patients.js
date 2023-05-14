function openModal(patientId) {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    document.getElementById("observations").focus();
    document.getElementById("observations").value = "";
    document.getElementById("observations").setAttribute("data-patient-id", patientId);
  }
  
  // Exécuter le code lorsque la page est complètement chargée
document.addEventListener("DOMContentLoaded", function() {

    // Fermer la boîte de dialogue lorsque l'utilisateur clique sur le bouton "X"
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
      var modal = document.getElementById("myModal");
      modal.style.display = "none";
    }
  
  });

  
  function saveObservations(event) {
    event.preventDefault();
    var observations = document.getElementById("observations").value;
    var patientId = document.getElementById("observations").getAttribute("data-patient-id");
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_observations.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          alert("Observations enregistrées avec succès!");
          var modal = document.getElementById("myModal");
          modal.style.display = "none";
        } else {
          alert("Une erreur s'est produite lors de l'enregistrement des observations.");
        }
      }
    };
    xhr.send("patient_id=" + patientId + "&observations=" + observations);

  }
  

    function showObservations(patientId) {
        fetch('med_patients.json')
          .then(response => response.json())
          .then(data => {
            const patientIndex = patientId - 1;
            const patient = data[patientIndex];
            const observations = patient.Observations;
            let message = "";
      
            if (observations) {
              observations.forEach(observation => {
                message += "Date: " + observation.Date + "\n";
                message += "Observations: " + observation.Observations + "\n\n";
              });
            } else {
              message = "Aucune observation trouvée.";
            }
      
            alert(message);
          });
      }
      
  
