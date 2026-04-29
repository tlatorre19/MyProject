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
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'date'          => 'required|date',
            'type'          => 'required|string',
            'reporter_name' => 'required|string|max:255',
            'contact_no'    => 'required|string|max:20',
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
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'date'          => 'required|date',
            'type'          => 'required|string',
            'status'        => 'required|string',
            'reporter_name' => 'required|string|max:255',
            'contact_no'    => 'required|string|max:20',
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