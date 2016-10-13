<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

 session_start();

?>
<!DOCTYPE html>
<html>
    <head>

        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

        <meta charset="UTF-8">
        <title>Secure Login: Protected Page</title>
        <link rel="stylesheet" type="text/css" href="style-main.css"/>
        <link rel="import" href="bower_components/paper-toolbar/paper-toolbar.html">
        <link rel="import" href="bower_components/paper-tabs/paper-tabs.html">
        <link rel="import" href="bower_components/paper-dialog/paper-dialog.html">
        <link rel="import" href="bower_components/google-map/google-map.html">
        <link rel="import" href="bower_components/paper-button/paper-button.html">
        <link rel="import" href="bower_components/paper-fab/paper-fab.html">
        <link rel="import" href="bower_components/iron-icons/iron-icons.html">
    </head>
    <body>
    	<script>
			function showDialog(){
				document.getElementById('modal-add').open();
			}
		</script>
        <?php if (login_check($mysqli) == true) : ?>
        <div id="container">
        	<paper-toolbar>
				<paper-tabs selected="0">
                    <paper-tab>MAPPA</paper-tab>
                    <paper-tab>ELENCO</paper-tab>
                    <paper-tab>REGISTRAZIONE</paper-tab>
                </paper-tabs>
            </paper-toolbar>

            	<paper-fab icon="add" onclick="showDialog();"></paper-fab>
          </div>
          <paper-dialog id="modal-add">
      		<google-map
        		api-key="AIzaSyAnZ5kvHIKRf_01L41sB9lCdv_xijlwHSs"
        		latitude="37.77493"
        		longitude="-122.41942"
        		fit-to-markers></google-map>
    		</paper-dialog>
        <?php else : ?>
            <p>
                <span class="error">Non sei autorizzato all'accesso a questa pagina.</span> Per favore <a href="index.php">effettua l'accesso</a>.
            </p>
        <?php endif; ?>
    </body>
</html>
