<style> 
.maindiv {
  box-sizing: content-box;  
  width: 100%;
  height: 300px;
  padding: 3px;  
  border: 1px solid grey;
  border-radius: 8px;
}

.button {
    background-color:  #7f7b7b  ;
    color: white;
    padding: 20px 40px;
    text-align: center;
    text-decoration: none;
    font-size: 24px;
    margin: 20px 20px;
    cursor: pointer;
    position: absolute;
    border-radius: 8px;
 
}

.rightdiv {
  /* box-sizing: content-box;   */
  width: 250px;
  height: 100px;
  padding: 3px;  
  margin: 0 auto;
  /* border: 1px solid grey;
  border-radius: 8px; */
}

.button-x {
  background-color:   #7f7b7b ;
  border: none;
  color: white;
  padding: 20px 40px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 24px;
  margin: 20px 21px;
  cursor: pointer;

  position: absolute;
  border-radius: 8px;
}

a:hover {
  background-color: #ff5733;
}

</style>



<div class="maindiv">
<h1 align="center"><?php echo $parade_name; ?></h1>
     <div class="rightdiv">
       
       <?php echo anchor('home/routes/'.$parade_id, 'Front of Parade', 'class="button"');?>
    </div>
    <div class="rightdiv">
    
    <?php echo anchor('home/tail_routes/'.$parade_id, 'Back of Parade', 'class="button-x"');?>     
</div> 
</div> 
