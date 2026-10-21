<x-layout.app>
    @section('title','Etudiant Bulletin')
    @section('headerTitle','Etudiant Bulletin')
    @section('headerSub','Bulletin étudiant')

    @if(session('examens_inexistants'))
        <div class="w3-panel w3-yellow w3-round">
            <h4>⚠️ Examens inexistants</h4>
            <ul class="w3-ul">
                @foreach(session('examens_inexistants') as $item)
                    <li>
                        ❌ <strong>{{ $item['type'] }}</strong> — 
                        Matière : <strong>{{ $item['matiere'] }}</strong>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

<x-bulletins.bulletin :etudiant="$etudiant" :bulletin="$bulletin" :matieres="$matieres" />

<br/>

<div class="w3-margin-bottom">
    <a href="{{ route('admin.notes.formulaire', [$etudiant->id, 'page' => request('page')]) }}"
        class="w3-button w3-blue w3-small w3-round w3-hover-light-blue">✏️ Modifier</a>
    <button onclick="window.print()" class="w3-button w3-green w3-round w3-small w3-hover-light-green">
        🖨️ Imprimer
    </button>
    <button onclick="window.location='{{ route('admin.etudiants.index', ['page' => request('page')]) }}'" 
            class="w3-button w3-gray w3-round w3-small w3-hover-light-gray">
        🔙 Retour Liste
    </button>
    <button onclick="window.location='{{ route('admin.etudiants.show', [$etudiant->id, 'page' => request('page')]) }}'" 
            class="w3-button w3-gray w3-round w3-small w3-hover-light-gray">
        🔙 Retour Fiche
    </button>
    <a href="{{ route('admin.etudiants.bulletins-anciens', [$etudiant->id, 'page' => request('page')]) }}"
           class="w3-button w3-green w3-small w3-round">📝 Anciens Bulletin</a>
</div>

</x-layout.app>