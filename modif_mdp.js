function openPasswordForm() {
    const form = document.createElement('form');
    form.innerHTML = `
        <label for="currentPassword">Mot de passe actuel :</label>
        <input type="password" id="currentPassword" name="currentPassword" required><br><br>
        <label for="newPassword">Nouveau mot de passe :</label>
        <input type="password" id="newPassword" name="newPassword" required><br><br>
        <label for="confirmNewPassword">Confirmer le nouveau mot de passe :</label>
        <input type="password" id="confirmNewPassword" name="confirmNewPassword" required><br><br>
        <input type="submit" value="Valider" onclick="return validatePassword()">
    `;
    form.style.display = 'block';
    form.style.position = 'absolute';
    form.style.top = '50%';
    form.style.left = '50%';
    form.style.transform = 'translate(-50%, -50%)';
    form.style.backgroundColor = '#f2f2f2';
    form.style.padding = '20px';
    form.style.border = '1px solid black';
    document.body.appendChild(form);
}

function validatePassword() {
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmNewPassword = document.getElementById('confirmNewPassword').value;

    if (newPassword.length < 6) {
        alert("Le nouveau mot de passe doit avoir au moins 6 caractères");
        return false;
    }

    if (!/\d/.test(newPassword)) {
        alert("Le nouveau mot de passe doit contenir au moins un chiffre");
        return false;
    }

    if (!/[A-Z]/.test(newPassword)) {
        alert("Le nouveau mot de passe doit contenir au moins une majuscule");
        return false;
    }

    if (newPassword !== confirmNewPassword) {
        alert("Les mots de passe ne correspondent pas");
        return false;
    }

    return true;
}