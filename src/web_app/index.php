<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Participatubes</title>
    
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>    

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        
    <!-- Leaflet -->
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
    <script src="libs/Leaflet_v0.7.7/leaflet.js"></script>  
    <link rel="stylesheet" href="style-bootstrap.css"/>

    <!-- Font Awesome -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="libs/font-awesome-4.6.3/css/font-awesome.min.css">

    <!-- Easy Button -->
    <link rel="stylesheet" href="libs/easy_button/easy-button.css" />
    <script type="text/javascript" src="libs/easy_button/easy-button.js"></script>

    <!-- Leaflet.BoxZoom -->
    <script src="libs/L.Control.BoxZoom-master/dist/leaflet-control-boxzoom.js"></script>
    <link rel="stylesheet" href="libs/L.Control.BoxZoom-master/dist/leaflet-control-boxzoom.css" />    
    
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
        
    <!-- Config -->
    <script type="text/javascript" src="config.js"></script></script>

    <!-- Scripts -->
    <script type="text/javascript" src="libs/geostats-master/lib/geostats.min.js"></script>
    <script type="text/javascript" src="libs/chroma.js-master/chroma.min.js"></script>
    
</head>

<!------------------------------------------------------------------------------ 
                                    Body
------------------------------------------------------------------------------->
<body>

<!-- Bootstrap -->
<!-- https://getbootstrap.com/components/#navbar -->
<!-- http://getbootstrap.com/javascript/ -->
<nav class="navbar navbar-default">
    <div class="container-fluid">
    
        <!-- Bootstrap - Header -->
        <div class="navbar-header">
        
            <!-- Image de la campagne -->
            <a class="navbar-brand" href="#">           
                <img alt="Brand" src="icons/marker-icon.png">
            </a>    

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
            <!-- Titre de la campagne (dynamique) -->
            <?php include 'scripts/header-bootstrap-title.php';?>
        </div>

        <!-- Bootstrap - Boutons du Header -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <!-- Bouton home -->
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default navbar-btn" onclick="bootstrap_home();">
                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                    </button>
                    <!-- Bouton tubes -->
                    <button type="button" class="btn btn-default navbar-btn" onclick="bootstrap_tubes();">
                        <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                    </button>        
                </div> 
            </ul>
            
            <!-- Formulaire de recherche -->
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Mon tube">
                </div>
                <button type="submit" class="btn btn-default">Recherche</button>
            </form>

            <!-- Bouton Modal de connexion --> 
            <ul class="nav navbar-nav navbar-right" data-toggle="modal" data-target="#myModal">
                <li><a href="#">Connexion</a></li>
            </ul>

            <!-- Bouton Modal d'identification -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Identification administrateur</h4>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-primary">Connexion</button>
                        </div>
                    </div>
                </div>
            </div>      
            
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<!-- Carte Leaflet -->
<div id="map"></div> 

<!-- Image "En développement" 
<a href="#"><img style="position: fixed; top: 0; right: 0; border: 0;" src="icons/developpement.png" alt="Version de développement"></a>
-->

<!------------------------------------------------------------------------------ 
                                    Map script
------------------------------------------------------------------------------->
<script type="text/javascript">
function bootstrap_home(){
    zoom_to_layer(tubes_layer);
};

function bootstrap_tubes(){
    map.removeLayer(tubes_layer);
};

function bootstrap_close_display() {
    displayControl.setContent('');
};

function creation_icones() {
    /*
    Penser que le point de référence des icones
    est en haut à gauche.

    Exemple d'utilisation: 
    " 
    var icones = creation_icones();
    console.log(icones.icon_trafic);
    "
    
    Autres options:
    iconSize: [24, 38], // size of the icon
    shadowSize: [50, 64], // size of the shadow
    */
    var icon = L.icon({
        iconUrl: 'icons/marker-icon.png',
        shadowUrl: 'icons/marker-shadow.png',
        iconAnchor:   [12.5, 41], 
        shadowAnchor: [13.5, 41],
        popupAnchor:  [0, -41]
    });
    
    var icon_trafic = L.icon({
        iconUrl: 'icons/marker-icon-trafic.png',
        shadowUrl: 'icons/marker-shadow.png',
        iconAnchor:   [12.5, 41], 
        shadowAnchor: [13.5, 41],
        popupAnchor:  [0, -41]
    });    

    var icon_urbain = L.icon({
        iconUrl: 'icons/marker-icon-urbain.png',
        shadowUrl: 'icons/marker-shadow.png',
        iconAnchor:   [12.5, 41],
        shadowAnchor: [13.5, 41],
        popupAnchor:  [0, -41]
    });  
    
    var icon_rural = L.icon({
        iconUrl: 'icons/marker-icon-rural.png',
        shadowUrl: 'icons/marker-shadow.png',
        iconAnchor:   [12.5, 41],
        shadowAnchor: [13.5, 41],
        popupAnchor:  [0, -41]
    });  
    
    var icon_proximite = L.icon({
        iconUrl: 'icons/marker-icon-proximite.png',
        shadowUrl: 'icons/marker-shadow.png',
        iconAnchor:   [12.5, 41],
        shadowAnchor: [13.5, 41],
        popupAnchor:  [0, -41]
    });  
    
    return {
        icon: icon,
        icon_trafic: icon_trafic,
        icon_urbain: icon_urbain,
        icon_rural: icon_rural,
        icon_proximite: icon_proximite
    };
    
};

