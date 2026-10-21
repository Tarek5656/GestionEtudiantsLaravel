<x-layout.app>
@section('title',$examen->id ? 'Modifier Examen' : 'Ajouter Examen')
@section('headerTitle',$examen->id ? 'Modifier Examen' : 'Ajouter Examen')
@section('headerSub',$examen->id ? 'Modifier les informations de l’examen' : 'Ajouter un nouvel examen')

<form action="{{ $examen->id ?? null ? route('admin.examens.update', $examen->id) : route('admin.examens.store') }}" method="POST" class="w3-container w3-card-4 w3-padding w3-white w3-round" style="max-width:600px; margin:auto;">
    @csrf
    @if($examen->id ?? false)
        @method('PUT')
    @endif

    <h3 class="w3-text-red">{{ $examen->id ? 'Modifier Examen' : 'Ajouter Examen' }}</h3>

    <input type="hidden" name="page" value="{{ request('page') }}">

    {{-- Type --}}
    <p>
    <label>Type d'examen</label>
    <select name="type_examen_id" class="w3-select w3-border" required>
        <option value="">-- Choisir un type d'examen --</option>
        @foreach($typeExamens as $typeExamen)
            <option value="{{ $typeExamen->id }}"
                {{ old('type_examen_id', $examen->type_examen_id ?? '') == $typeExamen->id ? 'selected' : '' }}>
                {{ $typeExamen->nom }}
            </option>
        @endforeach
    </select>
    </p>

    {{-- Date --}}
    <p>
        <label>Date d'examen</label>
        <input class="w3-input w3-border" type="date" name="date_examen" value="{{ old('date_examen', $examen->date_examen ? $examen->date_examen->format('Y-m-d') : '') }}" required>
    </p>

   {{-- Année académique --}}
<p>
    <label>Année Académique</label>
    <select id="anneeSelect" name="annee_academique_id" class="w3-select w3-border" required>
        <option value="">-- Choisir une année --</option>
        @foreach($annees as $annee)
            <option value="{{ $annee->id }}"
                {{ old('annee_academique_id', $examen->matiere->annee_academique_id ?? '') == $annee->id ? 'selected' : '' }}>
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
                data-annee="{{ $af->annee_academique_id }}">
                {{ $af->filiere->nom }}
            </option>
        @endforeach
    </select>
</p>

{{-- Matière --}}
<p id="matiereContainer" style="display:none;">
    <label>Matière</label>
    <select id="matiereSelect" name="matiere_id" class="w3-select w3-border" required>
        <option value="">-- Choisir une matière --</option>
        @foreach($matieres as $matiere)
            <option value="{{ $matiere->id }}"
                data-filiere="{{ $matiere->filiere_id }}"
                data-annee="{{ $matiere->annee_academique_id }}">
                {{ $matiere->nom }}
            </option>
        @endforeach
    </select>
</p>

<p>
    <button type="submit" class="w3-button w3-red w3-round w3-hover-light-red">{{ $examen->id ? 'Modifier' : 'Ajouter' }}</button>
    <button type="reset" class="w3-button w3-blue w3-round w3-hover-light-blue">Réinitialiser</button>
    <button type="button" onclick="window.location='{{ route('admin.examens.index', ['page' => request('page')]) }}'" class="w3-button w3-gray w3-round w3-hover-light-gray">Annuler</button>
</p>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const anneeSelect = document.getElementById('anneeSelect');
    const filiereSelect = document.getElementById('filiereSelect');
    const matiereSelect = document.getElementById('matiereSelect');
    const filiereContainer = document.getElementById('filiereContainer');
    const matiereContainer = document.getElementById('matiereContainer');

    function filterFilieres() {
        const selectedAnnee = anneeSelect.value;
        let hasFilieres = false;

        Array.from(filiereSelect.options).forEach(opt => {
            if (!opt.value) return;
            if (opt.dataset.annee === selectedAnnee) {
                opt.style.display = 'block';
                hasFilieres = true;
            } else {
                opt.style.display = 'none';
            }
        });

        filiereContainer.style.display = hasFilieres ? 'block' : 'none';
    }

    function filterMatieres() {
        const selectedFiliere = filiereSelect.value;
        const selectedAnnee = anneeSelect.value;
        let hasMatieres = false;

        Array.from(matiereSelect.options).forEach(opt => {
            if (!opt.value) return;

            if (
                opt.dataset.filiere === selectedFiliere &&
                opt.dataset.annee === selectedAnnee
            ) {
                opt.style.display = 'block';
                hasMatieres = true;
            } else {
                opt.style.display = 'none';
            }
        });

        matiereContainer.style.display = hasMatieres ? 'block' : 'none';
    }

    function initializeSelections() {
        const oldFiliereId = "{{ old('filiere_id', $examen->matiere->filiere_id ?? '') }}";
        const oldMatiereId = "{{ old('matiere_id', $examen->matiere_id ?? '') }}";

        // 1️⃣ Filtrer filières selon l'année déjà sélectionnée
        filterFilieres();

        // 2️⃣ Sélectionner la filière
        if (oldFiliereId) {
            filiereSelect.value = oldFiliereId;
        }

        // 3️⃣ Maintenant seulement on filtre les matières
        filterMatieres();

        // 4️⃣ Sélectionner la matière
        if (oldMatiereId) {
            matiereSelect.value = oldMatiereId;
        }
    }

    anneeSelect.addEventListener('change', () => {
        filterFilieres();
        filiereSelect.value = '';
        matiereSelect.value = '';
        matiereContainer.style.display = 'none';
    });

    filiereSelect.addEventListener('change', () => {
        filterMatieres();
        matiereSelect.value = '';
    });

    initializeSelections();
});
</script>

</x-layout.app>