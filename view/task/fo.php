<html>
<head>
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAyY8P_P6ipsS94pFqmjgPh4AE_MBdV4SM&sensor=false"></script>
    <!-- google map api javascript link-->
</head>
<?php
$url = 'https://spreadsheets.google.com/feeds/list/0Ai2EnLApq68edEVRNU0xdW9QX1BqQXhHRl9sWDNfQXc/od6/public/basic?alt=json';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch), TRUE);
curl_close($ch);
$feed = $response['feed'];
$entry = $feed['entry'];
$array = array();
$x = 0;
foreach ($entry as $e) {
    $content = $e['content'];
    echo "content:" . $content['$t'] . '<br>';
    $messageid = explode(',', $content['$t']);
    echo $messageid[0] . '<br>';
    $message = explode(',', $messageid[1]);
    echo $message[0] . '<br>';
    $city = explode(' ', $message[count($message) - 1]);
    foreach ($city as $key => $value) {
        if ($value == null) {
            unset($city[$key]);
        }
    }
    echo 'city:' . $city[count($city)] . '<br>';
    $address = $city[count($city)];
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyAyY8P_P6ipsS94pFqmjgPh4AE_MBdV4SM";
    $get_map = file_get_contents($url);
    $google_map = json_decode($get_map, TRUE);
    $lat = $google_map['results'][0]['geometry']['location']['lat'];
    $lng = $google_map['results'][0]['geometry']['location']['lng'];
    echo 'lat: ' . $lat . '<br>';
    echo 'lng: ' . $lng . '<br>';
    $sentiment = explode('sentiment:', $messageid[count($messageid) - 1]);
    echo 'sentiment:' . $sentiment[1] . '<br>';
    ?>

    <script>

        function initialize() {
            var lat = document.getElementById('lat').value;
            var long = document.getElementById('long').value;
            var add = document.getElementById('add').value;//text to b appeared in the Infowindow
            if (lat && long) {
                var myCenter = new google.maps.LatLng(lat, long);
                var mapProp = {
                    center: myCenter,
                    zoom: 5,      //increase zoom value to zoom map
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };


                var map = new google.maps.Map(document.getElementById("googleMap-<?php echo $x; ?>"), mapProp);// id of the div where map has to be displayed
                var sentiment= '<?php  print_r($sentiment[1]); ?>';
                var color = sentiment == " Positive" ? 'blue' : (sentiment == " Negative" ? 'red' : (sentiment == " Neutral" ? 'green' : 'yellow'));
                let svgMarker = {
                    path:
                        "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                    fillColor: color,
                    fillOpacity: 0.6,
                    strokeWeight: 0,
                    rotation: 0,
                    scale: 2,
                    anchor: new google.maps.Point(15, 30),
                };
                var marker = new google.maps.Marker({
                    position: myCenter,
                    icon: svgMarker,
                });

                marker.setMap(map);
                var infowindow = new google.maps.InfoWindow({
                    content: add //assigning the variable add to infowindow
                });
                infowindow.open(map, marker);
                //mouseover indicates,infowindow to be appeared on mouse over.You can also try 'click'
                google.maps.event.addListener(marker, 'mouseover', function () {
                    infowindow.open(map, marker);
                });
            }
        }

        google.maps.event.addDomListener(window, 'load', initialize);// to load map window on page load

    </script>
    <?php
    echo '<div id="googleMap-' . $x . '" style="height: 350px;"> <!--div where the map is displayed-->
    <input type="hidden" name="lat" id="lat" value="' . $lat . '" />
    <input type="hidden" name="long" id="long" value="' . $lng . '" />
    <input type="hidden" name="add" id="add" value="' . $address . '" />
    </div>';
    echo '------------------------------<br>';
    $x++;
}
?>
</html>
