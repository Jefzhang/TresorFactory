<div class="container-fluid compte-content">
    <div class="row">
         <div class="col-md-6" style="text-align:center" >
           <div class="row compte-bilan-chart" style="background-color:#333333" id="bilan-chart">
           </div>
         </div>
         <div class="col-md-6" style="text-align:center">
           <div class="row compte-bilan-chart" style="background-color:#333333" id="sub-pie">

           </div>
         </div>
    </div>
    <div class="row activity-fil">
      <div class="col-md-8 col-md-offset-2 " id="activity-fil">
      </div>
    </div>
</div>
<script>
$(document).ready(function(){
  $.ajax({
  url:'content/compteServer.php',
  type:'POST',
  success: function(json,statut){
    console.log(json);
    var recetteEvo=[];
    var depenseEvo=[];
    var subPieData = [];
    var soldeEvo=[];
    var info = JSON.parse(json);
    var eveData = info["data"];
    var initSolde = parseFloat(info["oldSolde"]);
    var initRecette = 0;
    var initDepense = 0;
    var subReste = parseFloat(info["sub"]);
    for(var i in eveData){
      initRecette +=parseFloat(eveData[i]["recette"]);
      initDepense +=parseFloat(eveData[i]["depence"]);
      initSolde +=parseFloat(eveData[i]["profit"]);
      recetteEvo.push([eveData[i]["date"],initRecette]);
      depenseEvo.push([eveData[i]["date"],initDepense]);
      soldeEvo.push([eveData[i]["date"],initSolde]);
      subPieData.push([eveData[i]["name"],parseFloat(eveData[i]["sub"])]);
      subReste = subReste - parseFloat([eveData[i]["sub"]]);
    }
    subPieData.push(['Restant',subReste]);
    var myLabels = $.makeArray($(subPieData).map(function(){return this[1]+'&#8364;'}));
    console.log(recetteEvo);
    console.log(depenseEvo);
    console.log(soldeEvo);
    var plot1 = $.jqplot('bilan-chart', [recetteEvo,depenseEvo,soldeEvo],{
      seriesColors: [ "#80e5ff","#ff8080","#66ff99"],
      title:{
        text:'Evolution',
        textColor:'#dddddd'
      },
      highlighter: {
            show: true,
            sizeAdjust: 7.5,
            tooltipOffset: 9
        },
      grid: {
            background: 'rgba(57,57,57,0.0)',
            drawBorder: false,
            shadow: false,
            gridLineColor: '#666666',
            gridLineWidth: 2
        },
      legend: {
              show: true,
              placement: 'inside',
              //localtion:'s'
          },
      seriesDefaults: {
               rendererOptions: {
                   //smooth: true,
                   animation: {
                       show: true
                   }
               }
              // showMarker: false
           },
      series: [
                 {
                    // fill: true,
                    //lineWidth:4,
                  //  markerOptions:{style:'square'},
                    markerOptions:{
                      show:true,
                      size:8
                    },
                    label: 'Recette',
                    rendererOptions: {
                          animation: {
                              speed: 2000
                          }
                    }
                 },
                 {
                     //lineWidth:4,
                     markerOptions:{
                       show:true,
                       size:8
                     },
                     label: 'Depense',
                     rendererOptions: {
                           animation: {
                               speed: 2000
                           }
                     }
                 },
                 {
                   lineWidth:4,
                   //markerOptions:{style:'square'},
                   markerOptions:{
                     show:true,
                     size:8
                   },
                   label: 'Solde',
                   rendererOptions: {
                         animation: {
                             speed: 2000
                         }
                   }
                 }
             ],
        axesDefaults: {
                 pad: 0
             },
        axes:{
                 xaxis:{
                     renderer:$.jqplot.DateAxisRenderer,
                     //tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                     tickOptions: {
                    //formatString: "%b %e",
                    angle: -30,
                    textColor: '#dddddd'
                    }
                 },
                 yaxis: {
                tickOptions: {
                  textColor: '#dddddd',
                    formatString: "€%.2f"
                },

                rendererOptions: {
                    forceTickAt0: true
                }
              }
            }
    })  //plot

    var pie1 = $.jqplot('sub-pie', [subPieData], {
      title:{
        text:'Utilisation de subvention',
        textColor:'#dddddd'
      },
      seriesDefaults:{
      renderer:$.jqplot.PieRenderer,
      trendline:{ show:false },
      rendererOptions: {
        //startAngle: 90,
        sliceMargin: 3,
        padding: 8,
        showDataLabels: true,
        dataLabels:myLabels
       }
      },
      grid: {
            drawBorder: false,
            drawGridlines: false,
            background: '#333333',
            shadow:false
        },
      legend:{
          show:true,
          //background:'#333',

        //  placement: 'outside',
        renderer: $.jqplot.EnhancedPieLegendRenderer,
          rendererOptions: {
              numberRows: 1,
              textColor:'#dddddd'
          },

          location:'s',
          marginTop: '15px'
      }


    });
    var filActivity = "";
    for(var i=eveData.length-1;i>=0;i--){
      filActivity += "<div class=\"panel panel-default\">";
      filActivity +="<div class=\"panel-heading\">";
      filActivity += "<h2 class=\"panel-title text-center\">";
      filActivity += eveData[i]["date"];
      filActivity += "<span class=\"label label-success pull-right\" tooltip=\"Profit net\" tooltip-placement=\"left\">";
      filActivity += eveData[i]["profit"]+"&nbsp;"+"€";
      filActivity += "</span></h2></div>";

      filActivity +="<table class=\"table table-striped table-hover table-condensed history\"><tbody><tr>";
      filActivity +="<td class=\"name\">"
      filActivity +=eveData[i]["name"]+"</td>";
      filActivity +="<td class=\"recette\">Recette</td>";
      filActivity +="<td class=\"montant\"><span class=\"label label-info\">";;
      filActivity +="+"+eveData[i]["recette"]+"&nbsp;"+"€";
      filActivity +="</span></td></tr><tr>";

      filActivity +="<td class=\"name\">"
      filActivity +=eveData[i]["name"]+"</td>";
      filActivity +="<td class=\"recette\">Depense</td>";
      filActivity +="<td class=\"montant\">";
      filActivity +="<span class=\"label label-danger\">";
      filActivity +="-"+eveData[i]["depence"]+"&nbsp;"+"€";
      filActivity +="</span></td></tr></tbody></table></div>";
    }
    $('#activity-fil').html(filActivity);

  }  //success
})  //ajax

})
</script>
