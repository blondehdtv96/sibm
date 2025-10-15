<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Competency;
use Illuminate\Http\Request;

class CompetencyController extends Controller
{
    /**
     * Display a listing of active competencies.
     */
    public function index(Request $request)
    {
        $query = Competency::active()->ordered();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $competencies = $query->get();

        return view('public.competencies.index', compact('competencies'));
    }

    /**
     * Display the specified competency program.
     */
    public function show(Competency $competency)
    {
        // Only show active competencies
        if (!$competency->isActive()) {
            abort(404);
        }

        // Get other active competencies for navigation
        $otherCompetencies = Competency::active()
            ->ordered()
            ->where('id', '!=', $competency->id)
            ->take(3)
            ->get();

        return view('public.competencies.show', compact('competency', 'otherCompetencies'));
    }
}
