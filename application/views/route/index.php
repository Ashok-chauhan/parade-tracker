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

<div style="width:100%;">
 <table> 
  <tr>
    <th>Today's Parades</th>
    
  </tr>
  <?php foreach ($parades as $value) {?>
  <tr>
   <td ><?php echo anchor('route/routes/'.$value['route_id'].'/'.$value['name'], $value['name']);?> </td>
  </tr>
  <?php }?>
 </table>
</div>

 