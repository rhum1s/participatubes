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

<!-- Loading JQuery -->
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<!-- --- -->

<!-- Loading Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<!-- --- -->


<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<script src="libs/Leaflet_v0.7.7/leaflet.js"></script>   

<script type="text/javascript" src="libs/geostats-master/lib/geostats.min.js"></script>
<script type="text/javascript" src="libs/chroma.js-master/chroma.min.js"></script>
<!-- <script type="text/javascript" src="libs/leaflet-choropleth-gh-pages/src/choropleth.js"></script> -->

<script type="text/javascript" src="config.js"></script></script>
<script type="text/javascript" src="scripts/jenks.js"></script></script>

<link rel="stylesheet" href="libs/font-awesome-4.6.3/css/font-awesome.min.css">


<link rel="stylesheet" href="libs/easy_button/easy-button.css" />
<script type="text/javascript" src="libs/easy_button/easy-button.js"></script>


<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>



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

function zoom_to_layer(layer) {
    /*
    Zoom sur une couche
    */
	var southWest = layer.getBounds().getSouthWest();
	var northEast = layer.getBounds().getNorthEast();
	var bounds = new L.LatLngBounds(southWest, northEast);
    map.fitBounds(bounds);
};   
   
function onClickFeature(e) {
    /* Zoom sur le tube */
    map.setView(e.latlng, 17);
   
    /* Informations du tube */
    console.log(this._popup._source);
    tube = this._popup._source.feature;   
    tube_lat = this._popup._source._latlng.lat;
    tube_lng = this._popup._source._latlng.lng;
    console.log(tube.properties.tube_id, tube.properties.tube_nom, tube_lat, tube_lng);
};

function onEachFeature(feature, layer) {
    layer.on({
        // mouseover: highlightFeature,
        // mouseout: resetHighlight,
        click: onClickFeature
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
            if (geojson.properties['type_id'] == 2) {
                return L.marker(latlng, {icon: icon1});                    
            } else if (geojson.properties['type_id'] == 1) {
                return L.marker(latlng, {icon: icon1});
            } else {
                return L.marker(latlng, {icon: icon1});
            };
        }, 
    });
	    
	geojsonLayer.addTo(map); 

	// Zoom sur les tubes	
    zoom_to_layer(geojsonLayer);
			
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
    


    
    
    
    
    
    
    
/* Creation d'un control leaflet pour afficher du texte html */
var displayControl = L.Control.extend({
    options: {
        position: 'topright'
    },
    onAdd: function (map) {
        // Create a container with classname and return it
        return L.DomUtil.create('div', 'my-display-control');
    },
    setContent: function (content) {
        this.getContainer().innerHTML = content;
    }
});

var displayControl =  new displayControl().addTo(map);
displayControl.setContent('Afficher graphiques ici?');
   
 

    
/* Boutons de carte (Easy-buttons) */
L.easyButton( 'fa-arrows', function(){
    zoom_to_layer(geojsonLayer)
}).addTo(map);

var toggle = L.easyButton({
    id: 'bouton-afficher-tubes',  // an id for the generated button
    position: 'topleft',      // inherited from L.Control -- the corner it goes in
    type: 'replace',          // set to animate when you're comfy with css
    leafletClasses: true,     // use leaflet classes to style the button?  
    states: [{
        stateName: 'remove-markers',
        icon: 'fa-undo',
        title: 'Retirer les tubes',
        onClick: function(control) {
            map.removeLayer(geojsonLayer);
            control.state('add-markers');
            // toggle.button.style.backgroundColor = 'white';
        }
    }, {
        stateName: 'add-markers',
        icon: 'fa-map-marker',
        title: 'Ajouter les tubes',
        onClick: function(control) {
            map.addLayer(geojsonLayer);
            control.state('remove-markers');
            // toggle.button.style.backgroundColor = 'red';
        },
    }]
});
// toggle.button.style.width = '200px';
// toggle.button.style.height = '100px';
// toggle.button.style.backgroundColor = 'green'; // repeated line (note below)
// toggle.button.style.transitionDuration = '.3s';

toggle.addTo(map);


// L.easyButton('fa-arrows', function( buttonArg, mapArg ){
  // buttonArg.doStuff();
  // mapArg.doStuff();
// }).addTo(map);

/* CUSTOM CONTROL EXAMPLE 
var customControl =  L.Control.extend({

  options: {
    position: 'topleft'
  },

  onAdd: function (map) {
    var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');

    container.style.backgroundColor = 'white';     
    container.style.backgroundImage = 'url(icons/marker-icon.png)'; // "url(http://t1.gstatic.com/images?q=tbn:ANd9GcR6FCUMW5bPn8C4PbKak2BJQQsmC-K9-mbYBeFZm1ZM2w2GRy40Ew)";
    container.style.backgroundSize = "10px 10px";
    // container.style.background-repeat = "no-repeat";
    container.style.width = '30px';
    container.style.height = '30px';

    container.onclick = function(){
      console.log('buttonClicked');
    }

    return container;
  }
});
map.addControl(new customControl()); */

  
  
  
   </script>
  
   
</body>
</html>    