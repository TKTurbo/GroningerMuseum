<div class="uk-margin">
    <label>Het thema van de route</label>
        <select class="uk-select" id="theme" name="theme">
        @foreach($attr['themes'] as $theme)
            <option value="{{ $theme->id }}"> {{ $theme->name }}</option>
        @endforeach
        </select>
    </div>