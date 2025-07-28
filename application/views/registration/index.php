<div  align="center"> User Rgistration
	<table border="0" align="center"><tr>
    <?php 
 
    
    if($this->session->flashdata()){
         echo '<div style="width: 100%; background-color: #F42E17; color: #F4f6f6; border: solid 1px; text-align: center;">'. $this->session->flashdata('error') . '</div>';
     }
     
	echo form_open('registration/register');
    echo '<tr>';
	echo '<td>'.form_label('User name','User name').'</td>';
	echo '<td>'.form_input('name', '', 'required').'</td>';
	echo '</tr>';

    echo '<tr>';
   	echo '<td>'.form_label('Password','Password').'</td>';
	echo '<td>'.form_password('password', '', 'required').'</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<td>'.form_label('User type', 'User type').'</td>';
    $typeOption= array(
        'admin' =>'admin',
        'user'  =>'user'
    );
    echo '<td>'.form_dropdown('type', $typeOption, 'user');
    echo '</tr>';
    
    
    echo '<tr>';
    
	$data = array(
	'name'	=> 'submit',
	'value' => 'Submit',
	'class' => 'ui-widget',
	);
	//echo '<td></td><td>'.form_submit($data).'</td>';
	echo '<td></td><td><button id="create-parade">Register user</button></td>';
	echo '</tr>';
	
	echo form_close();
	?>
	</table>
	
	</div>