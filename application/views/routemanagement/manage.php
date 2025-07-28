<div class="center-routes">
  <div class="center-list">
    <!-- <div class="page-heading">

    <div class="page-left"><h1>Manage parade routes</h1></div>
    <div class="page-right"><button class="btn-edit"> Add route</button></div>
</div> -->

    <div class="page-heading">
      <div class="page-left"> Manage parade routes </div>
      <div class="page-right"> <button class="adpoint" onClick="addRoute();"> Add point</button> </div>
    </div>

    <form name="toForm" id="toForm">
      <select class="custom-select" name="route_id" id="to_route_id" onChange="manageRoute();">
        <option value="#">--- DEFAULT---</option>
        <?php
        foreach ($parades as $parade) {
          echo '<option  value=' . $parade->route_id . '>' . $parade->name . '</option>';
        }
        ;
        ?>
      </select>
      <br><br>
    </form>
  </div>
  <!-- <div id="to-routes"></div> -->
  <table id="to-routes" class="tbl"></table>




  <!-- loader  -->

  <div id="loading"></div>

</div> <!--outer div -->
<!-- pop-up dialog box,  for edit form-->
<dialog id="route-edit">
  <form method="POST" id="frmUpdate">
    <p id="result"></p>
    <lable>Intersection</lable>
    <input type="text" id="intersection" />
    <lable>Latitude</lable>
    <input type="text" id="latitude" />
    <lable> Longitude</lable>
    <input type="text" id="longitude" />
    <input type="hidden" id="id" />

    <div>
      <button id="doneRoute" type="reset">Cancel</button>
      <button type="submit" id="updateRoute">Confirm</button>
    </div>

  </form>
</dialog>

<!-- Feed back dialog after update single route from edito button  bof -->

<!-- pop-up dialog box,  -->
<dialog id="favDialog">
  <form method="dialog">
    <p id="result"></p>
    <div>
      <button id="done" type="reset">Updated successfully</button>

    </div>
  </form>
</dialog>


<!-- Feed back dialog eof after update single route -->


<!-- pop-up dialog box,  for add route form-->
<dialog id="route-add">
  <form method="POST" id="frmAdd">
    <p id="addresult"></p>
    <lable>Intersection</lable>
    <input type="text" id="add-intersection" name="intersection" value="" />
    <lable>Latitude</lable>
    <input type="text" id="add-latitude" name="latitude" />
    <lable> Longitude</lable>
    <input type="text" id="add-longitude" name="longitude" />


    <div>
      <button id="doneRouteAdd" type="reset">Cancel</button>
      <button type="submit" id="addRouteSubmit">Add point</button>
    </div>

  </form>
</dialog>
<!-- eof add route form -->

<script src="<?php echo base_url() ?>js/routemanagement.js?v=1.0"></script>
<script src="<?php echo base_url() ?>js/dragndrop.js?v=1.0"></script>

<script src="<?php echo base_url() ?>js/addroute.js?v=1.0"></script>