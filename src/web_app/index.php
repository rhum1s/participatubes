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
      
    <!-- Bootbox -->
    <script src="libs/bootbox.js/bootbox.min.js"></script>
        
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
    
    <!-- Chart.js -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
        
    <!-- Config -->
    <script type="text/javascript" src="config.js"></script></script>

    <!-- Scripts -->
    <script type="text/javascript" src="libs/geostats-master/lib/geostats.min.js"></script>
    <script type="text/javascript" src="libs/chroma.js-master/chroma.min.js"></script>
    <script type="text/javascript" src="scripts/jenks.js"></script>
    
    <!-- Leaflet Sidebar -->
    <script src="libs/leaflet-sidebar-master/src/L.Control.Sidebar.modified.js"></script>
    <link rel="stylesheet" href="libs/leaflet-sidebar-master/src/L.Control.Sidebar.modified.css"/>
    
</head>

<!------------------------------------------------------------------------------ 
                                    Body
------------------------------------------------------------------------------->
<body>

<!-- Modal connexion (Utilise le bouton modal de connexion référencé plus bas) --> 
<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>

                </button>
                 <h4 class="modal-title">Connexion</h4>

            </div>
            <form id="myform" class="form-horizontal" role="form" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label popup-label">Utilisateur</label>
                            <input required type="text" class="form-control" name="login" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label popup-label">Mot de passe</label>
                            <input required type="password" class="form-control" name="pwd" value="">
                        </div>
                    </div>
                    <div id="error">
                        <div class="alert alert-danger"> <strong>Erreur</strong></br> Utilisateur ou mot de pass inconnu.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitForm">Login</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="reset">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bouton Modal formulaire tubes -->
<div id="modal_form_tube" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>

                </button>
                 <h4 class="modal-title">Ajouter un tube</h4>

            </div>
            <form id="myform_tube" class="form-horizontal" role="form" method="POST">
                <div class="modal-body">                       
                    
                  <div class="form-group">
                    <div class="col-md-12">
                        <label for="tube_nom">Nom du tube</label>
                        <input type="texts" class="form-control" id="tube_nom" placeholder="Nom du tube" name="tube_nom" >
                    </div>
                  </div>  
                  
                  <div class="form-group">
                    <div class="col-md-12">
                        <label for="type_tube">Typologie</label>
                        <select class="form-control" id="type_tube" name="tube_type">
                          <option>Trafic</option>
                          <option>Urbain</option>
                          <option>Proximité</option>
                          <option>Rural</option>
                        </select>
                    </div>
                  </div>  
                 
                  <div class="form-group">
                    <div class="col-md-12">
                        <!-- TODO: Faire un bouton particulier avec https://www.toptal.com/twitter-bootstrap/the-10-most-common-bootstrap-mistakes -->
                        <label for="tube_photo">Ajouter une photo</label>
                        <input type="file" accept="image/png, image/jpeg, image/gif" class="form-control-file" id="tube_photo" name="tube_image">
                        <small class="text-muted">TODO: Info caractéristiques image</small>
                    </div>  
                  </div>  
              
                    <div id="error_tube">
                    <div class="alert alert-danger"> <strong>Erreur</strong></br> Erreur dans un des champs du formulaire.</div>
                    </div>                        
                    
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitFormTube">Ajouter</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="reset">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div> 

<!-- Bootstrap -->
<!-- https://getbootstrap.com/components/#navbar -->
<!-- http://getbootstrap.com/javascript/ -->
<!-- https://www.toptal.com/twitter-bootstrap/the-10-most-common-bootstrap-mistakes -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
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

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      
        <!-- Bouton home -->
        <li><a href="#" onclick="bootstrap_home();"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
 
		<!-- TEST BTN GRAPIQUES 
		<li> 
		<button type="button" class="btn btn-info" data-toggle="button" aria-pressed="false" autocomplete="off">
		<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
		</button>
		</li>

		<li>

		<div class="checkbox checkbox-success checkbox-inline">
		<input type="checkbox" id="inlineCheckbox2" value="option1" checked>
		<label for="inlineCheckbox2"> Inline Two </label>
		</div>  
		</li>   
		-->  
		 
        <!-- Liste des couches -->
        <li class="dropdown">
          <a href="#" id="dropdownMenu1" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sites de mesure <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li id="dd_tubes" class="disabled"><a href="#" onClick="bootstrap_layers_list('tubes');">Sites de mesure</a></li>
            <li id="dd_tubes_no2" ><a href="#" onClick="bootstrap_layers_list('tubes_no2');">Mesures NO2</a></li>
            <li id="dd_tubes_btex"><a href="#" onClick="bootstrap_layers_list('tubes_btex');">Mesures BTEX</a></li>
            <li role="separator" class="divider"></li>
            <li class="disabled"><a href="#">Mapbox - light</a></li>
          </ul>
        </li>

        <!-- Edition -->    
        <li class="dropdown">
          <a href="#" id="dropdownMenu2" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Edition <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li id="dd_tubes"><a href="#" onClick="start_editing();">Déplacer des tubes</a></li>
            <li id="add_tubes"><a href="#" onClick="ajouter_tubes();">Ajouter des tubes</a></li>
            <li id="del_tubes"><a href="#" onClick="supprimer_tubes();">Supprimer des tubes</a></li>
          </ul>
        </li>
   
        <li id="btn_terminer" class="hidden"><a href="#" onClick="stop_editing();">Terminer</a></li>
		<li id="btn_terminer_ajout_tubes" class="hidden"><a href="#" onClick="ajouter_tubes_fin();">Terminer</a></li>
        <li id="btn_terminer_supprimer_tubes" class="hidden"><a href="#" onClick="supprimer_tubes_fin();">Terminer</a></li>
		
      </ul>
   

      <!-- Formulaire de recherche 
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Mon tube">
        </div>
        <button type="submit" class="btn btn-default">Recherche</button>
      </form>
      -->
      
    <!-- Bouton Modal de connexion (Utilise le modal connexion référencé au début) --> 
    <ul class="nav navbar-nav navbar-right" data-toggle="modal" data-target="#myModal">
        <li><a href="#" id="btn_connexion">Connexion</a></li>
    </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<!-- Leaflet sidebar -->
