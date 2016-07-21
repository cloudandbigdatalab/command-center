<?php   
	$json = file_get_contents('http://1-dot-restfulservice-1246.appspot.com/database/users');
	$response = json_decode($json,true);
	//print_r ($response);
	$restLatitude=array();
	$restLongitude=array();
	$restEvent=array();
	$restName=array();
	for($i = 0; $i < count($response); ++$i) {
//    $people[$i]['salt'] = mt_rand(000000, 999999);
		array_push($restLatitude,$response[$i][latitude]);
		array_push($restLongitude,$response[$i][longitude]);
		array_push($restEvent,$response[$i][event]);
		array_push($restName,$response[$i][name]);
	}
	//print_r ($restLatitude);

?>
<!DOCTYPE html>
 <html>
  <head>
   <title>Command Centre</title>
   <meta charset="UTF-8">
   <meta name="viewport" 
                 content="width=device-width">
   <script type="text/javascript"
      src="http://maps.google.com/maps/api/js?
                      key=AIzaSyCX1ED6mPeWahihrOci9y974P-M8zvJUmQ&sensor=false">
   </script> 
  </head>
      
  <body onload="GetMap()">
  
    <div id="mapContainer" 
             style="width:1320px;height:600px">
   </div>
   
   <script type="text/javascript">
    function GetMap() {
	//var totalLongitude= '<?php echo $androidmessages ;?>';
	var longitude= <?php echo json_encode($restLongitude) ?>;
	//var totalLatitude= '<?php echo $androidmessages2 ;?>';
	var latitude= <?php echo json_encode($restLatitude) ?>;
	//var totalEvents= '<?php echo $androidmessages3 ;?>';
	var events= <?php echo json_encode($restEvent) ?>;
	var name= <?php echo json_encode($restName) ?>;
	
    var latlng =  new google.maps.LatLng(29.58625181,-98.61872391);
	
     var myOptions = {
           zoom: 13,
         center: latlng,
      mapTypeId: google.maps.MapTypeId.HYBRID
     };
     var container = document.getElementById(
                               "mapContainer");
     map = new google.maps.Map(container,
                                   myOptions);
	for(var i=0;i<latitude.length;i++){
	marker1 = new google.maps.Marker();
	marker1.setPosition(new google.maps.LatLng(parseFloat(latitude[i]),parseFloat(longitude[i])));
	marker1.setMap(map);
	//marker1.setLabel("Name:");
	marker1.setDraggable(true);
	addInfoWindow(marker1, name[i]);
	if (events[i].match("Ambulance")){
		marker1.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
	}  
	if(events[i].match("Doctor")){
		marker1.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png');
	} 
	if(events[i].match("Insurance")){
		marker1.setIcon('http://maps.google.com/mapfiles/ms/icons/yellow-dot.png');
	} 
	}
	}
	function addInfoWindow(marker, message) {

            var infoWindow = new google.maps.InfoWindow({
                content: message
            });

            google.maps.event.addListener(marker, 'click', function () {
                infoWindow.open(map, marker);
            });
        }
  </script>
 
 </body>
</html> 