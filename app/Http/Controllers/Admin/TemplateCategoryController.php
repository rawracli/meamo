<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemplateCategory;
use Illuminate\Http\Request;

class TemplateCategoryController extends Controller
{
    public function index()
    {
        $categories = TemplateCategory::orderBy('name')->paginate(10);
        return view('admin.templates.template_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.templates.template_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:template_categories,name',
        ]);

        TemplateCategory::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.template-categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(TemplateCategory $templateCategory)
    {
        return view(
            'admin.templates.template_categories.edit',
            compact('templateCategory')
        );
    }

    public function update(Request $request, TemplateCategory $templateCategory)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:template_categories,name,' . $templateCategory->id,
        ]);

        $templateCategory->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.template-categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(TemplateCategory $templateCategory)
    {
        $templateCategory->delete();

        return redirect()
            ->route('admin.template-categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
