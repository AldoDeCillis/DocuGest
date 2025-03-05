<!DOCTYPE html>
<html lang="it">

<head>
    @include('partials.head')
</head>

<body class="bg-gray-100 text-gray-900">

    <!-- Hero Section -->
    <section class="relative flex h-screen flex-col items-center justify-center bg-blue-600 px-6 text-center text-white">
        <h1 class="mb-4 text-5xl font-bold">Benvenuto nel Sistema di Gestione Documentale</h1>
        <p class="max-w-2xl text-lg">Ottimizza l’archiviazione e gestione dei documenti aziendali con una piattaforma
            moderna ed efficiente.</p>
        <a class="mt-6 rounded-lg bg-white px-6 py-3 font-semibold text-blue-600 shadow-lg hover:bg-gray-200"
            href="{{ route('dashboard') }}">Accedi alla Dashboard</a>
    </section>

    <!-- Chi Siamo -->
    <section class="bg-white px-6 py-20 text-center">
        <h2 class="mb-6 text-4xl font-bold">Chi Siamo</h2>
        <p class="mx-auto max-w-3xl text-lg">Siamo un team di esperti nello sviluppo software dedicati a fornire
            soluzioni innovative per la gestione documentale. La nostra piattaforma garantisce sicurezza, efficienza e
            facilità d’uso.</p>
    </section>

    <!-- Servizi -->
    <section class="bg-gray-200 px-6 py-20 text-center">
        <h2 class="mb-6 text-4xl font-bold">I Nostri Servizi</h2>
        <div class="flex flex-wrap justify-center gap-8">
            <div class="w-80 rounded-lg bg-white p-6 shadow-lg">
                <h3 class="mb-3 text-xl font-semibold">Gestione Documenti</h3>
                <p>Archivia e organizza i documenti in modo sicuro ed efficiente.</p>
            </div>
            <div class="w-80 rounded-lg bg-white p-6 shadow-lg">
                <h3 class="mb-3 text-xl font-semibold">Ruoli e Permessi</h3>
                <p>Configura ruoli e permessi per controllare l’accesso ai documenti.</p>
            </div>
            <div class="w-80 rounded-lg bg-white p-6 shadow-lg">
                <h3 class="mb-3 text-xl font-semibold">Sicurezza e Backup</h3>
                <p>Protezione avanzata dei dati con backup regolari.</p>
            </div>
        </div>
    </section>

</body>

</html>
