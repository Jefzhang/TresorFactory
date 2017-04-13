<div class="container-fluid compte-content">
    <div class="row ">
         <div class="col-md-6" style="text-align:center">
           <div class="row compte-bilan-chart" style="background-color:#333333" id="bilan-chart">

           </div>
         </div>
         <div class="col-md-6" style="text-align:center">
           <div class="row compte-bilan-chart" id="sub-pie">

           </div>
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
    var soldeEvo=[];
    var info = JSON.parse(json);
    var eveData = info["data"];
    var initSolde = parseFloat(info["oldSolde"]);
    var initRecette = 0;
    var initDepense = 0;
    var sub = parseFloat(info["sub"]);
    for(var i in eveData){
      initRecette +=parseFloat(eveData[i]["recette"]);
      initDepense +=parseFloat(eveData[i]["depence"]);
      initSolde +=parseFloat(eveData[i]["profit"]);
      recetteEvo.push([eveData[i]["date"],initRecette]);
      depenseEvo.push([eveData[i]["date"],initDepense]);
      soldeEvo.push([eveData[i]["date"],initSolde]);
    }
    console.log(recetteEvo);
    console.log(depenseEvo);
    console.log(soldeEvo);
    var plot1 = $.jqplot('bilan-chart', [recetteEvo,depenseEvo,soldeEvo],{
      seriesColors: [ "#66ff99", "#80e5ff","#ff8080"],
      title:'Evolution',
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
              placement: 'inside'
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
                   //lineWidth:6,
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
                    formatString: "€%.2f"
                },
                rendererOptions: {
                    forceTickAt0: true
                }
              }
            }
    })  //plot

  }  //success
})  //ajax

})
</script>
