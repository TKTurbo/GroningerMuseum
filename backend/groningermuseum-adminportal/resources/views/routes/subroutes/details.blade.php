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

                    <div class="uk-child-width-1-2@s uk-grid-match" uk-grid>

                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <h3 class="uk-card-title">{{$subroute->name}}</h3>
                                <p>{{$subroute->description}}</p>
                                <hr>
                                <p>Hieronder kan je de Text-To-Speech voorbeeld beluisteren van deze beschrijving.</p>
                                <audio controls="" style="vertical-align: middle" src="{{asset('media/'.$location)}}" type="audio/mp3" controlslist="nodownload">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </div>

                        @if(!empty($subroute->getMedia()[0]))
                            <div class="uk-child-width-1-2@s uk-grid-match">
                                <img src="{{$subroute->getMedia()[0]->getUrl('thumb')}}" style="width: 250px; height: 500px;" />
                                <a class="uk-button uk-button-secondary" href="#modal-media-image" uk-toggle>Vergote weergave</a>
                            </div>

                        @else
                            <div class="uk-child-width-1-2@s">
                                <img src="https://www.bibliotheekwerk.nl/wp-content/uploads/2016/06/geen_foto_beschikbaar.jpg"
                                     style="width: 250px; height: 500px;"/>
                            </div>
                        @endif

                    </div>
                    @if(!empty($subroute->getMedia()[0]))
                        <div id="modal-media-image" class="uk-flex-top" uk-modal>
                            <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                                <button class="uk-modal-close-outside" type="button" uk-close></button>
                                <img src="{{$subroute->getMedia()[0]->getUrl('thumb')}}" width="1000" height="600" alt="">
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>

</x-app-layout>
