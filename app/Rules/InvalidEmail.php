<?php

namespace App\Rules;

use App\Models\Contact;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class InvalidEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public $email;
    public function __construct($email=null){
        $this->email = $email;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = Contact::where('user_id', auth()->id())
        ->where('email', $value)            //verifica que no haya repetidos los correos
        ->where('email', '!=', $this->email)    //verifica si el email q ya tengo registrado es diferente al que me mandaron
        ->exists();

    if ($exists) {
        $fail('El correo ya se encuentra registrado.');
    }
    }



}
