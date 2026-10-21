<x-layout.app>
    @section('title','Matieres Index')
    @section('headerTitle','Matieres Index')
    @section('headerSub','Liste des matières')

    <div class="w3-container w3-margin-top">

        <p>
            <b>Nombre de matières :</b> {{ $matieresAll }}
        </p>

    {{-- Ajouter nouvelle matière --}}
    <div class="w3-margin-bottom">
        <a href="{{ route('admin.matieres.create', ['page' => request('page')]) }}" class="w3-button w3-green w3-round">
            ➕ Ajouter une matière
        </a>
    </div>

    {{-- Filtres de recherche --}}
    <form method="GET" class="w3-margin-bottom w3-card w3-padding w3-light-grey w3-round-large">
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-col m2 s6">
                <label>ID</label>
                <input type="text" name="id" placeholder="Ex: 3" value="{{ request('id') }}" 
                class="w3-input w3-border w3-round w3-light-grey">
            </div>
            <div class="w3-col m2 s6">
                <label>Nom</label>
                <input type="text" name="nom" placeholder="Nom" value="{{ request('nom') }}" 
                class="w3-input w3-border w3-round w3-light-grey">
            </div>
            <div class="w3-col m2 s6">
                <label>Coefficient</label>
                <input type="text" name="coefficient" placeholder="Coefficient" value="{{ request('coefficient') }}" 
                class="w3-input w3-border w3-round w3-light-grey">
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
                        <a href="{{ route('admin.matieres.index') }}" class="w3-button w3-gray w3-round w3-block">
                            🔄 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Tableau des matières --}}
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
                        'sort_by' => 'coef',
                        'sort_dir' => (request('sort_by') == 'coef' && request('sort_dir') == 'asc') ? 'desc' : 'asc'
                    ]) }}" class="w3-text-white">
                        Coefficient
                        @if(request('sort_by') == 'coef')
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
            @forelse($matieres as $matiere)
                <tr>
                    <td>{{ $matiere->id }}</td>
                    <td>{{ $matiere->nom }}</td>
                    <td>{{ $matiere->coefficient }}</td>
                    <td>{{ $matiere->filiere->nom ?? '-' }}</td>
                    <td>{{ $matiere->anneeAcademique->nom ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.matieres.edit', ['matiere' => $matiere->id, 'page' => request('page')]) }}"
                           class="w3-button w3-blue w3-small w3-round">✏️ Modifier</a>
                        <a href="{{ route('admin.matieres.notes', ['matiere' => $matiere->id, 'page' => request('page')]) }}"
                           class="w3-button w3-green w3-small w3-round">📝 Notes</a>
                        <form action="{{ route('admin.matieres.destroy', $matiere->id) }}" method="POST" style="display:inline-block;">
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
                    <td colspan="7" class="w3-center">Aucune matière trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination si nécessaire --}}
    <x-pagination :items="$matieres" />

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