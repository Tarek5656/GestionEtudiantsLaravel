<x-layout.app>
    @section('title','Examens Index')
    @section('headerTitle','Examens Index')
    @section('headerSub','Liste des examens')

    <div class="w3-container w3-margin-top">

        <p>
            <b>Nombre d'éxamens :</b> {{ $examensAll }}
        </p>

    {{-- Ajouter nouveau examen --}}
    <div class="w3-margin-bottom">
        <a href="{{ route('admin.examens.create', ['page' => request('page')]) }}" class="w3-button w3-green w3-round">
            ➕ Ajouter un examen
        </a>
    </div>

    {{-- Filtres de recherche --}}
    <form method="GET" class="w3-margin-bottom w3-card w3-padding w3-light-grey w3-round-large">
        <div class="w3-row-padding w3-margin-bottom">

            <div class="w3-col m2 s6">
                <label>ID</label>
                <input type="text" name="id" placeholder="Ex: 69" value="{{ request('id') }}" 
                class="w3-input w3-border w3-round w3-light-grey">
            </div>

            <div class="w3-col m2 s6">
                <label>Type</label>
                <select name="type_examen" class="w3-select w3-border w3-round w3-light-grey">
                    <option value="">--- Sélectionner ---</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ request('type_examen') == $type->id ? 'selected' : '' }}>
                            {{ $type->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w3-col m2 s6">
                <label>Date Min</label>
                <input type="date" name="date_min" value="{{ request('date_min') }}" 
                class="w3-input w3-border w3-round w3-light-grey">
            </div>

            <div class="w3-col m2 s6">
                <label>Date Max</label>
                <input type="date" name="date_max" value="{{ request('date_max') }}" 
                class="w3-input w3-border w3-round w3-light-grey">
            </div>

            <div class="w3-col m2 s6">
                <label>Année Académique</label>
                <select id="anneeSelect" name="annee_academique_id" class="w3-select w3-border w3-round w3-light-grey">
                    <option value="">--- Sélectionner ---</option>
                    @foreach($annees as $annee)
                        <option value="{{ $annee->id }}" {{ request('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                            {{ $annee->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w3-col m2 s6" id="filiereContainer" style="display:none;">
                <label>Filière</label>
                <select id="filiereSelect" name="filiere_id" class="w3-select w3-border w3-round w3-light-grey">
                    <option value="">--- Sélectionner ---</option>
                    @foreach($anneeFilieres as $af)
                        <option value="{{ $af->filiere->id }}" 
                            data-annee="{{ $af->annee_academique_id }}"
                            {{ request('filiere_id') == $af->filiere->id ? 'selected' : '' }}>
                            {{ $af->filiere->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w3-col m2 s6" id="matiereContainer" style="display:none;">
                <label>Matière</label>
                <select id="matiereSelect" name="matiere_id" class="w3-select w3-border w3-round w3-light-grey">
                    <option value="">--- Sélectionner ---</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}" 
                            data-filiere="{{ $matiere->filiere_id }}"
                            data-annee="{{ $matiere->annee_academique_id }}"
                            {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                            {{ $matiere->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w3-col m2 s12 w3-padding-small">
                <label>&nbsp;</label>
                <div class="w3-row">
                    <div class="w3-col s6">
                        <button type="submit" class="w3-button w3-blue w3-round w3-block">🔍</button>
                    </div>
                    <div class="w3-col s6">
                        <a href="{{ route('admin.examens.index') }}" class="w3-button w3-gray w3-round w3-block">🔄</a>
                    </div>
                </div>
            </div>

        </div>
    </form>

    {{-- Tableau des examens --}}
    <table class="w3-table-all w3-hoverable w3-card-4">
        <thead>
            <tr class="w3-red">
                <th>
                    <a href="{{ request()->fullUrlWithQuery([
                        'sort_by' => 'id',
                        'sort_dir' => (request('sort_by') == 'id' && request('sort_dir') == 'asc') ? 'desc' : 'asc'
                    ]) }}" class="w3-text-white">
                        ID
                        @if(request('sort_by') == 'id')
                            @if(request('sort_dir') == 'asc') ▲ @else ▼ @endif
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery([
                        'sort_by' => 'type',
                        'sort_dir' => (request('sort_by') == 'type' && request('sort_dir') == 'asc') ? 'desc' : 'asc'
                    ]) }}" class="w3-text-white">
                        Type
                        @if(request('sort_by') == 'type')
                            @if(request('sort_dir') == 'asc') ▲ @else ▼ @endif
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery([
                        'sort_by' => 'date',
                        'sort_dir' => (request('sort_by') == 'date' && request('sort_dir') == 'asc') ? 'desc' : 'asc'
                    ]) }}" class="w3-text-white">
                        Date
                        @if(request('sort_by') == 'date')
                            @if(request('sort_dir') == 'asc') ▲ @else ▼ @endif
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery([
                        'sort_by' => 'matiere',
                        'sort_dir' => (request('sort_by') == 'matiere' && request('sort_dir') == 'asc') ? 'desc' : 'asc'
                    ]) }}" class="w3-text-white">
                        Matière
                        @if(request('sort_by') == 'matiere')
                            @if(request('sort_dir') == 'asc') ▲ @else ▼ @endif
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery([
                        'sort_by' => 'filiere',
                        'sort_dir' => (request('sort_by') == 'filiere' && request('sort_dir') == 'asc') ? 'desc' : 'asc'
                    ]) }}" class="w3-text-white">
                        Filière
                        @if(request('sort_by') == 'filiere')
                            @if(request('sort_dir') == 'asc') ▲ @else ▼ @endif
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery([
                        'sort_by' => 'annee',
                        'sort_dir' => (request('sort_by') == 'annee' && request('sort_dir') == 'asc') ? 'desc' : 'asc'
                    ]) }}" class="w3-text-white">
                        Année Académique
                        @if(request('sort_by') == 'annee')
                            @if(request('sort_dir') == 'asc') ▲ @else ▼ @endif
                        @endif
                    </a>
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($examens as $examen)
                <tr>
                    <td>{{ $examen->id }}</td>
                    <td>{{ $examen->typeExamen->nom ?? '-' }}</td>
                    <td>{{ $examen->date_examen->format('d-m-Y') }}</td>
                    <td>{{ $examen->matiere->nom ?? '-' }}</td>
                    <td>{{ $examen->matiere->filiere->nom ?? '-' }}</td>
                    <td>{{ $examen->matiere->anneeAcademique->nom ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.examens.edit', ['examen' => $examen->id, 'page' => request('page')]) }}"
                           class="w3-button w3-blue w3-small w3-round">✏️ Modifier</a>

                        <form action="{{ route('admin.examens.destroy', $examen->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="w3-button w3-red w3-small w3-round"
                                    onclick="openConfirmDelete(this)">
                                🗑 Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="w3-center">Aucun examen trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination si nécessaire --}}
    <x-pagination :items="$examens" />

</div>

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

            if (opt.dataset.filiere === selectedFiliere &&
                opt.dataset.annee === selectedAnnee) {
                opt.style.display = 'block';
                hasMatieres = true;
            } else {
                opt.style.display = 'none';
            }
        });

        matiereContainer.style.display = hasMatieres ? 'block' : 'none';
    }

    // Initialisation uniquement si l'utilisateur a sélectionné quelque chose
    if (anneeSelect.value) filterFilieres();
    if (filiereSelect.value) filterMatieres();

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
});

</script>

</x-layout.app>