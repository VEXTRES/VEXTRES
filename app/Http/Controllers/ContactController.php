<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Rules\InvalidEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = auth()->user()->contacts()->paginate(10);

        return view('contacts.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::notIn([auth()->user()->email]), new InvalidEmail],
        ]);

        $user=User::where('email',Auth::user()->email)->first();

        $contact = Contact::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
            'email' => $request->email,
            'contact_id' => $user->id
        ]);

        session()->flash('flash.banner', 'El contacto se ha creado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('contacts.edit', $contact);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::notIn([auth()->user()->email]), new InvalidEmail($contact->email)],
        ]);

        $user=User::where('email',Auth::user()->email)->first();

        $contact = $contact->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_id' => $user->id
        ]);

        session()->flash('flash.banner', 'El contacto se ha actualizado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        session()->flash('flash.banner', 'El contacto se ha eliminado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('contacts.index');
    }
}
