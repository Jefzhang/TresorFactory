var txt ={};
txt += "<thead>";
txt += "<tr class=\"bg-primary\"><th style=\"text-align:center\">Date</th><th style=\"text-align:center\">Activity</th><th style=\"text-align:center\">Recette</th><th style=\"text-align:center\">Depense</th><th style=\"text-align:center\">Profit</th><th></th></tr>";
txt += "</thead>";

txt += "<tbody id=\"activity-list\">";

var table;
var editor;
$(document).ready(function(){
    editor = new $.fn.dataTable.Editor({
    "ajax":'http://localhost/project/content/serverTest.php',
    "table": "#activity-table",
    //"idSrc":"id",
    "fields": [ {
            "label": "Nom d'activité:",
            "name": "activityList.name"
        }, {
            "label": "Date d'avoir lieu:",
            "name": "activityList.date",
            "type": "datetime",
            "format": "DD-MM-YY"
        }, {
            "label": "Description:",
            "name": "activityList.description"
        }, {
            "label": "Recette:",
            "name": "activityList.recette"
        },{
            "label": "Depence:",
            "name": "activityList.depence"
        }, {
            "label":"Profit",
            "name":"activityList.profit"
        }
    ]
});
console.log(editor);

$('#activity-table').on('click', 'button.editor_edit', function (e) {
    e.preventDefault();

    editor.edit( $(this).closest('tr'), {
        title: 'Modifier l\'information',
        buttons: 'Valiter'
    } );
} );

// Delete a record
$('#activity-table').on('click', 'button.editor_remove', function (e) {
    e.preventDefault();

    editor.remove( $(this).closest('tr'), {
        title: 'Supprimer',
        message: 'Vous voulez supprimer cet activité',
        buttons: 'Supprimer'
    } );
} );

$("#acti_add").click(function(){
  editor.create( {
        title: 'Ajouter une activité',
        buttons: 'Ajouter'
    } );
});

editor.on('create',function(e,json,data){
  console.log(json);
  console.log(data);
  var id = data["DT_RowId"].split("_")[1];
  var server = 'http://localhost/project/content/serverDatabase.php';
  /*
  $.ajax({
    url: server,
    data:'action=add'+ '&eveId='+id,
    type:"POST",
    success:function(succe,statut){
      console.log(succe);

    }});*/

});


editor.on('remove',function(e,json){
  console.log(json);
});



table=$('#activity-table').DataTable( {
    //ajax: "http://localhost/project/content/activity-info.php?t=all",
    "ajax":"http://localhost/project/content/serverTest.php",
    columnDef:[ {
"targets": [ 0 ],
"data": "activityList.date[, ]"
} ],
    columns: [
        {
          data: "activityList.date",
          className:"text_center"
        },
        {
          data: "activityList.name",
          className:"text_center"
        },
        {
          data: "activityList.recette",
          render: $.fn.dataTable.render.number('.',',',2,'€'),
          className:"text_center"
        },
        {
          data: "activityList.depence",
          render: $.fn.dataTable.render.number('.',',',2,'€'),
          className:'text_center'
        },
        {
          data: "activityList.profit",
          render: $.fn.dataTable.render.number('.',',',2,'€'),
          className:'text_center'
        },
        {
            data: null,
            className: "text_center",
            defaultContent: '<button type=\"button\" class=\"btn btn-default btn-xs editor_detaille\" aria-label=\"\" title=\"Voir plus\"><span class=\"glyphicon glyphicon-zoom-in\" aria-hidden=\"true\"></span></button><button type=\"button\" class=\"btn btn-default btn-xs editor_edit\" aria-label=\"Modifier\" title=\"Modifier\"><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></button><button type=\"button\" class=\"btn btn-default btn-xs editor_remove\" aria-label=\"Sepprimer\" title=\"Supprimer\"><span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></button>'
        }
    ]
} );

/*$("#activity-table").on('click','button.editor_detaille',function(){
  //e.preventDefault();


  var rowId = table.row($(this).closest('tr')).id();
  var recette =table.row("#"+rowId).data()["recette"];
  var depense = table.row("#"+rowId).data()["depence"];
  var descrip = table.row('#'+rowId).data()["description"];
  var name = table.row('#'+rowId).data()["name"];
  var date = table.row('#'+rowId).data()["date"];
  var profit = table.row('#'+rowId).data()["profit"];

  var server = 'http://localhost/project/content/serverDatabase.php';
  $.ajax({
    url:server,
    data:'action=modifD'+'&eveId='+rowId.split("_")[1],
    type:'POST',
    success: function(json,statut){
      console.log(json);
      var acti = JSON.parse(json);
      $("#acti-modal-nom").html(name);
      $("#acti-modal-date").html(date);
      $("#acti-modal-descrip").html(descrip);
      $("#acti-modal-profit").html(profit);
      var recetteInfo = {};
      var depenceInfo = {};
      for(term in acti.recette){
        //console.log(acti.recette[term][0]);
        recetteInfo +="<tr><th>"+acti.recette[term][0]+"</th>";
        recetteInfo +="<td style=\"text-align:right\">"+acti.recette[term][1]+"</td></tr>";
      }
      for(term in acti.depense){
        depenceInfo +="<tr><th>"+acti.depense[term][0]+"</th>";
        depenceInfo +="<td style=\"text-align:right\">"+acti.depense[term][1]+"</td></tr>";
        if(acti.depense[term][2]==1){
          var nom = acti.depense[term][0]+" (sub)";
          recetteInfo+="<tr><th>"+nom+"</th>";
          recetteInfo+="<td style=\"text-align:right\">"+acti.depense[term][1]+"</td></tr>";
        }
      }
      recetteInfo +="<tr style=\"background-color:#e6e6e6\"><th>Total</th>";
      recetteInfo +="<th style=\"text-align:right\">"+recette+"</th></tr>";
      depenceInfo +="<tr style=\"background-color:#e6e6e6\"><th>Total</th>";
      depenceInfo +="<th style=\"text-align:right\">"+depense+"</th></tr>";
      $("#acti-modal-incomInfo").html(recetteInfo);
      $("#acti-modal-expenInfo").html(depenceInfo);
      var pieData = [['Recette',recette],['Profit',Math.abs(profit)],['Depence',depense]];
      myLabels = $.makeArray($(pieData).map(function(){return this[1]+'&#8364;'}));
      var plot1 = $.jqplot('pie1', [pieData], {
                seriesDefaults:{
                renderer:$.jqplot.PieRenderer,
                trendline:{ show:false },
                rendererOptions: {
                  startAngle: 90,
                  sliceMargin: 3,
                  padding: 8,
                  showDataLabels: true,
                  dataLabels:myLabels
                 }
                },
                seriesColors: [ "#66ff99", "#80e5ff","#ff8080"],
                grid: {
                      drawBorder: false,
                      drawGridlines: false,
                      background: '#ffffff',
                      shadow:false
                  },
                legend:{
                    show:true,
                    placement: 'outside',
                    rendererOptions: {
                        numberRows: 1
                    },
                    location:'s',
                    marginTop: '15px'
                }
              });
    }

  });
  $("#activity-modal").css('display',"block");

});*/
});

