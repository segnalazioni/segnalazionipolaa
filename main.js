/**
 * Created by alessandro on 14/10/2016.
 */


//Wait for document to be ready, and access all its components safely

$( document ).ready(function() {

    //Register key listeners for login page

    $( document ).keydown(function(event) {
        if(!dialogOpen) {
            var keynum;

            if (window.event) { // IE
                keynum = event.keyCode;
            } else if (event.which) { // Netscape/Firefox/Opera
                keynum = event.which;
            }

            if (keynum == 13) {
                formhash(document.getElementById('user_input'), document.getElementById('pass_input'));
            }
        }
    });

});