<div id="sidebar">
    <h1>leaflet-sidebar</h1>
</div>

<!-- Carte Leaflet -->
<div id="map"></div> 

<!-- Image "En développement" 
<a href="#"><img style="position: fixed; top: 0; right: 0; border: 0;" src="icons/developpement.png" alt="Version de développement"></a>
-->

<!------------------------------------------------------------------------------ 
                                    Map script
------------------------------------------------------------------------------->
<script type="text/javascript">

function ajouter_tubes() {

    /* Affiche le bouton terminer */
    $("#dropdownMenu2").addClass('hidden');
    $("#dropdownMenu1").addClass('hidden');
    $("#btn_terminer_ajout_tubes").removeClass('hidden');	
};

function ajouter_tubes_fin() {
	
    /* Affiche le bouton terminer */
    $("#dropdownMenu2").removeClass('hidden');
    $("#dropdownMenu1").removeClass('hidden');
    $("#btn_terminer_ajout_tubes").addClass('hidden');	
    
    /* Remise à zéro de la variable temporaire */
    tmpLayerAddTube = "";
};

function supprimer_tubes() {

    /* Affiche le bouton terminer */
    $("#dropdownMenu2").addClass('hidden');
    $("#dropdownMenu1").addClass('hidden');
    $("#btn_terminer_supprimer_tubes").removeClass('hidden');	
    
    suppression = true
};

function supprimer_tubes_fin() {
    /* Affiche le bouton terminer */
    $("#dropdownMenu2").removeClass('hidden');
    $("#dropdownMenu1").removeClass('hidden');
    $("#btn_terminer_supprimer_tubes").addClass('hidden');	
    
    suppression = false  // TODO: On peut supprimer cette variable juste en regardant si le bouton
                         // supprimer des tubes est activé!
};

function start_editing() {
    /*
    Pour regarder les variables d'un markeur:
    for (var prop in marker) {
        if(!marker.hasOwnProperty(prop)) continue;
        console.log(prop + " = " + marker[prop]);    
    };
    */

    /* Affiche le bouton terminer */
    $("#dropdownMenu2").addClass('hidden');
    $("#dropdownMenu1").addClass('hidden');
    $("#btn_terminer").removeClass('hidden');
    
    /* Enregistre la position initiale de chaque markeur */
    for (var key in tubes_layer._layers) {
        var marker = tubes_layer._layers[key];
        layers_orig[marker.feature.properties.tube_id] = marker._latlng;
    };
        
    /* Rends chaque markeur draggable */
    for (var key in tubes_layer._layers) {
        var marker = tubes_layer._layers[key];
        marker.dragging.enable();
    };
};

