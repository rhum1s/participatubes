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

<div class="title">Participatubes</div>
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
        popupAnchor:  [9, -41] // point from which the popup should open relative to the iconAnchor
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
    
    
/*
 *******************************************************************************    
 *******************************************************************************
 *******************************************************************************
 *******************************************************************************
 *******************************************************************************
 *******************************************************************************
 *******************************************************************************
 *******************************************************************************
*/
    
    
    
    
    
    
        // console.log("Creating map : " + map_title);
    
		// var map = L.map('map', {layers: []}).setView([43.9, 7.2], 9);
       
        // Map attributions
		// map.attributionControl.addAttribution('Participatubes &copy; <a href="http://www.romain-souweine.fr">Romain Souweine - 2016</a>');

        // Create base layers
        // var base_layer = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoicmh1bSIsImEiOiJjaWx5ZmFnM2wwMGdidmZtNjBnYzVuM2dtIn0.MMLcyhsS00VFpKdopb190Q', {
			// maxZoom: 18,
			// attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
				// '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				// 'Imagery © <a href="http://mapbox.com">Mapbox</a>',
			// id: 'mapbox.streets',
            // opacity: 0.3,
		// });   
        // base_layer.addTo(map);  // We don't add it to map now cause we don't want it to display on sessions load 

        // var base_layer2 = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoicmh1bSIsImEiOiJjaWx5ZmFnM2wwMGdidmZtNjBnYzVuM2dtIn0.MMLcyhsS00VFpKdopb190Q', {
			// maxZoom: 18,
			// attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
				// '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				// 'Imagery © <a href="http://mapbox.com">Mapbox</a>',
			// id: 'mapbox.light',
            // opacity: 1.,
		// });   
        // base_layer2.addTo(map);          
        
		// control that shows state info on hover
		// var info = L.control();

		// info.onAdd = function (map) {
			// this._div = L.DomUtil.create('div', 'info');
			// this.update();
			// return this._div;
		// };

		// info.update = function (props) {
            // console.log("info.update()");
			// this._div.innerHTML = "<h4>Indices de qualité de l'air</h4>" +  (props ?
				// '<b>' + props.nom_comm + '</b><br />Indice ' + props.indice + '</sup>'
				// : ' ');
		// };

		// info.addTo(map);

/* 		// get color depending on population density value
		function getColor(d) {
			return d > 66  ? '#800026' :
			       d > 52  ? '#BD0026' :
			       d > 35  ? '#E31A1C' :
			       d > 28  ? '#FC4E2A' :
			       d > 21  ? '#FD8D3C' :
			       d > 13  ? '#FEB24C' :
			       d > 5   ? '#FED976' :
			                  '#FFEDA0';
		}; */

 		// get color depending on population density value
/* 		function getType(d) {
			// return d > 66  ? '#800026' :
			       // d > 52  ? '#BD0026' :
			       // d > 35  ? '#E31A1C' :
			       // d > 28  ? '#FC4E2A' :
			       // d > 21  ? '#FD8D3C' :
			       // d > 13  ? '#FEB24C' :
			       // d > 5   ? '#FED976' :
			                  // '#FFEDA0';
                              
            var my_icone = L.icon({
                iconUrl: 'incon.png',
                shadowUrl: 'incon.png',

                iconSize:     [38, 95], // size of the icon
                shadowSize:   [50, 64], // size of the shadow
                iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
                shadowAnchor: [4, 62],  // the same for the shadow
                popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
            });
            
            console.log("ù****");
            console.log(my_icone);
            return ;my_icone
            
		};  */       
     

// var greenIcon = L.icon({
    // iconUrl: 'incon.png',
    // shadowUrl: 'incon.png',

    // iconSize:     [38, 95], // size of the icon
    // shadowSize:   [50, 64], // size of the shadow
    // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
    // shadowAnchor: [4, 62],  // the same for the shadow
    // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
// });

/* var icon1 = L.icon({
    iconUrl: 'icons/marker-icon.png',
    shadowUrl: 'icons/marker-shadow.png',

    iconSize:     [24, 38], // size of the icon
    shadowSize:   [50, 64], // size of the shadow
    // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
    // shadowAnchor: [4, 62],  // the same for the shadow
    // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});
var icon2 = L.icon({
    iconUrl: 'icons/ios7-location-outline.png',
    // shadowUrl: 'incon.png',

    iconSize:     [38, 38], // size of the icon
    // shadowSize:   [50, 64], // size of the shadow
    // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
    // shadowAnchor: [4, 62],  // the same for the shadow
    // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
}); */

