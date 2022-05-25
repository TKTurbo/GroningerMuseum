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

                        <div class="uk-child-width-1-2@s uk-grid-match">
                            <img src="{{$image}}">
                        </div>

                    </div>

                    <div class="uk-child-width-1-2@s uk-visible-toggle uk-flex-right uk-grid-match" uk-grid>

                        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1"
                        uk-slider="sets: false; autoplay: true; autoplay-interval: 4500; pause-on-hover: true;">
                            <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-2@s uk-child-width-1-3@m">
                                <li>
                                    <img src="https://source.unsplash.com/random/200x200?sig=1" alt="">
                                    <div class="uk-position-center uk-panel"><h1>1</h1></div>
                                </li>
                                <li>
                                    <img src="https://source.unsplash.com/random/200x200?sig=2" alt="">
                                    <div class="uk-position-center uk-panel"><h1>2</h1></div>
                                </li>
                                <li>
                                    <img src="https://source.unsplash.com/random/200x200?sig=3" alt="">
                                    <div class="uk-position-center uk-panel"><h1>3</h1></div>
                                </li>
                                <li>
                                    <img src="https://source.unsplash.com/random/200x200?sig=4" alt="">
                                    <div class="uk-position-center uk-panel"><h1>4</h1></div>
                                </li>
                            </ul>
                        </div>

                    </div>

            </div>
        </div>
    </div>

</x-app-layout>