function stop_editing() {

    /* Rends chaque markeur non draggable */
    for (var key in tubes_layer._layers) {
        var marker = tubes_layer._layers[key];
        marker.dragging.disable();
    };
    
    /* Affiche le bouton d'édition */
    $("#btn_terminer").addClass('hidden');
    $("#dropdownMenu2").removeClass('hidden');
    $("#dropdownMenu1").removeClass('hidden');

    /* Création du code SQL d'update */
    var sql = "";
    for (var i = 0; i < layers_maj.length; i++) {
        //FIXME: Le schema doit être une variable
        sql += "UPDATE " + wa_sch + ".tubes SET geom = ST_Transform(ST_SetSrid(ST_MakePoint(" + layers_maj[i]["lng"] + "," + layers_maj[i]["lat"] + "), 4326), 2154) WHERE tube_id = '" + layers_maj[i]["id"] + "';";
		console.log(sql);
    };

    /* Si des tubes ont été déplacés */
    if (layers_maj.length > 0) { 
		bootbox.confirm("Enregistrer les modifications ?", function(result) {
			
			/* Si enregisrer alors update bdd */
			if (result == true) {

				$.ajax({
					url: "scripts/update_tubes.php",
					type: 'GET',
					data : {type: "update", sql_queries: sql},
					dataType: 'html',
					beforeSend:function( jqXHR, settings){
						// Passe les variables nécessaires pour error/success
						jqXHR.layers_maj = layers_maj;
						jqXHR.layers_orig = layers_orig;
						jqXHR.tubes_layer = tubes_layer;
						jqXHR.tubes_no2_layer = tubes_no2_layer;
						jqXHR.tubes_btex_layer = tubes_btex_layer;
					},									
					error: function (jqXHR, request, error) {
						
						/* Debug */
						console.log(arguments);
						console.log("Ajax error: " + error);
						
						/* Rollback position des tubes */					
						for (var key in jqXHR.tubes_layer._layers) {
							var marker = jqXHR.tubes_layer._layers[key];
							for (var i = 0; i < jqXHR.layers_maj.length; i++) {
								if (jqXHR.layers_maj[i]["id"] == marker.feature.properties.tube_id){
									marker.setLatLng(jqXHR.layers_orig[jqXHR.layers_maj[i]["id"]]);
								};
							};	
						};						
						
						// TODO: Faire une vraie alerte "Warning"
						bootbox.alert("<font color=\"red\"><strong>ALERT:</strong> Erreur dans l'enregistrement des modifications!</font>", function() {});
						
					},       
					success: function(response,textStatus,jqXHR){
						
						if (response == "Erreure de mise à jour."){
							
							/* Rollback position des tubes */					
							for (var key in jqXHR.tubes_layer._layers) {
								var marker = jqXHR.tubes_layer._layers[key];
								for (var i = 0; i < jqXHR.layers_maj.length; i++) {
									if (jqXHR.layers_maj[i]["id"] == marker.feature.properties.tube_id){
										marker.setLatLng(jqXHR.layers_orig[jqXHR.layers_maj[i]["id"]]);
									};
								};	
							};						
							
							// TODO: Faire une vraie alerte "Warning"
							bootbox.alert("<font color=\"red\"><strong>ALERT:</strong> Erreur dans l'enregistrement des modifications!</font>", function() {});							
								
						} else {
						
							/* Mise à jour des positions des tubes NO2 et BTEX */
							for (var i = 0; i < jqXHR.layers_maj.length; i++) {
								// --- NO2
								for (var key in jqXHR.tubes_no2_layer._layers) {
									var marker = jqXHR.tubes_no2_layer._layers[key];
									if (jqXHR.layers_maj[i]["id"] == marker.feature.properties.tube_id){
										var newLatLng = new L.LatLng(jqXHR.layers_maj[i]["lat"], jqXHR.layers_maj[i]["lng"]);
										marker.setLatLng(newLatLng);
									};
								};
								// --- BTEX
								for (var key in jqXHR.tubes_btex_layer._layers) {
									var marker = jqXHR.tubes_btex_layer._layers[key];
									if (jqXHR.layers_maj[i]["id"] == marker.feature.properties.tube_id){
										var newLatLng = new L.LatLng(jqXHR.layers_maj[i]["lat"], jqXHR.layers_maj[i]["lng"]);
										marker.setLatLng(newLatLng);
									};
								};					
							};						
							
							bootbox.alert("Modifications enregistrées.", function() {});	
						};		 
					},
				});
						
			} else {
				
				/* Sinon rollback la position des tubes */
				for (var key in tubes_layer._layers) {
					var marker = tubes_layer._layers[key];
					for (var i = 0; i < layers_maj.length; i++) {
						if (layers_maj[i]["id"] == marker.feature.properties.tube_id){
							marker.setLatLng(layers_orig[layers_maj[i]["id"]]);
						};
					};	
				};
				
			};
			
			/* Mise à 0 des compteurs de mise à jour */
			layers_orig = {};
			layers_maj = [];			
			
		}); 
	};
};

