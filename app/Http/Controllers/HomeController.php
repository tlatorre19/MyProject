<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function home()
    {
        return view('home');
    }

    public function charts()
    {
        return view('charts.charts');
    }

    public function iconmenu()
    {
        return view('icon-menu');
    }

    public function forms()
    {
        return view('forms');
    }

    public function adminItems()
    {
        $items = Item::latest()->get();
        return view('admin.items', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\-]+$/',
            'description'   => 'required|string|min:10',
            'date'          => 'required|date|before_or_equal:today',
            'type'          => 'required|in:Lost,Found',
            'reporter_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'contact_no'    => 'required|string|max:20|regex:/^[0-9\+\-\s]+$/',
        ], [
            'name.required'          => 'Item name is required.',
            'name.regex'             => 'Item name can only contain letters, numbers, spaces and dashes.',
            'description.required'   => 'Description is required.',
            'description.min'        => 'Description must be at least 10 characters.',
            'date.required'          => 'Date is required.',
            'date.before_or_equal'   => 'Date cannot be in the future.',
            'type.required'          => 'Please select a type.',
            'type.in'                => 'Type must be Lost or Found.',
            'reporter_name.required' => 'Reporter name is required.',
            'reporter_name.regex'    => 'Reporter name can only contain letters and spaces.',
            'contact_no.required'    => 'Contact number is required.',
            'contact_no.regex'       => 'Contact number can only contain numbers.',
        ]);

        try {
            $item = Item::create([
                'user_id'       => auth()->id(),
                'name'          => $request->name,
                'description'   => $request->description,
                'date'          => $request->date,
                'type'          => $request->type,
                'status'        => 'Pending',
                'reporter_name' => $request->reporter_name,
                'contact_no'    => $request->contact_no,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Item reported successfully.',
                    'item'    => $item,
                ], 201);
            }

            return redirect()->route('forms')->with('success', 'Item reported successfully.');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to report item. Please try again.',
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to report item. Please try again.');
        }
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name'          => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\-]+$/',
            'description'   => 'required|string|min:10',
            'date'          => 'required|date|before_or_equal:today',
            'type'          => 'required|in:Lost,Found',
            'status'        => 'required|string',
            'reporter_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'contact_no'    => 'required|string|max:20|regex:/^[0-9\+\-\s]+$/',
        ], [
            'name.required'          => 'Item name is required.',
            'name.regex'             => 'Item name can only contain letters, numbers, spaces and dashes.',
            'description.required'   => 'Description is required.',
            'description.min'        => 'Description must be at least 10 characters.',
            'date.required'          => 'Date is required.',
            'date.before_or_equal'   => 'Date cannot be in the future.',
            'type.required'          => 'Please select a type.',
            'type.in'                => 'Type must be Lost or Found.',
            'reporter_name.required' => 'Reporter name is required.',
            'reporter_name.regex'    => 'Reporter name can only contain letters and spaces.',
            'contact_no.required'    => 'Contact number is required.',
            'contact_no.regex'       => 'Contact number can only contain numbers.',
        ]);

        try {
            $item->update($request->all());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Item updated successfully.',
                    'item'    => $item,
                ]);
            }

            return redirect()->route('forms')->with('success', 'Item updated successfully.');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to update item. Please try again.',
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to update item. Please try again.');
        }
    }

    public function destroy(Item $item)
    {
        try {
            $item->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => 'Item deleted successfully.',
                ]);
            }

            return redirect()->route('forms')->with('success', 'Item deleted successfully.');

        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to delete item. Please try again.',
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to delete item. Please try again.');
        }
    }
}