//  });





  /*$.ajax({
    url:'http://localhost/project/content/activity-info.php?t=all',
    type: 'POST',
    //data: 'login=X-Chine&t=all',
    success: function(json,statut){
      //$("#show").text("merdemerde");
      //var obj = JSON.parse(json);
    //  $("#show").html(json);

      var obj = JSON.parse(json);
      var i=1;
      for(acti in obj.activities){
        txt +="<tr><th style=\"text-align:center\" scope=\"row\">"+i+"</th>";
        txt +="<td style=\"text-align:center\">"+obj.activities[acti].date+"</td>";
        txt +="<td style=\"text-align:center\">"+obj.activities[acti].name+"</td>";
        txt +="<td style=\"text-align:center\">"+obj.activities[acti].recette+"</td>";
        txt +="<td style=\"text-align:center\">"+obj.activities[acti].depence+"</td>";
        txt +="<td style=\"text-align:center\">"+obj.activities[acti].profit+"</td>";
        txt +="<td style=\"text-align:center\"><button type=\"button\" class=\"btn btn-default btn-xs\" aria-label=\"Modifier\" title=\"Modifier\"><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></button></td>";
        txt +="</tr>";
        i++;
      }
      txt +="</tbody>";
      $("#activity-table").html(txt);
      $("#activity-table").DataTable();
    }
  })
});*/
/*$(document).ready(function(){

});*/