function bootstrap_layers_list(layer_name) {
   
    $("#dropdownMenu2").addClass('hidden');
   
    displayControl.setContent('');
    
    if (layer_name == 'tubes') {
        $("#dropdownMenu1").html('Sites de mesure <span class="caret"></span>');
        $("#dd_tubes").addClass( "disabled" );
        $("#dd_tubes_no2").removeClass( "disabled" );
        $("#dd_tubes_btex").removeClass( "disabled" );
        map.removeLayer(tubes_btex_layer);
        map.removeLayer(tubes_no2_layer);
        map.addLayer(tubes_layer);
        if (user != "public") {
            $("#dropdownMenu2").removeClass('hidden');
        };
    } else if (layer_name == 'tubes_no2') {
        $("#dropdownMenu1").html('Mesures NO2 <span class="caret"></span>');
        $("#dd_tubes_no2").addClass( "disabled" );
        $("#dd_tubes").removeClass( "disabled" );
        $("#dd_tubes_btex").removeClass( "disabled" );        
        map.removeLayer(tubes_layer);
        map.removeLayer(tubes_btex_layer);
        map.addLayer(tubes_no2_layer);   
        map.removeLayer(tmpLayer1);
        $("#dropdownMenu2").addClass('hidden');  
    } else if (layer_name == 'tubes_btex') {
        $("#dropdownMenu1").html('Mesures BTEX <span class="caret"></span>');
        $("#dd_tubes_btex").addClass( "disabled" );
        $("#dd_tubes").removeClass( "disabled" );
        $("#dd_tubes_no2").removeClass( "disabled" );          
        map.removeLayer(tubes_layer);
        map.removeLayer(tubes_no2_layer);
        map.addLayer(tubes_btex_layer);  
        map.removeLayer(tmpLayer1);
        $("#dropdownMenu2").addClass('hidden');      
    };  
};

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
    tube = this.feature; 
    couche = tube.properties.layer;
    
    /* Si session de suppression en cours alors on supprime */
    
    if ((couche == "tubes") && (suppression == true)) {
        // console.log(this.feature);
        console.log("TODO: Modal de suppression pour le point " + tube.properties.tube_id);
    };
    
    /* Surbrillance du point selectionné */
    if (couche == "tubes") { 
        map.removeLayer(tmpLayer1);
        tmpLayer1 = new L.CircleMarker(e.latlng, {
            radius: 16, fillOpacity: 0.3, fillColor: "#4B4B4B", color:"#4B4B4B", opacity: 0.3
        }).addTo(map);    
    } else {
        var layer = e.target;
        layer.setStyle({weight: 4});  // color: "#FFBF00", // layer.setIcon(layer.options.icon = icones.iconDiv);
        if (tmpLayer) tmpLayer.setStyle({weight: 2});  // color: "#4B4B4B", 
        tmpLayer = layer;  
    };
    
   /* Affiche la side bar */
   sidebar.show();     
    
    $.ajax({
        url: "scripts/query_tubes.php",
        type: 'GET',
        data : { tube_id: tube.properties.tube_id, user: user },
        dataType: 'json',
        error: function (request, error) {
            console.log(arguments);
            console.log("Ajax error: " + error);
        },       
        success: function(response,textStatus,jqXHR){

            // Prépare le ou les élément(s) HTML du graph
            // -- Si tubes no2
            if ((couche == "tubes")&&(response[0][0].nb_poll == 1)) {
                sidebar.setContent('<canvas id="graph_no2" width="600" height="350"></canvas>');            
            // -- Si tubes no2 + btex
            } else if ((couche == "tubes")&&(response[0][0].nb_poll > 1)) {
                sidebar.setContent('<canvas id="graph_no2" width="600" height="350"></canvas><br/><canvas id="graph_btex" width="600" height="300"></canvas>');            
            // -- Si mesures no2
            } else if ((couche == "mes_no2")&&(response[0][0].nb_poll = 1)) {
                sidebar.setContent('<canvas id="graph_mes_no2" width="600" height="700"></canvas>');            
            // -- Si mesures btex
            } else if ((couche == "mes_btex")&&(response[0][0].nb_poll > 1)) {
                sidebar.setContent('<canvas id="graph_mes_btex" width="600" height="700"></canvas>');            
            };           

            // Graphique tubes NO2           
            if ((couche == "tubes")&&(typeof response[1][0] !== "undefined")) {
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
                
                // -- Graphique
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

              
            
            
            // Graphique tubes BTEX            
            if ((couche == "tubes")&&(typeof response[2][0] !== "undefined")) {
            
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
                
                // -- Graphique
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

            // Graphique mesures BTEX             
            if ((couche == "mes_btex")&&(typeof response[3][0] !== "undefined")) {
            
                // -- Labels
                var graph_labels = [];
                for (var i in response[3]) {
                    graph_labels.push(response[3][i].tube_nom);
                };            
                
                // -- Titre
                var graph_title = "Total BTEX (" + response[3][0].nom_unite + ")";
                
                // -- Données
                var graph_data = [];
                for (var i in response[3]) {
                    graph_data.push(response[3][i].val);
                };   
                
                // -- Couleur des barres
                var graph_colors = [];
                var graph_border_colors = [];
                for (var i in response[3]) {
                    if (response[3][i].tube_id == tube.properties.tube_id) {
                        graph_colors.push('rgba(75, 75, 75, 0.8)');
                        graph_border_colors.push('rgba(75, 75, 75, 1)');
                    } else {
                        graph_colors.push('rgba(170, 170, 170, 0.8)');
                        graph_border_colors.push('rgba(170, 170, 170, 1)');
                    };
                };                      
                
                // -- Graphique
                var ctx = document.getElementById("graph_mes_btex");
                var graph_mes = new Chart(ctx, {
                    type: 'horizontalBar', // 'bar',          
                    data: {
                        labels: graph_labels,
                        datasets: [{
                            label: 'BTEX',
                            data: graph_data,
                            backgroundColor: graph_colors,
                            borderColor: graph_border_colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        animation : false,
                        responsive: true,
                        maintainAspectRatio: false,    
                        responsiveAnimationDuration: 0,                   
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
                                    // categorySpacing: 0,
                                }
                            }],
                            xAxes: [{ barPercentage: 1. }],
                        }
                    }
                });  
            };

            // Graphique mesures NO2            
            if ((couche == "mes_no2")&&(typeof response[4][0] !== "undefined")) {
                
                // -- Labels
                var graph_labels = [];
                for (var i in response[4]) {
                    // graph_labels.push(response[4][i].tube_nom);
                    graph_labels.push("");
                };            
                
                // -- Titre
                var graph_title = "NO2 corrigé (" + response[4][0].nom_unite + ")";
                
                // -- Données
                var graph_data = [];
                for (var i in response[4]) {
                    graph_data.push(response[4][i].val);
                };   
                
                // -- Couleur des barres 
                var graph_colors = [];
                var graph_border_colors = [];
                for (var i in response[4]) {
                    if (response[4][i].tube_id == tube.properties.tube_id) {
                        graph_colors.push('rgba(75, 75, 75, 0.8)');
                        graph_border_colors.push('rgba(75, 75, 75, 1)');
                    } else {
                        graph_colors.push('rgba(170, 170, 170, 0.8)');
                        graph_border_colors.push('rgba(170, 170, 170, 1)');
                    };
                };                      
                
                // -- Graphique
                var ctx = document.getElementById("graph_mes_no2");
                var graph_mes = new Chart(ctx, {
                    type: 'horizontalBar', // 'bar' ,          
                    data: {
                        labels: graph_labels,
                        datasets: [{
                            label: 'NO2',
                            data: graph_data,
                            backgroundColor: graph_colors,
                            borderColor: graph_border_colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        animation : false,
                        responsive: true,
                        maintainAspectRatio: false,    
                        responsiveAnimationDuration: 0,                   
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
                                    // categorySpacing: 0,
                                }
                            }],
                            xAxes: [{ barPercentage: 1. }],
                        }
                    }
                }); 
                
                
				/* TODO - Si click sur bar zoom sur le tube */
				ctx.onclick = function(evt){
					//console.log(graph_mes);
					
					var activePoints = graph_mes.getElementAtEvent(evt);
					// console.log(response[4][activePoints[0]._index]["tube_id"]);
					
					if (typeof activePoints[0] !== 'undefined') {
						
						for (var key in tubes_layer._layers) {
							var marker = tubes_layer._layers[key];
							if (marker.feature.properties.tube_id == parseInt(response[4][activePoints[0]._index]["tube_id"])) {
								console.log(marker._latlng);
								map.setView(e.latlng);
								
								
								
								/* Surbrillance du point selectionné 
								FIXME - Répétition de code, faire une fonction */
								//if (couche == "tubes") { 
								//	map.removeLayer(tmpLayer1);
								//	tmpLayer1 = new L.CircleMarker(e.latlng, {
								//		radius: 16, fillOpacity: 0.3, fillColor: "#4B4B4B", color:"#4B4B4B", opacity: 0.3
								//	}).addTo(map);    
								//} else {
									//var layer = e.target;
									// layer.setStyle({weight: 4});  // color: "#FFBF00", // layer.setIcon(layer.options.icon = icones.iconDiv);
									console.log(marker);
									marker.setStyle({weight: 4});
									//if (tmpLayer) tmpLayer.setStyle({weight: 2});  // color: "#4B4B4B", 
									//tmpLayer = layer;  
								//};
								
								
								
								
								
								
								
							};
							//console.log(marker.feature.properties.tube_id, parseInt(response[4][activePoints[0]._index]["tube_id"]));
						};
					};
					
				};
				
				
                 
            };
    
        }
    });


    
};

