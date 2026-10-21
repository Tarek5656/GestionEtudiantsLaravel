<x-layout.app>
    @section('title','Matieres Index')
    @section('headerTitle','Matieres Index')
    @section('headerSub','Liste des matières')

    <div class="w3-container w3-margin-top">

        <p>
            <b>Nombre de matières :</b> {{ $matieresAll }}
        </p>

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
            <div class="w3-col m2 s12 w3-padding-small">
                <label>&nbsp;</label>
                <div class="w3-row">
                    <div class="w3-col s4">
                        <button type="submit" class="w3-button w3-blue w3-round w3-block">
                            🔍 
                        </button>
                    </div>
                    <div class="w3-col s4">
                        <a href="{{ route('user.matieres', $etudiant->id) }}" class="w3-button w3-gray w3-round w3-block">
                            🔄 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <p>
        <b>Liste des matières de {{ $etudiant->anneeAcademique->nom }} {{ $etudiant->filiere->nom }} :</b>
    </p>

    {{-- Tableau des matières --}}
    <table class="w3-table-all w3-hoverable w3-card-4">
        <thead>
            <tr class="w3-blue">
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
            </tr>
        </thead>
        <tbody>
            @forelse($matieres as $matiere)
                <tr>
                    <td>{{ $matiere->id }}</td>
                    <td>{{ $matiere->nom }}</td>
                    <td>{{ $matiere->coefficient }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="w3-center">Aucune matière trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

</x-layout.app>