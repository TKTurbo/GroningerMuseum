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

                  <p>{{$subroute->name}}</p>

                    <img src="">

                   <hr>

                    <a href="#" class="uk-button uk-button-secondary">Subroute aanpassen</a>

                </div>
            </div>
        </div>
    </div>


    <div class="uk-container uk-margin-top"></div>

</x-app-layout>