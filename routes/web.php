<?php

use App\Http\Controllers\ChunkUploadController;
use App\Http\Controllers\EmployeeDocumentController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::resource('employee-documents', EmployeeDocumentController::class);
    Route::get('/employee-documents/{employeeDocument}/download', [EmployeeDocumentController::class, 'download'])
        ->name('employee-documents.download');

    Route::post('/upload-chunk', [ChunkUploadController::class, 'uploadChunk']);
    Route::post('/finalize-upload', [ChunkUploadController::class, 'finalizeUpload']);

    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
