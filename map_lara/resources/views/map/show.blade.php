<html> 
<head> 
    <title>Map</title>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=(AIzaSyBt7iWrqVAavF2zBKIT3efe2ADtdcPK9vo)"></script> 
<script type="text/javascript"> 
  function init() { 
    var latlng = new google.maps.LatLng('{{ $map->lat }}','{{ $map->lng }}'); 
    var myOptions = { 
      zoom: 15, 
      center: latlng, 
      mapTypeId: google.maps.MapTypeId.ROADMAP 
    }; 
    var map = new google.maps.Map(document.getElementById("map"), myOptions);  

    var marker = new google.maps.Marker({
       position: latlng,
       map: map,
       title:"{{ $map->name }}"
    });
  } 
</script> 
</head> 
<body onload="init()"> 
<div id="map" style="width:550px; height:300px;"></div>
</body> 
</html>