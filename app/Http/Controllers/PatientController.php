<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PatientController extends Controller
{
    public function index(Request $request): View
    {
        $term = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', 'all');

        $patients = $this->filteredPatients($term, $status)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(10)
            ->withQueryString();

        return view('patients.index', compact('patients', 'term', 'status'));
    }

    public function export(Request $request): StreamedResponse
    {
        $term = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', 'all');
        $filename = 'patients-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function () use ($term, $status) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Patient ID', 'First name', 'Last name', 'Date of birth', 'Sex', 'Phone', 'Email', 'City', 'Status', 'Last visit']);

            $this->filteredPatients($term, $status)
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->chunkById(250, function ($patients) use ($output) {
                    foreach ($patients as $patient) {
                        fputcsv($output, [
                            $patient->patient_number,
                            $patient->first_name,
                            $patient->last_name,
                            $patient->date_of_birth->format('Y-m-d'),
                            $patient->sex,
                            $patient->phone,
                            $patient->email,
                            $patient->city,
                            $patient->status,
                            $patient->last_visit_at?->format('Y-m-d H:i:s'),
                        ]);
                    }
                });

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function filteredPatients(string $term, string $status)
    {
        return Patient::query()
            ->when($term !== '', function ($query) use ($term) {
                $like = "%{$term}%";

                $query->where(function ($query) use ($like) {
                    $query->where('patient_number', 'like', $like)
                        ->orWhere('first_name', 'like', $like)
                        ->orWhere('last_name', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhere('phone', 'like', $like);
                });
            })
            ->when(in_array($status, ['active', 'inactive'], true), fn ($query) => $query->where('status', $status));
    }
}
