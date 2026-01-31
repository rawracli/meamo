<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\TemplateCategories;
use App\Models\TemplateCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $categories = TemplateCategory::orderBy('name')->get();

        // eager loading supaya tidak N+1 query
        $templates = Template::with('category')
            ->when($request->category, function ($query) use ($request) {
                $query->where('template_category_id', $request->category);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString(); // penting: filter tidak hilang saat paginate

        return view('admin.templates.index', compact('templates', 'categories'));
    }

    public function create()
    {
        $categories = TemplateCategory::orderBy('name')->get();
        return view('admin.templates.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'template_category_id' => 'required|exists:template_categories,id',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $imagePath = $request->file('image')->store('templates', 'public');

        Template::create([
            'name' => $request->name,
            'template_category_id' => $request->template_category_id,
            'image' => $imagePath,
            'description' => $request->description,
            'status' => $request->status ?? true,
        ]);

        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Template berhasil ditambahkan');
    }

    public function destroy(Template $template)
    {
        Storage::disk('public')->delete($template->image);
        $template->delete();

        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Template berhasil dihapus');
    }
}
