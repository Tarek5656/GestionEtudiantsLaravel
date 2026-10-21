<x-layout.app>
@section('title',$matiere->id ? 'Modifier Matière' : 'Ajouter Matière')
@section('headerTitle',$matiere->id ? 'Modifier Matière' : 'Ajouter Matière')
@section('headerSub',$matiere->id ? 'Modifier les informations de la matière' : 'Ajouter une nouvelle matière')

<form action="{{ $matiere->id ?? null ? route('admin.matieres.update', $matiere->id) : route('admin.matieres.store') }}" method="POST" class="w3-container w3-card-4 w3-padding w3-white w3-round" style="max-width:600px; margin:auto;">
    @csrf
    @if($matiere->id ?? false)
        @method('PUT')
    @endif

    <h3 class="w3-text-red">{{ $matiere->id ? 'Modifier Matière' : 'Ajouter Matière' }}</h3>

    <input type="hidden" name="page" value="{{ request('page') }}">

    {{-- Nom --}}
    <p>
        <label>Nom</label>
        <input class="w3-input w3-border" type="text" name="nom" value="{{ old('nom', $matiere->nom ?? '') }}" required>
    </p>

    {{-- Coefficient --}}
    <p>
        <label>Coefficient</label>
        <input class="w3-input w3-border" type="number" name="coefficient" value="{{ old('coefficient', $matiere->coefficient ?? '') }}" required>
    </p>

    {{-- Année académique --}}
    <p>
        <label>Année Académique</label>
        <select id="anneeSelect" name="annee_academique_id" class="w3-select w3-border" required>
            <option value="">-- Choisir une année --</option>
            @foreach($annees as $annee)
                <option value="{{ $annee->id }}"
                    {{ old('annee_academique_id', $matiere->annee_academique_id ?? '') == $annee->id ? 'selected' : '' }}>
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
                        {{ old('filiere_id', $matiere->filiere_id ?? '') == $af->filiere->id ? 'selected' : '' }}>
                    {{ $af->filiere->nom }}
                </option>
            @endforeach
        </select>
    </p>


    <p>
        <button type="submit" class="w3-button w3-red w3-round w3-hover-light-red">{{ $matiere->id ? 'Modifier' : 'Ajouter' }}</button>
        <button type="reset" class="w3-button w3-blue w3-round w3-hover-light-blue">Réinitialiser</button>
        <button type="button" onclick="window.location='{{ route('admin.matieres.index', ['page' => request('page')]) }}'" class="w3-button w3-gray w3-round w3-hover-light-gray">Annuler</button>
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