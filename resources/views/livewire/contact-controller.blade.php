<div x-data="{openCreate:false,
openEdit:false
}"

>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Contactos
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-end mb-4">
            <x-button x-on:click="openCreate=true">
                <span>Agregar contacto</span>
            </x-button>
        </div>

        @if ($contacts->count())


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    NOMBRE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    EMAIL
                                </th>
                                <th scope="col" class="px-6 py-3">

                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($contacts as $contact)
                            <tr wire:key="contact-{{ $contact->id }}" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap ">
                                    {{ $contact->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $contact->email }}
                                </td>
                                <td class="px-2 py-4">
                                    <div class="flex space-x-2 gap-3">
                                        <x-button x-on:click="openEdit=true" wire:click='edit({{$contact->id}})' >Edit</x-button>
                                        <x-button wire:click='delete({{$contact->id}})' >Borrar</x-button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

        @else
            <div class="flex w-full mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-center w-12 bg-blue-500">
                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z" />
                    </svg>
                </div>
                <div class="px-4 py-2 -mx-3">
                    <div class="mx-3">
                        <span class="font-semibold text-blue-500 dark:text-blue-400">upss</span>
                        <p class="text-sm text-gray-600 dark:text-gray-200">No tiene Contactos</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

<div x-show="openCreate"
    class="bg-gray-800 bg-opacity-25 fixed inset-0">
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <!-- Contenedor con flex para alinear el título y el botón -->
                <div class="flex justify-between items-center mb-4">
                    <x-label class="text-lg font-semibold">
                        Nombre del contacto
                    </x-label>
                    <x-button x-on:click="openCreate=false" class="bg-blue-500 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2">
                        Cerrar
                    </x-button>
                </div>

                @if (session()->has('message'))
                    <div class="mb-4 text-green-600">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="create">
                    <x-input
                        class="w-full mb-4"
                        placeholder="Ingrese el nombre del contacto"
                        wire:model="name"
                        required>
                    </x-input>

                    @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

                    <x-label class="mb-1 pt-3 pb-3">
                        Correo Electrónico
                    </x-label>
                    <x-input
                        class="w-full"
                        placeholder="Ingrese el correo electrónico del contacto"
                        wire:model="email"
                        required>
                    </x-input>

                    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror

                    <div class="pt-3">
                        <x-danger-button x-on:click="openCreate=false" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2">
                            Cancelar
                        </x-danger-button>
                        <x-button class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2">
                            Guardar
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div x-show="openEdit"
    class="bg-gray-800 bg-opacity-25 fixed inset-0">
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                <!-- Contenedor con flex para alinear el título y el botón -->
                <div class="flex justify-between items-center mb-4">
                    <x-label class="text-lg font-semibold">
                        Nombre del contacto
                    </x-label>
                    <x-button x-on:click="openEdit=false" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2">
                        Cerrar
                    </x-button>
                </div>

                @if (session()->has('message'))
                    <div class="mb-4 text-green-600">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="update">
                    <x-input
                        class="w-full mb-4"
                        placeholder="Ingrese el nombre del contacto"
                        wire:model="contactEdit.name"
                        required>
                    </x-input>

                    @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

                    <x-label class="mb-1 pt-3 pb-3">
                        Correo Electrónico
                    </x-label>
                    <x-input
                        class="w-full"
                        placeholder="Ingrese el correo electrónico del contacto"
                        wire:model="contactEdit.email"
                        required>
                    </x-input>

                    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror

                    <div class="pt-3">
                        <x-danger-button x-on:click="openEdit=false" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2">
                            Cancelar
                        </x-danger-button>
                        <x-button class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2">
                            Guardar
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
