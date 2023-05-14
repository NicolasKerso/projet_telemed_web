document.addEventListener("DOMContentLoaded", function() {
    var hamburger = document.querySelector(".hamburger");
    var menu = document.querySelector(".menu");
    
    hamburger.addEventListener("click", function() {
        this.classList.toggle("active");
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });
    });



    function confirmerSelection(id_patient) {
        if (confirm("Êtes-vous sûr de vouloir sélectionner ce patient ?")) {
            // Soumettre le formulaire avec l'id du patient sélectionné
            document.getElementById("form_patient").id_patient.value = id_patient;
            document.getElementById("form_patient").submit();
        }
    }