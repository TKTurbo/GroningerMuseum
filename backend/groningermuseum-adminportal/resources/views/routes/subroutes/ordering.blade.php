<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $attr['header'] }}
            <p class="uk-align-right">

            </p>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <p>Het ordernen van een subroute gaat in volgorde van 1 t/m x.</p>

                    <form method="POST"
                          action="#">
                        @csrf
                        <fieldset class="uk-fieldset">

                            <ul class="uk-grid-small uk-child-width-1-2 uk-child-width-1-4@s" uk-sortable=".uk-sortable-handle" id="sortable" uk-grid>

                                @foreach($subroutes as $key => $subroute)
                                <li id="{{$subroute->order_number}}" name="{{$subroute->name}}">
                                    <div class="uk-card uk-card-default">
                                        <div class="uk-card-media-top">
                                            @if(!empty($subroute->getMedia()[0]))
                                                <img src="{{$subroute->getMedia()[0]->getUrl('thumb')}}"
                                                     style="height: 300px; width: 300px;" alt="">
                                            @else
                                                <img src="https://www.bibliotheekwerk.nl/wp-content/uploads/2016/06/geen_foto_beschikbaar.jpg"
                                                     style="height: 300px; width: 300px;" alt="">
                                            @endif
                                        </div>
                                        <div class="uk-card-title">
                                            <h5 class="uk-text-center">{{$subroute->name}}</h5>
                                        </div>
                                    </div>
                                </li>
                                @endforeach

                            </ul>

                        </fieldset>

                            <input type="hidden" name="new_order" id="new_order" value="">

                            <button type="submit" class="uk-button uk-button-secondary uk-margin-top">{{ $attr['button'] }}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">

     let util = UIkit.util;


        util.on('#sortable', 'moved', function (item) {
            const new_order = event.detail[0].items.map(el => el.id);
            console.log(new_order);
            document.getElementById("new_order").value = new_order;
        });

</script>

</x-app-layout>
