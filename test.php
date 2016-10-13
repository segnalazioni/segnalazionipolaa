<!doctype html>
<html style="height:100%; width:100%;">
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
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
        <link rel="import" href="bower_components/paper-dropdown-menu/paper-dropdown-menu.html">
        <link rel="import" href="bower_components/paper-item/paper-item.html">
        <link rel="import" href="bower_components/paper-listbox/paper-listbox.html">
        <link rel="import" href="bower_components/paper-menu/paper-menu.html">
        <link rel="import" href="bower_components/iron-list/iron-list.html">
        <link rel="import" href="my-menu.html">
</head>

<body style="width:100%; height:100%; margin:0; padding:0;">
	<script>

		var map;
		var mapdialog;
		var latitude;
		var longitude;
		var tipo;
		var oldMarker;

		function addAllMarkers(){
			$.ajax ( {
				url: 'get-markers.php',
				type: 'POST',
				success: function(data){
						var result = JSON.parse(data);

						for (i = 0; i < result.length; i++) {
 					 		var marker = new google.maps.Marker({
    							position: {lat: Number(result[i].latitudine), lng: Number(result[i].longitudine)},
    							map: map,
								title: 'Uluru (Ayers Rock)'
  							});
							var contentString = '<div id="content">'+
      								'<div id="siteNotice">'+
									  '</div>'+
									  '<h1 id="firstHeading" class="firstHeading">'+result[i].tipo+"  "+result[i].quando+'</h1>'+
									  '<div id="bodyContent">'+
									  result[i].descrizione+
									  '<br/><paper-button>MODIFICA</paper-button><br/>'+
									  '<paper-button>CHIUDI</paper-button>'+
									  '</div>'+
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

		function openDialog(){
			document.getElementById('modal-add').open();
			document.getElementById('modal-add').addEventListener('iron-overlay-opened', function(){google.maps.event.trigger(mapdialog, "resize");});
		}

		function setButtonText(sender){
			document.getElementById('button-dr').innerHTML = sender.innerHTML;
		}

		function myFunction() {
    		document.getElementById("myDropdown").classList.toggle("show");
		}

		// Close the dropdown menu if the user clicks outside of it
		window.onclick = function(event) {
  			if (!event.target.matches('.dropbtn')) {

				var dropdowns = document.getElementsByClassName("dropdown-content");
				var i;
				for (i = 0; i < dropdowns.length; i++) {
					var openDropdown = dropdowns[i];
					if (openDropdown.classList.contains('show')) {
						openDropdown.classList.remove('show');
					}
				}
  			}
		}

		function getShowLocation(){
			if (navigator.geolocation) {
        		navigator.geolocation.getCurrentPosition(showPosition);
    		} else {
        		alert("Geolocation is not supported by this browser.");
    		}
		}



    	function initMap() {
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
			var descrizione =  $('textarea').val();
			if(latitude != null && longitude != null){
				$.ajax ( {
				url: 'agg-segn.php',
				type: 'POST',
				data: {'tipo': tipo, 'descr': descrizione, 'lat': latitude, 'lng': longitude},
				success: function(data){
						alert(data+"");
						var contentString = '<div id="content">'+
      								'<div id="siteNotice">'+
									  '</div>'+
									  '<h1 id="firstHeading" class="firstHeading">'+tipo+"  "+new Date().toLocaleString()+'</h1>'+
									  '<div id="bodyContent">'+
									  descrizione+
									  '<br/><paper-button>MODIFICA</paper-button><br/>'+
									  '<paper-button>CHIUDI</paper-button>'+
									  '</div>'+
									  '</div>';
						var infowindow = new google.maps.InfoWindow({
    						content: contentString
  						});
						var marker = new google.maps.Marker({
    						position: {lat: latitude, lng: longitude},
    						map: map
  						});

						marker.addListener('click', function() {
    						infowindow.open(map, marker);
  						});
					 }
				});
			}

		}
	</script>
    <style>
		.gmnoprint a, .gmnoprint spancc {
    		display:none;
		}
		.gm-style-cc{
			display:none;
		}
	</style>
	<div style="width:100%; height:100%; display: flex; flex-direction: column;">
    	<paper-toolbar>
			<paper-tabs selected="0" style="margin:0; width:100%; height:100%;">
                <paper-tab>MAPPA</paper-tab>
                <paper-tab>ELENCO</paper-tab>
                <paper-tab>REGISTRAZIONE</paper-tab>
            </paper-tabs>
        </paper-toolbar>
        <div id="map" style="margin:0; padding:0; width:100%; height:100%;">
        </div>
        <paper-fab icon="add" onclick="openDialog();" style="position:absolute; bottom:30px; right:30px; background-color:#e1382d;"></paper-fab>
    </div>
    <paper-dialog id="modal-add" class="segdialog" is="custom-style" modal>
    	<div style="margin-top:0px; position:relative; padding:0; height:70%;">
        	<div id="map-dialog" style="margin:0; padding:0; width:100%; height:100%;">
        </div>
            <my-menu admin="is"></my-menu>
            <paper-fab class="gpsfab" icon="device:gps-fixed" onclick="getShowLocation();" style="position:absolute; right:30px; --paper-fab-mini:true; bottom:-28px; background-color:#e1382d;"></paper-fab>
            <textarea id="description" style="margin:0 auto, 0 auto; resize:none; font-size:30px; border:none; width:99%; height:20%"></textarea>
        </div>

        <div class="buttons" style="position:absolute; bottom:5px; right:15px;">
          	<paper-button dialog-dismiss>ANNULLA</paper-button>
    		<paper-button dialog-confirm autofocus onclick="addToDatabase();">SEGNALA</paper-button>
  		</div>


    </paper-dialog>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnZ5kvHIKRf_01L41sB9lCdv_xijlwHSs&callback=initMap" async defer></script>
</body>
</html>