function onEachTube(feature, layer) {
    /*
    Code qui sera appliqué à chaque objet lors du chargement des tubes.
    */
      
    /* Ajout d'une propriété layer pour retrouver la couche */
    feature.properties.layer = 'tubes'; 
    
    /* Appel la fonction onClickFeature() en cliquant sur l'objet */
    layer.on({
        click: onClickFeature
    });
    
    /* Si l'utilisateur est un administrateur, il peut déplacer le marqueur */
    if (user == "public") {

        layer.on('dragend', function(event){
        
                /* Retourne query update id tube et coordonnées en SQL */
                var tube_id = event.target.feature.properties.tube_id;
                var position = event.target.getLatLng();
                var tube_lat = position["lat"];
                var tube_lng = position["lng"];
               
                layers_maj.push({"id":tube_id, "lat":tube_lat, "lng":tube_lng});
        });        
    };

    /* Ajoute un popup avec les valeurs de l'objet */
    var popupcontent = "<h4>" + feature.properties["tube_nom"] + "</h4>";
    popupcontent += "<p><b>Identifiant: </b>" + feature.properties["tube_id"] + "<br/>";
    popupcontent += "<b>Typologie: </b>" + feature.properties["typo_nom"] + "<br/>";
    popupcontent += "<b>Polluants: </b>" + feature.properties["polluants"] + "<br/>";
    popupcontent += "<b>Commune: </b>" + feature.properties["tube_ville"] + "</p><br/>";
    popupcontent += "<img src='data:image/png;base64, " + feature.properties["tube_image"] + "'/>";
    layer.bindPopup(popupcontent);      
}; 

