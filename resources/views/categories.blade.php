<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categorieën') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-5 lg:mx-10">
                    <h2 class="text-center text-3xl my-5">Onze Categorieën</h2>
                    @livewire('category-component')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>