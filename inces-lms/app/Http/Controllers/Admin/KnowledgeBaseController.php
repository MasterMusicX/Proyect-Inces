<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeBase;
use Illuminate\Http\Request;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        $entries = KnowledgeBase::when($request->category, fn($q) => $q->where('category', $request->category))
            ->when($request->search, fn($q) => $q->where('question', 'ilike', "%{$request->search}%"))
            ->orderByDesc('views')
            ->paginate(20)
            ->withQueryString();

        $categories = KnowledgeBase::distinct()->pluck('category');
        return view('admin.knowledge-base.index', compact('entries', 'categories'));
    }

    public function create()
    {
        return view('admin.knowledge-base.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category'  => 'required|string|max:50',
            'question'  => 'required|string|max:500',
            'answer'    => 'required|string',
            'tags'      => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        if (!empty($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }
        KnowledgeBase::create($data);
        return redirect()->route('admin.knowledge-base.index')->with('success', 'Entrada añadida a la base de conocimiento.');
    }

    public function edit(KnowledgeBase $knowledgeBase)
    {
        return view('admin.knowledge-base.edit', compact('knowledgeBase'));
    }

    public function update(Request $request, KnowledgeBase $knowledgeBase)
    {
        $data = $request->validate([
            'category'  => 'required|string|max:50',
            'question'  => 'required|string|max:500',
            'answer'    => 'required|string',
            'tags'      => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        if (!empty($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }
        $knowledgeBase->update($data);
        return redirect()->route('admin.knowledge-base.index')->with('success', 'Entrada actualizada.');
    }

    public function destroy(KnowledgeBase $knowledgeBase)
    {
        $knowledgeBase->delete();
        return back()->with('success', 'Entrada eliminada.');
    }
}
