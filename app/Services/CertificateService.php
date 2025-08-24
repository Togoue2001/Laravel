<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    /**
     * Émet un certificat si l'utilisateur a terminé toutes les leçons du cours
     */
    public function issueIfEligible(int $userId, Course $course): ?Certificate
    {
        $user = \App\Models\User::findOrFail($userId);

        $totalLessons = $course->lessons()->count();
        $completedLessons = $user->lessons()->where('course_id', $course->id)->count();

        if ($totalLessons === 0 || $completedLessons < $totalLessons) {
            return null; // pas éligible
        }

        // Vérifier si le certificat existe déjà
        $certificate = Certificate::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if ($certificate) {
            return $certificate; // déjà généré
        }

        // Générer le PDF
        $issuedAt = now();
        $code = strtoupper(substr(sha1($userId . $course->id . $issuedAt), 0, 10));

        $pdf = PDF::loadView('student.certificates.certificate', [
            'user' => $user,
            'course' => $course,
            'issuedAt' => $issuedAt,
            'code' => $code
        ]);

        $fileName = "certificates/{$user->id}_{$course->id}.pdf";

        Storage::disk('public')->put($fileName, $pdf->output());

        // Sauvegarder en DB
        $certificate = Certificate::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'file_path' => $fileName,
        ]);

        return $certificate;
    }
}
