<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ChunkUploadController extends Controller
{
    public function uploadChunk(Request $request)
    {
        Log::info("Ricevuto chunk {$request->index} di {$request->totalChunks} per il file: {$request->filename}");

        $request->validate([
            'chunk' => 'required|file',
            'index' => 'required|integer',
            'totalChunks' => 'required|integer',
            'filename' => 'required|string',
        ]);

        // Definiamo la cartella temporanea
        $tempPath = storage_path('app/private/temp');
        if (! File::exists($tempPath)) {
            File::makeDirectory($tempPath, 0777, true);
        }

        // Salviamo i chunk con nome coerente
        $chunkFilePath = "{$tempPath}/".basename($request->filename).".part{$request->index}";
        file_put_contents($chunkFilePath, file_get_contents($request->file('chunk')->getRealPath()));

        return response()->json(['success' => true]);
    }

    public function finalizeUpload(Request $request)
    {
        $request->validate(['filename' => 'required|string']);

        // Percorso dei chunk temporanei
        $tempPath = storage_path('app/private/temp');
        $finalPath = storage_path('app/private/uploads');

        if (! File::exists($finalPath)) {
            File::makeDirectory($finalPath, 0777, true);
        }

        $finalFilePath = "$finalPath/".basename($request->filename);
        $chunkFiles = glob("$tempPath/".basename($request->filename).'.part*');

        if (empty($chunkFiles)) {
            Log::error("Chunks mancanti per il file: {$request->filename}");

            return response()->json(['success' => false, 'message' => 'Chunks mancanti'], 400);
        }

        foreach ($chunkFiles as $chunk) {
            file_put_contents($finalFilePath, file_get_contents($chunk), FILE_APPEND);
            unlink($chunk);
        }

        Log::info("File {$request->filename} ricostruito con successo in {$finalFilePath}");

        return response()->json(['success' => true, 'file_path' => 'uploads/'.basename($request->filename)]);
    }
}
