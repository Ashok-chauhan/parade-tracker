<link rel="stylesheet" href="<?php echo base_url() ?>css/routes.css" />

<dialog id="dialog">
  <div class="warning">Error</div>
  <p>
    Front of parade can't be set behind End.
  </p>
  <button class="btn" onclick="window.dialog.close();" aria-label="close">Close</button>
</dialog>

<div>
  <div style="width:150px;">
    <button class="btn" onclick="headReset(<?php echo $this->session->userdata('route_id') ?>);">Reset</button>
  </div>

  <div class="location" style="display:inline-block; width:100%;">
    <?php if ($head == 'f') { ?>
      <script>
        function errorModal() {
          document.getElementById("dialog").showModal();
        }
        errorModal();
      </script>
    <?php } ?>
    <!-- HEAD ROUTE LIST -->
    <table>
      <tr>
        <th>
          <h1 align="center">Front of Parade <?php echo $this->session->userdata('parade_name'); ?></h1>
        </th>

      </tr>
    </table>
    <table width="100%" border="0">

      <?php foreach ($routes as $value) { ?>

        <?php if (isset($location_name) && $value['status']) { ?>
          <tr>
            <td class="selected" width="45%">
              <?php echo anchor('home/status/' . $value['id'] . '/' . $value['status'], $value['intersection']); ?>
            </td>
            <td width="45%" style=" font-style: italic;  text-align: center; background-color: #4CAF50; color: #ffffff;">
              <?php echo $location_name; ?>
            </td>
            <td style=" font-style: italic;font-weight: bold;  text-align: center; width: 10%;">
              <?php echo anchor('home/getroute/' . $value['id'], 'Edit'); ?>
            </td>
          </tr>
        <?php } else { ?>
          <tr>
            <td width="90%" colspan="3">
              <?php echo anchor('home/status/' . $value['id'] . '/' . $value['status'], $value['intersection']); ?>
            </td>
            <!--  <td style=" font-style: italic;font-weight: bold;  text-align: center;"><?php //echo anchor('home/getroute/'.$value['id'], 'Edit'); ?> </td>-->
          </tr>
        <?php } ?>

      <?php } ?>
    </table>

  </div>