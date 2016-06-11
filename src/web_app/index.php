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

    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
        
    <!-- Config -->
    <script type="text/javascript" src="config.js"></script></script>

    <!-- Scripts -->
    <script type="text/javascript" src="libs/geostats-master/lib/geostats.min.js"></script>
    <script type="text/javascript" src="libs/chroma.js-master/chroma.min.js"></script>
    <script type="text/javascript" src="scripts/jenks.js"></script></script>
    
</head>

<!------------------------------------------------------------------------------ 
                                    Body
------------------------------------------------------------------------------->
<body>

<!-- https://getbootstrap.com/components/#navbar -->
<!-- http://getbootstrap.com/javascript/ -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
    
      <a class="navbar-brand" href="#">
        <img alt="Brand" src="icons/marker-icon.png">
      </a>    
    
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php include 'scripts/header-bootstrap-title.php';?>
      <!-- <a class="navbar-brand" href="#">Brandvvv</a> -->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
 
        <div class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-default navbar-btn" onclick="bootstrap_home();">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
            </button>

            <button type="button" class="btn btn-default navbar-btn" onclick="bootstrap_tubes();">
                <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
            </button>        
        </div> 

        
        
        
        <!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
        <!-- <li><a href="#">Link</a></li> -->
        <!-- <li class="dropdown"> -->
        <!--   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a> -->
        <!--   <ul class="dropdown-menu"> -->
        <!--     <li><a href="#">Action</a></li> -->
        <!--     <li><a href="#">Another action</a></li> -->
        <!--     <li><a href="#">Something else here</a></li> -->
        <!--     <li role="separator" class="divider"></li> -->
        <!--     <li><a href="#">Separated link</a></li> -->
        <!--     <li role="separator" class="divider"></li> -->
        <!--     <li><a href="#">One more separated link</a></li> -->
        <!--   </ul> -->
        <!-- </li> -->  
        
      </ul>
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

    <!-- Bouton Modal d'affichage --> 
    <ul class="nav navbar-nav navbar-right" data-toggle="modal" data-target="#Modal_affichage"></ul>

    <div class="modal" id="Modal_affichage" tabindex="-1" role="dialog" aria-labelledby="Modal_affichage">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="Modal_affichage">[identifiant] - [nom]</h4>
          </div>
          <div class="modal-body-affichage">
            [AFFICHER LES DONNEES ICI.]
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Quitter</button>
            <button type="button" class="btn btn-primary">Afficher tout</button>
          </div>
        </div>
      </div>
    </div>  




    
    </div><!-- /.navbar-collapse -->

    </div><!-- /.container-fluid -->
</nav>
<!-- 
<div class="container fill">
     <div id="map"></div> 
 </div> 
 -->
<div id="map"></div> 


<!------------------------------------------------------------------------------ 
                                    Map script
------------------------------------------------------------------------------->
<script type="text/javascript">
function bootstrap_home(){
    zoom_to_layer(geojsonLayer);
};

function bootstrap_tubes(){
    map.removeLayer(geojsonLayer);
};

