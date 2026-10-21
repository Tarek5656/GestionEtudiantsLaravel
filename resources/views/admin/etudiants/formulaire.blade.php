<x-layout.app>
@section('title',$etudiant->id ? 'Modifier Étudiant' : 'Ajouter Étudiant')
@section('headerTitle',$etudiant->id ? 'Modifier Étudiant' : 'Ajouter Étudiant')
@section('headerSub',$etudiant->id ? 'Modifier les informations de l’étudiant' : 'Ajouter un nouvel étudiant')

<form action="{{ $etudiant->id ?? null ? route('admin.etudiants.update', $etudiant->id) : route('admin.etudiants.store') }}" method="POST" class="w3-container w3-card-4 w3-padding w3-white w3-round" style="max-width:600px; margin:auto;">
    @csrf
    @if($etudiant->id ?? false)
        @method('PUT')
    @endif

    <h3 class="w3-text-red">{{ $etudiant->id ? 'Modifier Étudiant' : 'Ajouter Étudiant' }}</h3>

    <input type="hidden" name="page" value="{{ request('page') }}">
    <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
    <input type="hidden" name="return_url" value="{{ old('return_url', url()->previous()) }}">

    {{-- Nom --}}
    <p>
        <label>Nom</label>
        <input class="w3-input w3-border" type="text" name="nom" value="{{ old('nom', $etudiant->nom ?? '') }}" required>
    </p>

    {{-- Prénom --}}
    <p>
        <label>Prénom</label>
        <input class="w3-input w3-border" type="text" name="prenom" value="{{ old('prenom', $etudiant->prenom ?? '') }}" required>
    </p>

    {{-- Date de naissance --}}
    <p>
        <label>Date de Naissance</label>
        <input class="w3-input w3-border" type="date" name="date_naissance" value="{{ old('date_naissance', $etudiant->date_naissance ? $etudiant->date_naissance->format('Y-m-d') : '') }}" required>
    </p>

    {{-- CIN --}}
    <p>
        <label>CIN</label>
        <input class="w3-input w3-border" type="text" name="cin" value="{{ old('cin', $etudiant->cin ?? '') }}" required>
    </p>

    {{-- Sexe --}}
    <p>
        <label>Sexe</label>
        <select name="sexe_id" class="w3-select w3-border" required>
            <option value="">-- Choisir un sexe --</option>
            @foreach($sexes as $sexe)
                <option value="{{ $sexe->id }}"
                    {{ old('sexe_id', $etudiant->sexe_id ?? '') == $sexe->id ? 'selected' : '' }}>
                    {{ $sexe->nom }}
                </option>
            @endforeach
        </select>
    </p>

    {{-- Email --}}
    <p>
        <label>Email</label>
        <input class="w3-input w3-border" type="email" name="email" value="{{ old('email', $etudiant->email ?? '') }}" required>
    </p>

    {{-- Adresse --}}
    <p>
        <label>Adresse</label>
        <input class="w3-input w3-border" type="text" name="adresse" value="{{ old('adresse', $etudiant->adresse ?? '') }}" required>
    </p>

    {{-- Téléphone --}}
    <p>
        <label>Téléphone</label>
        <input class="w3-input w3-border" type="tel" name="telephone" value="{{ old('telephone', $etudiant->telephone ?? '') }}" required>
    </p>

    {{-- Année académique --}}
    <p>
        <label>Année Académique</label>
        <select id="anneeSelect" name="annee_academique_id" class="w3-select w3-border" required>
            <option value="">-- Choisir une année --</option>
            @foreach($annees as $annee)
                <option value="{{ $annee->id }}"
                    {{ old('annee_academique_id', $etudiant->annee_academique_id ?? '') == $annee->id ? 'selected' : '' }}>
                    {{ $annee->nom }}
                </option>
            @endforeach
        </select>
    </p>


    {{-- Filière --}}
    <p id="filiereContainer" style="display:none;">
        <label>Filière</label>
        <select id="filiereSelect" name="filiere_id" class="w3-select w3-border" required>
            <option value="">-- Choisir une filière --</option>

            @foreach($anneeFilieres as $af)
                <option value="{{ $af->filiere->id }}"
                        data-annee="{{ $af->annee_academique_id }}"
                        {{ old('filiere_id', $etudiant->filiere_id ?? '') == $af->filiere->id ? 'selected' : '' }}>
                    {{ $af->filiere->nom }}
                </option>
            @endforeach
        </select>
    </p>


    <p>
        <button type="submit" class="w3-button w3-red w3-round w3-hover-light-red">{{ $etudiant->id ? 'Modifier' : 'Ajouter' }}</button>
        <button type="reset" class="w3-button w3-blue w3-round w3-hover-light-blue">Réinitialiser</button>
        <button type="button" onclick="window.location='{{ old('return_url', url()->previous()) }}'" class="w3-button w3-gray w3-round w3-hover-light-gray">Annuler</button>
    </p>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const anneeSelect = document.getElementById('anneeSelect');
    const filiereSelect = document.getElementById('filiereSelect');
    const filiereContainer = document.getElementById('filiereContainer');

    const oldFiliere = "{{ old('filiere_id', $etudiant->filiere_id ?? '') }}";

    function filterFilieres(keepSelection = false) {
        const annee = anneeSelect.value;
        let hasVisible = false;

        Array.from(filiereSelect.options).forEach(opt => {
            if (!opt.value) return;

            if (opt.dataset.annee === annee) {
                opt.style.display = "block";
                hasVisible = true;
            } else {
                opt.style.display = "none";
            }
        });

        filiereContainer.style.display = hasVisible ? "block" : "none";

        // Ne pas reset en mode édition
        if (!keepSelection) {
            filiereSelect.value = "";
        }
    }

    // Quand on change l’année → reset filière
    anneeSelect.addEventListener('change', function () {
        filterFilieres(false);
    });

    // Initialisation (édition)
    filterFilieres(true);

    if (oldFiliere) {
        const option = filiereSelect.querySelector(`option[value="${oldFiliere}"]`);
        if (option && option.style.display !== "none") {
            filiereSelect.value = oldFiliere;
        }
    }
});
</script>

</x-layout.app>