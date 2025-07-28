<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #F4F6F6;
}
</style>
<script>
function warn(parade_id) {
    var retVal = confirm("Do you want to delete parade ?");
   
     if( retVal === true ){
                  window.location = '/parade/delete/'+parade_id;
               }
               
}
</script>


<?php 
date_default_timezone_set('America/Chicago'); 

 if($this->session->flashdata()){?>
     <div style="widht: 100%;  background-color: #39F417; color: #F4F6F6; border: solid 1px; text-align: center;"><?php echo $this->session->flashdata('message');?></div>
 
 <?php } ?>

<div style="width: 100%;">
 <table> 
  <tr>
   <th ><?php echo anchor('parade/index/'.$nameOrder, 'Parade name &#8645') ;?></th>

   <th><?php echo anchor('parade/index/'.$dateOrder, 'Date  &#8645') ;?></th>
    
  </tr>
<?php foreach ($parades as $value){ ?>
  <tr>
   <td ><?php echo anchor('parade/edit/'.$value['id'], $value['name']) ;?></td>
   <td><?php if($value['date'])
    {
        echo date('m/d/Y  ', $value['date']);
        
    }else{ echo '0';}
    
    if($value['start_time'])
    {
        echo date(' h:i:s ', $value['start_time'] );
        echo $value['am_pm'];
    }else{ echo '0';}
    
    ?>
   </td>
    
<!--   <td>
   
       <?php 
       
        // echo '<span style="background-color:yellow"><a href="#" onclick="warn('.$value['id'].' )">Delete </a></span>' ;          
       ?>
     
    </td>-->
  </tr>
  

<?php }?>
 </table>
 <div  > <?php //echo $pages; ?></div>
 
</div>
     
     
     