var recetteData = [['Poste',0]
 ];
var depenseData = [['Poste',0,1]
];
var recetteWidth;
var depenseWidth;
var changed=false;
var update = function(obj,cel,val){
  changed=true;
  console.log(changed);
}
//console.log(recetteWidth);
/*$("#recette-detaille").jexcel({
  data:recetteData,
  onchange:update,
  colHeaders:['Poste','Montant(€)'],
  colWidths:[recetteWidth/2,recetteWidth/4],
  columns:[
    {type:'text'},
    {type:'text'}
  ]
});

$("#depense-detaille").jexcel({
  data:depenseData,
  onchange:update,
  colHeaders:['Poste','Montant(€)','(À)Rembourser'],
  //colWidths:[200,80,80],
  columns:[
    {type:'text'},
    {type:'text'},
    {type:'dropdown',source:[
      {'id':0,'name':false},
      {'id':1,'name':true}
  ]}
]});*/

$("#recette-add").on('click',function(){
  line = new Array('','');
  recetteData.push(line);
  //console.log(recetteData);
  $("#recette-detaille").jexcel({
    data:recetteData,
    onchange:update,
    colHeaders:['Poste','Montant(€)'],
    //colWidths:[200,80],
    colWidths:[recetteWidth/2,recetteWidth/4],
    columns:[
      {type:'text'},
      {type:'text'}
    ]
  });
})

$("#depense-add").on('click',function(){
  line = new Array('','',0);
  depenseData.push(line);
  $("#depense-detaille").jexcel({
    data:depenseData,
    onchange:update,
    colHeaders:['Poste','Montant(€)','(À)Rembourser'],
    //colWidths:[200,80,80],
    columns:[
      {type:'text'},
      {type:'text'},
      {type:'dropdown',source:[
        {'id':0,'name':false},
        {'id':1,'name':true}
      ]}
    ]
  })
});


var eveId;

$("#activity-table").on('dblclick','tbody tr',function(){
  //console.log($(this).closest('tr'));

  var rowId = table.row($(this).closest('tr')).id();
  console.log(table.row("#"+rowId).data());
  var recette =table.row("#"+rowId).data()["recette"];
  var depense = table.row("#"+rowId).data()["depence"];
  $("#recette-total").html("€"+recette);
  $("#depense-total").html("€"+depense);
  eveId = rowId.split("_")[1];
  changed = false;                            //initially we haven't changed the data
  var server = "http://localhost/project/content/serverDatabase.php";
  $.ajax({                            //get the information of "recette" and "depense"
      url:server,
      data:'action=modifD'+ '&eveId='+eveId,
      type:'POST',
      success: function(json,statut){
        console.log(json);
        var eveData = JSON.parse(json);
        recetteData = eveData.recette;
        depenseData = eveData.depense;
        $("#recette-detaille").jexcel({
          data:recetteData,
          onchange:update,
          colHeaders:['Poste','Montant(€)'],
          //colWidths:[recetteWidth/2,recetteWidth/4],
          columns:[
            {type:'text'},
            {type:'text'}
          ]
        });

        $("#depense-detaille").jexcel({
          data:depenseData,
          onchange:update,
          colHeaders:['Poste','Montant(€)','(À)Rembourser'],
          //colWidths:[200,80,80],
          columns:[
            {type:'text'},
            {type:'text'},
            {type:'dropdown',source:[
              {'id':0,'name':false},
              {'id':1,'name':true}
          ]}
        ]});

      }

    });
    $("#item-modal").css('display',"block");

  });

$("#modal-close").click(function(){
  $("#activity-modal").css('display','none');
});

$("#item-modal-close").click(function(){
  $("#item-modal").css('display','none');
})

