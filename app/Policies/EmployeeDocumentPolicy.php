<?php

namespace App\Policies;

use App\Models\EmployeeDocument;
use App\Models\User;

class EmployeeDocumentPolicy
{
    /**
     * Determina se l'utente può visualizzare qualsiasi documento.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determina se l'utente può visualizzare un documento specifico.
     */
    public function view(User $user, EmployeeDocument $document): bool
    {
        return $user->hasRole('admin') || $user->id === $document->user_id;
    }

    /**
     * Determina se l'utente può creare un nuovo documento.
     */
    public function create(User $user): bool
    {
        return $user->can('create documents');
    }

    /**
     * Determina se l'utente può aggiornare un documento specifico.
     */
    public function update(User $user, EmployeeDocument $document): bool
    {
        return $user->id === $document->user_id && $user->can('edit documents');
    }

    /**
     * Determina se l'utente può eliminare un documento.
     */
    public function delete(User $user, EmployeeDocument $document): bool
    {
        return $user->hasRole('admin') || $user->id === $document->user_id;
    }

    /**
     * Determina se l'utente può scaricare un documento.
     */
    public function download(User $user, EmployeeDocument $document): bool
    {
        return $user->hasRole('admin') || $user->id === $document->user_id;
    }

    /**
     * Determina se l'utente può ripristinare un documento eliminato.
     */
    public function restore(User $user, EmployeeDocument $document): bool
    {
        return $user->id === $document->user_id || $user->hasRole('admin');
    }

    /**
     * Determina se l'utente può eliminare definitivamente un documento.
     */
    public function forceDelete(User $user, EmployeeDocument $document): bool
    {
        return $user->id === $document->user_id || $user->hasRole('admin');
    }
}
