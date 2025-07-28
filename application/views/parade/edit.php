<style>
    qqq-img {
    width:300px;
    height:150px;
    object-fit:scale-down;
    object-position:center;
}

.imagefile input[type="file"] {
    /*display: none;*/
    /*font-size: 15px;*/
   /* position: absolute;
    margin-top: 60px;
   */
    /*position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
  */
}
</style>
<div id="tab1" align="center" > Edit Parade
 	<table border="0" align="center"><tr>
    <?php 
     if($this->session->flashdata()){
         echo '<div style="width: 100%; background-color: #F42E17; color: #F4f6f6; border: solid 1px; text-align: center;">'. $this->session->flashdata('error') . '</div>';
     }
     
    date_default_timezone_set('America/Chicago');
	echo form_open_multipart('parade/save');
    
	echo '<td>'.form_label('Parade name','Parade name').'</td>';
	echo '<td>'.form_input('name', $row['name']).'</td>';
	echo '</tr>';

    echo '<tr>';
   	echo '<td>'.form_label('Parade area','Parade area').'</td>';
	echo '<td>'.form_input('area', $row['area']).'</td>';
    echo '</tr>';
    
    echo '<tr>';
    
   	echo '<td>'.form_label('Date','Date').'</td>';
	echo '<td>';
    echo '<span> M '.form_dropdown('month',$months, date('m', $row['date'])).'</span>';
    echo '<span> D'.form_dropdown('date',$dates, date('d', $row['date'])).'</span>';
    echo '<span> Y '.form_dropdown('year',$years, date('Y', $row['date'])).'</span>';
    echo '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<td>'.form_label('Start time', 'Start time').'</td>';
    echo '<td>';
    echo '<span> H '.form_dropdown('hour',$hour, date('H', $row['start_time'])).'</span>';
    echo '<span> M '.form_dropdown('minute',$minute, date('i', $row['start_time'])).'</span>';
    echo '<span> S . '.form_dropdown('second',$second, date('s', $row['start_time'])).'</span>';
    if($row['am_pm'] == 'am'){
        echo '<span> am '.form_radio('am_pm','am','true').'</span>';
        echo '<span> pm '.form_radio('am_pm','pm','').'</span>';
    }  else {
        echo '<span> am '.form_radio('am_pm','am','').'</span>';
        echo '<span> pm '.form_radio('am_pm','pm','true').'</span>';
        
    }
    echo '</td>';
    echo '</tr>';
   
    echo '<tr>';
   	echo '<td>'.form_label('Route id','Route id').'</td>';
	echo '<td>'.form_input('route_id', $row['route_id'], 'required readonly').'</td>';
    echo '</tr>';

    echo '<tr>';
   	echo '<td>'.form_label('No. of floats','No. of floats').'</td>';
	echo '<td>'.form_input('floats', $row['floats']).'</td>';
    echo '</tr>';
    echo '<tr>';
   	echo '<td>'.form_label('Banner ad','Banner ad').'</td>';
	echo '<td>'.form_input('banner', $row['banner']).'</td>';
    echo '</tr>';
    echo '<tr>';
   	echo '<td>'.form_label('Sponsor ad','Sponsor ad').'</td>';
	echo '<td>'.form_input('sponsor_ad', $row['sponsor_ad']).'</td>';
    echo '</tr>';

    $attributes= array(
       'class' => 'imagefile---'
       
   );
    echo '<tr>';
	echo '<td>'.form_label('Image', 'Image', $attributes).'</td>';
    ?>
    
      <td class="imagefile">
     <input   type="file" name="userfile" size="20" value="<?php echo $row['image'];?>" />
     <?php if(is_file('assets/'.$row['image'])){?>
     <span style="margin-left: 0px;"><img  src="<?php echo base_url().'assets/'.$row['image'];?>"/></span>
     <?php } ?>
    </td>
    
	</tr>
 
    <tr>
     <?php 
	$data = array(
	'name'	=> 'submit',
	'value' => 'Submit',
	'class' => 'ui-widget',
	);
    echo form_hidden('id', $row['id']);
	//echo '<td></td><td>'.form_submit($data).'</td>';
	echo '<td></td><td><button id="edit">Save</button></td>';
	echo '</tr>';
	//echo anchor('users/register', 'Create Account');
	echo form_close();
    
    
   
	?>
	</table>
	
	</div>