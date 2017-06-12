<!DOCTYPE html>
<html>
<?php
include 'firebaseConnectivity.php';
include 'roverHeadSection.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("location: index.php");
}

?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- START HEADER BAR -->
    <?php
    include 'roverHeader.php';
    ?>
    <!-- END HEADER BAR -->
    <!-- START SIDE BAR -->
    <?php
    include 'roverSidebar.php';
    ?>
    <!-- END SIDE BAR -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Intensity Map</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                        <div id="map" class="mapping" style="height: 450px"></div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2017-2018 <a href="#">Rover</a>.</strong> All rights
        reserved.
    </footer>
</div>
<!-- ./wrapper -->
<?php
include 'roverBodyLinkSection.php';
?>
<script type="text/javascript">
    firebase.database().ref().child('tripRoute').once('value').then(function (snapshot) {
        snapshot.forEach(function (snap) {
            var coordinateData = [];
            var json = snap.val();
            var key;
            for (var field in json) {
                key = field;
                var jkey = json[key];
                for (var field1 in jkey) {
                    var jkey1 = field1;
                    var lat = jkey[jkey1]["latitude"];
                    var long = jkey[jkey1]["longitude"];
                    coordinateData.push(new google.maps.LatLng(lat, long));
                }
            }
            loadMap(coordinateData);
        });
    });

    var map, heatmap, pointArray = [];
    function initMap() {
        //pointArray = new google.maps.MVCArray(txData);
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {lat: 19.9975, lng: 73.7898},
            mapTypeId: 'roadmap'
        });
    }
    function loadMap(txData) {

        pointArray = new google.maps.MVCArray(txData);
        heatmap = new google.maps.visualization.HeatmapLayer({
            data: txData,            //txData,
            map: map
        });
    }

    function toggleHeatmap() {
        heatmap.setMap(heatmap.getMap() ? null : map);
    }

    function changeGradient() {
        var gradient = [
            'rgba(0, 255, 255, 0)',
            'rgba(0, 255, 255, 1)',
            'rgba(0, 191, 255, 1)',
            'rgba(0, 127, 255, 1)',
            'rgba(0, 63, 255, 1)',
            'rgba(0, 0, 255, 1)',
            'rgba(0, 0, 223, 1)',
            'rgba(0, 0, 191, 1)',
            'rgba(0, 0, 159, 1)',
            'rgba(0, 0, 127, 1)',
            'rgba(63, 0, 91, 1)',
            'rgba(127, 0, 63, 1)',
            'rgba(191, 0, 31, 1)',
            'rgba(255, 0, 0, 1)'
        ]
        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
    }

    function changeRadius() {
        heatmap.set('radius', heatmap.get('radius') ? null : 20);
    }

    function changeOpacity() {
        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
    }

    // Heatmap data: 500 Points

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkoWVVZbGvjquh_d2k9XmC9i6omvNVRDY&libraries=visualization&callback=initMap">
</script>
</body>
</html>
