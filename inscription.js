

function validateTelephone() {
    var telephone = document.getElementById("telephone").value;
    if (telephone.length > 10) {
        alert("Le numéro de téléphone ne doit pas dépasser 10 caractères.");
        return false;
    }
    return true;
}

function validateForm() {
     validateTelephone();
}

function showFields() {
    var type = document.getElementById("type").value;

    if (type == "medecin") {
        document.getElementById("specialite-div").style.display = "block";
        document.getElementById("antecedents-div").style.display = "none";
    } else if (type == "patient") {
        document.getElementById("antecedents-div").style.display = "block";
        document.getElementById("specialite-div").style.display = "none";
    }
}
