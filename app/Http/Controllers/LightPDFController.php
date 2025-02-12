<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LightPDFController extends Controller
{
    private $apiKey;
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiKey = env('LIGHTPDF_API_KEY');
        $this->apiBaseUrl = env('LIGHTPDF_API_BASE_URL');
    }

    public function showForm()
    {
        return view('lightpdf.upload');
    }

    public function uploadAndProcess(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:20480',
        ]);

        $file = $request->file('file');

        $response = Http::attach('file', file_get_contents($file), $file->getClientOriginalName())
            ->withHeaders(['X-API-KEY' => $this->apiKey])
            ->post("{$this->apiBaseUrl}/tasks/document/conversion", [
                'format' => 'doc-repair'
            ]);

        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to create task. Please try again.']);
        }

        $taskData = $response->json();
        $taskId = $taskData['data']['task_id'] ?? null;

        if (!$taskId) {
            return back()->withErrors(['error' => 'Invalid task response.']);
        }

        $result = $this->queryTaskResult($taskId);

        if (isset($result['error'])) {
            return back()->withErrors(['error' => $result['error']]);
        }

        return view('lightpdf.success', [
            'downloadLink' => $result['file'],
            'fileName' => $file->getClientOriginalName()
        ]);
    }

    private function queryTaskResult($taskId)
    {
        $maxAttempts = 30;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            $response = Http::withHeaders(['X-API-KEY' => $this->apiKey])
                ->get("{$this->apiBaseUrl}/tasks/document/conversion/{$taskId}");

            if ($response->failed()) {
                return ['error' => 'Failed to fetch task status.'];
            }

            $resultData = $response->json();
            $state = $resultData['data']['state'] ?? null;

            if ($state === 1) {
                return [
                    'file' => $resultData['data']['file']
                ];
            } elseif ($state === -1) {
                return ['error' => 'The file processing failed.'];
            }

            sleep(1);
            $attempt++;
        }

        return ['error' => 'File processing timed out. Please try again.'];
    }
}
