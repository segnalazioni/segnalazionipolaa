<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

 session_start();

?>
<!DOCTYPE html>
<html style="margin:0; padding:0; width:100%; height:100%;">
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Protected Page</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="jquery-3.1.0.min.js"></script>
        <script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
        <link rel="stylesheet" type="text/css" href="teststyle.css"/>
        <script>
			window.Polymer = {
      			dom: 'shady'
    		};
		</script>
        <link rel="impport" href="bower_components/polymer/polymer.html">
		<link rel="import" href="bower_components/paper-toolbar/paper-toolbar.html">
        <link rel="import" href="bower_components/paper-tabs/paper-tabs.html">
        <link rel="import" href="bower_components/paper-dialog/paper-dialog.html">
        <link rel="import" href="bower_components/google-map/google-map.html">
        <link rel="import" href="bower_components/paper-button/paper-button.html">
        <link rel="import" href="bower_components/paper-fab/paper-fab.html">
        <link rel="import" href="bower_components/iron-icons/iron-icons.html">
        <link rel="import" href="bower_components/iron-icons/device-icons.html">
        <link rel="import" href="bower_components/iron-icons/image-icons.html">
        <link rel="import" href="bower_components/paper-dropdown-menu/paper-dropdown-menu.html">
        <link rel="import" href="bower_components/paper-item/paper-item.html">
        <link rel="import" href="bower_components/paper-listbox/paper-listbox.html">
        <link rel="import" href="bower_components/paper-menu/paper-menu.html">
        <link rel="import" href="bower_components/iron-list/iron-list.html">
        <link rel="import" href="bower_components/iron-pages/iron-pages.html">
        <link rel="import" href="bower_components/iron-ajax/iron-ajax.html">
        <link rel="import" href="bower_components/paper-datatable-api/paper-datatable-api.html">
        <link rel="import" href="my-menu.html">
        <link rel="stylesheet" href="teststyle.css" />
    </head>
    <body style="margin:0; padding:0; width:100%; height:100%;">
        <?php/* if (login_check($mysqli) == true) : */?>
        <template is="dom-bind" id="scope">
        	<script>

				var map;
				var mapdialog;
				var latitude;
				var longitude;
				var tipo;
				var openDialogId;
				var oldMarker;
				var markers = [];

				function addAllMarkers(){
					$.ajax ( {
						url: 'get-markers.php',
						type: 'POST',
						success: function(data){
								var result = JSON.parse(data);
								for (i = 0; i < result.length; i++) {
									var id = result[i].seg_id;
									var icon;
									var button;
									if(result[i].stato == 0){
										icon = "img/marker_green_small.png";
										button = "IN LAVORAZIONE";
									}else if(result[i].stato == 1){
										icon = "img/marker_yellow_small.png";
										button = "CHIUDI";
									}else{
										icon = "img/marker_small.png";
										button = "RIAPRI";
									}
									var marker = new google.maps.Marker({
										position: {lat: Number(result[i].latitudine), lng: Number(result[i].longitudine)},
										map: map,
										icon: icon,
										title: result[i].tipo+"  "+result[i].quando
									});
									markers[id] = marker;
									var contentString = '<div id="content">'+
											'<div id="siteNotice">'+
											  '</div>'+
											  '<h1 id="firstHeading" class="firstHeading">'+result[i].tipo+"  "+result[i].quando+'</h1>'+
											  '<div id="bodyContent" style="margin-bottom:40px;">'+
											  result[i].descrizione+
											  '<br/>'+
											  '<template is="dom-bind"><iron-ajax'+
													'auto'+
													'url="get-status.php"'+
													'params="{'+"'id'"+':'+id+'}"'+
													'handle-as="json"'+
													'last-response="{{data}}"'+
													'debounce-duration="300">'+
											  '</iron-ajax>'+
											  '<paper-datatable-api data="[[data]]">'+
												  '<paper-datatable-api-column header="Fruit" property="fruit">'+
													'<template>'+
													  '<span>{{value}}</span>'+
													'</template>'+
												  '</paper-datatable-api-column>'+
												  '<paper-datatable-api-column header="Color" property="color">'+
													'<template>'+
													  '<span>{{value}}</span>'+
													'</template>'+
												  '</paper-datatable-api-column>'+
												'</paper-datatable-api></template>'+
												'<div style="position:absolute; right:0; bottom:0;"><paper-button onclick="openUpdateDialog('+id+')">AGGIORNA STATO</paper-button>'+
											  '<paper-button onclick="clickedclose('+id+', this)">'+button+'</paper-button>'+
											  '</div></div>'+
											  '</div>';
									var infowindow = new google.maps.InfoWindow({
										content: contentString
									});
									marker.addListener('click', function(infowindow, marker) {
										return function () {
											infowindow.open(map, marker);
										};
									}(infowindow, marker));
								}
							 }
						});
				}

				function openUpdateDialog(id){
					document.getElementById('aggiorna-stato').open();
					openDialogId = Number(id);
				}

				function moveToLocationMap(lat, lng){
					var center = new google.maps.LatLng(lat, lng);
					map.panTo(center);
				}

				function moveToLocationSecondMap(lat, lng){
					var center = new google.maps.LatLng(lat, lng);
					mapdialog.panTo(center);
				}

				function clickedclose(id, button){
					var nuovoStato;
					var butTex = Polymer.dom(button).innerHTML;
					var newIcon;

					if(butTex === "IN LAVORAZIONE"){
						nuovoStato = 1;
						newIcon = "img/marker_yellow_small.png";
						Polymer.dom(button).innerHTML = "CHIUDI";
					}else if(butTex === "CHIUDI"){
						nuovoStato = 2;
						newIcon = "img/marker_small.png";
						Polymer.dom(button).innerHTML = "RIAPRI";
					}else{
						nuovoStato = 1;
						newIcon = "img/marker_yellow_small.png";
						Polymer.dom(button).innerHTML = "CHIUDI";
					}
					$.ajax ( {
						url: 'aggiorna-stato.php',
						type: 'POST',
						data: {'nuovostato': nuovoStato, 'id': id},
						success: function(data){
							if(markers[id] != null){
								markers[id].setIcon(newIcon);
							}
						}
					});

				}

				function getShowLocation(){
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(showPosition);
					} else {
						alert("Geolocation is not supported by this browser.");
					}
				}

				function openDialog(){
					document.getElementById('modal-add').open();
					document.getElementById('modal-add').addEventListener('iron-overlay-opened', function(){google.maps.event.trigger(mapdialog, "resize");});
				}

				function showPosition(position){
					var myLatLng = {lat: position.coords.latitude, lng: position.coords.longitude};
					if(oldMarker != null){
						oldMarker.setMap(null);
					}

					var marker = new google.maps.Marker({
						position: myLatLng,
						map: mapdialog
					});
					oldMarker = marker;
					latitude = position.coords.latitude;
					longitude = position.coords.longitude;
					moveToLocationSecondMap(position.coords.latitude, position.coords.longitude);
				}

				function setItem(event){
					alert(event);
					var selectedItem = event.target.selectedItem;
					if (selectedItem) {
						alert("selected: " + selectedItem.innerText);
					}
				}

				function addToDatabase(){
					var tipo = document.querySelector('my-menu').getSelectedElement();
                    var files = document.getElementById('getPhoto').files;
                    alert(files[0]+"");
					var descrizione =  $('textarea').val();
					if(latitude != null && longitude != null){
						$.ajax ( {
						url: 'agg-segn.php',
						type: 'POST',
						data: {'tipo': tipo, 'descr': descrizione, 'lat': latitude, 'lng': longitude, 'user': <?php echo "'".htmlentities($_SESSION['username'])."'"; ?>},
						success: function(data){
								var contentString = '<div id="content">'+
											'<div id="siteNotice">'+
											  '</div>'+
											  '<h1 id="firstHeading" class="firstHeading">'+tipo+"  "+new Date().toLocaleString()+'</h1>'+
											  '<div id="bodyContent" style="margin-bottom:40px;">'+
											  descrizione+
											  '<br/><div style="position:absolute; right:0; bottom:0;"><paper-button onclick="openUpdateDialog()">AGGIORNA STATO</paper-button>'+
											  '<paper-button>CHIUDI</paper-button>'+
											  '</div></div>'+
											  '</div>';
								var infowindow = new google.maps.InfoWindow({
									content: contentString
								});
								var marker = new google.maps.Marker({
									position: {lat: latitude, lng: longitude},
									map: map,
									icon: "img/marker_green_small.png"
								});

								marker.addListener('click', function() {
									infowindow.open(map, marker);
								});
							 }
						});
					}

				}

				function aggiungiUpdate(){
					alert("working");
					var text = document.getElementById('testo').value;

					if(text != ""){
						alert("still working");
						$.ajax ( {
							url: 'add-status.php',
							type: 'POST',
							data: {'text': text, 'id': openDialogId},
							success: function(data){
								alert(data);
							}
						});
					}
				}

				function showFirstPosition(position){
					moveToLocationMap(position.coords.latitude, position.coords.longitude);
				}

				function initMap() {

					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(showFirstPosition);
					} else {
						alert("Geolocation is not supported by this browser.");
					}

    				map = new google.maps.Map(document.getElementById('map'), {
    					center: {lat: 45.698336, lng: 9.677357},
    					zoom: 15,
						mapTypeControl: true,
						mapTypeControlOptions: {
							style: google.maps.MapTypeControlStyle.VERTICAL_BAR,
							position: google.maps.ControlPosition.TOP_LEFT
						},
						  zoomControl: false,
						  scaleControl: false,
						  streetViewControl: false,
						  fullscreenControl: false
					});

					mapdialog = new google.maps.Map(document.getElementById('map-dialog'), {
						center: {lat: 45.698336, lng: 9.677357},
						zoom: 15,
						disableDefaultUI: true
					});

					addAllMarkers();
				}

            </script>


            	<style>
					.gmnoprint a, .gmnoprint span {
						display:none;
					}
					.gm-style-cc{
						display:none;
					}
				</style>

            	<paper-toolbar>
					<paper-tabs selected="{{selected}}" style="margin:0; width:100%; height:100%;">
                		<paper-tab>MAPPA</paper-tab>
                		<paper-tab>ELENCO</paper-tab>
                		<paper-tab>REGISTRAZIONE</paper-tab>
            		</paper-tabs>
        		</paper-toolbar>

                <iron-pages selected="{{selected}}" style="position:absolute; left:0px; right:0px; bottom:0px;">
                	<div style="height:100%">
                    	<div id="map" style="height:100%"></div>
        				<paper-fab icon="add" onclick="openDialog();" style="position:absolute; bottom:30px; right:30px; background-color:#e1382d;"></paper-fab>
                        <paper-dialog id="modal-add" class="segdialog" is="custom-style" modal>
                            <div id="mainDiv" style="margin: 0; padding: 0; height: 100%; width: 100%;">
                                <table class="dialog-content" border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                                    <tr>
                                        <td height="70%">
                                            <div style="width: 100%; height: 100%; position: relative;">
                                                <div id="map-dialog" style="width: 100%; height: 100%;"></div>
                                                <my-menu admin="is"></my-menu>
                                                <paper-fab class="camerafab" icon="image:camera-alt" onclick="document.getElementById('getPhoto').click();"></paper-fab>
                                                <paper-fab class="gpsfab" icon="device:gps-fixed" onclick="getShowLocation();"></paper-fab>
                                                <input id="getPhoto" style="cursor: pointer;" type="file" accept="image/*" capture="camera">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30%"><textarea style="resize:none; overflow: hidden; margin-top:45px; margin-left: 30px; margin-right: 30px; box-sizing: border-box; vertical-align: top; height:100%;"></textarea></td>
                                    </tr>
                                </table>

                                <div class="buttons" style="height: 70px; bottom:5px; right:15px;">
                                    <paper-button dialog-dismiss>ANNULLA</paper-button>
                                    <paper-button dialog-confirm autofocus onclick="addToDatabase();">SEGNALA</paper-button>
                                </div>
                            </div>
        				</paper-dialog>
                        <paper-dialog id="aggiorna-stato" modal>
                        	<div><h1>Aggiunta di un nuovo aggiornamento sullo stato</h1></div>
                            <div style="margin-bottom:60px;"><paper-input id="testo" label="STATO SEGNALAZIONE"></paper-input></div>
                            <div class="buttons" style="position:absolute; bottom:5px; right:15px;">
                                <paper-button dialog-dismiss>ANNULLA</paper-button>
                                <paper-button dialog-confirm autofocus onclick="aggiungiUpdate()">CONFERMA</paper-button>
                            </div>
                        </paper-dialog>

                    </div>
                    <div>Pagina 2</div>
                    <div>Pagina 3</div>
                </iron-pages>

            <script>
  				document.addEventListener('WebComponentsReady', function () {
    				var template = document.querySelector('template[is="dom-bind"]');
    				template.selected = 0; // selected is an index by default
  				});
			</script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnZ5kvHIKRf_01L41sB9lCdv_xijlwHSs&callback=initMap" async defer></script>
        </template>
        <?php /*else : */?><!--
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        --><?php /*endif; */?>
    </body>
</html>
