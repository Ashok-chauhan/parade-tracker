<link rel="stylesheet" href="<?php echo base_url() ?>css/routes.css" />
<div style="width:150px;">
  <button class="btn" onclick="backReset(<?php echo $this->session->userdata('route_id') ?>);">Reset</button>
</div>
<div class="location">
  <table>
    <tr>
      <th>
        <h1 align="center">Back of Parade <?php echo $this->session->userdata('parade_name'); ?></h1>
      </th>

    </tr>
  </table>
  <table border="0" widht="100%">
    <?php foreach ($routes as $value) {
      //if($value['status'])
      if (isset($location_id) && $value['id'] == $location_id) { ?>
        <tr>
          <td class="selected" width="45%">
            <?php echo anchor('home/tail_status/' . $value['id'] . '/' . $value['status'], $value['intersection']); ?>

          </td>
          <td width="45%" style=" font-style: italic;  text-align: center; background-color: #4CAF50; color: #ffffff;">
            <?php echo $location_name; ?>
          </td>
          <td style=" font-style: italic;font-weight: bold;  text-align: center; width: 10%;">
            <?php echo anchor('home/getTailRoute/' . $value['id'] . '/routes', 'Edit'); ?>
          </td>
        </tr>
      <?php } else { ?>
        <tr>
          <td width="90%" colspan="3">
            <?php echo anchor('home/tail_status/' . $value['id'] . '/' . $value['status'], $value['intersection']); ?>
          </td>

          <!--  <td style=" font-style: italic;font-weight: bold;  text-align: center;"><?php //echo anchor('home/getroute/'.$value['id'].'/routes', 'Edit'); ?> 
  
 
  </td>-->
        </tr>
      <?php } ?>

    <?php } ?>
  </table>
</div>