<link rel="stylesheet" href="<?php echo base_url() ?>css/routes.css" />
<dialog id="dialog">
  <div class="warning">Error</div>
  <p>
    End of parade can't be set ahead of Front.
  </p>
  <button class="btn" onclick="window.dialog.close();" aria-label="close">Close</button>
</dialog>



<div style="width:150px;">
  <button class="btn" onclick="backReset(<?php echo $this->session->userdata('route_id') ?>);">Reset</button>
</div>
<div class="location" style="display:inline-block; width:100%;">
  <!-- HEAD ROUTE LIST -->

  <table>
    <tr>
      <th>
        <h1 align="center">Back of Parade <?php echo $this->session->userdata('parade_name'); ?></h1>
        <!-- <h1 align="center"><a style="cursor:pointer;" onclick="backReset();">Reset</a></h1> -->
      </th>

    </tr>

  </table>


  <!-- TAIL ROUTE LIST -->

  <table width="100%" border="0">
    <?php if ($tail == 'f') { ?>
      <script>
        function myFunction() {
          document.getElementById("dialog").showModal();
        }
        myFunction();
      </script>

    <?php } ?>
    <?php foreach ($routes as $value) { ?>

      <?php if (isset($tail_location_id) && $value['id'] == $tail_location_id) { ?>

        <tr>
          <td class="selected" width="45%">
            <?php echo anchor('home/tail_status/' . $tail_location_id . '/' . $value['status'], $tail_location_name); ?>
          </td>
          <td width="45%" style=" font-style: italic;  text-align: center; background-color: #4CAF50; color: #ffffff;">
            <?php echo $tail_location_name; ?>
          </td>
          <td style=" font-style: italic;font-weight: bold;  text-align: center; width: 10%;">
            <?php echo anchor('home/getTailRoute/' . $value['id'], 'Edit'); ?>
          </td>
        </tr>
      <?php } else { ?>
        <tr>
          <td width="90%" colspan="3">
            <?php echo anchor('home/tail_status/' . $value['id'] . '/' . $value['status'], $value['intersection']); ?>
          </td>
          <!--  <td style=" font-style: italic;font-weight: bold;  text-align: center;"><?php //echo anchor('home/getroute/'.$value['id'], 'Edit'); ?> </td>-->
        </tr>
      <?php } ?>

    <?php } ?>
  </table>
</div>