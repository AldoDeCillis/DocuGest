<x-layouts.app>

    <head>
        <meta content="{{ csrf_token() }}" name="csrf-token">
    </head>
    <div class="flex min-h-screen items-center justify-center text-gray-700">
        <div class="w-full max-w-4xl rounded-lg border bg-slate-200 p-6 shadow-lg">
            <h2 class="mb-6 text-center text-2xl font-semibold">Crea Documento Dipendente</h2>

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('employee-documents.store') }}" class="space-y-4" enctype="multipart/form-data"
                method="POST">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700" for="user_id">Utente</label>
                    <select
                        class="mt-1 block w-full rounded-lg border-gray-300 p-2 text-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        id="user_id" name="user_id">
                        <option value="">Seleziona un utente</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700" for="category_id">Categoria</label>
                    <select
                        class="mt-1 block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        id="category_id" name="category_id">
                        <option value="">Seleziona una categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700" for="title">Titolo</label>
                    <input
                        class="mt-1 block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        id="title" name="title" type="text">
                    @error('title')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700" for="description">Descrizione</label>
                    <textarea class="mt-1 block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        id="description" name="description"></textarea>
                    @error('description')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700" for="file">File</label>
                    <input
                        class="mt-1 block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        id="fileInput" type="file">
                    <p id="status"></p>
                </div>

                <!-- Input nascosto per salvare il percorso del file caricato -->
                <input id="uploadedFilePath" name="uploaded_file_path" type="hidden">


                <div>
                    <label class="block text-sm font-medium text-gray-700" for="expiration_date">Data di
                        Scadenza</label>
                    <input
                        class="mt-1 block w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        id="expiration_date" name="expiration_date" type="date">
                    @error('expiration_date')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <button
                    class="w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white shadow-md hover:bg-blue-700"
                    type="submit">
                    Salva
                </button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fileInput = document.getElementById("fileInput");

            if (!fileInput) {
                console.error("Elemento #fileInput non trovato nella pagina!");
                return;
            }

            fileInput.addEventListener("change", async function(event) {
                const file = event.target.files[0];
                if (!file) {
                    console.error("Nessun file selezionato!");
                    return;
                }

                console.log("File selezionato:", file.name, "Dimensione:", file.size);

                const chunkSize = 512 * 1024;
                const totalChunks = Math.ceil(file.size / chunkSize);
                let uploadedChunks = 0;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                    "content");

                document.getElementById("status").innerText = `Caricamento in corso...`;

                for (let i = 0; i < totalChunks; i++) {
                    const start = i * chunkSize;
                    const end = Math.min(start + chunkSize, file.size);
                    const chunk = file.slice(start, end);

                    let formData = new FormData();
                    formData.append("chunk", chunk);
                    formData.append("index", i);
                    formData.append("totalChunks", totalChunks);
                    formData.append("filename", file.name);

                    console.log(`Inviando chunk ${i + 1} di ${totalChunks}`);

                    try {
                        let response = await fetch("/upload-chunk", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken
                            },
                            body: formData
                        });

                        let data = await response.json();

                        if (data.success) {
                            uploadedChunks++;
                            console.log(`Chunk ${i + 1}/${totalChunks} caricato.`);
                            document.getElementById("status").innerText =
                                `Caricato ${uploadedChunks}/${totalChunks}`;
                        } else {
                            console.error("Errore nell'upload del chunk:", data);
                            return;
                        }
                    } catch (error) {
                        console.error("Errore nella richiesta al server:", error);
                        return;
                    }
                }

                console.log("Tutti i chunk inviati. Notifico il server per la finalizzazione...");

                try {
                    let finalizeResponse = await fetch("/finalize-upload", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({
                            filename: file.name
                        })
                    });

                    let finalizeData = await finalizeResponse.json();

                    if (finalizeData.success) {
                        console.log("Upload completato con successo!");
                        document.getElementById("status").innerText = "Upload completato con successo!";

                        // ✅ Imposta il percorso del file caricato nel campo nascosto
                        document.getElementById("uploadedFilePath").value =
                            `/storage/uploads/${file.name}`;
                    } else {
                        console.error("Errore nella finalizzazione:", finalizeData);
                    }
                } catch (error) {
                    console.error("Errore nella richiesta di finalizzazione:", error);
                }

            });
        });
    </script>
</x-layouts.app>
