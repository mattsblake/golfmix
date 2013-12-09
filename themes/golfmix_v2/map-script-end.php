    ];

    var map = new google.maps.Map(document.getElementById('map_canvas'), {
      zoom: 11,
      center: new google.maps.LatLng(<?php echo $c_latitude.','.$c_longitude; ?>),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
   }
</script>
	<?php if ($detect->isMobile() && !$detect->isIpad()) { ?>
		<div style="border: 1px solid #CCCCCC;height: 200px;margin: 3%; width: 94%;">
			<div id="map_canvas" style="width: 100%; height: 100%;"></div>
		</div>
	<?php } else { ?>
		<div class="inner-map-area" style="width: 98%;margin-top: -10px;">
			<div id="map_canvas" style="width: 99%; height: 282px;"></div>
		</div>
	<?php } ?>