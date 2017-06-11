<!DOCTYPE html>
<html>

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
?>

<script type="text/javascript">

    // Get uid
    var uid = '<?php echo $uid ?>';

    // Set Email id and username
    database.ref("/users/" + uid + "/").once('value').then(function (data) {
        email = data.child('email').val();
        username = data.child('username').val();
        workplace = data.child('workPlace').val();
        document.getElementById("userNameDetailPage").innerHTML = username;
        document.getElementById("emailDetailPage").innerHTML = email;
        document.getElementById("organization").innerHTML = workplace;
    });

    // Braking and Speeding Patterns
    var braking = [], speeding = [];
    database.ref().child('tripSpeeding/' + uid + '/').once('value').then(function (snapshot) {
        snapshot.forEach(function (snap) {
            braking.push(snap.child("braking").val());
            speeding.push(snap.child("speeding").val());
        });
        if (braking.length == 0 && speeding.length == 0) {
            document.getElementById("braking-speeding-line-chart").innerHTML = "<h4>No braking & speeding details</h4>";
        } else {
            drawLineChart(braking, speeding);
        }
    });

</script>

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
                <!-- /.col -->
                <div class="col-md-6">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-black"
                             style="background: url('dist/img/photo1.png') center center; height: 132px;">
                            <h3 class="widget-user-username" id="userNameDetailPage"></h3>
                            <h5 class="widget-user-desc" id="emailDetailPage"></h5>
                        </div>
                        <div class="widget-user-image" style="padding-top: 40px">
                            <img class="img-circle" src="dist/img/avatar04.png" alt="User Avatar">
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">Organization</h5>
                                        <span class="description-text" id="organization"></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header"></h5>
                                        <span class="description-text"></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">Points Gained</h5>
                                        <span class="description-text" id="points">150</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">Avg Speed</h5>
                                        <span class="description-text" id="userAvgSpeedValue"></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">Max Speed</h5>
                                        <span class="description-text" id="userMaxSpeedValue"></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">Distance</h5>
                                        <span class="description-text" id="userDistanceValue">kms</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!--/.row-->
                        </div>
                    </div>
                    <!-- /.widget-user -->
                </div>
                <!-- /.col -->


                <!-- Calendar -->
                <div class="col-md-6">
                    <div class="box box-solid bg-green-gradient">
                        <div class="box-header">
                            <i class="fa fa-calendar"></i>

                            <h3 class="box-title">Trips Calendar</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <!-- button with a dropdown -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                            data-toggle="dropdown">
                                        <i class="fa fa-bars"></i></button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Add new event</a></li>
                                        <li><a href="#">Clear events</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">View calendar</a></li>
                                    </ul>
                                </div>
                                <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i
                                        class="fa fa-times"></i>
                                </button>
                            </div>
                            <!-- /. tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <!--The calendar -->
                            <div id="trips-calendar" style="width: 100%;"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <!-- Line chart -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-bar-chart-o"></i>

                            <h3 class="box-title">Braking & Speeding Pattern</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div id="braking-speeding-line-chart" style="height: 300px;"></div>
                        </div>
                        <!-- /.box-body-->
                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-md-6">
                    <div class="box box-solid bg-light-blue-gradient">
                        <div class="box-header">
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button type="button" id="trip-date-picker-map" class="btn btn-primary btn-sm pull-right"
                                        data-toggle="tooltip" title="Date">
                                    <i class="fa fa-calendar"></i></button>
                                <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
                                        data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                                    <i class="fa fa-minus"></i></button>
                            </div>
                            <!-- /. tools -->

                            <i class="fa fa-map-marker"></i>

                            <h3 class="box-title">
                                Last Trip
                            </h3>
                        </div>
                        <div class="box-body">
                            <div id="lastLocationMap" style="height:305px">
                            </div>
                            <!-- /.box-body-->
                        </div>
                        <!-- /.box -->

                    </div>
                </div>
            </div>

            <div class="row">
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

    // On Page Load - Date Pickers
    $("#trips-calendar").datepicker();

    $('#trip-date-picker-map').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
    }, function (start, end) {
        window.alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });

    // To draw line chart
    function drawLineChart(braking, speeding) {
        var brakingArray = [], speedingArray = [];
        for (var i = 0; i < braking.length; i++) {
            brakingArray.push([i, braking[i]]);
            speedingArray.push([i, speeding[i]]);
        }
        var line_data1 = {
            label: "braking",
            data: brakingArray,
            color: "#3c8dbc"
        };
        var line_data2 = {
            label: "speeding",
            data: speedingArray,
            color: "#ff4040"
        };

        $.plot("#braking-speeding-line-chart", [line_data1, line_data2], {
            grid: {
                hoverable: true,
                borderColor: "#f3f3f3",
                borderWidth: 1,
                tickColor: "#f3f3f3"
            },
            series: {
                shadowSize: 0,
                lines: {
                    show: true
                },
                points: {
                    show: true
                }
            },
            lines: {
                fill: false,
                color: ["#3c8dbc", "#f56954"]
            },
            yaxis: {
                show: true
            },
            xaxis: {
                show: true
            }
        });

        //Initialize tooltip on hover
        $('<div class="tooltip-inner" id="braking-speeding-line-chart-tooltip"></div>').css({
            position: "absolute",
            display: "none",
            opacity: 0.8
        }).appendTo("body");

        $("#braking-speeding-line-chart").bind("plothover", function (event, pos, item) {
            if (item) {
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);
                $("#braking-speeding-line-chart-tooltip").html(item.series.label + " " + y)
                    .css({top: item.pageY + 5, left: item.pageX + 5})
                    .fadeIn(200);
            } else {
                $("#braking-speeding-line-chart-tooltip").hide();
            }

        });
    }

    // Update Last Seen Location on Map
    var lastTripCoordinates = [];
    var tempLatitude, tempLongitude;
    var lastTrip;
    var directionsService, directionsDisplay;
    var ref = firebase.database().ref("/tripRoute/" + uid + "/");
    ref.orderByKey().limitToLast(1).on("child_added", function (snapshot) {
        lastTrip = snapshot.key;
        trip(lastTrip);
    });
    function trip(triplast) {
        var count = 0;
        var ref1 = firebase.database().ref("/tripRoute/" + uid + "/" + triplast).once("value").then(function (snapshot) {
            snapshot.forEach(function (snapchild) {
                a = snapchild.child('latitude').val();
                b = snapchild.child('longitude').val();
                count = count + 2;
                storeCoordinate(a, b, lastTripCoordinates);
            });
            initLastLocationMap(lastTripCoordinates, count);
        });
    }
    function storeCoordinate(xVal, yVal, array) {
        lastTripCoordinates.push(xVal);
        lastTripCoordinates.push(yVal);
    }
    var lastLocationMap;
    function initLastLocationMap(coord, cownt) {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        lastLocationMap = new google.maps.Map(document.getElementById('lastLocationMap'), {
            zoom: 7,
            center: {lat: 20.5937, lng: 78.9629}
        });
        directionsDisplay.setMap(lastLocationMap);
        directionsDisplay.setOptions({suppressMarkers: true});
        if (cownt > 0) {
            DisplayRoute(directionsService, directionsDisplay, coord, cownt);
        }
    }

    function DisplayRoute(directionsService, directionsDisplay, coords, countt) {
        var waypts = [];
        var checkboxArray = coords;
        var mid = countt / 2;
        var left, right;
        if (mid % 2 != 0) {
            left = mid - 1;
            right = mid;
        }
        else {
            left = mid;
            right = mid + 1;
        }
        waypts.push({
            location: new google.maps.LatLng(checkboxArray[left], checkboxArray[right]),
            stopover: true
        });
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(checkboxArray[0], checkboxArray[1]),
            title: "Source",
        });
        marker.setMap(lastLocationMap);
        var marker1 = new google.maps.Marker({
            position: new google.maps.LatLng(checkboxArray[countt - 2], checkboxArray[countt - 1]),
            icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
            title: "Destination",
        });
        marker1.setMap(lastLocationMap);
        directionsService.route({
            origin: new google.maps.LatLng(checkboxArray[0], checkboxArray[1]),
            destination: new google.maps.LatLng(checkboxArray[countt - 2], checkboxArray[countt - 1]),
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: 'DRIVING'
        }, function (response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
                var route = response.routes[0];
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }

    // Max, Avg Speed and Distance Update
    database.ref().child('tripSpeedDetails/' + uid + '/').once('value').then(function (snapshot) {
        var total = 0, count = 0, avgSpeed = 0, maxSpeed = 0;
        snapshot.forEach(function (snap) {
            var key, tripid;
            var json = snap.val();
            var subtotal = 0, subcount = 0;
            for (var field in json) {
                tripid = field;
                var speed = json[tripid]["speed"];
                if (speed > maxSpeed)
                    maxSpeed = speed;
                subtotal += speed;
                subcount++;
            }
            total += subtotal;
            count += subcount;
        });
        avgSpeed = total / count;
        if (isNaN(avgSpeed)) {
            document.getElementById('userAvgSpeedValue').innerHTML = 0 + " Kmph";
        }
        document.getElementById('userAvgSpeedValue').innerHTML = avgSpeed.toFixed(2) + " Kmph";
        document.getElementById('userMaxSpeedValue').innerHTML = maxSpeed + " Kmph";
    });
    var totaldistance=0;
    firebase.database().ref().child('trips/'+uid+'/').once('value').then(function(snapshot) {
        var total=0,count=0,avg=0,maxspeed=0;
        snapshot.forEach(function(snap){
            var distance=snap.child("tripDistance").val();
            totaldistance+=distance;
        });
        document.getElementById('userDistanceValue').innerHTML = totaldistance.toFixed(2) + " Km";
    });

</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkoWVVZbGvjquh_d2k9XmC9i6omvNVRDY&callback=initLastLocationMap">
</script>
</body>
</html>
