<!DOCTYPE html>
<html>

<?php
include 'firebaseConnectivity.php';
include 'roverHeadSection.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("location: index.php");
}
if(isset($_POST['disqbutton'])){
    if($_POST['passworddisq']=="disqroverio123")
    header("location: usersList.php?organization=DISQ");
}
if(isset($_POST['ashokabutton'])){
    if($_POST['passwordashoka']=="ashoka")
    header("location: usersList.php?organization=Ashoka");
}
?>

<body class="hold-transition skin-blue sidebar-mini">
<form action="" method="POST">
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
               Organization List
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Organization</a></li>
                <li class="active">Organization List</li>
            </ol>
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle"
                                 src="disq.jpg" alt="User profile picture">

                            <h3 class="profile-username text-center">Digital Impact Square</h3>

                            <p class="text-muted text-center">TCS initiative</p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Riders</b> <a class="pull-right">25</a>
                                </li>
                                <li class="list-group-item">
                                    <b>No of Trips</b> <a class="pull-right">80</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Password</b> <a class="pull-right"><input type="password" name="passworddisq" placeholder="Password"></a>
                                </li>
                            </ul>
                            <button class="btn btn-primary btn-block" name="disqbutton"><b>Show Users</b></button>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle"
                                 src="ashoka.png" alt="User profile picture">

                            <h3 class="profile-username text-center">Ashoka</h3>

                            <p class="text-muted text-center">Ashoka Business Enclave</p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Riders</b> <a class="pull-right">18</a>
                                </li>
                                <li class="list-group-item">
                                    <b>No of Trips</b> <a class="pull-right">64</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Password</b> <a class="pull-right"><input type="password" name="passwordashoka" placeholder="Password"></a>
                                </li>
                            </ul>
                            <button class="btn btn-primary btn-block" name="ashokabutton"><b>Show Users</b></button>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </section>
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 3.0
        </div>
        <strong>Copyright &copy; 2017-2018 <a href="#">Rover</a>.</strong> All rights
        reserved.
    </footer>

</div>
<!-- ./wrapper -->

<?php
include 'roverBodyLinkSection.php';
?>
</form>
</body>
</html>

