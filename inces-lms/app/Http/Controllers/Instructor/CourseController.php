<?php
namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())
            ->withCount(['enrollments', 'modules', 'resources'])
            ->latest()
            ->paginate(12);
        return view('instructor.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $this->authorize('view', $course);
        $course->load(['modules.resources', 'category']);
        $stats = [
            'students'  => $course->enrollments()->count(),
            'modules'   => $course->modules()->count(),
            'resources' => $course->resources()->count(),
            'completed' => $course->enrollments()->where('status', 'completed')->count(),
        ];
        $students = $course->students()->latest('enrollments.created_at')->limit(10)->get();
        return view('instructor.courses.show', compact('course', 'stats', 'students'));
    }

    public function students(Course $course)
    {
        $this->authorize('view', $course);
        $students = $course->students()
            ->withPivot('status', 'progress_percentage', 'completed_at', 'created_at')
            ->orderByPivot('created_at', 'desc')
            ->paginate(20);
        return view('instructor.courses.students', compact('course', 'students'));
    }

    public function modules(Course $course)
    {
        $this->authorize('view', $course);
        $modules = $course->modules()->withCount('resources')->orderBy('order')->get();
        return view('instructor.courses.modules', compact('course', 'modules'));
    }

    public function storeModule(Request $request, Course $course)
    {
        $this->authorize('update', $course);
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'is_published' => 'boolean',
        ]);
        $data['course_id'] = $course->id;
        $data['order']     = $course->modules()->max('order') + 1;
        Module::create($data);
        return back()->with('success', 'Módulo creado.');
    }

    public function destroyModule(Course $course, Module $module)
    {
        $this->authorize('update', $course);
        $module->delete();
        return back()->with('success', 'Módulo eliminado.');
    }
}
