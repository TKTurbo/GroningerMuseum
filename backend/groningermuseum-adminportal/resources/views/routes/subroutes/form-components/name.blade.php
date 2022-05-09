<div class="uk-margin">
    <label>Naam van de subroute</label>
            <input class="uk-input" type="text" placeholder="naam" id="name" name="name"
            value="{{ 
            isset($subroute)
            ? $subroute->name 
            : '' }}">
        </div>