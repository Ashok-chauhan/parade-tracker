<!-- <div id="generateRoute">
  <button id="btn">Generate Route</button>
</div> -->
<div>
  <form name="generateRouteForm" id="generateRouteForm">
  <button id="btn">Generate Route</button>
</form>
</div>
<div class="float-container">
  <div class="float-child">
    <div class="green">

    <h1>Parade to be updated</h1>
    <form  name="toForm" id="toForm">
        <select class="custom-select" name="route_id" id="to_route_id" onChange="toParadeRoute();">
          <option value="#">--- DEFAULT---</option>
          <?php
          foreach ($parades as $parade){
              echo '<option value='.$parade->route_id.'>'.$parade->name.'</option>';
          };
          ?>
        </select>
  <br><br>
 </form>
</div>
<div id="to-routes"></div>
  </div>
  
  <div class="float-child">
    <div class="blue">


    <h1>Routes from selected Parade</h1> 
    <form name="fromForm" id="fromForm">
  
  <select class="custom-select" name="route_id" id="from_route_id" onChange="fromParadeRoute();" >
    <option value="#">--- DEFAULT---</option>
    <?php
    foreach ($parades as $parade){
       
        echo '<option value='.$parade->route_id.'>'.$parade->name.'</option>';
         
         
     };
     ?>
    
  </select>
  <br><br>
 
</form>

    </div>
    <div id="from-routes"></div>
  </div>
  
</div>
<!-- loader  -->
<div id="loading"></div>

<!-- pop-up dialog box,  -->
<dialog id="favDialog">
  <form method="dialog">
    <p id="result"></p>
    <div>
      <button id="done" type="reset">Updated successfully</button>
  
    </div>
  </form>
</dialog>

<script src="<?php echo base_url() ?>js/routemanagement.js"></script>