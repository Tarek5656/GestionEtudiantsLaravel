<x-layout.app>
@section('title','Dashboard')
@section('headerTitle','Dashboard')
@section('headerSub','Statistiques générales')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- FILTRE --}}
<form method="GET" class="w3-margin-bottom">
    <select name="annee_academique_id" class="w3-select w3-border w3-round" onchange="this.form.submit()">
        <option value="">Toutes les années</option>
        @foreach($annees as $annee)
            <option value="{{ $annee->id }}" {{ request('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                {{ $annee->nom }}
            </option>
        @endforeach
    </select>
</form>

{{-- CARTES STATISTIQUES --}}
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-col m3 s6">
        <div class="w3-card w3-padding w3-center">
            <h2>{{ $totalEtudiants }}</h2>
            <p>Total Étudiants</p>
        </div>
    </div>

    <div class="w3-col m3 s6">
        <div class="w3-card w3-padding w3-center w3-green">
            <h2>{{ $valides }}</h2>
            <p>Validés</p>
        </div>
    </div>

    <div class="w3-col m3 s6">
        <div class="w3-card w3-padding w3-center w3-red">
            <h2>{{ $nonValides }}</h2>
            <p>Non Validés</p>
        </div>
    </div>

    <div class="w3-col m3 s6">
        <div class="w3-card w3-padding w3-center w3-blue">
            <h2>{{ $moyenneGlobale ?? '—' }}</h2>
            <p>Moyenne Générale</p>
        </div>
    </div>
</div>

{{-- GRAPHIQUES --}}
<div class="w3-row-padding">

    <div class="w3-col m6">
        <div class="w3-card w3-padding">
            <h4>Validation des étudiants</h4>
            <canvas id="validationChart"></canvas>
        </div>
    </div>

    <div class="w3-col m6">
        <div class="w3-card w3-padding">
            <h4>Réussite par filière</h4>
            @if($statsFilieres->count())
                <canvas id="filiereChart" style="max-width:535px;height:535px"></canvas>
            @else
                <p class="w3-text-grey">Aucune donnée disponible pour cette année.</p>
            @endif
        </div>
    </div>

</div>

{{-- Taux de réussite par sexe --}}

<div class="w3-card w3-padding w3-margin-top">
    <h4>Taux de réussite par sexe</h4>
    <canvas id="sexeChart"></canvas>
</div>


{{-- MATIÈRES DIFFICILES --}}
<div class="w3-card w3-padding w3-margin-top">
    <h4>Matières difficiles (moyenne < 10)</h4>
    <ul class="w3-ul">
        @forelse($matieresDifficiles as $m)
            <li>{{ $m['nom'] }} — moyenne {{ $m['moyenne'] }}</li>
        @empty
            <li>Aucune matière critique</li>
        @endforelse
    </ul>
</div>

{{-- SCRIPTS --}}
<script>
    // Diagramme Validation
    new Chart(document.getElementById('validationChart'), {
        type: 'doughnut',
        data: {
            labels: ['Validés', 'Non validés'],
            datasets: [{
                data: [{{ $valides }}, {{ $nonValides }}],
                backgroundColor: ['#4CAF50', '#F44336']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Diagramme Réussite par filière
    @if($statsFilieres->count())
    new Chart(document.getElementById('filiereChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($statsFilieres->pluck('nom')) !!},
            datasets: [{
                label: 'Taux de réussite (%)',
                data: {!! json_encode($statsFilieres->pluck('taux')) !!},
                backgroundColor: '#2196F3'
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: false, // pour respecter les dimensions CSS
            maintainAspectRatio: false,
            scales: {
                x: { beginAtZero: true, max: 100 },
                y: { ticks: { autoSkip: false } }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
    @endif
</script>
<script>
const statsSexes = @json($statsSexes->values());

new Chart(document.getElementById('sexeChart'), {
    type: 'bar',
    data: {
        labels: statsSexes.map(s => s.sexe),
        datasets: [{
            label: 'Taux de réussite (%)',
            data: statsSexes.map(s => s.taux),
            backgroundColor: ['#FF4081', '#2196F3']
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>

</x-layout.app>
