<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\EmployeeDocument;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class EmployeeDocumentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', EmployeeDocument::class);
        $documents = EmployeeDocument::latest()->paginate(10);

        return view('employee-documents.index', compact('documents'));
    }

    public function create()
    {
        $this->authorize('create', EmployeeDocument::class);
        $users = User::all();
        $categories = Category::all();

        return view('employee-documents.create', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'uploaded_file_path' => 'required|string',
        ]);

        EmployeeDocument::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => 'uploads/'.basename($request->uploaded_file_path),
            'expiration_date' => $request->expiration_date,
        ]);

        return redirect()->route('employee-documents.index')->with('success', 'Documento caricato con successo!');
    }

    public function download(EmployeeDocument $employeeDocument)
    {
        $filePath = storage_path('app/private/uploads/'.basename($employeeDocument->file_path));

        if (! file_exists($filePath)) {
            abort(404, 'Il file non esiste: '.$filePath);
        }

        return response()->download($filePath);
    }

    public function update(Request $request, EmployeeDocument $employeeDocument)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx',
        ]);
        $employeeDocument->update($request->all());

        return redirect()->route('employee-documents.index')->with('success', 'Documento aggiornato con successo!');
    }

    public function edit(EmployeeDocument $employeeDocument)
    {
        $this->authorize('update', $employeeDocument);

        return view('employee-documents.edit', compact('employeeDocument'));
    }

    public function destroy(EmployeeDocument $employeeDocument)
    {
        $this->authorize('delete', $employeeDocument);
        $employeeDocument->delete();

        return redirect()->route('employee-documents.index')->with('success', 'Documento eliminato con successo!');
    }
}