function onEachTube_btex(feature, layer) {
    /*
    Code qui sera appliqué à chaque objet lors du chargement des tubes.
    */
    
    /* Ajout d'une propriété layer pour retrouver la couche */
    feature.properties.layer = 'mes_btex'; 
      
    /* Appel la fonction onClickFeature() en cliquant sur l'objet */
    layer.on({
        click: onClickFeature
    });  
}; 

function onEachTube_no2(feature, layer) {
    /*
    Code qui sera appliqué à chaque objet lors du chargement des tubes.
    */
    
    /* Ajout d'une propriété layer pour retrouver la couche */
    feature.properties.layer = 'mes_no2'; 
      
    /* Appel la fonction onClickFeature() en cliquant sur l'objet */
    layer.on({
        click: onClickFeature
    });  
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
    if (must_zoom == true){
        zoom_to_layer(tubes_layer);
	}; 	
    
    /* Ajoute la couche au contrôleur de couches */
    layerControl.addOverlay(tubes_layer, "Points des mesures");
}; 

function loadGeoJson_tubes_btex(data) {
    /*
    Fonction de création de la couche des tubes BTEX
    qui sera appelée si une donnée a été récupérée depuis Geoserver
    */
    
    // Liste des valeurs BTEX
    items = [];
    for (var i in data.features) {
        
        items.push(data.features[i].properties.tot_btex);
    };     
    
    // Création des classes Jenks et couleurs
    classifier = new geostats(items);
    jenksResult = classifier.getJenks(6);
    ranges = classifier.getRanges(6);
    var color_x = chroma.scale('Reds').colors(6)
    // console.log(items);    
    // console.log(jenksResult);
    // console.log(color_x);    
    // console.log(ranges);   
    
    /* Charge les tubes depuis Geoserver */
    tubes_btex_layer = L.geoJson(data, {
        id: 'tubes_btex',
        name: 'Tubes BTEX',
        onEachFeature: onEachTube_btex,

        /* Crée le style de chaque marqueur en fonction des Jenks */
        style: function(geojson) {

            for (index = 0, len = jenksResult.length; index < len; ++index) { 
                if (index != 0) {        
                    if ( geojson.properties.tot_btex <= jenksResult[index]) {

                        return {
                            color: '#4B4B4B',
                            opacity: 1,
                            fillColor: color_x[index-1],
                            fillOpacity: 1.,
                            weight: 2,
                            radius: 10 + index * 1.3,
                            clickable: true,
                        };
                    };
                };
            };  
            
        },
        
        /* Crée un layer au lieu de simples marqueurs */
        pointToLayer: function(geojson, latlng) {
            return new L.CircleMarker(latlng, {radius: 0, fillOpacity: 0.85});
        },      
    });
	
    /* Ajoute les tubes à la carte */
	// tubes_btex_layer.addTo(map); 
			
    /* Ajoute la couche au contrôleur de couches */
    layerControl.addOverlay(tubes_btex_layer, "Points des mesures BTEX");
}; 

function loadGeoJson_tubes_no2(data) {
    /*
    Fonction de création de la couche des tubes NO2
    qui sera appelée si une donnée a été récupérée depuis Geoserver
    */
    
    // Liste des valeurs NO2
    items = [];
    for (var i in data.features) {
        
        items.push(data.features[i].properties.tot_no2);
    };  

    // Création des classes Jenks et couleurs
    classifier = new geostats(items);
    jenksResult = classifier.getJenks(8);
    ranges = classifier.getRanges(8);
    var color_x = chroma.scale('Reds').colors(8)
    // console.log(items);    
    // console.log(jenksResult);
    // console.log(color_x);    
    // console.log(ranges);  
    
    /* Charge les tubes depuis Geoserver */
    tubes_no2_layer = L.geoJson(data, {
        id: 'tubes_no2',
        name: 'Tubes NO2',
        onEachFeature: onEachTube_no2,

        /* Crée le style de chaque marqueur en fonction des Jenks */
        style: function(geojson) {

            for (index = 0, len = jenksResult.length; index < len; ++index) { 
                if (index != 0) {        
                    if ( geojson.properties.tot_no2 <= jenksResult[index]) {

                        return {
                            color: '#4B4B4B',
                            opacity: 1,
                            fillColor: color_x[index-1],
                            fillOpacity: 1.,
                            weight: 2,
                            radius: 10 + index * 1.3,
                            clickable: true,
                        };
                    };
                };
            };  
            
        },
        
        /* Crée un layer au lieu de simples marqueurs */
        pointToLayer: function(geojson, latlng) {
            return new L.CircleMarker(latlng, {radius: 0, fillOpacity: 0.85});
        },      
    });
	
    /* Ajoute les tubes à la carte */
	// tubes_no2_layer.addTo(map); 
			
    /* Ajoute la couche au contrôleur de couches */
    layerControl.addOverlay(tubes_no2_layer, "Points des mesures NO2");
}; 

// function supprimer_couches(){
    // tubeslayer
// };

/* Enlève les boutons d'édition
$("#dropdownMenu2").addClass('hidden');
 */
/* Variable utilisateur (Chargera fichiers de cfg différents) */ 
var user = "public";
var layers_orig = {};
var layers_maj = [];

