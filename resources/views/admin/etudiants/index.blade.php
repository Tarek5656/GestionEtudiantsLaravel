<x-layout.app>
    @section('title','Etudiants Index')
    @section('headerTitle','Etudiants Index')
    @section('headerSub','Liste des etudiants')

    <div class="w3-container w3-margin-top">

        <p>
            <b>Nombre d'étudiants :</b> {{ $etudiantsAll }}
        </p>

    {{-- Ajouter nouveau étudiant --}}
    <div class="w3-margin-bottom">
        <a href="{{ route('admin.etudiants.create', ['page' => request('page')]) }}" class="w3-button w3-green w3-round">
            ➕ Ajouter un étudiant
        </a>
    </div>

    {{-- Filtres de recherche améliorés --}}
    <form method="GET" class="w3-margin-bottom w3-card w3-padding w3-light-grey w3-round-large">
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-col m2 s6">
                <label>ID</label>
                <input type="text" name="id" placeholder="Ex: 21" value="{{ request('id') }}" 
                    class="w3-input w3-border w3-round w3-light-grey">
            </div>
            <div class="w3-col m2 s6">
                <label>Nom</label>
                <input type="text" name="nom" placeholder="Nom" value="{{ request('nom') }}" 
                    class="w3-input w3-border w3-round w3-light-grey">
            </div>
            <div class="w3-col m2 s6">
                <label>Prénom</label>
                <input type="text" name="prenom" placeholder="Prénom" value="{{ request('prenom') }}" 
                    class="w3-input w3-border w3-round w3-light-grey">
            </div>
            <div class="w3-col m2 s6">
                <label>Sexe</label>
                <select id="sexeSelect" name="sexe_id" class="w3-select w3-border w3-round w3-light-grey">
                    <option value="">--- Sélectionner ---</option>
                    @foreach($sexes as $sexe)
                        <option value="{{ $sexe->id }}" 
                            {{ request('sexe_id') == $sexe->id ? 'selected' : '' }}>
                            {{ $sexe->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w3-col m2 s6">
                <label>Année Académique</label>
                <select id="anneeSelect" name="annee_academique_id" class="w3-select w3-border w3-round w3-light-grey">
                    <option value="">--- Sélectionner ---</option>
                    @foreach($annees as $annee)
                        <option value="{{ $annee->id }}" 
                            {{ request('annee_academique_id') == $annee->id ? 'selected' : '' }}>
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
                        <option value="{{ $af->filiere_id }}" 
                                data-annee="{{ $af->annee_academique_id }}"
                                {{ request('filiere_id') == $af->filiere_id ? 'selected' : '' }}>
                            {{ $af->filiere->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w3-col m2 s12 w3-padding-small">
                <label>&nbsp;</label>
                <div class="w3-row">
                    <div class="w3-col s4">
                        <button type="submit" class="w3-button w3-blue w3-round w3-block">
                            🔍 
                        </button>
                    </div>
                    <div class="w3-col s4">
                        <a href="{{ route('admin.etudiants.index') }}" class="w3-button w3-gray w3-round w3-block">
                            🔄 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Tableau des étudiants --}}
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
                        'sort_by' => 'nom',
                        'sort_dir' => (request('sort_by') == 'nom' && request('sort_dir') == 'asc') ? 'desc' : 'asc'
                    ]) }}" class="w3-text-white">
                        Nom
                        @if(request('sort_by') == 'nom')
                            @if(request('sort_dir') == 'asc') ▲ @else ▼ @endif
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery([
                        'sort_by' => 'prenom',
                        'sort_dir' => (request('sort_by') == 'prenom' && request('sort_dir') == 'asc') ? 'desc' : 'asc'
                    ]) }}" class="w3-text-white">
                        Prénom
                        @if(request('sort_by') == 'prenom')
                            @if(request('sort_dir') == 'asc') ▲ @else ▼ @endif
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery([
                        'sort_by' => 'sexe',
                        'sort_dir' => (request('sort_by') == 'sexe' && request('sort_dir') == 'asc') ? 'desc' : 'asc'
                    ]) }}" class="w3-text-white">
                        Sexe
                        @if(request('sort_by') == 'sexe')
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
            @forelse($etudiants as $etudiant)
                <tr>
                    <td>{{ $etudiant->id }}</td>
                    <td>{{ $etudiant->nom }}</td>
                    <td>{{ $etudiant->prenom }}</td>
                    <td>{{ $etudiant->sexe->nom ?? '-' }}</td>
                    <td>{{ $etudiant->filiere->nom ?? '-' }}</td>
                    <td>{{ $etudiant->anneeAcademique->nom ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.etudiants.bulletin', [$etudiant->id, 'page' => request('page')]) }}"
                        class="w3-button w3-green w3-small w3-round">📝 Bulletin</a>

                        <a href="{{ route('admin.etudiants.show', [$etudiant->id, 'page' => request('page')]) }}"
                           class="w3-button w3-blue w3-small w3-round">🔍 Détails</a>

                        <form action="{{ route('admin.etudiants.destroy', $etudiant->id) }}" method="POST" style="display:inline-block;">
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
                    <td colspan="7" class="w3-center">Aucun étudiant trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination si nécessaire --}}
    <x-pagination :items="$etudiants" />

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const anneeSelect = document.getElementById('anneeSelect');
    const filiereSelect = document.getElementById('filiereSelect');
    const filiereContainer = document.getElementById('filiereContainer');

    const oldFiliere = "{{ request('filiere_id') }}";

    function filterFilieres(keepSelection = false) {
        const annee = anneeSelect.value;
        let hasVisible = false;

        Array.from(filiereSelect.options).forEach(opt => {
            if (!opt.value) return; // ignorer option vide

            if (opt.dataset.annee === annee) {
                opt.style.display = "block";
                hasVisible = true;
            } else {
                opt.style.display = "none";
            }
        });

        filiereContainer.style.display = hasVisible ? "block" : "none";

        if (!keepSelection) {
            filiereSelect.value = "";
        }
    }

    anneeSelect.addEventListener('change', () => filterFilieres(false));

    // initialisation au chargement
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