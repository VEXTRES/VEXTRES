<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Contactos
        </h2>
    </x-slot>

    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        <form class="rounded-lg bg-white p-6 shadow" action="{{ route('contacts.update', $contact) }}" method="post">
            @csrf
            @method('PUT')

            <x-validation-errors class="mb-4" />

            <div class="mb-4">
                <x-label for="name" value="Nombre de contacto" />
                <x-input class="mt-1 block w-full" id="name" name="name" type="text" :value="old('name', $contact->name)"
                    required autofocus autocomplete="name" placeholder="Ingresar nombre de contacto" />
            </div>

            <div class="mb-4">
                <x-label for="email" value="Correo electrónico" />
                <x-input class="mt-1 block w-full" id="email" name="email" type="email" :value="old('email', $contact->user->email)"
                    required autofocus autocomplete="name" placeholder="Ingresar correo electrónico" />
            </div>

            <div class="flex justify-end">
                <x-button class="ml-4">
                    Actualizar Contacto
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
