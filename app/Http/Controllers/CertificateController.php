<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $certificates = Certificate::where('user_id', $user->id)->get();

        return view('student.certificates.index', compact('certificates'));
    }

public function download(Certificate $certificate)
{
    // Vérifie que le certificat appartient bien à l'utilisateur connecté
    if ($certificate->user_id !== auth()->id()) {
        abort(403, 'Accès refusé : ce certificat ne vous appartient pas.');
    }

    $filePath = storage_path('app/public/' . $certificate->file_path);

    if (!file_exists($filePath)) {
        abort(404, 'Fichier introuvable.');
    }

    return response()->download($filePath, 'certificat-' . $certificate->id . '.pdf');
}

}