/*      
 		function style(feature) {
            console.log(feature.properties.type_id);
            console.log('****');
            console.log(greenIcon);
            console.log('****');
            // On fait les jenks ici et on les passes avec les couleurs 
            // en argument dans la fonction getColor(...
			return {
				// weight: 2,
				// opacity: 1,
				// color: 'white',
				// dashArray: '',
				// fillOpacity: 0.5,
				// icon: getType(feature.properties.type_id)
                icon: greenIcon
			};
		};  
         */
/*         function highlightFeature(e) {
            console.log("highlightFeature(e)");
			var layer = e.target;

			layer.setStyle({
				weight: 5,
				color: '#666',
				dashArray: '',
				fillOpacity: 0.5
			});

			if (!L.Browser.ie && !L.Browser.opera) {
				layer.bringToFront();
			};

			info.update(layer.feature.properties);
		};

		var geojsonLayer = new L.GeoJSON();

        
		function resetHighlight(e) {
			geojsonLayer.resetStyle(e.target);
			info.update();
		};
*/ 

/* 		function zoomToFeature(e) {
            console.log(e);
            console.log(e.latlng);
            map.setView(e.latlng, 17);
			// map.fitBounds(e.target.getBounds());
		}; */
/*
		function onEachFeature(feature, layer) {
			layer.on({
				mouseover: highlightFeature,
				mouseout: resetHighlight,
				click: zoomToFeature
			});
		}; */

/*         function loadGeoJson(data) {
        
            console.log(data);
            geojsonLayer = L.geoJson(data, {
                id: 'toto',
                name: 'tata',
                // name: 'tata',
                style: style,
                onEachFeature: onEachFeature,
            }).addTo(map); 
            
            // Calculer les jenks?

            // var toto = jenks_stats(data, "indice", 16);
            // console.log(toto.items); 
            // console.log(toto.jenksResult); 
            // console.log(toto.color_x); 
            // console.log(toto.ranges); 
            // console.log("*************");

		
            
            // ***
                        
            layerControl.addOverlay(geojsonLayer, "Indices communaux"); // Add layer to layer switcher
        }; */
            
            
        // var geoJsonUrl = gs_url + "ows?service=WFS&version=1.0.0&request=GetFeature&typeName=websig:communes_multipoll&outputFormat=application%2Fjson&format_options=callback:loadGeoJson"; 

        // $.ajax({
            // url: geoJsonUrl,
            // datatype: 'json',
            // jsonCallback: 'getJson',
            // success: loadGeoJson
        // });
          

/*         // Legend
		var legend = L.control({position: 'bottomright'});

		legend.onAdd = function (map) {

			var div = L.DomUtil.create('div', 'info legend'),
				grades = [0, 5, 13, 21, 28, 35, 52, 1000],
				labels = [],
				from, to;               
                
			for (var i = 0; i < grades.length; i++) {
				from = grades[i];
				to = grades[i + 1];

				labels.push(
					'<i style="background:' + getColor(from + 1) + '"></i> ' +
					from + (to ? '&ndash;' + to : '+'));
			}

			div.innerHTML = labels.join('<br>');
			return div;
		};

		legend.addTo(map); */
    
/*         // Layers control pannel      
		var baseLayers = {
			"Mapbox.streets": base_layer,
			"Mapbox.light": base_layer2
		};

        var layerControl = L.control.layers(baseLayers, null, {collapsed: false, position:"topright"});
        map.addControl(layerControl); */
      
/*         // Listeners for layers control change and legend update
        function updateLegend(eventLayer, action) {            
            if (action == "add") {
                if (eventLayer.name === 'Indices communaux') {
                    map.addControl(legend);
                }; 
            } else if (action == "remove") {
                if (eventLayer.name === 'Indices communaux') {
                    map.removeControl(legend);
                };        
            } else {
                console.log('ERROR in function updateLegend(eventLayer, action) > action not in ["add", "remove"]');
            };
        }; */
