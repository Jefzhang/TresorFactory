<div class="container-fluid list-activi">
  <div class="row activity-table">
  <table class="table table-hover table-responsive"id="activity-table">
    <thead>
       <tr class="bg-primary">
         <th style="text-align:center">Date</th>
         <th style="text-align:center">Activity</th>
         <th style="text-align:center">Recette</th>
         <th style="text-align:center">Depense</th>
         <th style="text-align:center">Profit</th>
         <th></th>
       </tr>
    </thead>
  </table>
</div>
<div class="row" style="text-align:center">
  <button type='button' class="btn btn-default" title="Ajouter" id="acti_add"><span class="glyphicon glyphicon-plus"></span></button>
</div>
</div>

  <div class="activity-modal " id="activity-modal">
    <div class="acti-modal-content acti-modal-animate container-fluid">
      <div class="row acti-modal-header bg-primary">
          <div id="acti-modal-nom" class="col-md-6">

          </div>
          <div id="acti-modal-date" class="col-md-6" style="text-align:right">

          </div>
      </div>
      <div class="row acti-modal-descrip">
          <h3>Description</h3>
          <p id="acti-modal-descrip" ></p>
          <hr>
      </div>
        <div class="row">
          <div class="col-md-6">
            <div class="row acti-modal-incomTab">
              <table class="table table-bordered table-responsive ">
                <thead>
                  <tr style="background-color:#66ff99">
                    <th >Recette</th>
                    <th style="text-align:right">&#8364;</th>
                  </tr>
                </thead>
                <tbody id="acti-modal-incomInfo">
                </tbody>
              </table>
            </div>
            <div class="row  acti-modal-incomTab">
              <table class="table table-bordered table-responsive">
                <thead>
                  <tr style="background-color:#ff8080">
                    <th>Depense</th>
                    <th style="text-align:right">&#8364;</th>
                  </tr>
                </thead>
                <tbody id="acti-modal-expenInfo">
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row acti-modal-net">
              <table class="table table-bordered ">
                <tbody>
                  <tr style="background-color:#80e5ff">
                    <th>Profit net</th>
                    <th style="text-align:right">&#8364;</th>
                  </tr>
                  <tr style="background-color:#e6e6e6">
                    <th>Total</th>
                    <td style="text-align:right" id="acti-modal-profit"></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row">
              <div id="pie1" style="">
              </div>

            </div>
          </div>
        </div>
        <div class="row acti-modal-footer">
          <!--<div class="col-md-5 col-md-offset-1">-->
            <button type="button" class="btn btn-default" aria-label="Modifier" title="Modifier"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
          <!--</div>
          <div class="col-md-5" style="text-align:right">-->
            <button type="button" id="modal-close" class="btn btn-default" aria-label="Fermer" title="Fermer"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
          <!--</div>-->
        </div>
   </div>
</div>


<div class="activity-modal" id="item-modal">
  <div class="acti-modal-content acti-modal-animate container-fluid">
    <div class="row acti-modal-header bg-primary" style="text-align:center">
        <div id="item-modal-title" class="item-modal-title" style="text-align:center">
             <p>Détaille de l'évenement</p>
        </div>
    </div>
    <hr>
    <div class="row item-modal-content">
      <div class="col-md-5">
        <div class="row item-table-title acti-modal-incomTab" style="background-color:#66ff99">
          <div class="col-md-6">
            Recette
          </div>
          <div class="col-md-6" id="recette-total">
          </div>
        </div>
        <div class="row recette-detaille acti-modal-incomTab" id="recette-detaille">
        </div>
        <div class="row" style="text-align:center">
          <button type='button' class="btn btn-default btn-sm" title="Ajouter" id="recette-add"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
      </div>
      <div class="col-md-7">
        <div class="row item-table-title acti-modal-incomTab" style="background-color:#ff8080">
          <div class="col-md-6">
            Depense
          </div>
          <div class="col-md-6" id="depense-total"></div>
        </div>
        <div class="row depense-detaille acti-modal-incomTab" id="depense-detaille">
        </div>
        <div class="row" style="text-align:center">
          <button type='button' class="btn btn-default btn-sm" title="Ajouter" id="depense-add"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
      </div>
    </div>
    <div class="row acti-modal-footer">
      <!--<div class="col-md-5 col-md-offset-1">-->
        <button type="button" id="item-modal-valider" class="btn btn-default" aria-label="Valider" title="Valider"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
      <!--</div>
      <div class="col-md-5" style="text-align:right">-->
        <button type="button" id="item-modal-close" class="btn btn-default" aria-label="Fermer" title="Fermer"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
      <!--</div>-->
    </div>

  </div>
</div>
<script type="text/javascript" src="js/activity.js"></script>
