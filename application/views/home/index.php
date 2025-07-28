<script>
function todaysParade() {
    var x = document.getElementById("paradelist").value;
    //for production
    //url = '/home/routes/'+x;
    // for devlopment only 
    //url = '/parade.whizti.com/home/routes/'+x;
    url = '/home/stringer/'+x;
    if(url){
           window.location = url;
    }
   
}
</script>

<?php

 $paradeOption = array('-1' => ' --- DEFAULT --- ');
foreach ($parades as $parade){
    $paradeOption[$parade['id']] = $parade['name'];
    
    
}

$listOption = array(
    'id' => 'paradelist',
    'onChange'=> 'todaysParade()'
);

echo '<div align="center"> <h1>Today\'s Parade </h1>';
echo '<table>';
	//echo form_open('home/routes');
    echo form_open('home/stringer');
    
    echo '<tr>';
   	echo '<td>'.form_label('Select parade','parade').'</td>';
	echo '<td>'.form_dropdown('parade', $paradeOption,'', $listOption).'</td>';
    echo '</tr>';
    
     //echo form_hidden('parade_id', $row['parade_id']);
     echo form_close();
     
     echo '</table>';
     echo '</div>';