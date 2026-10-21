<x-layout.app>
    @section('title','Etudiant Anciens Bulletins')
    @section('headerTitle','Etudiant Anciens Bulletins')
    @section('headerSub','Bulletins anciens étudiant')

<form method="GET" class="w3-card w3-padding w3-margin-bottom w3-light-grey w3-round">
    <label><b>Année académique</b></label>
    <select name="annee_academique_id"
            class="w3-select"
            onchange="this.form.submit()">

        <option value="">— Sélectionner une année —</option>

        @foreach($annees as $annee)
            <option value="{{ $annee->id }}"
                {{ $anneeId == $annee->id ? 'selected' : '' }}>
                {{ $annee->nom }}
            </option>
        @endforeach
    </select>
</form>

@if($anneeId)

    @if($bulletin)
        <x-bulletins.bulletin :etudiant="$etudiant" 
        :bulletin="$bulletin" :matieres="$matieres" />
    @else
        <div class="w3-panel w3-yellow w3-round">
            Aucun bulletin disponible pour cette année.
        </div>
    @endif
@endif

<br/>

<div class="w3-margin-bottom">
    <button onclick="window.print()" class="w3-button w3-green w3-round w3-small w3-hover-light-green">
        🖨️ Imprimer
    </button>
    <button onclick="window.location='{{ route('user.profile', $etudiant->id) }}'" 
            class="w3-button w3-blue w3-round w3-small w3-hover-light-blue">
        📝 Profile
    </button>
    <a href="{{ route('user.bulletin', $etudiant->id) }}"
        class="w3-button w3-green w3-small w3-round">📝 Bulletin Actuel</a>
</div>

</x-layout.app>