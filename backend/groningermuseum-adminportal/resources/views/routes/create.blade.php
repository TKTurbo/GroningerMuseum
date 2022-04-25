<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $attr['header'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    <form method="POST" action="{{ route('routes.store') }}">
                        @csrf
                        <fieldset class="uk-fieldset">

                            @include('routes.form-components.name')
                            @include('routes.form-components.theme')

                        </fieldset>

                        <button type="submit" class="uk-button uk-button-secondary">{{ $attr['button'] }}</a>    
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>