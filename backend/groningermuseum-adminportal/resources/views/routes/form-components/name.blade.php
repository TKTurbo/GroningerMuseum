<div class="uk-margin">
    <label>Naam van de route</label>
            <input class="uk-input" type="text" placeholder="naam" id="name" name="name"
            value="{{ 
            isset($route)
            ? $route->name 
            : '' }}">
        </div>