<x-layout.app>
    @section('title','Détails Étudiant')
    @section('headerTitle','Détails Étudiant')
    @section('headerSub','Informations complètes de l’étudiant')

<h3 class="w3-text-red w3-center w3-margin-bottom">Fiche de l’étudiant</h3>

<div class="w3-card-4 w3-padding w3-white w3-round w3-margin-top" style="max-width:700px; margin:auto;">

    {{-- Section Informations personnelles --}}
    <div class="w3-container w3-light-gray w3-round w3-padding w3-margin-bottom">
        <h4 class="w3-text-red">Informations personnelles</h4>
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
        <h4 class="w3-text-red">Informations académiques</h4>
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
        <h4 class="w3-text-red">Compte utilisateur</h4>
        <div class="w3-row w3-margin-bottom">
            <div class="w3-col s4"><strong>Email école :</strong></div>
            <div class="w3-col s8">{{ $etudiant->user->email ?? '-' }}</div>
        </div>
    </div>

    {{-- Boutons --}}
    <div class="w3-margin-top w3-center">
        <a href="{{ route('admin.etudiants.bulletin', [$etudiant->id, 'page' => request('page')]) }}"
           class="w3-button w3-green w3-small w3-round">📝 Bulletin</a>
        <a href="{{ route('admin.etudiants.edit', [$etudiant->id, 'page' => request('page')]) }}"
           class="w3-button w3-blue w3-small w3-round"
           onclick="sessionStorage.setItem('etudiant_return_url', window.location.href)">✏️ Modifier</a>
        <form action="{{ route('admin.etudiants.destroy', $etudiant->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="button" class="w3-button w3-red w3-small w3-round" onclick="openConfirmDelete(this)">
                🗑 Supprimer
            </button>
        </form>
        <button onclick="window.location='{{ route('admin.etudiants.index', ['page' => request('page')]) }}'" 
            class="w3-button w3-gray w3-round w3-small w3-hover-light-gray">
            🔙 Retour
        </button>
    </div>
</div>

</x-layout.app>
