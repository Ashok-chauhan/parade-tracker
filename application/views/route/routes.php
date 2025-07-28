<div   class="location">
 <table> 
  <tr>
    <th>Current location for <?php echo $this->session->userdata('parade_name'); ?></th>
    
  </tr>
 </table>
 <ul>
  <?php foreach ($routes as $value) {
      if($value['status']){?>
  <li class="selected"><?php echo anchor('route/status/'.$value['id'].'/'.$value['status'], $value['intersection']);?> 
    
    </li>
   <?php }else{?>
   <li><?php echo anchor('route/status/'.$value['id'].'/'.$value['status'], $value['intersection']);?> </li>
   <?php }?>
  
  <?php }?>
 </ul>
</div>


