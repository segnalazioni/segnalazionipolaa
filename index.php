<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Secure Login: Log In</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="includes/sha512.js"></script>
        <script src="includes/forms.js"></script>
        <script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
        <script src="jquery-3.1.0.min.js"></script>
        <script src="main.js"></script>

        <link rel="stylesheet" type="text/css" href="style.css"/>
    	<link rel="import" href="bower_components/paper-button/paper-button.html">
        <link rel="import" href="bower_components/paper-icon-button/paper-icon-button.html">
        <link rel="import" href="bower_components/paper-card/paper-card.html">
        <link rel="import" href="bower_components/paper-input/paper-input.html">
        <link rel="import" href="bower_components/paper-dialog/paper-dialog.html">
        <link rel="import" href="bower_components/paper-dialog-behavior/paper-dialog-behavior.html">
        <link rel="import" href="bower_components/iron-form/iron-form.html">
        <link rel="import" href="bower_components/iron-icon/iron-icon.html">
        <link rel="import" href="bower_components/iron-icons/iron-icons.html">
        <link rel="import" href="bower_components/iron-icons/social-icons.html">
        <link rel="import" href="bower_components/font-roboto/roboto.html">

        <script>
            // Setup Polymer options
            /*window.Polymer = {
                dom: 'shadow',
                lazyRegister: true
            };*/

            // Load webcomponentsjs polyfill if browser does not support native Web Components
            (function() {
                'use strict';

                var onload = function() {
                    // For native Imports, manually fire WebComponentsReady so user code
                    // can use the same code path for native and polyfill'd imports.
                    if (!window.HTMLImports) {
                        document.dispatchEvent(
                            new CustomEvent('WebComponentsReady', {bubbles: true})
                        );
                    }
                };

                var webComponentsSupported = (
                    'registerElement' in document
                    && 'import' in document.createElement('link')
                    && 'content' in document.createElement('template')
                );

                if (!webComponentsSupported) {
                    var script = document.createElement('script');
                    script.async = true;
                    script.src = 'bower_components/webcomponentsjs/webcomponents-lite.min.js';
                    script.onload = onload;
                    document.head.appendChild(script);
                } else {
                    onload();
                }
            })();

            // Load pre-caching Service Worker
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/service-worker.js');
                });
            }
        </script>

    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?>
        <center><p class="show-on-mobile roboto title">Esegui l'accesso</p> </center>
        <div class="card-container">
            <paper-card class="dark">
            	<p id="titolo" align="center" class="hide-on-mobile roboto" style="font-size:28px;">Accesso</p>
                <div class="card-content">
                <form is"iron-form" action="protected-page.php" id="form" method="post" name="login_form" class="vertical center center-justified layout">
            		<paper-input required auto-validate class="input-mobile" error-message="Compila questo campo!" id="user_input" spellcheck="false" style="--paper-input-container-color: red;" type="text" label="USERNAME" tabindex="1">
                    	<iron-icon icon="social:person" prefix></iron-icon>
                        <paper-icon-button suffix onclick="document.getElementById('user_input').value = '';" icon="clear" style="color:#e1382d;" alt="clear" title="clear"></paper-icon-button>
                    </paper-input>
                    <br/>
                    <paper-input required auto-validate class="input-mobile" error-message="Compila questo campo!" style="margin-bottom:40px;" id="pass_input" spellcheck="false" type="password" label="PASSWORD" tabindex="2">
                    	<iron-icon icon="lock" prefix></iron-icon>
                        <paper-icon-button suffix onclick="document.getElementById('pass_input').value = '';" icon="clear" style="color:#e1382d;" alt="clear" title="clear"></paper-icon-button>
                    </paper-input>
        		</form>
                </div>
                <div class="card-actions" style="text-align:end; padding-top:10px; padding-bottom:10px;">
                    <paper-button>Aiuto</paper-button>
                    <paper-button raised style="background-color:#e1382d; color:white;" onclick="formhash(document.getElementById('user_input'), document.getElementById('pass_input'));">Accedi</paper-button>
                </div>
            </paper-card>
        </div>
        <paper-dialog id="modal-user" entry-animation="scale-up-animation" exit-animation="fade-out-animation" with-backdrop>
        <h2>Spiacente</h2>
  			<p>Il nome utente da lei inserito non è presente nel nostro database, ne controlli la correttezza e in caso di problemi clicchi il pulsante AIUTO</p>
  			<div class="buttons">
    			<paper-button dialog-confirm autofocus>OK</paper-button>
  			</div>
		</paper-dialog>
        <paper-dialog id="modal-password" entry-animation="scale-up-animation" exit-animation="fade-out-animation" with-backdrop>
        <h2>Spiacente</h2>
  			<p>La password da lei inserita non è corretta, ne controlli la correttezza e in caso di problemi clicchi il pulsante AIUTO</p>
            <br/>
            <p id="tries"></p>
  			<div class="buttons">
    			<paper-button dialog-confirm autofocus>OK</paper-button>
  			</div>
		</paper-dialog>
        <paper-dialog id="modal-compile" entry-animation="scale-up-animation" exit-animation="fade-out-animation" with-backdrop>
        <h2>Spiacente</h2>
  			<p>Devi compilare tutti i campi prima di poter effettuare il login!</p>
  			<div class="buttons">
    			<paper-button dialog-confirm autofocus>OK</paper-button>
  			</div>
		</paper-dialog>
        <paper-dialog id="modal-over" entry-animation="scale-up-animation" exit-animation="fade-out-animation" with-backdrop>
            <h2>Spiacente</h2>
            <p>Hai esaurito i tentativi di accesso, contatta l'amministratore per la riattivazione!</p>
            <div class="buttons">
                <paper-button dialog-confirm autofocus>OK</paper-button>
            </div>
        </paper-dialog>
    </body>
</html>
