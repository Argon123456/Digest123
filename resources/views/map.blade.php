<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCI-Kh_T5tqZP5xcqRSpxIFRG8OxbknWz0">
    </script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script>
        $( document ).ready(function() {
            $.getJSON( "map/json", function( data ) {
                var markers =[];

                $.each( data, function( key, val ) {
                    let lat = parseFloat(val.width.replace(',','.'));
                    let lng = parseFloat(val.length.replace(',','.'));
                    markers.push({
                        position : {lat: lat, lng: lng},
                        name : val.name,
                        trademark: val.trademark
                    });
                });
                console.log(markers);
                initMap(markers);
                initMap2(markers);
            });


        });

        function initMap(markers) {
            let center = {lat: 53.937341, lng: 27.482173};

            let map = new google.maps.Map(
                document.getElementById('map'), {zoom: 4, center: center});

            $.each(markers, function (key, marker) {
                let m = new google.maps.Marker({
                    position: marker.position,
/*                    label: {
                        text: 'VDS',
                        color: "#ffffff",
                        fontSize: "10px",
                        //fontWeight: "bold"
                    },*/
                    map: map
                });
                var infowindow = new google.maps.InfoWindow({
                    content: "<p style='margin:0px;font-weight: bold;'>"+marker.trademark+"</p>"+"<p style='margin:0px;'>"+marker.name+"</p>",
                });
                m.addListener('click', function() {
                    infowindow.open(map, m);
                });
            });
        }

        function initMap2(markers) {
            let center = {lat: 53.937341, lng: 27.482173};

            let map = new google.maps.Map(
                document.getElementById('map2'), {zoom: 4, center: center});

            let googleMarkers = [];

            $.each(markers, function (key, marker) {
                let m = new google.maps.Marker({
                    position: marker.position,
                    /*                    label: {
                                            text: 'VDS',
                                            color: "#ffffff",
                                            fontSize: "10px",
                                            //fontWeight: "bold"
                                        },*/
                    map: map
                });
                var infowindow = new google.maps.InfoWindow({
                    content: "<p style='margin:0px;font-weight: bold;'>"+marker.trademark+"</p>"+"<p style='margin:0px;'>"+marker.name+"</p>",
                });
                m.addListener('click', function() {
                    infowindow.open(map, m);
                });
                googleMarkers.push(m);
            });

            var markerCluster = new MarkerClusterer(map, googleMarkers,
                {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'})
        }
    </script>

</head>
<body>
<div><p>Вариант 1 простые маркеры</p></div>
<div id="map" style="width: 95vw;height: 80vh;">

</div>
<div><p>Вариант 2 Кластеризация</p></div>
<div id="map2" style="width: 95vw;height: 80vh;">

</div>
</body>
</html>
