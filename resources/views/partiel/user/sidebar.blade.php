@php
    $etudiant = auth()->user()->etudiant;
@endphp

<nav class="w3-sidebar w3-blue w3-top w3-large w3-padding"
     style="z-index:3;width:260px;height:100%;font-weight:bold">

    <div class="w3-container">
        <h3 class="w3-padding-64"><b>Espace Etudiant</b></h3>
    </div>

    <!-- NAV LINKS -->
    <div class="w3-bar-block">
        <a href="{{ route('user.profile', $etudiant->id) }}"
           class="w3-bar-item w3-button w3-hover-white">
            Profile
        </a>

        <a href="{{ route('user.bulletin', $etudiant->id) }}"
           class="w3-bar-item w3-button w3-hover-white">
            Bulletin
        </a>

        <a href="{{ route('user.matieres', $etudiant->id) }}"
           class="w3-bar-item w3-button w3-hover-white">
            Matières
        </a>

        <a href="{{ route('user.examens', $etudiant->id) }}"
           class="w3-bar-item w3-button w3-hover-white">
            Examens
        </a>
    </div>

    <!-- USER MENU (BOTTOM) -->
    <div style="position:absolute;bottom:20px;left:0;width:100%"
         class="w3-padding">

        <div class="w3-dropdown-hover w3-block dropdown-up">

            <button class="w3-button w3-white w3-round w3-block w3-left-align">
                👤 {{ auth()->user()->name }}
            </button>

            <div class="w3-dropdown-content w3-bar-block w3-card">
                <a href="javascript:void(0)" onclick="openSettingsModal()"
                   class="w3-bar-item w3-button">
                    ⚙️ Paramètres
                </a>
            @include('partiel.profileParametres')

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w3-bar-item w3-button w3-text-red">
                        🚪 Logout
                    </button>
                </form>
            </div>

        </div>
    </div>

</nav>
