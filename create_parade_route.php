<?php


$link = mysql_connect('util.crhgfocqvn5v.us-east-1.rds.amazonaws.com', 'admin', 'KCADCkshjhXwgRtY');
if(!$link){
	die('Could not connect .'. mysql_error());
}
echo 'Connected ...';

mysql_select_db('parade');

$query = 'Select intersection, latitude, longitude, route_order from Routes where route_id=77';
$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
	//echo $row['app_name'] .' --------> '.$row['app_id']. "\n";
	//echo  $row['app_id'];

	mysql_query("insert into Routes (route_id, intersection, latitude, longitude, route_order) VALUES ('9044', '".$row['intersection']."','".$row['latitude']."','".$row['longitude']."', '".$row['route_order']."')");

	printf("Last insterted recond has id  %d\n", mysql_insert_id());
}

print 'Route created successfully!';


