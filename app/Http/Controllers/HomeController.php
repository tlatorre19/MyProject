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
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('forms', compact('categories'));
    }

    public function browse(Request $request)
    {
        $query = Item::latest();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $items = $query->get();
        return view('browse', compact('items'));
    }

    public function show($id)
    {
        $item = Item::with('user')->findOrFail($id);
        return view('items.show', compact('item'));
    }

    public function submitClaim(Request $request, $id)
    {
        $request->validate([
            'claim_description' => 'required|string|min:10',
            'color_brand'       => 'nullable|string|max:255',
            'unique_marks'      => 'nullable|string',
            'proof'             => 'nullable|image|max:5120',
        ]);

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
        }

        \App\Models\Claim::create([
            'item_id'           => $id,
            'user_id'           => auth()->id(),
            'claim_description' => $request->claim_description,
            'color_brand'       => $request->color_brand,
            'unique_marks'      => $request->unique_marks,
            'proof'             => $proofPath,
            'status'            => 'Pending',
        ]);

        return redirect()->route('items.show', $id)->with('success', 'Your claim has been submitted successfully!');
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
            'description'   => 'required|string|min:10',
            'date'          => 'required|date|before_or_equal:today',
            'type'          => 'required|in:Lost,Found',
            'reporter_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'contact_no'    => 'required|string|max:20|regex:/^[0-9\+\-\s]+$/',
            'photo'         => 'nullable|image|max:5120',
        ], [
            'name.required'          => 'Item name is required.',
            'description.required'   => 'Description is required.',
            'description.min'        => 'Description must be at least 10 characters.',
            'date.required'          => 'Date is required.',
            'date.before_or_equal'   => 'Date cannot be in the future.',
            'type.required'          => 'Please select a type.',
            'reporter_name.required' => 'Reporter name is required.',
            'reporter_name.regex'    => 'Reporter name must contain letters only.',
            'contact_no.required'    => 'Contact number is required.',
            'contact_no.regex'       => 'Contact number must contain numbers only.',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        Item::create([
            'user_id'       => auth()->id() ?? null,
            'name'          => $request->name,
            'description'   => $request->description,
            'date'          => $request->date,
            'type'          => $request->type,
            'status'        => 'Pending',
            'reporter_name' => $request->reporter_name,
            'contact_no'    => $request->contact_no,
            'photo'         => $photoPath,
        ]);

        return redirect()->route('forms')->with('success', 'Item reported successfully.');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required|string|min:10',
            'date'          => 'required|date|before_or_equal:today',
            'type'          => 'required|in:Lost,Found',
            'status'        => 'required|in:Pending,Resolved',
            'reporter_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'contact_no'    => 'required|string|max:20|regex:/^[0-9\+\-\s]+$/',
        ], [
            'name.required'          => 'Item name is required.',
            'description.required'   => 'Description is required.',
            'description.min'        => 'Description must be at least 10 characters.',
            'date.required'          => 'Date is required.',
            'date.before_or_equal'   => 'Date cannot be in the future.',
            'type.required'          => 'Please select a type.',
            'status.required'        => 'Please select a status.',
            'reporter_name.required' => 'Reporter name is required.',
            'reporter_name.regex'    => 'Reporter name must contain letters only.',
            'contact_no.required'    => 'Contact number is required.',
            'contact_no.regex'       => 'Contact number must contain numbers only.',
        ]);

        $item = Item::findOrFail($id);
        $item->update([
            'name'          => $request->name,
            'description'   => $request->description,
            'date'          => $request->date,
            'type'          => $request->type,
            'status'        => $request->status,
            'reporter_name' => $request->reporter_name,
            'contact_no'    => $request->contact_no,
        ]);

        return redirect()->route('admin.items')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.items')->with('success', 'Item deleted successfully.');
    }
}