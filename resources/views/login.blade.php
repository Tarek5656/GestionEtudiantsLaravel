<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- Tailwind CSS CDN pour style rapide -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-red-600">Connexion</h1>

        <x-alert />

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" id="email" list="emails-list" 
                       value="{{ old('email') }}" 
                       class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                       required>
                <datalist id="emails-list"></datalist>
            </div>

            <div>
                <label for="password" class="block mb-1 font-medium">Mot de passe</label>
                <input type="password" name="password" id="password" 
                       class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                       required>
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors">
                    Se connecter
                </button>
            </div>
        </form>

        <div class="mt-4 text-sm text-center text-gray-500">
            &copy; 2026 ISGA
        </div>
    </div>

<script>
    const emailInput = document.getElementById('email');
    const dataList = document.getElementById('emails-list');

    // Charger les emails stockés
    const storedEmails = JSON.parse(localStorage.getItem('emails')) || [];

    function refreshDatalist() {
        dataList.innerHTML = '';
        storedEmails.forEach(email => {
            const option = document.createElement('option');
            option.value = email;
            dataList.appendChild(option);
        });
    }

    refreshDatalist();

    // Sauvegarder l'email lors de la soumission
    document.querySelector('form').addEventListener('submit', () => {
        const email = emailInput.value.trim();
        if (email && !storedEmails.includes(email)) {
            storedEmails.push(email);
            localStorage.setItem('emails', JSON.stringify(storedEmails));
        }
    });
</script>

</body>
</html>