/* Variable de layer temporaire */
var tmpLayer = "";
var tmpLayer1 = "";
var tmpLayerAddTube = "";
var tmp_latlng = "";

/* Autres variables générales */
var must_zoom = true;
var suppression = false; 

/* Création des icones */
var icones = creation_icones();
 
/* Création de la carte */
var map = L.map('map', {layers: []}).setView([43.9, 7.2], 9);    
map.attributionControl.addAttribution('Participatubes &copy; <a href="http://www.romain-souweine.fr">Romain Souweine - 2016</a>');    

/* Chargement des fonds carto */    
// TODO: https://leaflet-extras.github.io/leaflet-providers/preview/
var mapbox_light = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoicmh1bSIsImEiOiJjaWx5ZmFnM2wwMGdidmZtNjBnYzVuM2dtIn0.MMLcyhsS00VFpKdopb190Q', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
        '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="http://mapbox.com">Mapbox</a>',
    id: 'mapbox.light',
    opacity: 1.,
});   
mapbox_light.addTo(map);
// var mapbox_light = L.tileLayer('http://{s}.tile.openstreetmap.se/hydda/full/{z}/{x}/{y}.png', {
	// attribution: 'Tiles courtesy of <a href="http://openstreetmap.se/" target="_blank">OpenStreetMap Sweden</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
// });
// mapbox_light.addTo(map); 

/* Chargement de la vue des tubes depuis Geoserver. */
var tubes_layer = new L.GeoJSON();
var geoJsonUrl = gs_url + "ows?service=WFS&version=1.0.0&request=GetFeature&typeName=participatubes:tubes_mef&outputFormat=application%2Fjson&format_options=callback:loadGeoJson"; 

$.ajax({
    url: geoJsonUrl,
    datatype: 'json',
    jsonCallback: 'getJson',
    success: loadGeoJson_tubes
});   

/* Chargement de la vue des tubes btex. */
var tubes_btex_layer = new L.GeoJSON();
cql_filter = "&CQL_FILTER=tot_btex IS NOT NULL"; //cql_filter = "&CQL_FILTER=polluants='NO2 et BTEX'";
var geoJsonUrl = gs_url + "ows?service=WFS&version=1.0.0&request=GetFeature&typeName=participatubes:tubes_mef" + cql_filter + "&outputFormat=application%2Fjson&format_options=callback:loadGeoJson"; 

$.ajax({
    url: geoJsonUrl,
    datatype: 'json',
    jsonCallback: 'getJson',
    success: loadGeoJson_tubes_btex
});  

/* Chargement de la vue des tubes no2. */
var tubes_no2_layer = new L.GeoJSON();
cql_filter = "&CQL_FILTER=tot_no2 IS NOT NULL";
var geoJsonUrl = gs_url + "ows?service=WFS&version=1.0.0&request=GetFeature&typeName=participatubes:tubes_mef" + cql_filter + "&outputFormat=application%2Fjson&format_options=callback:loadGeoJson"; 

$.ajax({
	url: geoJsonUrl,
	datatype: 'json',
	jsonCallback: 'getJson',
	success: loadGeoJson_tubes_no2
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

/* Prise en compte du click sur la carte */
map.on('click', function(e) {   
	
	// Cache les affichages graphs et popups     
    displayControl.setContent('');
    sidebar.hide();
    
    // Ajout de tubes
    if (!$("#btn_terminer_ajout_tubes").hasClass('hidden')) {
		
		/* Enregistre la position du tube */
		tmp_latlng = e.latlng;
		
		/* Afficher le formulaire d'insertion */
		$('#modal_form_tube').modal('show');
	};
	
});

/* Ajout du contrôleur de couches Leaflet "LayerSwitcher" */
var baseLayers = {"Fonde de carte: MapBox Light": mapbox_light,};
var layerControl = L.control.layers(baseLayers, null, {collapsed: false, position:"bottomleft"});
// map.addControl(layerControl); 

/* Ajout du control Leaflet "ZoomBox" */
L.Control.boxzoom({ position:'topleft' }).addTo(map);

/* Connexion à travers le formulaire Bootstrap */
$('#myModal').on('hidden.bs.modal', function () {
    $(this).removeData('bs.modal');
    $(':input', '#myform').val("");
    $("#error").hide();
});

$("#error").hide();
$("#submitForm").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "scripts/connexion.php",
        data: $('#myform').serialize(),
        success: function(response,textStatus,jqXHR){
            if (response.length == 0) {
                $("#error").show();    
            } else {
                if (response[0].nom_privilege == "Administrateur") {					
                    user = "admin";
                    $("a#btn_connexion").text("Utilisateur - " + response[0].prenom_utilisateur + " " + response[0].nom_utilisateur);
                    $("#myModal").modal('hide');
                    if ($("#dd_tubes").hasClass("disabled")) {
                        $("#dropdownMenu2").removeClass('hidden');
                    };
                    $("#dd_tubes").removeClass('disabled');
                } else {
                    user = "public";
                    $("a#btn_connexion").text("Connexion");
                    $("#myModal").modal('hide');  
                    $("#dropdownMenu2").addClass('hidden');                    
                };              
            };
        },
        error: function (request, error) {
            console.log(arguments);
            console.log("Ajax error: " + error);
            $("#error").show();
        },        
    });
});

