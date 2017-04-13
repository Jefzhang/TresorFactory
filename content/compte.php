<div class="container-fluid compte-content">
    <div class="row ">
         <div class="col-md-6" style="text-align:center">
           <div class="row compte-bilan-chart" id="bilan-chart">

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
  url:'content/server.php?a=g',
  type:'POST',
  success: function(json,statut){
    
})
</script>
