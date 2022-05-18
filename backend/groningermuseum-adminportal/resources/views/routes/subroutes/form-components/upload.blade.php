<div class="js-upload uk-placeholder uk-text-center">
    <span uk-icon="icon: cloud-upload"></span>
    <span class="uk-text-middle">Attach binaries by dropping them here or</span>
    <div uk-form-custom>
        <input type="file" id="file" name="file" multiple>
        <span class="uk-link">selecting one</span>
    </div>
</div>

<progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>

<script type="text/javascript">
    var bar = document.getElementById('js-progressbar');

    var tokenElement = document.head.querySelector('meta[name="csrf-token"]');
    var token;

    var newUrl = "{{route('routes.details', ['route_id' => $route_id ])}}"

    console.log(tokenElement)

    if (tokenElement) {
        token = tokenElement.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

    UIkit.upload('.js-upload', {

        url: "{{route('routes.subroutes.upload-image', ['route_id' => $route_id, 'subroute_id' => $subroute->id])}}",
        method: "POST",
        multiple: true,

        beforeSend: function (e) {
            console.log('beforeSend', arguments);
            // var {data, method, headers, xhr, responseType} = environment;
            e.data.append('_token', token);
        },
        beforeAll: function (e) {
            console.log('beforeAll', arguments);
        },
        load: function (e) {
            console.log('load', arguments);
        },
        error: function (e) {
            console.log('error', arguments);
        },
        complete: function (e) {
            console.log('complete', arguments);
        },

        loadStart: function (e) {
            console.log('loadStart', arguments);

            bar.removeAttribute('hidden');
            bar.max = e.total;
            bar.value = e.loaded;
        },

        progress: function (e) {
            console.log('progress', arguments);

            bar.max = e.total;
            bar.value = e.loaded;
        },

        loadEnd: function (e) {
            console.log('loadEnd', arguments);

            bar.max = e.total;
            bar.value = e.loaded;
        },

        completeAll: function () {
            console.log('completeAll', arguments);

            setTimeout(function () {
                bar.setAttribute('hidden', 'hidden');
            }, 1000);

            UIkit.notification({
                message: 'Afbeelding is succesvol geupload',
                status: 'success',
                timeout: 1500
            });

            UIkit.util.on(document, 'close', function(evt) {
                window.location.replace(newUrl)

            });
        }

    });

</script>