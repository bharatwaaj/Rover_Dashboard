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
        <div class="content-wrapper">
            <br>
            <section class="content-header">
                <h1>
                    LeaderBoard
                </h1>
            </section>
            <section class="content">
                <div class="row">
                    <br><br>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Safe Riders</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-striped">
                                    <tr>
                                        <th style="width: 10px">S.No</th>
                                        <th>Rider's Name</th>
                                        <th style="width: 40px">Points</th>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td id="saferider1">Loading...</td>
                                        <td><span class="badge bg-red">182</span></td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td id="saferider2">Loading...</td>
                                        <td><span class="badge bg-yellow">168</span></td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td id="saferider3">Loading...</td>
                                        <td><span class="badge bg-light-blue">149</span></td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td id="saferider4">Loading...</td>
                                        <td><span class="badge bg-green">110</span></td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td id="saferider5">Loading...</td>
                                        <td><span class="badge bg-blue">95</span></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">UnSafe Riders</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-striped">
                                    <tr>
                                        <th style="width: 10px">S.No</th>
                                        <th>Rider's Name</th>
                                        <th style="width: 40px">Points</th>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td id="unsaferider1">Loading...</td>
                                        <td><span class="badge bg-red">55</span></td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td id="unsaferider2">Loading...</td>
                                        <td><span class="badge bg-yellow">46</span></td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td id="unsaferider3">Loading...</td>
                                        <td><span class="badge bg-light-blue">43</span></td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td id="unsaferider4">Loading...</td>
                                        <td><span class="badge bg-green">30</span></td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td id="unsaferider5">Loading...</td>
                                        <td><span class="badge bg-blue">28</span></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
        </div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.1.1
            </div>
            <strong>Copyright &copy; 2017-2018 <a href="#">Rover</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <?php
    include 'roverBodyLinkSection.php';
    ?>
    <script type="text/javascript">
        firebase.database().ref().child('tripSpeeding').once('value').then(function (snapshot) {
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
                /*console.log("Key value is."+snap.key+" ");*/
            });
            sorting(keyvalue, count);
            // console.log(keyvalue);
        });
        function sorting(homes, cnt) {
            homes.sort(function (a, b) {
                return parseFloat(a.ranking) - parseFloat(b.ranking);
            });
            console.log(homes);
            console.log("ID is.." + homes[0].id);
            //document.getElementById("name1")=homes[0].id;
            var j = 1, k = 1,user=[],user1=[];
            for (var i = 0; i < 5; i++) {

                firebase.database().ref("/users/" + homes[i].id + "/").once('value').then(function (data) {
                    var sno = k++;
                    var index = sno-1;
                    user[index] = data.child('username').val();
                    /*element = "<tr><td><center>" + sno + "</center></td><td><center>" + user + "</center></td><td></td></tr>";
                    $("#saferiders").append(element);*/
                    document.getElementById("saferider1").innerHTML=user[0];
                    document.getElementById("saferider2").innerHTML=user[1];
                    document.getElementById("saferider3").innerHTML=user[2];
                    document.getElementById("saferider4").innerHTML=user[3];
                    document.getElementById("saferider5").innerHTML=user[4];
                });
                //var user=usernames(homes[i].id);

            }
            for (var i = cnt - 1; i >= cnt - 5; i--) {

                firebase.database().ref("/users/" + homes[i].id + "/").once('value').then(function (data) {
                    var sno = j++;
                    var index = sno-1;
                    user1[index] = data.child('username').val();
                    /*element = "<tr><td><center>" + sno + "</center></td><td><center>" + user + "</center></td><td></td></tr>";
                    $("#unsaferiders").append(element);*/
                    document.getElementById("unsaferider1").innerHTML=user1[0];
                    document.getElementById("unsaferider2").innerHTML=user1[1];
                    document.getElementById("unsaferider3").innerHTML=user1[2];
                    document.getElementById("unsaferider4").innerHTML=user1[3];
                    document.getElementById("unsaferider5").innerHTML=user1[4];
                });
            }
        }
    </script>
</body>
</html>