function zoom_to_layer(layer) {
    /*
    Zoom sur une couche
    */
	var southWest = layer.getBounds().getSouthWest();
	var northEast = layer.getBounds().getNorthEast();
	var bounds = new L.LatLngBounds(southWest, northEast);
    map.fitBounds(bounds, {padding: [0, 0]});
};   
     
function onClickFeature(e) {
    /*
    NOTE: Pour décaler la vue après le zoom: 
    "
    map.panBy([50, 0], {duration: 0.5});
    "
    */

    /* Zoom sur l'élément */
    map.setView(e.latlng); // Pour changer le zoom: ", 13"

    /* Récupération des informations du tube */
    tube = this._popup._source.feature;       
   
    $.ajax({
        url: "scripts/query_tubes.php",
        type: 'GET',
        data : { tube_id: tube.properties.tube_id },
        dataType: 'json',
        error: function (request, error) {
            console.log(arguments);
            console.log("Ajax error: " + error);
        },       
        success: function(response,textStatus,jqXHR){
            
            /* Prépare le ou les élément(s) HTML du graph */
            if (response[0][0].nb_poll == 1) {
                displayControl.setContent('<button type="button" class="close" aria-label="Close" onclick="bootstrap_close_display();"><span aria-hidden="true">&times;</span></button><h3 style="color:black;">' + tube.properties.tube_nom + '</h3><canvas id="graph_no2" width="600" height="350"></canvas>');            
            } else {
                displayControl.setContent('<button type="button" class="close" aria-label="Close" onclick="bootstrap_close_display();"><span aria-hidden="true">&times;</span></button><h3 style="color:black;">' + tube.properties.tube_nom + '</h3><canvas id="graph_no2" width="600" height="350"></canvas><br/><canvas id="graph_btex" width="600" height="350"></canvas>');            
            };
 
            /* Graphique NO2 */            
            if (typeof response[1][0] !== "undefined") {
                var graph_labels = [];
                for (var i in response[1]) {
                    graph_labels.push(response[1][i].nom_periode);
                };            
                
                var graph_title = response[1][0].nom_polluant + " (" + response[1][0].nom_unite + ")";
                
                // -- Données
                var graph_data = [];
                for (var i in response[1]) {
                    graph_data.push(response[1][i].val);
                };   
                
                // Graphique
                var ctx = document.getElementById("graph_no2");
                var graph_no2 = new Chart(ctx, {
                    type: 'bar', // 'horizontalBar',          
                    data: {
                        labels: graph_labels,
                        datasets: [{
                            label: 'NO2',
                            data: graph_data,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.8)', // Hivert
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)', // Ete
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)', // Corrections
                                'rgba(75, 192, 192, 0.8)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 250, 85, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            fontSize: 20,
                            text: graph_title
                        },
                        legend: {
                            position: 'bottom',
                            display: false,
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    // beginAtZero:true,
                                    min:0,
                                    max: 200,
                                }
                            }]
                        }
                    }
                }); 
            };

            /* Graphique BTEX */             
            if (typeof response[2][0] !== "undefined") {
            
                // -- Labels
                var graph_labels = [];
                for (var i in response[2]) {
                    graph_labels.push(response[2][i].nom_polluant);
                };            
                
                // -- Titre
                var graph_title = "BTEX (" + response[2][0].nom_unite + ")";
                
                // -- Données
                var graph_data = [];
                for (var i in response[2]) {
                    graph_data.push(response[2][i].val);
                };   
                
                // Graphique
                var ctx = document.getElementById("graph_btex");
                var graph_btex = new Chart(ctx, {
                    type: 'bar', // 'horizontalBar',          
                    data: {
                        labels: graph_labels,
                        datasets: [{
                            label: 'BTEX',
                            data: graph_data,
                            backgroundColor: [
                                'rgba(170, 170, 170, 0.8)', 
                                'rgba(170, 170, 170, 0.8)', 
                                'rgba(170, 170, 170, 0.8)', 
                                'rgba(170, 170, 170, 0.8)', 
                                'rgba(170, 170, 170, 0.8)', 
                            ],
                            borderColor: [
                                'rgba(170, 170, 170, 1)',
                                'rgba(170, 170, 170, 1)',
                                'rgba(170, 170, 170, 1)',
                                'rgba(170, 170, 170, 1)',
                                'rgba(170, 170, 170, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            fontSize: 20,
                            text: graph_title
                        },
                        legend: {
                            position: 'bottom',
                            display: false,
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    // beginAtZero:true,
                                    min:0,
                                    max: 30,
                                }
                            }]
                        }
                    }
                });  
            };
            
        }
    });

};

