
<script>
function listFunction() {
    var x = document.getElementById("paradelist").value;
    //alert(x);
    url = '/parade/config/'+x;
    if(url){
           window.location = url;
    }
   
}
</script>

<div align="center"> Configuration
 <table border="0" align="center"><tr>
    <?php 
    
    if($this->session->flashdata()){
     echo '<div style="widht: 100%;  background-color: #39F417; color: #F4F6F6; border: solid 1px; text-align: center;">';
     echo $this->session->flashdata('message');
     echo '</div>';
    }
//   
    $paradeOption = array('-1' => ' --- DEFAULT --- ');
foreach ($parades as $parade){
    $paradeOption[$parade['id']] = $parade['name'];
    
}
$listOption = array(
    'id' => 'paradelist',
    'onChange'=> 'listFunction()'
);

	echo form_open('parade/configSave');
    
    echo '<tr>';
   	echo '<td>'.form_label('Select parade','parade').'</td>';
	echo '<td>'.form_dropdown('parade', $paradeOption,$parade_id, $listOption).'</td>';
    echo '</tr>';
    
    echo '<tr>';
   	echo '<td>'.form_label('About text','About text').'</td>';
	echo '<td>'.form_input('about_text', $row['about_text']).'</td>';
    echo '</tr>';
    
    echo '<tr>';
   	echo '<td>'.form_label('E-mail','E-mail').'</td>';
	echo '<td>'.form_input('email', $row['email']).'</td>';
    echo '</tr>';
    
    echo '<tr>';
   	echo '<td>'.form_label('Parade location interval','Parade location interval').'</td>';
	echo '<td>'.form_input('location_interval', $row['location_interval']).'</td>';
    echo '</tr>';
    
    echo '<tr>';
   	echo '<td>'.form_label('Parade location url','Parade location url').'</td>';
	echo '<td>'.form_input('location_url', $row['location_url']).'</td>';
    echo '</tr>';
 
    echo '<tr>';
   	echo '<td>'.form_label('Weather url','Weather url').'</td>';
	echo '<td>'.form_input('weather_url', $row['weather_url']).'</td>';
    echo '</tr>';
    
    echo '<tr>';
   	echo '<td>'.form_label('Zipcode','Zipcode').'</td>';
	echo '<td>'.form_input('zipcode', $row['zipcode']).'</td>';
    echo '</tr>';
    
    echo '<tr>';
   	echo '<td>'.form_label('DFP ad unit','DFP ad unit').'</td>';
	echo '<td>'.form_input('dfp_ad_unit', $row['dfp_ad_unit']).'</td>';
    echo '</tr>';
    
    echo '<tr>';
   	echo '<td>'.form_label('Google analytics','Google analytics').'</td>';
	echo '<td>'.form_input('google_analytics', $row['google_analytics']).'</td>';
    echo '</tr>';
    echo '<tr>';
   	echo '<td>'.form_label('Home screen ad','Home screen ad').'</td>';
	echo '<td>'.form_input('home_screen', $row['home_screen']).'</td>';
    echo '</tr>';
    echo '<tr>';
   	echo '<td>'.form_label('Schedule screen ad','Schedule screen ad').'</td>';
	echo '<td>'.form_input('schedule_screen', $row['schedule_screen']).'</td>';
    echo '</tr>';
    echo '<tr>';
   	echo '<td>'.form_label('Interstitial ad','Interstitial ad').'</td>';
	echo '<td>'.form_input('interstitial_ad', $row['interstitial_ad']).'</td>';
    echo '</tr>';
    echo '<tr>';
   	echo '<td>'.form_label('Sponsor ad','Sponsor ad').'</td>';
	echo '<td>'.form_input('sponsor_ad', $row['sponsor_ad']).'</td>';
    echo '</tr>';
    echo '<tr>';
   	echo '<td>'.form_label('Cox ad','Cox ad').'</td>';
	echo '<td>'.form_input('cox_ad', $row['cox_ad']).'</td>';
    echo '</tr>';
    
    echo '<tr>';
	$data = array(
	'name'	=> 'submit',
	'value' => 'Submit',
	'class' => 'ui-widget',
	);
    echo form_hidden('parade_id', $row['parade_id']);
	//echo '<td></td><td>'.form_submit($data).'</td>';
	echo '<td></td><td><button id="config">Save configuration</button></td>';
	echo '</tr>';
	//echo anchor('users/register', 'Create Account');
	echo form_close();
	?>
 </table>
</div>
