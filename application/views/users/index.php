<div id="tab1" align="center"> Whiz Technologies Parade Tracker
	<table border="0" align="center"><tr>
    <?php 
    
	echo form_open('users/login');
	echo '<td>'.form_label('User name','user name').'</td>';

	echo '<td>'.form_input('user', '', 'required').'</td>';
    

	echo '</tr><tr>';
	echo '<td>'.form_label('Password', 'password').'</td>';
	echo '<td>'.form_password('password', '', 'required').'</td>';
	echo '</tr><tr>';
	$data = array(
	'name'	=> 'submit',
	'value' => 'Login',
	'class' => 'ui-widget',
	);
	//echo '<td></td><td>'.form_submit($data).'</td>';
	echo '<td></td><td><button type="submit" id="create-user">Login</button></td>';
	echo '</tr>';
	//echo anchor('users/register', 'Create Account');
	echo form_close();
     
     
	?>

     
	</table>
	
	</div>