<?php

namespace App\Livewire;

use App\Models\Contact;
use App\Models\User;
use App\Rules\InvalidEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule as ValidationRule;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ContactController extends Component
{

    // -------------Variables
    public $contacts;
    public $name,$email;
    public $cerrar;

    public $contactEdit=[
        'name' => '',
        'email' => '',
        'id' => '',
    ];


    public function mount()
    {
        // Obteniendo los datos de la base de datos
        $this->contacts = Contact::all();
    }
    public function render()
    { 
        return view('livewire.contact-controller');
    }

    public function create(){
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                ValidationRule::notIn([auth()->user()->email]),
                new InvalidEmail
            ],
        ]);

        $user=User::where('email',Auth::user()->email)->first();
        
        $contact=Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'user_id' => auth()->id(),
            'contact_id' => $user->id,
        ]);
        $this->reset(['name','email']);
        session()->flash('message', 'Contacto creado correctamente');
        $this->contacts = Contact::all();
    }

    
    public function edit($contactId){
        $contact=Contact::find($contactId);
        $this->contactEdit=[
            'name' => $contact->name,
            'email' => $contact->email,
            'id' => $contactId,
        ];
    }

    public function update(){
        $this->validate([
            'contactEdit.name' => 'required|string|max:255',
            'contactEdit.email' => [
               'required',
                'email',
               'max:255',
                ValidationRule::notIn([auth()->user()->email]), //valida q no sea el mismo email del que anda loggeado
                new InvalidEmail($this->contactEdit['email']),
            ],
        ]);
        $user=User::where('email',Auth::user()->email)->first();

        $contact = Contact::find($this->contactEdit['id']);
        if ($contact) {
            $contact->update([
                'name' => $this->contactEdit['name'],
                'email' => $this->contactEdit['email'],
                'contact_id' => $user->id,
            ]);
    
        } 
        $this->reset(['name','email']);
        session()->flash('message', 'Contacto Actualizado correctamente');
        $this->contacts = Contact::all();
    }
    public function delete($contactId){
        $contact = Contact::find($contactId);
        if ($contact) {
            $contact->delete();
        }
        $this->contacts = Contact::all();
        session()->flash('message', 'Contacto Eliminado correctamente');
    }
}