function onEachTube(feature, layer) {
    /*
    Code qui sera appliqué à chaque objet lors du chargement des tubes.
    */
    
    /* Appel la fonction onClickFeature() en cliquant sur l'objet */
    layer.on({
        click: onClickFeature
    });

    /* Ajoute un popup avec les valeurs de l'objet */
    var popupcontent = "<h4>" + feature.properties["tube_nom"] + "</h4>";
    popupcontent += "<p><b>Identifiant: </b>" + feature.properties["tube_id"] + "<br/>";
    popupcontent += "<b>Typologie: </b>" + feature.properties["typo_nom"] + "<br/>";
    popupcontent += "<b>Commune: </b>" + feature.properties["tube_ville"] + "</p><br/>";
    popupcontent += "<img src='data:image/png;base64, " + feature.properties["tube_image"] + "'/>";
    layer.bindPopup(popupcontent);      
}; 

function loadGeoJson_tubes(data) {
    /*
    Fonction de création de la couche des tubes
    qui sera appelée si une donnée a été récupérée depuis Geoserver
    */
    
    /* Charge les tubes depuis Geoserver */
    tubes_layer = L.geoJson(data, {
        id: 'tubes',
        name: 'Tubes',
        onEachFeature: onEachTube,
        /* Crée un layer au lieu de simples marqueurs */
        pointToLayer: function (geojson, latlng) {        
            if (geojson.properties['typo_id'] == 1) {
                return L.marker(latlng, {icon: icones.icon_trafic});                    
            } else if (geojson.properties['typo_id'] == 2) {
                return L.marker(latlng, {icon: icones.icon_urbain});
            } else if (geojson.properties['typo_id'] == 3) {
                return L.marker(latlng, {icon: icones.icon_rural});
            } else if (geojson.properties['typo_id'] == 4) {
                return L.marker(latlng, {icon: icones.icon_proximite});                
            } else {
                return L.marker(latlng, {icon: icones.icon});
            };
        }, 
    });
	
    /* Ajoute les tubes à la carte */
	tubes_layer.addTo(map); 

	/* Zoom sur les tubes une fois ajoutés */
    zoom_to_layer(tubes_layer);
			
    /* Ajoute la couche au contrôleur de couches */
    layerControl.addOverlay(tubes_layer, "Points des mesures");
}; 
 
/* Création des icones */
var icones = creation_icones();
 
/* Création de la carte */
var map = L.map('map', {layers: []}).setView([43.9, 7.2], 9);    
map.attributionControl.addAttribution('Participatubes &copy; <a href="http://www.romain-souweine.fr">Romain Souweine - 2016</a>');    

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
    
/* Chargement de la vue des tubes depuis Geoserver. */
var tubes_layer = new L.GeoJSON();
var geoJsonUrl = gs_url + "ows?service=WFS&version=1.0.0&request=GetFeature&typeName=participatubes:tubes_mef&outputFormat=application%2Fjson&format_options=callback:loadGeoJson"; 

$.ajax({
    url: geoJsonUrl,
    datatype: 'json',
    jsonCallback: 'getJson',
    success: loadGeoJson_tubes
});    
 
/* Creation d'un control leaflet pour afficher du texte html */
var displayControl = L.Control.extend({
    options: {position: 'topright'},
    onAdd: function (map) {
        return L.DomUtil.create('div', 'my-display-control');
    },
    setContent: function (content) {
        this.getContainer().innerHTML = content;
    }
});
var displayControl =  new displayControl().addTo(map);

/* Bouton Leaflet - Zoom sur les tubes */
L.easyButton( 'fa-arrows', function(){
    zoom_to_layer(tubes_layer)
}).addTo(map);

/* Bouton Leaflet toggle - Afficher / Désafficher les tubes */
var toggle = L.easyButton({
    id: 'bouton-afficher-tubes', 
    position: 'topleft',
    type: 'replace',
    leafletClasses: true, // TODO: Si "false" on peut utiliser notre propre classe CSS 
    states: [{
        stateName: 'remove-markers',
        icon: 'fa-undo',
        title: 'Retirer les tubes',
        onClick: function(control) {
            map.removeLayer(tubes_layer);
            control.state('add-markers');
            // toggle.button.style.backgroundColor = 'white';
        }
    }, {
        stateName: 'add-markers',
        icon: 'fa-map-marker',
        title: 'Ajouter les tubes',
        onClick: function(control) {
            map.addLayer(tubes_layer);
            control.state('remove-markers');
            // toggle.button.style.backgroundColor = 'red';
        },
    }]
}).addTo(map);

/* Ferme les popups au click sur la carte */
/* FIXME: Empêche le click sur le graph si il est dans un contrôle leaflet. */
map.on('click', function(e) {        
    displayControl.setContent('');
});

/* Ajout du contrôleur de couches Leaflet "LayerSwitcher" */
var baseLayers = {"Fonde de carte: MapBox Light": mapbox_light,};
var layerControl = L.control.layers(baseLayers, null, {collapsed: false, position:"bottomleft"});
map.addControl(layerControl); 

/* Ajout du control Leaflet "ZoomBox" */
L.Control.boxzoom({ position:'topleft' }).addTo(map);

</script>

</body>
</html>