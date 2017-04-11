<div class = "container-fluid admin">
    <div class="row admin-header bg-primary">
      <div class="col-md-12">
        <div>
        <span style="font-size:1.5em"class="glyphicon glyphicon-user"></spn>
        Information de l'utilisateur
        </div>
      </div>
    </div>
    <div class="row">
    <div class="col-md-2 sidebar rightverticalLine">
      <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Information</a></li>
            <li><a href="#">Historique</a></li>
      </ul>
    </div>
    <div class="col-md-10 admin-info">
      <div class="row">
        <div class="col-md-6 admin-info-title">
          Binet :
        </div>
        <div class="col-md-6 admin-edit-text" id="login">
          X-Chine
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-6 admin-info-title">
          User:
        </div>
        <div class="col-md-6" style="text-align:left">
          <span class="click-edit"  id="nom">ZHANG</span> &nbsp
          <span class="click-edit"  id="prenom">Jianfei</span>
        </div>
        <div class="col-md-6 admin-info-title">
          Poste:
        </div>
        <div class="col-md-6 admin-edit-select" id = "poste">
          Tresor
        </div>



      </div>

    </div>
  </div>

</div>

<script src="js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
<script>
$(document).ready(function(){
  $('.admin-edit-text').editable('data/userInfo.php',{
    //type:'textarea',
    submit:'OK',
    //cancel:'Annuler',
    style  : "inherit",
    submitdata: { _method: "put" },
  });

  $('#poste').editable('data/userInfo.php' ,{
    submit:'OK',
    data:"{'Trez':'Tresor','Prez':'President'}",
    type:'select',
    style:'inherit',
    submitdata:{ _method: "put" }
    })

  $('.click-edit').editable('dta/userInfo.php',{
  //  style : 'inherit',
    submitdata:{_metheod:"put"}
  });


})
</script>
<style type="text/css">
.editable input[type=submit] {
  color: #F00;
  font-weight: bold;
}
.editable input[type=button] {
  color: #0F0;
  font-weight: bold;
}

</style>
