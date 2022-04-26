<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $attr['header'] }}
            <p class="uk-align-right">
                <a href="{{ route('routes.create') }}" class="uk-button uk-button-primary">{{ $attr['button'] }}</a>    
            </p>
        </h2>
    </x-slot>

    <div class="py-12" uk-scrollspy="cls: uk-animation-slide-left; repeat: true">>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="uk-table uk-table-divider">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Route</th>
                                <th>Thema</th>
                                <th>Aangemaakt door</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($routes as $route)
                                <tr>
                                    <td><span class="uk-badge">{{ $route->id }}</span></td>
                                    <td><a href="{{ route('routes.details', [$route_id = $route->id]) }}">{{ $route->name }}</a></td>
                                    <td>{{ $route->theme->name }}</td>
                                    <td>{{ $route->user->name }}</td>
                                    <td>
                                        <a href="" uk-icon="icon: pencil; ratio: 0.8;"></a>
                                        <a href="#" uk-icon="icon: trash; ratio: 0.8;"
                                        uk-toggle="target: #my-id"
                                        ></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- This is a button toggling the modal -->

                    <!-- This is the modal -->
                    <div id="my-id" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <h2 class="uk-modal-title">Let op! Als je een route verwijderd, verwijder je ook alle subroutes!</h2>
                            <a href="{{ route('routes.delete', [$route_id = $route->id ]) }}"
                                class="uk-text-danger" 
                                uk-toggle="target: #my-id"
                                onclick="event.preventDefault();
                                document.getElementById('delete-form-{{ $route->id }}').submit();">Ok, ik weet het zeker
                            </a>
                            <button class="uk-modal-close uk-margin-left" type="button">Nee, Anuleer</button>
                        </div>
                    </div>

                    <form id="delete-form-{{ $route->id }}" action="{{ route('routes.delete', ['route_id' => $route->id]) }}"
                        method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>