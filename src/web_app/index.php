<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">

	<title>Participatubes</title>
	
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
    <link rel="stylesheet" href="style.css"/>
</head>
<body>

<?php include 'scripts/header.php';?>
<div id="map"></div>

<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="libs/Leaflet_v0.7.7/leaflet.js"></script>   

<script type="text/javascript" src="libs/geostats-master/lib/geostats.min.js"></script>
<script type="text/javascript" src="libs/chroma.js-master/chroma.min.js"></script>
<!-- <script type="text/javascript" src="libs/leaflet-choropleth-gh-pages/src/choropleth.js"></script> -->

<script type="text/javascript" src="config.js"></script></script>
<script type="text/javascript" src="scripts/jenks.js"></script></script>

<script type="text/javascript">



function creation_icones() {
    /* FIXME: Créer une classe icone */
    var icon1 = L.icon({
        iconUrl: 'icons/marker-icon.png',
        shadowUrl: 'icons/marker-shadow.png',
        // iconSize:     [24, 38], // size of the icon
        // shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [12.5, 41], // point of the icon which will correspond to marker's location
        shadowAnchor: [13.5, 41],  // the same for the shadow
        popupAnchor:  [0, -41] // point from which the popup should open relative to the iconAnchor
    });
    return icon1;
};
    
function zoomToFeature(e) {
    map.setView(e.latlng, 17);
};

function onEachFeature(feature, layer) {
    layer.on({
        // mouseover: highlightFeature,
        // mouseout: resetHighlight,
        click: zoomToFeature
    });
 
    var popupcontent = [];
    for (var prop in feature.properties) {
        if (prop == "tube_image") {
            popupcontent.push("<img src='data:image/png;base64, " + feature.properties[prop] + "' />");
        } else {
            popupcontent.push(prop + ": " + feature.properties[prop]);
        };
    }
    layer.bindPopup(popupcontent.join("<br />"));                      
}; 

function loadGeoJson_tubes(data) {
    /*
    Chargement de la vue des tubes depuis Geoserver.
    */
    geojsonLayer = L.geoJson(data, {
        id: 'toto',
        name: 'tata',
        // style: style,
        onEachFeature: onEachFeature,
        /* FIXME: Bug dans l'emplacement des markeurs spéciaux" */
        pointToLayer: function (geojson, latlng) {
            console.log();
            if (geojson.properties['type_id'] == 2) {
                return L.marker(latlng, {icon: icon1});                    
            } else if (geojson.properties['type_id'] == 1) {
                return L.marker(latlng, {icon: icon1});
            } else {
                return L.marker(latlng, {icon: icon1});
            };
        }, 
    }).addTo(map); 
               
    // layerControl.addOverlay(geojsonLayer, "Sites de mesures"); // Add layer to layer switcher
}; 
 
/* Création des icones */
var icon1 = creation_icones();
 
/* Création de la carte */
var map = L.map('map', {layers: []}).setView([43.9, 7.2], 9);    
map.attributionControl.addAttribution(
    'Participatubes &copy; <a href="http://www.romain-souweine.fr">Romain Souweine - 2016</a>');    

/* Chargement des fonds carto */    
var mapbox_light = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoicmh1bSIsImEiOiJjaWx5ZmFnM2wwMGdidmZtNjBnYzVuM2dtIn0.MMLcyhsS00VFpKdopb190Q', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
        '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="http://mapbox.com">Mapbox</a>',
    id: 'mapbox.light',
    opacity: 1.,
});   
mapbox_light.addTo(map);        
    
/* Chargement des tubes */
var geojsonLayer = new L.GeoJSON();
var geoJsonUrl = gs_url + "ows?service=WFS&version=1.0.0&request=GetFeature&typeName=participatubes:tubes_mef&outputFormat=application%2Fjson&format_options=callback:loadGeoJson"; 

$.ajax({
    url: geoJsonUrl,
    datatype: 'json',
    jsonCallback: 'getJson',
    success: loadGeoJson_tubes
});    
    
/* var layers = [];
    map.eachLayer(function(layer) {
    // if( layer instanceof L.TileLayer )
        layers.push(layer);
        console.log(layer);
        console.log(layer._leaflet_id)
        // map.fitBounds(layer);
});
console.log(layers);   */  
    
    
    
    
    
    
    
    
</script>
</body>
</html>    