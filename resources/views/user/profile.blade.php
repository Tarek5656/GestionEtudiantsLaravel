<x-layout.app>
    @section('title','Profile Étudiant')
    @section('headerTitle','Profile Étudiant')
    @section('headerSub','Informations complètes de l’étudiant')

<h3 class="w3-text-blue w3-center w3-margin-bottom">Profile</h3>

<div class="w3-card-4 w3-padding w3-white w3-round w3-margin-top" style="max-width:700px; margin:auto;">

    {{-- Section Informations personnelles --}}
    <div class="w3-container w3-light-gray w3-round w3-padding w3-margin-bottom">
        <h4 class="w3-text-blue">Informations personnelles</h4>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>ID :</strong></div>
            <div class="w3-col s8">{{ $etudiant->id }}</div>
        </div>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>Nom :</strong></div>
            <div class="w3-col s8">{{ $etudiant->nom }}</div>
        </div>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>Prénom :</strong></div>
            <div class="w3-col s8">{{ $etudiant->prenom }}</div>
        </div>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>Sexe :</strong></div>
            <div class="w3-col s8">{{ $etudiant->sexe->nom }}</div>
        </div>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>Date de naissance :</strong></div>
            <div class="w3-col s8">{{ $etudiant->date_naissance->format('d-m-Y') }}</div>
        </div>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>CIN :</strong></div>
            <div class="w3-col s8">{{ $etudiant->cin }}</div>
        </div>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>Téléphone :</strong></div>
            <div class="w3-col s8">{{ $etudiant->telephone }}</div>
        </div>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>Adresse :</strong></div>
            <div class="w3-col s8">{{ $etudiant->adresse }}</div>
        </div>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>Email :</strong></div>
            <div class="w3-col s8">{{ $etudiant->email }}</div>
        </div>
    </div>

    {{-- Section Académique --}}
    <div class="w3-container w3-light-gray w3-round w3-padding w3-margin-bottom">
        <h4 class="w3-text-blue">Informations académiques</h4>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>Filière :</strong></div>
            <div class="w3-col s8">{{ $etudiant->filiere->nom ?? '-' }}</div>
        </div>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>Année académique :</strong></div>
            <div class="w3-col s8">{{ $etudiant->anneeAcademique->nom ?? '-' }}</div>
        </div>
    </div>

    {{-- Section Compte --}}
    <div class="w3-container w3-light-gray w3-round w3-padding w3-margin-bottom">
        <h4 class="w3-text-blue">Compte utilisateur</h4>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>Email école :</strong></div>
            <div class="w3-col s8">{{ $etudiant->user->email ?? '-' }}</div>
        </div>
    </div>

    {{-- Boutons --}}
    <div class="w3-margin-top w3-center">
        <a href="{{ route('user.bulletin', $etudiant->id) }}"
           class="w3-button w3-green w3-small w3-round">📝 Bulletin</a>
    </div>
</div>

</x-layout.app>
