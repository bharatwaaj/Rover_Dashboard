<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<?php
include 'firebaseConnectivity.php';
include 'roverHeadSection.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("location: index.php");
}
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
}
else{
    header("location: dashboard.php");
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
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Timeline
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- row -->
            <div class="row" id="tripsoutput">

            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2017-2018 <a href="#">Rover</a>.</strong> All rights
        reserved.
    </footer>
    <!-- ./wrapper -->
    <?php
    include 'roverBodyLinkSection.php';
    ?>
</div>
<script type="text/javascript" src="busy.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript">
    var uid = '<?php echo $uid ?>';
    var timestamp=1496464372;
    function tripdate(timestamp) {
        var a = new Date(timestamp * 1000);
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();
        var time = date + ' ' + month + ' ' + year;
        //alert(time);
        return time;
    }


    if (!Date.now) {
        Date.now = function() { return new Date().getTime(); }
    }
    var currentTimestamp=Math.floor(Date.now() / 1000);
    //alert(date);
    //alert(timeDifference(149649999000,149646437000));
    function timeDifference(current, previous) {

        var msPerMinute = 60 * 1000;
        var msPerHour = msPerMinute * 60;
        var msPerDay = msPerHour * 24;
        var msPerMonth = msPerDay * 30;
        var msPerYear = msPerDay * 365;
        var elapsed = current - previous;

        if (elapsed < msPerMinute) {
            return Math.round(elapsed/1000) + ' seconds ago';
        }

        else if (elapsed < msPerHour) {
            return Math.round(elapsed/msPerMinute) + ' minutes ago';
        }

        else if (elapsed < msPerDay ) {
            return Math.round(elapsed/msPerHour ) + ' hours ago';
        }

        else if (elapsed < msPerMonth) {
            return Math.round(elapsed/msPerDay) + ' days ago';
        }

        else if (elapsed < msPerYear) {
            return Math.round(elapsed/msPerMonth) + ' months ago';
        }

        else {
            return Math.round(elapsed/msPerYear ) + ' years ago';
        }
    }
    var source="Source";
    var destination="Destination",i;
    var duration, starttime, endtime,sourcelatitude,sourcelongitude,destinationlatitude,destinationlongitude,tripid;
    database.ref().child('trips/' + uid + '/').once('value').then(function (snapshot) {
        var tripssdate;
        snapshot.forEach(function (snap) {
            endtime=snap.child("tripEndTime").val();
            sourcelatitude=snap.child("tripSourceLatitude").val();
            sourcelongitude=snap.child("tripSourceLongitude").val();
            destinationlatitude=snap.child("tripDestinationLatitude").val();
            destinationlongitude=snap.child("tripDestinationLongitude").val();
            duration=snap.child("tripDuration").val();
            starttime=snap.child("tripStartTime").val();
            tripid=snap.child("tripId").val();
            tripssdate=tripdate(endtime);
            createtimeline(tripssdate,starttime,endtime,sourcelatitude,sourcelongitude,destinationlatitude,destinationlongitude);
        });
    });
    function createtimeline(tripsdate,tripstarttime,tripendtime,sourcelat,sourcelng,destinationlat,destinationlng) {
            var element = "<div class='col-md-12'><ul class='timeline'><li class='time-label'>\
            <span class='bg-red'>"+ tripsdate + "</span>\
            </li>\
            <li>\
            <i class='fa fa-map-marker bg-blue'></i>\
                <div class='timeline-item'>\
                <span class='time'><i class='fa fa-clock-o'>  "+ timeDifference(currentTimestamp*1000,tripstarttime*1000) +"</i></span>\
            <h3 class='timeline-header'><a href='#'>" + source + "</a></h3>\
                <div class='timeline-body'>" + GetAddress(destinationlat,destinationlng,'source') + "<span id='source'></span></div>\
            </div>\
            </li>\
            <li>\
            <i class='fa fa-motorcycle bg-aqua'></i>\
                <div class='timeline-item'>\
                <span class='time'><i class='fa fa-clock-o'>  "+ timeDifference(currentTimestamp*1000,tripstarttime*1000) +"</i></span>\
            <h3 class='timeline-header no-border'>Description<a href='#'></a>\
            </h3>\
            </div>\
            </li>\
            <li>\
            <i class='fa fa-map-marker bg-yellow'></i>\
                <div class='timeline-item'>\
                <span class='time'><i class='fa fa-clock-o'>  "+ timeDifference(currentTimestamp*1000,tripendtime*1000) +"</i></span>\
                <h3 class='timeline-header'><a href='#'>" + destination + "</a></h3>\
                <div class='timeline-body'>" + GetAddress(destinationlat,destinationlng,'destiny') + "<span id='destiny'></span></div>\
            </div>\
            </li></ul></div>";
            $("#tripsoutput").append(element);
        }
    </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDkoWVVZbGvjquh_d2k9XmC9i6omvNVRDY"></script>
        <script type="text/javascript">
            //alert(GetAddress(19.12365, 75.36521));
            function GetAddress(lat, lng, id) {
                var latlng = new google.maps.LatLng(lat, lng);
                var geocoder = geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': latlng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            if(results[0].formatted_address!=null) {
                                document.getElementById(id).innerHTML = results[0].formatted_address;
                            }
                            else{
                                document.getElementById(id).innerHTML=" ";
                                }
                        }
                        else{
                            document.getElementById(id).innerHTML=" ";
                        }
                    }
                });
            }
        </script>
</body>
</html>