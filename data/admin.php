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
    <!--<div class="col-md-2 sidebar rightverticalLine">
      <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Information</a></li>
            <li><a href="#">Historique</a></li>
      </ul>
    </div>-->
    <div class="col-md-12 admin-info">
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
      </div>
      <div class="row">
        <div class="col-md-6 admin-info-title">
          Poste:
        </div>
        <div class="col-md-6 admin-edit-select" id = "poste">
          Tresor
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-6 admin-info-title">
          Email:
        </div>
        <div class="col-md-6 admin-edit-text" id="email">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 admin-info-title">
          Portable:
        </div>
        <div class="col-md-6 admin-edit-text" id="tel">
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-6 admin-info-title">
          Montant hérité:
        </div>
        <div class="col-md-6 admin-edit-text" id="solde">
        </div>
     </div>
     <div class="row">
       <div class="col-md-6 admin-info-title">
         Subvention obtenue:
       </div>
       <div class="col-md-6 admin-edit-text" id="sub">
       </div>
    </div>
  </div>

</div>

<script src="js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
<script>
$(document).ready(function(){
  $.ajax({                            //get the information of "recette" and "depense"
      url:'data/userInfo.php?a=g',
      type:'POST',
      success:function(json,statut){
        var data = JSON.parse(json);
        console.log(data);
        $('#login').html(data['login']);
        $('#nom').html(data['nom']);
        $('#prenom').html(data['prenom']);
        $('#poste').html(data['poste']);
        $('#email').html(data['email']);
        $('#tel').html(data['tel']);
        $('#solde').html(data['solde']);
        $('#sub').html(data['sub']);
      }
    });
  $('.admin-edit-text').editable('data/userInfo.php?a=c',{
    //type:'textarea',
    submit:'OK',
    //cancel:'Annuler',
    style  : "inherit",
    submitdata: { _method: "put" },
  });

  $('#poste').editable('data/userInfo.php?a=c' ,{
    submit:'OK',
    data:"{'Trez':'Tresor','Prez':'President'}",
    type:'select',
    style:'inherit',
    submitdata:{ _method: "put" }
    })

  $('.click-edit').editable('dta/userInfo.php?a=c',{
  //  style : 'inherit',
    submitdata:{_metheod:"put"}
  });


})
$('#email').on('input', function() {
	var input=$(this);
	var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	var is_email=re.test(input.val());
	if(is_email){input.removeClass("invalid").addClass("valid");}
	else{input.removeClass("valid").addClass("invalid");}
});
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
