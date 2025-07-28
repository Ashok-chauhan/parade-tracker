<div  align="center"> Edit Back of Parade Route 
	<table border="0" align="center"><tr>
    <?php 
 
    
    if($this->session->flashdata()){
         echo '<div style="width: 100%; background-color: #F42E17; color: #F4f6f6; border: solid 1px; text-align: center;">'. $this->session->flashdata('error') . '</div>';
     }
    date_default_timezone_set('America/Chicago'); 
	echo form_open('home/editTailLocation');
    echo '<tr>';
	echo '<td>'.form_label('Back of Parade Route  name','Back of Parade Route name').'</td>';
	echo '<td>'.form_input('intersection', $row->intersection).'</td>';
	echo '</tr>';

    
    
    echo '<tr>';
    
	$data = array(
	'name'	=> 'submit',
	'value' => 'Submit',
	'class' => 'ui-widget',
	);
	//echo '<td></td><td>'.form_submit($data).'</td>';
	echo '<td></td><td><button id="create-parade">Edit Back of Parade route</button></td>';
	echo '</tr>';
	 echo form_hidden('id', $row->id);
     echo form_hidden('page', $page);
	echo form_close();
	?>
	</table>
	
	</div>