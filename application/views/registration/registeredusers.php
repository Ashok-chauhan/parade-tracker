<div id="tab1" align="center"> <h3>Registered users.</h3>
	
      
      <?php 
     if($this->session->flashdata()){
         echo '<div style="width: 100%; background-color: #F42E17; color: #F4f6f6; border: solid 1px; text-align: center;">'. $this->session->flashdata('message') . '</div>';
     }
     ?>
   <table border="0" align="center">
     <tr>
      <th> User name </th>
      <th> Type </th>
      <th> Status </th>
      <th> Action </th>
    </tr>
    <?php
    //print '<pre>';
   // print_r($users);
    foreach ($users as $user){
        echo '<tr>';
        echo '<td>'.$user['user']. '</td>';
        echo '<td>'.$user['type']. '</td>';
        echo '<td>'.$user['status']. '</td>';
        echo '<td>'. anchor('registration/userdelete/'.$user['id'], 'Delete').'</td>';
        echo '</tr>';
    }
    ?>
   </table>
</div>

    