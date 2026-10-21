<x-layout.app>
@section('title','Modifier Notes')
@section('headerTitle','Modifier les notes étudiant')
@section('headerSub','')

<h3><b>Étudiant</b> : {{ $etudiant->nom }} {{ $etudiant->prenom }}</h3>
<h3>{{ $etudiant->anneeAcademique->nom }} {{ $etudiant->filiere->nom ?? '-' }}</h3>

<form action="{{ route('admin.notes.store') }}" method="POST">
    @csrf

    <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">
    <input type="hidden" name="page" value="{{ request('page') }}">

    <table class="w3-table w3-bordered w3-striped w3-margin-top">
        <thead class="w3-light-grey">
            <tr>
                <th>Matière</th>
                <th>CC</th>
                <th>Final</th>
                <th>Moyenne matière</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matieres as $matiere)
                <tr>
                    <td class="w3-left-align">{{ $matiere['nom'] }}</td>

                    {{-- CC --}}
                    <td class="w3-center">
                        <input type="number" step="0.1" min="0" max="20"
                               name="notes[{{ $matiere['cc_exam_id'] ?? 'new_cc_'.$matiere['id'] }}]"
                               value="{{ old('notes.'.($matiere['cc_exam_id'] ?? 'new_cc_'.$matiere['id']), $matiere['cc'] ?? '') }}"
                               class="w3-input w3-border w3-center"
                               placeholder="--">
                    </td>

                    {{-- Final --}}
                    <td class="w3-center">
                        <input type="number" step="0.1" min="0" max="20"
                               name="notes[{{ $matiere['final_exam_id'] ?? 'new_final_'.$matiere['id'] }}]"
                               value="{{ old('notes.'.($matiere['final_exam_id'] ?? 'new_final_'.$matiere['id']), $matiere['final'] ?? '') }}"
                               class="w3-input w3-border w3-center"
                               placeholder="--">
                    </td>

                    {{-- Moyenne matière --}}
                    <td class="w3-center w3-text-red">
                        <b>
                            {{ isset($matiere['cc'],$matiere['final']) ? round(($matiere['cc'] + $matiere['final'])/2, 2) : '-' }}
                        </b>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="w3-margin-top">
        <button type="submit" class="w3-button w3-red w3-round w3-hover-light-red">💾 Enregistrer</button>
        <button type="button" onclick="window.location='{{ route('admin.etudiants.bulletin', [$etudiant->id, 'page' => request('page')]) }}'"
                class="w3-button w3-gray w3-round w3-hover-light-gray">↩️ Retour</button>
    </p>
</form>
</x-layout.app>
