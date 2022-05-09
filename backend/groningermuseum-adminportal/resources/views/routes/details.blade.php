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

                    <a href="{{ route('routes.show.update', [$route_id = $selected_route->id]) }}" class="uk-button uk-button-secondary">Route aanpassen</a>

                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <div uk-icon="icon: info; ratio: 0.75" uk-tooltip="Subroutes zijn de route die een bezoeker neemt punt per punt, een punt (dus een kunststuk) is een subroute. Bij meerdere punten (subroutes) creëer je de volledige route die dan onder een hoofdroute zit."></div> Wat zijn subroutes en waarom zijn deze van belang? Hover over de info icon hier links van de tekst voor verdere informatie.
                    
                <hr class="uk-divider-icon">

                @if(isset($selected_route->subroutes))

                    <table class="uk-table uk-table-divider">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Naam</th>
                                <th>Beschrijving</th>
                                <th>Order</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selected_route->subroutes as $route)
                                <tr>
                                    <td><span class="uk-badge">{{ $route->id }}</span></td>
                                    <td><a href="{{ route('routes.details', [$route_id = $route->id]) }}">{{ $route->name }}</a></td>
                                    <td>{{ $route->description }}</td>
                                    <td>{{ $route->order_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr class="uk-divider-icon">

                    <a href="{{ route('routes.subroutes.create', [$route_id = $selected_route->id]) }}">Klik hier om meer subroutes aan te maken</a>

                @else
                    <p>Er zijn nog geen subroutes gevonden... <br> Om een subroute aan te maken klik hieronder op de link. Vul s.v.p. ook alvast de hoeveelheid subroutes in die gemaakt worden.</p>
                    <a href="{{ route('routes.subroutes.create', [$route_id = $selected_route->id]) }}">Klik hier om subroutes aan te maken</a>
                @endif
            </div>
        </div>
    </div>

    <div class="uk-container uk-margin-top"></div>

</x-app-layout>