<div id="print-area" class="w3-container w3-card w3-white w3-padding">

    <p>
        <b>Étudiant :</b> {{ $etudiant->nom }} {{ $etudiant->prenom }} <br/>
        {{ $bulletin->anneeAcademique->nom }} {{ $bulletin->filiere->nom }}
    </p>

    <table class="w3-table w3-bordered w3-striped w3-margin-top w3-small">
    <thead class="w3-light-grey">
        <tr>
            <th class="w3-left-align">Matière</th>
            <th class="w3-center">CC</th>
            <th class="w3-center">Final</th>
            <th class="w3-center">Moyenne matière</th>
            <th class="w3-right-align">Validation</th>
        </tr>
    </thead>
    <tbody>
        @foreach($matieres as $matiere)
            <tr>
                <td class="w3-left-align">{{ $matiere['nom'] }}</td>
                <td class="w3-center">{{ $matiere['cc'] ?? '-' }}</td>
                <td class="w3-center {{ isset($matiere['final']) && $matiere['final'] < 7 ? 'w3-text-red w3-text-bold' : '' }}">
                    {{ $matiere['final'] ?? '-' }}</td>
                <td class="w3-center {{ $matiere['valide'] ? 'w3-text-green' : 'w3-text-red' }}">
                    <b>{{ $matiere['moyenne'] ?? '-' }}</b></td>
                <td class="w3-right-align">
                    @if(isset($matiere['valide']))
                        @if($matiere['valide'])
                        <span class="w3-text-green"><b>Validée ✅</b></span>
                        @else
                        <span class="w3-text-red"><b>Non validée ❌</b></span>
                        @endif
                    @else
                        <span><b> - </b></span>
                    @endif
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="w3-right-align"><b>Moyenne générale</b></td>
            <td class="w3-center {{ ($bulletin->moyenne_generale && $bulletin->valider) ? 'w3-text-green' : 'w3-text-red' }}">
                <b>{{ $bulletin->moyenne_generale }}</b></td>
            <td class="w3-right-align">
                @if($bulletin && $bulletin->valider)
                    <span class="w3-text-green"><b>Validée ✅</b></span>
                @else
                    <span class="w3-text-red"><b>Non validée ❌</b></span>
                @endif
        </tr>
    </tbody>
</table>

</div>