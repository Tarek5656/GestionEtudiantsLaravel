    {{-- Success --}}
    @if(session('success'))
        <div class="w3-panel w3-green w3-round w3-padding">
            <span class="w3-large">✔</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Error --}}
    @if(session('error'))
        <div class="w3-panel w3-red w3-round w3-padding">
            <span class="w3-large">✖</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="w3-panel w3-orange w3-round w3-padding">
            <span class="w3-large">⚠</span>
            <ul class="w3-ul w3-small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
