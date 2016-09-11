<section id="startPage">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Step 1: Type your address below</h3>
            </div>
        </div>
        <div class="row text-center" id="locationField">
            <div class="col-md-12">
                <input id="autocomplete" class="form-control" placeholder="Enter your address" onFocus="geolocate()" type="text"></input>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Step 2: Verify your address</h3>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-offset-1 col-md-5">
                <label for="street_number">Street Number</label>
                <input class="form-control addressField" name="streetnum" id="street_number" disabled="true"></input>
            </div>
            <div class="form-group col-md-5">
                <label for="route">Street Name</label>
                <input class="form-control addressField" name="streetname" id="route" disabled="true"></input>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-offset-1 col-md-5">
                <label for="street_number">Unit/Apt/Suite Number (optional)</label>
                <input class="form-control addressField" name="apt" id="apt" disabled="true"></input>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-offset-1 col-md-5">
                <label for="locality">City</label>
                <input class="form-control addressField" name="city" id="locality" disabled="true"></input>
            </div>
            <div class="form-group col-md-5">
                <label for="administrative_area_level_1">State</label>
                <input class="form-control addressField" name="state" id="administrative_area_level_1" disabled="true"></input>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-offset-1 col-md-5">
                <label for="postal_code">Zipcode</label>
                <input class="form-control addressField" name="zip" id="postal_code" disabled="true"></input>
            </div>
            <div class="form-group col-md-5">
                <label for="country">Country</label>
                <input class="form-control addressField" name="country" id="country" disabled="true"></input>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Step 3: Get your information!</h3>
            </div>
        </div>
        <div class="row text-center" id="locationField">
            <div class="col-md-12">
                <button type="button" id="checkIt" class="btn btn-success" disabled="true"><i class="fa fa-binoculars"></i> Check It!</button>
            </div>
        </div>
    </div>
</section>

<!-- Autocomplete script - courtesy of Google, minor modifications by me  -->
<script src="js/locationAutocomplete.js" type="text/javascript"></script>

<!-- Google Maps Places API -->
<!-- You will need to put your API key into here -->
<script src="https://maps.googleapis.com/maps/api/js?key={YOUR-API-KEY-HERE}&libraries=places&callback=initAutocomplete" async defer></script>

<?php include_once '_infoModal.php'; ?>