<?php

namespace App\Http\Controllers;

use App\Services\CourseraService;

class CourseController extends Controller
{
    protected $courseraService;

    public function __construct(CourseraService $courseraService)
    {
        $this->courseraService = $courseraService;
    }

    public function index()
    {
        // Fetch courses from Coursera
        $courses = $this->courseraService->getCourses();

                // Pass the courses data to the view
        return view('courses.index', compact('courses'));

    }
}
