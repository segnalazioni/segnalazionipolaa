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
        <link rel="import" href="bower_components/paper-datatable/paper-datatable.html">
        <link rel="import" href="bower_components/iron-ajax/iron-ajax.html">
</head>

<body>
<template is="dom-bind">
	<iron-ajax
            auto
            url="get-status.php"
            params="{'id': 0}"
            handle-as="json"
            last-response="{{data}}"
            debounce-duration="300">
      </iron-ajax>
      	<paper-datatable-card data="{{data}}" selectable multi-selection>
    		<paper-datatable-column header="Aggiornamento" property="aggiornamento" sortable>
    		</paper-datatable-column>
            <paper-datatable-column header="Data" property="data" sortable>
    		</paper-datatable-column>
		</paper-datatable-card>
        </template>
</body>
</html>
