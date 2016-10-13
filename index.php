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

        <script src="bower_components/webcomponentsjs/webcomponents.js"></script>
        <script src="jquery-3.1.0.min.js"></script>

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
            		<paper-input required auto-validate class="input-mobile" error-message="Compila questo campo!" id="user_input" spellcheck="false" style="--paper-input-container-color: red;" type="text" label="USERNAME">
                    	<iron-icon icon="social:person" prefix></iron-icon>
                        <paper-icon-button suffix onclick="document.getElementById('user_input').value = '';" icon="clear" style="color:#e1382d;" alt="clear" title="clear"></paper-icon-button>
                    </paper-input>
                    <br/>
                    <paper-input required auto-validate class="input-mobile" error-message="Compila questo campo!" style="margin-bottom:40px;" id="pass_input" spellcheck="false" type="password" label="PASSWORD">
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
    </body>
</html>
