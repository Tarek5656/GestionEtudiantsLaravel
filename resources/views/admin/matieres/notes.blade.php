<x-layout.app>
    @section('title','Notes Matiere')
    @section('headerTitle','Notes Matiere')
    @section('headerSub','Liste des notes de la matiere par étudiant')

    <p>
        <b>Nombre d'étudiants :</b> {{ $notesAll }}
    </p>

<form method="GET" class="w3-margin-bottom w3-card w3-padding w3-light-grey w3-round-large">
    <div class="w3-row-padding w3-margin-bottom">
        {{-- CC --}}
        <div class="w3-col m2 s6">
            <label>CC Min</label>
            <input type="number" step="0.1" name="cc_min" class="w3-input w3-border w3-round w3-light-grey"
                placeholder="CC min" value="{{ request('cc_min') }}">
        </div>
        <div class="w3-col m2 s6">
            <label>CC Max</label>
            <input type="number" step="0.1" name="cc_max" class="w3-input w3-border w3-round w3-light-grey"
                placeholder="CC max" value="{{ request('cc_max') }}">
        </div>

        {{-- Final --}}
        <div class="w3-col m2 s6">
            <label>Final Min</label>
            <input type="number" step="0.1" name="final_min" class="w3-input w3-border w3-round w3-light-grey"
                placeholder="Final min" value="{{ request('final_min') }}">
        </div>
        <div class="w3-col m2 s6">
            <label>Final Max</label>
            <input type="number" step="0.1" name="final_max" class="w3-input w3-border w3-round w3-light-grey"
                placeholder="Final max" value="{{ request('final_max') }}">
        </div>

        {{-- Moyenne --}}
        <div class="w3-col m2 s6">
            <label>Moyenne Min</label>
            <input type="number" step="0.1" name="moyenne_min" class="w3-input w3-border w3-round w3-light-grey"
                placeholder="Moyenne min" value="{{ request('moyenne_min') }}">
        </div>
        <div class="w3-col m2 s6">
            <label>Moyenne Max</label>
            <input type="number" step="0.1" name="moyenne_max" class="w3-input w3-border w3-round w3-light-grey"
                placeholder="Moyenne max" value="{{ request('moyenne_max') }}">
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
                    <a href="{{ route('admin.matieres.notes', ['matiere' => $matiere->id, 'page' => request('page')]) }}" class="w3-button w3-gray w3-round w3-block">
                        🔄 
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</form>

<div id="print-area" class="w3-container w3-card w3-white w3-padding">

    <p>
        <b>Matière :</b> {{ $matiere->nom }} <br/>
        {{ $matiere->anneeAcademique->nom }} {{ $matiere->filiere->nom }}
    </p>

    <table class="w3-table w3-bordered w3-striped w3-margin-top w3-small">
        <thead class="w3-light-grey">
            <tr>
                <th class="w3-left-align">Étudiant</th>
                <th class="w3-center">CC</th>
                <th class="w3-center">Final</th>
                <th class="w3-center">Moyenne</th>
            </tr>
        </thead>
        <tbody>
            @foreach($examens as $examen)
                <tr>
                    <td class="w3-left-align">{{ $examen['nom'] }} {{ $examen['prenom'] }}</td>
                    <td class="w3-center">{{ $examen['cc'] ?? '-' }}</td>
                    <td class="w3-center">{{ $examen['final'] ?? '-' }}</td>
                    <td class="w3-center">{{ $examen['moyenne'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

<br/>

<div class="w3-margin-bottom">
    <button onclick="window.print()" class="w3-button w3-green w3-round w3-small w3-hover-light-green">
        🖨️ Imprimer
    </button>
    <button onclick="window.location='{{ route('admin.matieres.index', ['page' => request('page')]) }}'" 
            class="w3-button w3-gray w3-round w3-small w3-hover-light-gray">
        🔙 Retour
    </button>
</div>

</x-layout.app>