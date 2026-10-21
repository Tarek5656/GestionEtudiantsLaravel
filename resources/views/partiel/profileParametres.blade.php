<!-- resources/views/partiel/profileParametres.blade.php -->
<div id="settingsModal" class="w3-modal" style="display:none;">
    <div class="w3-modal-content w3-animate-top w3-card-4 w3-round-large" style="max-width:400px; margin:auto; top:10%;">
        <header class="w3-container {{ auth()->user()->role === 'admin' ? 'w3-red' : 'w3-blue' }} w3-round-top">
            <span onclick="closeSettingsModal()" class="w3-button w3-display-topright">&times;</span>
            <h3>Paramètres Compte</h3>
        </header>

        <div class="w3-container w3-padding">
            <form method="POST" action="{{ route('user.update') }}">
                @csrf
                @method('PUT')

                <label for="name">Nom</label>
                <input class="w3-input w3-border w3-round w3-margin-bottom" type="text" id="name" name="name"
                       value="{{ auth()->user()->name }}" required>

                <label for="password">Mot de passe <small>(laisser vide pour ne pas changer)</small></label>
                <input class="w3-input w3-border w3-round w3-margin-bottom" type="password" id="password" name="password">

                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input class="w3-input w3-border w3-round"
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation">

                <!-- Barre de confirmation -->
                <div class="w3-light-grey w3-round w3-small w3-margin-top">
                    <div id="passwordBar"
                        class="w3-round"
                        style="height:8px; width:0%; transition:0.3s;">
                    </div>
                </div>

                <p id="passwordMessage" class="w3-small w3-margin-top"></p>

                <button type="submit"
                        class="w3-button w3-block w3-round {{ auth()->user()->role === 'admin' ? 'w3-red' : 'w3-blue' }}">
                    💾 Sauvegarder
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w3-margin-top">
                @csrf
            </form>
        </div>
    </div>
</div>
