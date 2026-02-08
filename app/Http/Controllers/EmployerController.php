<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    //

    protected $employer;

    public function __construct(Employer $employer)
    {
        $this->employer = $employer;
    }

    public function index()
    {
        $userId = Auth()->user()->id;
        // $user = Auth()->user();

        return inertia('employer/Index', [
            'jobOpenings' => $this->employer->getJobOpenings($userId),
            // 'user' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $userId = Auth()->user()->id;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $this->employer->storeJobOpening($userId, $validated);

        return redirect()->route('employer.index')->with('success', 'Jobs created successfully');
    }
}
