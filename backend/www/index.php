<?php

//
// backend controller 
//

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/ico" href="images/favicon.ico">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <meta name="description" content="Android synoptic satus report">

    <title>Android status report</title>

    <link rel="stylesheet" type="text/css" href="lib/jquery.dataTables.css"> 
    <link rel="stylesheet" type="text/css" href="lib/select.dataTables.min.css"> 
    <link rel="stylesheet" type="text/css" href="lib/buttons.dataTables.min.css">  
    <link rel="stylesheet" type="text/css" href="lib/shCore.css">
    <link rel="stylesheet" type="text/css" href="lib/demo.css">
  
    <style class="init">
      ui-menu { 
        margin-top: 30px;   
        width: 180px; 
        border: 0px;    
      }
    </style>

    <script type="text/javascript" language="javascript" src="lib/jquery-3.3.1.js"></script>
    <script type="text/javascript" language="javascript" src="lib/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="lib/dataTables.select.min.js"></script>
    <script type="text/javascript" language="javascript" src="lib/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="lib/shCore.js"></script>
    <script type="text/javascript" language="javascript" src="lib/demo.js"></script>

    <link rel="stylesheet" href="lib/jquery-ui.css">
    <script src="lib/jquery-ui.js"></script>

    <script type="text/javascript">

      //
      // SHOW MODAL DIALOG
      //
      
      function popup() {        
        $( "#dialog" ).dialog({
          resizable: false,
          height: "auto",
          width: 400,
          modal: true,
          buttons: {
            "Conferma": function() {
              console.log("selected confirm");
              $( this ).dialog( "close" );
              /*  
              $.ajax({
                url: "data/?p=1",
                success: function(data) {
                  console.log("action success: " + JSON.stringify(data));
                },
                error: function(data) {
                  console.log("action error");
                }           
              });
              */
            },
            "Annulla": function() {
              console.log("selected cancel");
              $( this ).dialog( "close" );
            }
          }
        });
      }

      //
      // INITIALIZE COMPONENTS WHEN DOCUMENT IS READY
      //
            
      $(document).ready(function() {

        //
        // DIRECT AJAX INVOCATION
        //
        /*
        $.ajax(
        {
          "type": "POST",       
          "url": "data/",               
          "data" : {
            "field1": "value 1",    
            "field2": "value 2",    
          },        
          success: function (data) {                                
          },
          error: function(data) {            
          }
        });
        */

        //
        // DATA TABLE INITIALIZATION
        //
        var events = $('#events');
        var table = $('#results').DataTable( {        
          "ajax": {
              "url": "data/",
              "type": "POST",
              "data" : {
                "field1": "value 1",                    
                "field2": "value 2",                    
              },
              "language": {
                "lengthMenu": "Visualizza _MENU_ linee per pagina",
                "zeroRecords": "Nessun dato trovato - spiacenti.",
                "info": "Visualizza pagina _PAGE_ di _PAGES_",
                "infoEmpty": "Nessun dispositivo trovato",
                "infoFiltered": "(filtrati da un totale di _MAX_ linee)",
                "search": "cerca",
                "sLoadingRecords": "Caricamento...",
                "sProcessing": "Elaborazione...",
                "sSearch": "Cerca:",
                "sZeroRecords": "La ricerca non ha portato alcun risultato.",
                "oPaginate": {
                  "sFirst": "Inizio",
                  "sPrevious": "Precedente",
                  "sNext": "Successivo",
                  "sLast": "Fine"
                },
                "oAria": {
                  "sSortAscending": "attiva per ordinare la colonna in ordine crescente",
                  "sSortDescending": "attiva per ordinare la colonna in ordine decrescente"
                }
              }
          },          
          select: true
        });    

        //
        // ON CELL CLICK LISTENER
        //
        /*
        $('#results tbody').on( 'click', 'td', function () {
          var c = table.cell( this ).index().column;
          if (c == 2) { //clicked col 2
              var value = table.cell( this ).data();         
              //.. do something with value here ...              
          }
        });
        */

        //
        // INIT AUTOCOMPLETE TEXT BOX
        //
        /*
        var source = [ "pippo", "pluto", "paperino" ];
        $( "#tags" ).autocomplete({     
          minLength: 2,
          source: source,
          select: function(event, ui) {
            //var label = ui.item.label;
            var value = ui.item.value;
            document.location.href = '../tool-ureq/?user=' + value;
            //$('#success').html(label + ' - ' + value);
          }
        });
        */

        //
        // INITIALIZE MENU
        //
        $( "#menu" ).menu();

      });

    </script>
  </head>

  <body class="dt-example">    

    <!--CONFIRM DIALOG BOX -->    

    <div id="dialog" title="Avviso" style="display:none;">
      <p id="dialogMessage">Procedere con l'operazione selezionata?</p>
    </div>

    <!-- BEGIN MENU -->    

    <ul id="menu">
      <li class="ui-state-disabled"><div>BACKEND</div></li>
      <li><div>IoTC</div>
        <ul>
          <li class="ui-state-disabled"><div>MQTT BROKER</div></li>
          <li><div onclick='document.location.href="../tool-revk/"'>ca errors</div></li>
          <li><div onclick='document.location.href="../tool-mqtt/"'>connected devices</div></li>
        </ul>
      </li>  
      <li><div>APPs</div>
        <ul>
          <li class="ui-state-disabled"><div>COUNTERS</div></li>
          <li><div onclick='document.location.href="../tool-accs/"'>access</div></li>
          <li class="ui-state-disabled"><div>USERS</div></li>
          <li><div onclick='document.location.href="../tool-ureq/?user=charles@yopmail.com"'>requests</div></li>            
          <li><div onclick='document.location.href="../tool-upns/?user=charles@yopmail.com"'>notifications</div></li>      
        </ul>
      </li>  
    </ul>

    <!-- END MENU -->

    <!--
    <div class="ui-widget" style="margin-top: 10px;">
      <label for="tags">Username: </label>
      <input id="tags" placeholder="search username ...">
    </div>
    -->

    <div class="container">
      
      <h1>Status report<span> - smartphones list</span></h1>

        <table id="results" class="display" style="width:100%">
          <thead>
            <tr>          
              <th>userid</th>
              <th>username</th>
              <th>email</th>
              <th>registration date</th>
              <th>country</th>
              <th>src_app</th>
            </tr>
          </thead>
          <tfoot>
            <tr>                    
              <th>userid</th>
              <th>username</th>
              <th>email</th>
              <th>registration date</th>
              <th>country</th>
              <th>src_app</th>
            </tr>
          </tfoot>
        </table>  

    </div>    

  </body>
  
</html>