$("#item-modal-valider").click(function(){

  //var recetteJson = JSON.stringify(recetteData);
  //var depenseJson = JSON.stringify(depenseData);
  var detaille = {"eveId":eveId,"recette":recetteData,"depense":depenseData}
  var detailleJson = JSON.stringify(detaille);
  console.log(detailleJson);
  $("#item-modal").css('display','none');
  if(changed){
  var server = 'http://localhost/project/content/serverDatabase.php';
  $.ajax({
    url: server,
    data:'action=addD'+ '&data='+detailleJson,
    type:"POST",
    success:function(succe,statut){
      console.log(succe);
    }});
  }

})

var modal1 = document.getElementById('activity-modal');
var modal2 = document.getElementById('item-modal');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal1) {
    modal1.style.display = "none";
}
else if(event.target == modal2) {
  modal2.style.display = "none";
}
}

$("#activity-table").on('click','button.editor_detaille',function(){
//e.preventDefault();

$("#activity-modal").css('display',"block");
//console.log(table.row($(this).closest('tr')));
var rowId = table.row($(this).closest('tr')).id();
var recette =table.row("#"+rowId).data()["activityList"]["recette"];
var depense = table.row("#"+rowId).data()["activityList"]["depence"];
var descrip = table.row('#'+rowId).data()["activityList"]["description"];
var name = table.row('#'+rowId).data()["activityList"]["name"];
var date = table.row('#'+rowId).data()["activityList"]["date"];
var profit = table.row('#'+rowId).data()["activityList"]["profit"];

var server = 'http://localhost/project/content/serverDatabase.php';
$.ajax({
url:server,
data:'action=modifD'+'&eveId='+rowId.split("_")[1],
type:'POST',
success: function(json,statut){
  console.log(json);
  var acti = JSON.parse(json);
  $("#acti-modal-nom").html(name);
  $("#acti-modal-date").html(date);
  $("#acti-modal-descrip").html(descrip);
  $("#acti-modal-profit").html(profit);
  var recetteInfo = {};
  var depenceInfo = {};
  for(term in acti.recette){
    //console.log(acti.recette[term][0]);
    recetteInfo +="<tr><th>"+acti.recette[term][0]+"</th>";
    recetteInfo +="<td style=\"text-align:right\">"+acti.recette[term][1]+"</td></tr>";
  }
  for(term in acti.depense){
    depenceInfo +="<tr><th>"+acti.depense[term][0]+"</th>";
    depenceInfo +="<td style=\"text-align:right\">"+acti.depense[term][1]+"</td></tr>";
    if(acti.depense[term][2]==1){
      var nom = acti.depense[term][0]+" (sub)";
      recetteInfo+="<tr><th>"+nom+"</th>";
      recetteInfo+="<td style=\"text-align:right\">"+acti.depense[term][1]+"</td></tr>";
    }
  }
  recetteInfo +="<tr style=\"background-color:#e6e6e6\"><th>Total</th>";
  recetteInfo +="<th style=\"text-align:right\">"+recette+"</th></tr>";
  depenceInfo +="<tr style=\"background-color:#e6e6e6\"><th>Total</th>";
  depenceInfo +="<th style=\"text-align:right\">"+depense+"</th></tr>";
  $("#acti-modal-incomInfo").html(recetteInfo);
  $("#acti-modal-expenInfo").html(depenceInfo);
  //console.log(typeof(depense));
  var pieData = [['Recette',parseFloat(recette)],['Profit',parseFloat(profit)],['Depense',parseFloat(depense)]];
  myLabels = $.makeArray($(pieData).map(function(){return this[1]+'&#8364;'}));
  var plot1 = $.jqplot('pie1', [pieData], {
            seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            trendline:{ show:false },
            rendererOptions: {
              startAngle: 90,
              sliceMargin: 3,
              padding: 8,
              showDataLabels: true,
              dataLabels:myLabels
             }
            },
            seriesColors: [ "#66ff99", "#80e5ff","#ff8080"],
            grid: {
                  drawBorder: false,
                  drawGridlines: false,
                  background: '#ffffff',
                  shadow:false
              },
            legend:{
                show:true,
                placement: 'outside',
                rendererOptions: {
                    numberRows: 1
                },
                location:'s',
                marginTop: '15px'
            }
          });
}

});

});
