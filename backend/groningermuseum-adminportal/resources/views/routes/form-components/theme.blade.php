<div class="uk-margin">
    <label>Het thema van de route</label>
        <select class="uk-select" id="theme" name="theme">
        @foreach($attr['themes'] as $theme)
        @if(isset($route))
            <option value="{{ $theme->id }}" {{ ($theme->id == $route->theme->id) ? 'selected' : '' }}>
        @else
            <option value="{{ $theme->id }}">
        @endif
                {{ $theme->name }}</option>
        @endforeach
        </select>
    </div>