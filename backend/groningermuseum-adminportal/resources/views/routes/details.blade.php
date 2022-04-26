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

                   <p>Auteur: {{$selected_route->user->name}}</p>
                   <p>Thema: <a href="#">{{$selected_route->theme->name}}</a></p>
                   <p>Gecreeerd op: {{$selected_route->created_at}}<br>Laatst geupdated op: {{$selected_route->updated_at}}</p>

                   <hr>

                    <a href="#" class="uk-button uk-button-secondary">Route aanpassen</a>

                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

               <p>Er zijn nog geen subroutes gemaakt... 
                <hr>
                <a href="#">Klik hier om subroutes aan te maken</a>
                </p>

            </div>
        </div>
    </div>

</x-app-layout>