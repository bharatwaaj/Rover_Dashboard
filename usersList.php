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
    var mainRef = database.ref();
    mainRef.once('value', function (data) {

        // Users Data Capture
        var usersData = data.child("users").val();

        // Update Users Data
        for (user in usersData) {
            var userColumnElement = "<div class='col-lg-3 col-xs-6'>\
                <div class='small-box bg-aqua'>\
                <div class='inner'>\
                <h3 style='font-size: 27px'>" + usersData[user]['username'].split(' ')[0] + "</h3>\
                <br/>\
                <br/>\
                <br/>\
                </div>\
                <div class='icon'>\
                <i class='fa fa-user'></i>\
                </div>\
                <a href='userDetails.php?uid=" + user + "' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>\
                </div>\
                </div>";
            $("#usersListRow").append(userColumnElement);
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
            <div class="row" id="usersListRow">
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

</body>
</html>
