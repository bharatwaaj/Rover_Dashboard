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

<script type="text/javascript">

    // Generic Functions
    /**
     * @return {number}
     */
    function ObjectLength(object) {
        var length = 0;
        for (var key in object) {
            if (object.hasOwnProperty(key)) {
                ++length;
            }
        }
        return length;
    }
    ;

    // Users Count Update
    var usersReference = database.ref("users");
    function updateUserCount(objectLength) {
        document.getElementById("total-users").innerHTML = objectLength;
    }
    usersReference.on("value", function (snapshot) {
        updateUserCount(ObjectLength(snapshot.val()));
    });

    // Trips Count Update
    var tripsReference = database.ref("trips");
    var tripslength = 0;
    function updateTripsCount(objectLength) {
        document.getElementById("total-trips").innerHTML = objectLength;
    }
    tripsReference.on("child_added", function (snapshot) {
        tripslength += ObjectLength(snapshot.val());
        updateTripsCount(tripslength);
    });

    // Safe And Unsafe Rider Update
    function updateSafeDriverPlaceHolder(text) {
        document.getElementById("safe-rider-name").innerHTML = text;
    }
    function updateUnSafeDriverPlaceHolder(text) {
        document.getElementById("unsafe-rider-name").innerHTML = text;
    }
    database.ref().child('tripSpeeding').once('value').then(function (snapshot) {
        var keyvalue = [], count = 0;
        snapshot.forEach(function (snap) {
            var json = snap.val();
            var key, jkey, brake, speed, rank = 0;
            for (var field in json) {
                key = field;
                jkey = json[key];
                brake = json[key]["braking"];
                speed = json[key]["speeding"];
                rank += ((brake * 2) + (speed * 1));
            }
            keyvalue.push({id: snap.key, ranking: rank});
            count++;
        });
        sorting(keyvalue, count);
    });
    function sorting(homes, cnt) {
        homes.sort(function (a, b) {
            return parseFloat(a.ranking) - parseFloat(b.ranking);
        });
        firebase.database().ref("/users/" + homes[0].id + "/").once('value').then(function (data) {
            var userNameSafe = data.child('username').val();
            updateSafeDriverPlaceHolder(userNameSafe.split(' ')[0]);
            document.getElementById("safedriver_info").href="userDetails.php?uid="+homes[0].id;
        });
        firebase.database().ref("/users/" + homes[cnt - 1].id + "/").once('value').then(function (data) {
            var userNameUnSafe = data.child('username').val();
            updateUnSafeDriverPlaceHolder(userNameUnSafe.split(' ')[0]);
            document.getElementById("rashdriver_info").href="userDetails.php?uid="+homes[cnt-1].id;
        });
    }
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
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3 id="safe-rider-name"></h3>

                            <p>Safest driver of the week</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="#" class="small-box-footer" id="safedriver_info">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3 id="unsafe-rider-name"></h3>

                            <p>Rash driver of the week</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="#" class="small-box-footer" id="rashdriver_info">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3 id="total-users"></h3>

                            <p>Total users</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="usersList.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3 id="total-trips"></h3>

                            <p>Total trips</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="tripsTimeline.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <!-- /.row -->
            <div class="row">
                <div class="col-md-6">
                    <!-- Donut chart -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-bar-chart-o"></i>

                            <h3 class="box-title">Donut Chart</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div id="safe-unsafe-donut-chart" style="height: 300px;"></div>
                        </div>
                        <!-- /.box-body-->
                    </div>
                    <!-- /.box -->
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

    // Donut Chart Safe & Unsafe Riders
    $(document).ready(function () {
        var donutData = [
            {label: "Safe Riders", data: 30, color: "#4caf50"},
            {label: "Unsafe Riders", data: 20, color: "#ff5722"},
            {label: "Mod Riders", data: 50, color: "#ffeb3b"}
        ];
        $.plot("#safe-unsafe-donut-chart", donutData, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    innerRadius: 0,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1
                    }
                }
            },
            legend: {
                show: false
            }
        });
    });

    function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
            + label
            + "<br>"
            + Math.round(series.percent) + "%</div>";
    }
</script>

</body>
</html>
