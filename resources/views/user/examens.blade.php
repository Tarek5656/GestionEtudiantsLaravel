<x-layout.app>
    @section('title','Examens Index')
    @section('headerTitle','Examens Index')
    @section('headerSub','Liste des examens')

    <div class="w3-container w3-margin-top">

        <p>
            <b>Nombre d'éxamens :</b> {{ $examensAll }}
        </p>

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

            <div class="w3-col m2 s6"">
                <label>Matière</label>
                <select name="matiere_id" class="w3-select w3-border w3-round w3-light-grey">
                    <option value="">--- Sélectionner ---</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}" 
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
                        <a href="{{ route('user.examens', $etudiant->id) }}" class="w3-button w3-gray w3-round w3-block">🔄</a>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <p>
        <b>Liste des examens de {{ $etudiant->anneeAcademique->nom }} {{ $etudiant->filiere->nom }} :</b>
    </p>

    {{-- Tableau des examens --}}
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
                </tr>
        </thead>
        <tbody>
            @forelse($examens as $examen)
                <tr>
                    <td>{{ $examen->id }}</td>
                    <td>{{ $examen->typeExamen->nom ?? '-' }}</td>
                    <td>{{ $examen->date_examen->format('d-m-Y') }}</td>
                    <td>{{ $examen->matiere->nom ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="w3-center">Aucun examen trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

</x-layout.app>