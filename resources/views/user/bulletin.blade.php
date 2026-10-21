<x-layout.app>
    @section('title','Etudiant Bulletin')
    @section('headerTitle','Etudiant Bulletin')
    @section('headerSub','Bulletin étudiant')

<x-bulletins.bulletin :etudiant="$etudiant" :bulletin="$bulletin" :matieres="$matieres" />

<br/>

<div class="w3-margin-bottom">
    <button onclick="window.print()" class="w3-button w3-green w3-round w3-small w3-hover-light-green">
        🖨️ Imprimer
    </button>
    <button onclick="window.location='{{ route('user.profile', $etudiant->id) }}'" 
            class="w3-button w3-blue w3-round w3-small w3-hover-light-blue">
        📝 Profile
    </button>
    <a href="{{ route('user.bulletins-anciens', $etudiant->id) }}"
           class="w3-button w3-green w3-small w3-round">📝 Anciens Bulletins</a>
</div>

</x-layout.app>