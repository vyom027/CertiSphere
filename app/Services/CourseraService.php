<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CourseraService
{
    private $apiKey;
    private $baseUrl = 'https://api.coursera.org/api/courses.v1';

    public function __construct()
    {
        $this->apiKey = config('services.coursera.api_key');
    }

    public function getCourses()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey
        ])->get($this->baseUrl);

        // Check if the response is successful
        if ($response->successful()) {
            return $response->json();
        }

        // Handle errors (optional)
        return [
            'error' => 'Unable to fetch courses from Coursera.',
            'status' => $response->status(),
        ];
    }
}