/* 
        map.on('overlayremove', function (eventLayer) {
            updateLegend(eventLayer, "remove");
        }); 
           
        map.on('overlayadd', function (eventLayer) {
            updateLegend(eventLayer, "add");
        });    */    
      



      
 /*        // json_objects = [];
		function onEachFeature(feature, layer) {
            console.log(feature)
			
            
            layer.on({
				// mouseover: highlightFeature,
				// mouseout: resetHighlight,
				click: zoomToFeature
			});
            
            
            
            var popupcontent = [];
            for (var prop in feature.properties) {
                if (prop == "tube_image") {
                    console.log(feature.properties[prop]);
                    popupcontent.push(
                        //"<img src='data:image/png;base64, " + pg_unescape_bytea(feature.properties[prop]) + "' />"
                        "<img src='data:image/png;base64, " + feature.properties[prop] + "' />"
                    );
                    
                } else {
                    popupcontent.push(prop + ": " + feature.properties[prop]);
                };
                
                               
                
            }
            layer.bindPopup(popupcontent.join("<br />"));            
            
            
            
            // json_objects.push(feature);
            // console.log(json_objects);
            
        // featureGroup = L.featureGroup(json_objects)
        // map.fitBounds(featureGroup.getBounds());            
        }; 
             */
        // var geojsonMarkerOptions = {
            // radius: 8,
            // fillColor: "#ff7800",
            // color: "#000",
            // weight: 1,
            // opacity: 1,
            // fillOpacity: 0.8
        // };         
          

          
/*         // Chargement des points de mesure
        function loadGeoJson_tubes(data) {
           
            // Chargement de la vue des tubes depuis Geoserver.

            geojsonLayer = L.geoJson(data, {
                id: 'toto',
                name: 'tata',
                // style: style,
                onEachFeature: onEachFeature,
                // FIXME: Bug dans l'emplacement des markeurs spéciaux"
                // pointToLayer: function (geojson, latlng) {
                    // console.log();
                    // if (geojson.properties['type_id'] == 2) {
                        // return L.marker(latlng, {icon: icon1});                    
                    // } else if (geojson.properties['type_id'] == 1) {
                        // return L.marker(latlng, {icon: icon2});
                    // } else {
                        // return L.marker(latlng, {icon: icon2});
                    // };
                // },
            }).addTo(map); 
                       
            // layerControl.addOverlay(geojsonLayer, "Sites de mesures"); // Add layer to layer switcher
        };  */
 
/*         var geojsonLayer = new L.GeoJSON();
        var geoJsonUrl = gs_url + "ows?service=WFS&version=1.0.0&request=GetFeature&typeName=participatubes:tubes_mef&outputFormat=application%2Fjson&format_options=callback:loadGeoJson"; 

        $.ajax({
            url: geoJsonUrl,
            datatype: 'json',
            jsonCallback: 'getJson',
            success: loadGeoJson_tubes
        }); */

        // map.eachLayer(function (layer) {
            // console.log(layer.url);
            // layer.bindPopup('Hello');
        // }); 
        
/*         var layers = [];
            map.eachLayer(function(layer) {
            // if( layer instanceof L.TileLayer )
                layers.push(layer);
                console.log(layer);
                console.log(layer._leaflet_id)
                // map.fitBounds(layer);
        });
        console.log(layers); */
        
            
            
        // console.log("-------------------------------------------------------");  
        // console.log(geojsonLayer);
        // console.log("-------------------------------------------------------");
        
        
        

// bounds = new L.LatLngBounds(new L.LatLng(49.5, -11.3), new L.LatLng(61.2, 2.5));
// var latlngs = L.rectangle(bounds).getLatLngs();
// L.polyline(latlngs.concat([latlngs[0]])).addTo(map);  // Dessiner un rectangle à la vollée.
// map.setMaxBounds(bounds);	// Should not enter infinite recursion
        
        
        
        
        
        
  // map.on('click', function(e) {
    // console.log(e);
    // map.fitBounds(e.layer);
  // });
       
        
// var group = new L.featureGroup([geojsonLayer]);
// map.fitBounds(geojsonLayer.getBounds());
// map.fitBounds(bounds);
// http://stackoverflow.com/questions/17277686/leaflet-js-center-the-map-on-a-group-of-markers
// --------------------------------------------------------------------------------


 
       
// TEST DE CHARGEMENT DES POINTS EN GEOJSON AVEC SCRIPT PHP QUI CREE LE FICHIER A LA VOLLEE      
// var district_boundary = new L.geoJson();
// district_boundary.addTo(map);

// $.ajax({
// dataType: "json",
// url: wa_url + scripts/postgis_geojson.php?geotable=c_template.tubes&geomfield=geom",
// success: function(data) {
    // $(data.features).each(function(key, data) {
        // console.log("Adding data");
        // district_boundary.addData(data);
    // });
// }
// }).error(function() {console.log("ERROROOOOOOOOOR");});       
// ############################################
       
       
        // Logs usefull infos 
        // console.log('FIN');

