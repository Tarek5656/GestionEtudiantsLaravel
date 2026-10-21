<!DOCTYPE html>
<html lang="en">
<head>
<title>@yield('title','Titre')</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<style>
    body {
        font-family: "Poppins", sans-serif;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .page-content {
        flex: 1; /* pousse le footer vers le bas */
    }
    .dropdown-up .w3-dropdown-content {
        bottom: 100%;
        top: auto;
    }

</style>
<style>
@media print {

    table {
        page-break-inside: avoid;
    }

    /* Tout cacher */
    body * {
        visibility: hidden;
    }

    /* Afficher uniquement la zone d'impression */
    #print-area,
    #print-area * {
        visibility: visible;
    }

    /* Position propre pour l'impression */
    #print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: auto;
    }

    /* Supprimer les ombres / cartes */
    .w3-card {
        box-shadow: none !important;
    }
}
</style>

</head>
<body>

<!-- Header -->
@include('partiel.header', [
    'title' => View::yieldContent('headerTitle', 'Titre par défaut'),
    'subtitle' => View::yieldContent('headerSub', '')
])

<div class="w3-container w3-margin-bottom" style="margin-left:260px">
<x-alert />
</div>

<!-- Sidebar/menu -->
@include('partiel.' . $role . '.sidebar')

<!-- !PAGE CONTENT! -->
<div class="page-content w3-main" style="margin-left:300px;margin-right:40px">

    <x-confirm-delete 
    title="Suppression"
    message="⚠️ Cette suppression est définitive. Voulez-vous continuer ?" />

    {{ $slot }}

<!-- End page content -->
</div>

@include('partiel.footer')

<!-- JS pour modal et overlay -->
<script>
function openSettingsModal() {
    document.getElementById('settingsModal').style.display = 'block';
}

function closeSettingsModal() {
    document.getElementById('settingsModal').style.display = 'none';
}

// Fermer si clic en dehors du contenu
window.onclick = function(event) {
    const modal = document.getElementById('settingsModal');
    if (event.target === modal) {
        closeSettingsModal();
    }
}
document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');
    const confirmation = document.getElementById('password_confirmation');
    const bar = document.getElementById('passwordBar');
    const message = document.getElementById('passwordMessage');
    const submitBtn = document.querySelector('button[type="submit"]');

    function checkPasswordMatch() {

        // Si password vide → reset
        if (!password.value && !confirmation.value) {
            bar.style.width = '0%';
            bar.className = 'w3-round';
            message.textContent = '';
            submitBtn.disabled = false;
            return;
        }

        // Si password renseigné mais confirmation vide
        if (password.value && !confirmation.value) {
            bar.style.width = '50%';
            bar.className = 'w3-round w3-orange';
            message.textContent = '⏳ En attente de confirmation';
            message.className = 'w3-text-orange';
            submitBtn.disabled = true;
            return;
        }

        // Comparaison
        if (password.value === confirmation.value) {
            bar.style.width = '100%';
            bar.className = 'w3-round w3-green';
            message.textContent = '✔ Mot de passe confirmé';
            message.className = 'w3-text-green';
            submitBtn.disabled = false;
        } else {
            bar.style.width = '100%';
            bar.className = 'w3-round w3-red';
            message.textContent = '✖ Les mots de passe ne correspondent pas';
            message.className = 'w3-text-red';
            submitBtn.disabled = true;
        }
    }

    password.addEventListener('input', checkPasswordMatch);
    confirmation.addEventListener('input', checkPasswordMatch);
});
</script>
<script>
    let confirmDeleteForm = null;

    function openConfirmDelete(button) {
        confirmDeleteForm = button.closest('form');
        document.getElementById('confirmDeleteModal').style.display = 'block';
    }

    function closeConfirmDelete() {
        confirmDeleteForm = null;
        document.getElementById('confirmDeleteModal').style.display = 'none';
    }

    function submitConfirmDelete() {
        if (confirmDeleteForm) {
            confirmDeleteForm.submit();
        }
    }
</script>

</body>
</html>
