@props([
    'title' => 'Confirmation',
    'message' => 'Cette action est irréversible. Voulez-vous continuer ?',
])

<div id="confirmDeleteModal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-top w3-round" style="max-width:420px">
        <header class="w3-container w3-red w3-round-top">
            <h4>{{ $title }}</h4>
        </header>

        <div class="w3-container w3-padding">
            <p>{{ $message }}</p>
        </div>

        <footer class="w3-container w3-light-grey w3-padding w3-round-bottom w3-right-align">
            <button type="button"
                    class="w3-button w3-red w3-round"
                    onclick="submitConfirmDelete()">
                🗑 Supprimer
            </button>
            <button type="button"
                    class="w3-button w3-gray w3-round"
                    onclick="closeConfirmDelete()">
                Annuler
            </button>
        </footer>
    </div>
</div>
