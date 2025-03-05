<x-layouts.app>
    <div class="flex min-h-screen items-center justify-center text-gray-700">
        <div class="w-full max-w-7xl rounded-lg border bg-slate-200 p-6 shadow-lg">
            <h2 class="mb-6 text-center text-2xl font-semibold">Elenco Documenti Dipendenti</h2>

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-end">
                <a class="rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white shadow-md hover:bg-blue-700"
                    href="{{ route('employee-documents.create') }}">
                    Aggiungi Documento
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse rounded-lg bg-white shadow-md">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="border px-4 py-2">Utente</th>
                            <th class="border px-4 py-2">Categoria</th>
                            <th class="border px-4 py-2">Titolo</th>
                            <th class="border px-4 py-2">Scadenza</th>
                            <th class="border px-4 py-2">Azione</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $document)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="border px-4 py-2">{{ $document->user->name }}</td>
                                <td class="border px-4 py-2">{{ $document->category->name }}</td>
                                <td class="border px-4 py-2">{{ $document->title }}</td>
                                <td class="border px-4 py-2">
                                    {{ $document->expiration_date ? $document->expiration_date : '-' }}
                                </td>
                                <td class="flex space-x-2 border px-4 py-2">
                                    <a class="text-blue-600 hover:underline"
                                        href="{{ route('employee-documents.show', $document) }}">Visualizza</a>
                                    <a class="text-green-600 hover:underline"
                                        href="{{ route('employee-documents.edit', $document) }}">Modifica</a>
                                    <form action="{{ route('employee-documents.destroy', $document) }}" method="POST"
                                        onsubmit="return confirm('Sei sicuro di voler eliminare questo documento?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline" type="submit">Elimina</button>
                                    </form>
                                    @can('view', $document)
                                        <a class="btn btn-primary"
                                            href="{{ route('employee-documents.download', $document) }}">Scarica</a>
                                    @else
                                        <span class="text-muted">Accesso negato</span>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