/* Gestion du formulaire tube */
$('#modal_form_tube').on('hidden.bs.modal', function () {
    $(this).removeData('bs.modal');
    $(':input', '#myform_tube').val("");
    $("#error_tube").hide();
});

$("#error_tube").hide();

$("#submitFormTube").click(function (e) {
    e.preventDefault();

    /* Vérification du formulaire (sans le champ photo) */
    if ($('#myform_tube').serializeArray()[0].value == "") {
		$("#error_tube").show();
		return;
	};
	if (typeof $('#myform_tube').serializeArray()[1] == 'undefined') {
		$("#error_tube").show();
		return;
	};
    
    /* Upload de la photo avant requetes */
    if ($('#tube_photo')[0].files && $('#tube_photo')[0].files[0]) {
		
		// Traitement de l'image	
		// Code récupéré ici: http://stackoverflow.com/questions/10333971/html5-pre-resize-images-before-uploading
		var reader = new FileReader();
		reader.onload = function (e) {

			var canvas = document.createElement('canvas');
			var img = document.createElement("img");
		
			img.src = e.target.result;

			var ctx = canvas.getContext("2d");
			ctx.drawImage(img, 0, 0);

			var MAX_WIDTH = 100;
			var MAX_HEIGHT = 500;
			var width = img.width;
			var height = img.height;
			
			console.log(width, height);

			if (width > height) {
			  if (width > MAX_WIDTH) {
				height *= MAX_WIDTH / width;
				width = MAX_WIDTH;
			  }
			} else {
			  if (height > MAX_HEIGHT) {
				width *= MAX_HEIGHT / height;
				height = MAX_HEIGHT;
			  }
			}
			canvas.width = width;
			canvas.height = height;
			var ctx = canvas.getContext("2d");
			ctx.drawImage(img, 0, 0, width, height);

			var dataurl = canvas.toDataURL("image/jpeg"); // peut etre fait en png
			
			// FIXME: Peut ne pas fonctionner le premier coup, pourquoi?
			
			// FIXME: Peut ne pas fonctionner sous IOS:
			// http://stackoverflow.com/questions/11929099/html5-canvas-drawimage-ratio-bug-ios
			
			/* Execution de la requête et insertion du marqueur */
			$.ajax({
				type: "POST",
				url: "scripts/insertion_tube.php",
				data: { 
					lat: tmp_latlng.lat, 
					lng: tmp_latlng.lng,
					image: dataurl.replace('data:image/jpeg;base64,', ''), //image: e.target.result.replace('data:image/jpeg;base64,', ''),
					nom: $('#myform_tube').serializeArray()[0].value,
					type: $('#myform_tube').serializeArray()[1].value
				},
				dataType: 'json',
				beforeSend:function( jqXHR, settings){
					jqXHR.latlng = tmp_latlng;
					jqXHR.icones = icones;
					jqXHR.image = e.target.result;
                    jqXHR.tubes_layer = tubes_layer;
				},
				success: function(response,textStatus,jqXHR){
					
                    /* On supprime la couche tubes avant de la récréer */
                    for (var key in jqXHR.tubes_layer._layers) {
                        map.removeLayer(jqXHR.tubes_layer._layers[key]);
                        
                    };
                    
					/* Chargement de la vue des tubes depuis Geoserver. */
					var tubes_layer = new L.GeoJSON();
					var geoJsonUrl = gs_url + "ows?service=WFS&version=1.0.0&request=GetFeature&typeName=participatubes:tubes_mef&outputFormat=application%2Fjson&format_options=callback:loadGeoJson"; 

                    /* On ne veut pas zoomer au rechargement de la couche tubes */
                    must_zoom = false;
                    
					$.ajax({
						url: geoJsonUrl,
						datatype: 'json',
						jsonCallback: 'getJson',
						success: loadGeoJson_tubes
					}); 					
					
					// Fermeture du formulaire 
					$("#modal_form_tube").modal('hide');
		 
				},
				error: function (request, error) {
					console.log(arguments);
					console.log("Ajax error: " + error);
					$("#error_tube").show();
				},        
			});			
			
		};
		reader.readAsDataURL($('#tube_photo')[0].files[0]);
	} else {
		$("#error_tube").show();
	};
});

/* Leaflet sidebar */
var sidebar = L.control.sidebar('sidebar', {
    closeButton: true,
    position: 'right',
    autoPan: true,
});
map.addControl(sidebar);
sidebar.hide();

/* Leaflet location */
map.locate({setView: false, maxZoom: 13});

function onLocationFound(e) {
    var radius = e.accuracy / 2;
    L.marker(e.latlng).addTo(map).bindPopup("Approxiation " + radius + " mètres.") //.openPopup();
    L.circle(e.latlng, radius).addTo(map);
};

map.on('locationfound', onLocationFound);
function onLocationError(e) {
    alert(e.message);
};

map.on('locationerror', onLocationError);



</script>

</body>
</html>
