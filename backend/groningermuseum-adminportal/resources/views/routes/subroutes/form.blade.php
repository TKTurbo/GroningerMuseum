<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $attr['header'] }}
        </h2>
    </x-slot>


    @if(!isset($attr['upload']))
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                       
                        <form class="uk-grid-small" uk-grid method="POST" action="{{ route('routes.subroutes.store', [$route_id = $route_id]) }}">
                            @csrf

                                <div class="uk-width-1-2@s">

                                    @include('routes.subroutes.form-components.name')
                                    @include('routes.subroutes.form-components.description')
                                    @include('routes.subroutes.form-components.order_number')
                                </div>

                                <div class="uk-width-1-1@s">
                                    <label for="image_check">Klik de checkbox aan als je afbeelding(en) wilt toevoegen: </label>
                                    <input type="checkbox" class="uk-checkbox" id="image_check" name="image_check" value="1">
                                <hr>

                            <button type="#" class="uk-button uk-button-primary">Voeg nog een subroute toe</button>
                            <button type="submit" class="uk-button uk-button-secondary">{{ $attr['button'] }}</a> 
                            </div>   
                        </form>

                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div>Wanneer je succesvol afbeeldingen hebt geupload word je direct doorverwezen naar de volgende pagina</div>
                                @csrf
                                        @include('routes.subroutes.form-components.upload')
                                    <hr>  

                        </div>
                    </div>
                </div>
            </div>
        @endif

</x-app-layout>