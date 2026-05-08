<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::latest()->get();
        return view('forms', compact('forms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'description'   => 'required|min:10',
            'date'          => 'required|date',
            'type'          => 'required',
            'reporter_name' => 'required',
            'contact_no'    => 'required',
            'photo'         => 'nullable|image|max:5120',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        Form::create([
            'name'          => $request->name,
            'description'   => $request->description,
            'date'          => $request->date,
            'type'          => $request->type,
            'reporter_name' => $request->reporter_name,
            'contact_no'    => $request->contact_no,
            'photo'         => $photoPath,
        ]);

        return redirect()->route('forms.index')->with('success', 'Item reported successfully!');
    }
}