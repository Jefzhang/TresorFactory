
var table;
var editor;
$(document).ready(function(){
    editor = new $.fn.dataTable.Editor({
    "ajax":'http://localhost/project/content/demandeServer.php',
    "table": "#demande-history",
    "fields": [ {
            "label": "Date de demande:",
            "name": "date",
            "type":"datetime",
            "format":"YYYY-MM-DD"
        }, {
            "label": "Type de sub:",
            "name": "type",
            "type":"select",
            "options":[
              {"label":"Sub Forum",value:"forum"},
              {"label":"Sub Kes",value:"kes"},
              {"label":"Sub DFHM",value:"dfhm"}
            ]
        }, {
            "label": "Somme demandée pour cette année:",
            "name": "somme"
        },{
            "label": "Part de la subvention dans le budget de binet(en %):",
            "name": "part"
        }, {
            "label":"Somme demandée la dernière année:",
            "name":"lsomme"
        }, {
           "label":"Somme accordée la dernière fois:",
           "name":"lasomme"
        }
    ]
});

/*$('#activity-table').on('click', 'button.editor_edit', function (e) {
    e.preventDefault();

    editor.edit( $(this).closest('tr'), {
        title: 'Modifier l\'information',
        buttons: 'Valiter'
    } );
} );*/

// Delete a record
$('#demande-history').on('click', 'button.editor_remove', function (e) {
    e.preventDefault();

    editor.remove( $(this).closest('tr'), {
        title: 'Supprimer',
        message: 'Vous voulez supprimer ce record de demande',
        buttons: 'Supprimer'
    } );
} );

$("#demande_add").click(function(){
  editor.create( {
        title: 'Lancer une demande de subvention',
        buttons: 'Valider'
    } );
});

/*editor.on('create',function(e,json,data){
  console.log('success');
  console.log(json);
  console.log(data);
  var id = data["DT_RowId"].split("_")[1];
  var server = 'http://localhost/project/content/serverDatabase.php';
  $.ajax({
    url: server,
    data:'action=add'+ '&eveId='+id,
    type:"POST",
    success:function(succe,statut){
      console.log(succe);

    }});

});*/

editor.on('preSubmit',function(e,data,action){
  console.log('presubmit');
  console.log(data);
});



editor.on('postCreate',function(e,json,data){
  console.log('postCreate');
  console.log(json);
});

editor.on('postSubmit',function(e,json,data,action){
  console.log('postSubmit');
  console.log(data);
  console.log(json);
});

editor.on('Create',function(e,json,data){
  console.log('create');
  console.log(json);
});

editor.on('remove',function(e,json){
  console.log('remove');
  console.log(json);
});



table=$('#demande-history').DataTable( {
    //ajax: "http://localhost/project/content/activity-info.php?t=all",
    "ajax":"http://localhost/project/content/demandeServer.php",
    columnDef:[ {
"targets": [ 0 ],
"data": "date[, ]"
} ],
    columns: [
        {
          data: "date",
          className:"text_center"
        },
        {
          data: "type",
          className:"text_center"
        },
        {
          data: "somme",
          render: $.fn.dataTable.render.number('.',',',2,'€'),
          className:"text_center"
        },
        {
          data: "part",
          render: function(data,type,row){
            return data+'%';
          },
          className:'text_center'
        },
        {
          data: "asomme",
          render: $.fn.dataTable.render.number('.',',',2,'€'),
          className:'text_center'
        },
        {
            data: null,
            className: "text_center",
            defaultContent: '<button type=\"button\" class=\"btn btn-default btn-xs editor_remove\" aria-label=\"Sepprimer\" title=\"Supprimer\"><span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></button>'
        }
    ]
} );


});