function creation_icones() {
    var icon = L.icon({
        iconUrl: 'icons/marker-icon.png',
        shadowUrl: 'icons/marker-shadow.png',
        // iconSize:     [24, 38], // size of the icon
        // shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [12.5, 41], // point of the icon which will correspond to marker's location
        shadowAnchor: [13.5, 41],  // the same for the shadow
        popupAnchor:  [0, -41] // point from which the popup should open relative to the iconAnchor
    });
    
    var icon_trafic = L.icon({
        iconUrl: 'icons/marker-icon-trafic.png',
        shadowUrl: 'icons/marker-shadow.png',
        // iconSize:     [24, 38], // size of the icon
        // shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [12.5, 41], // point of the icon which will correspond to marker's location
        shadowAnchor: [13.5, 41],  // the same for the shadow
        popupAnchor:  [0, -41] // point from which the popup should open relative to the iconAnchor
    });    

    var icon_urbain = L.icon({
        iconUrl: 'icons/marker-icon-urbain.png',
        shadowUrl: 'icons/marker-shadow.png',
        // iconSize:     [24, 38], // size of the icon
        // shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [12.5, 41], // point of the icon which will correspond to marker's location
        shadowAnchor: [13.5, 41],  // the same for the shadow
        popupAnchor:  [0, -41] // point from which the popup should open relative to the iconAnchor
    });  
    
    var icon_rural = L.icon({
        iconUrl: 'icons/marker-icon-rural.png',
        shadowUrl: 'icons/marker-shadow.png',
        // iconSize:     [24, 38], // size of the icon
        // shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [12.5, 41], // point of the icon which will correspond to marker's location
        shadowAnchor: [13.5, 41],  // the same for the shadow
        popupAnchor:  [0, -41] // point from which the popup should open relative to the iconAnchor
    });  
    
    var icon_proximite = L.icon({
        iconUrl: 'icons/marker-icon-proximite.png',
        shadowUrl: 'icons/marker-shadow.png',
        // iconSize:     [24, 38], // size of the icon
        // shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [12.5, 41], // point of the icon which will correspond to marker's location
        shadowAnchor: [13.5, 41],  // the same for the shadow
        popupAnchor:  [0, -41] // point from which the popup should open relative to the iconAnchor
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
    console.log(southWest, northEast);
	var bounds = new L.LatLngBounds(southWest, northEast);
    map.fitBounds(bounds, {padding: [0, 40]});
};   
   
function onClickFeature(e) {
    /* Zoom sur le tube */
    map.setView(e.latlng, 17);
   
    /* Informations du tube */
    console.log(this._popup._source);
    tube = this._popup._source.feature;   
    tube_lat = this._popup._source._latlng.lat;
    tube_lng = this._popup._source._latlng.lng;
    
    // Requête dans la base PostgreSQL
    
    // TODO: Pour chaque poll ete hivert corr corr moy corr an
    
    $.ajax({
        url: "scripts/query.php",
        type: 'GET',
        data : { tube_id: tube.properties.tube_id },
        dataType: 'json',
        success: function(response,textStatus,jqXHR){
            // console.log(response); 
            // console.log("----");
            // displayControl.setContent(response[0].tube_nom);
            content = "" + response[0].tube_nom + ": " + response[0].val;
            // displayControl.setContent(content);
            
            // Affiche les données récupérées          
            displayControl.setContent('<canvas id="myChart" width="600" height="400"></canvas>');            
            
            // Récupérer le NO2 et les BTEX et faire plusieurs datasets
            
            
            // -- Labels
            var graph_labels = [];
            for (var i in response) {
                graph_labels.push(response[i].nom_polluant);
            };            
            
            // -- Titre
            var graph_title = response[0].tube_nom;
            
            // -- Données
            var graph_data = [];
            for (var i in response) {
                graph_data.push(response[i].val);
            };   
            
             // Object { tube_id: "4", tube_nom: "Quai du Commerce", nom_polluant: "COV", nom_periode: "Eté", val: "0.7" }           
            
            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',          
                data: {
                    labels: graph_labels,
                    datasets: [{
                        label: 'Polluants mesurés',
                        data: graph_data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 159, 64, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    title: {
                        display: true,
                        fontSize: 30,
                        text: graph_title
                    },
                    legend: {
                        // display: true,
                        position: 'bottom',
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                // beginAtZero:true,
                                min:0,
                                // max: 100,
                            }
                        }]
                    }
                }
            });  
        }
    });
};

function onEachFeature(feature, layer) {
    layer.on({
        // mouseover: highlightFeature,
        // mouseout: resetHighlight,
        click: onClickFeature
    });
 
    // var popupcontent = [];
    // for (var prop in feature.properties) {
        // if (prop == "tube_image") {
            // popupcontent.push("<img src='data:image/png;base64, " + feature.properties[prop] + "' />");
        // } else {
            // popupcontent.push(prop + ": " + feature.properties[prop]);
        // };
    // }
    // layer.bindPopup(popupcontent.join("<br />"));      
 
    var popupcontent = "<h4>" + feature.properties["tube_id"] + " - " + feature.properties["tube_nom"] + "</h4><br/>";
    popupcontent += "<p><b>Typologie: </b>" + feature.properties["typo_nom"] + "<br/>";
    popupcontent += "<b>Commune: </b>" + feature.properties["tube_ville"] + "</p><br/>";
    popupcontent += "<img src='data:image/png;base64, " + feature.properties["tube_image"] + "'/>";
    layer.bindPopup(popupcontent);      
 
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
	    
	geojsonLayer.addTo(map); 

	// Zoom sur les tubes	
    zoom_to_layer(geojsonLayer);
			
    // layerControl.addOverlay(geojsonLayer, "Sites de mesures"); // Add layer to layer switcher
}; 
 
/* Création des icones */
var icones = creation_icones();
 
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
 
/* Creation d'un control leaflet pour afficher du texte html 
Pour modifier le contenu:
displayControl.setContent('Afficher graphiques ici?');
*/
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
 
/* var layers = [];
    map.eachLayer(function(layer) {
    // if( layer instanceof L.TileLayer )
        layers.push(layer);
        console.log(layer);
        console.log(layer._leaflet_id)
        // map.fitBounds(layer);
});
console.log(layers);   */  
       
    

   
 

    
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


// Ferme les popups au click sur la carte
// map.on('click', function(e) {        
    // displayControl.setContent('');
    // console.log("TTTTTTTTTTTTTT");
// });



</script>

</body>
</html>