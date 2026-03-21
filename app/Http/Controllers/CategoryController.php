<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::latest()->get();
        return view('category.categories', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $category = Category::create($request->all());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message'  => 'Category created successfully.',
                    'category' => $category,
                ], 201);
            }

            return redirect()->route('category.index')
                ->with('success', 'Category created successfully.');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to create category. Please try again.',
                ], 500);
            }
            return redirect()->back()
                ->with('error', 'Failed to create category. Please try again.');
        }
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $category->update($request->all());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message'  => 'Category updated successfully.',
                    'category' => $category,
                ]);
            }

            return redirect()->route('category.index')
                ->with('success', 'Category updated successfully.');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to update category. Please try again.',
                ], 500);
            }
            return redirect()->back()
                ->with('error', 'Failed to update category. Please try again.');
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => 'Category deleted successfully.',
                ]);
            }

            return redirect()->route('category.index')
                ->with('success', 'Category deleted successfully.');

        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to delete category. Please try again.',
                ], 500);
            }
            return redirect()->back()
                ->with('error', 'Failed to delete category. Please try again.');
        }
    }
}