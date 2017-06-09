<?php
/**
 * Created by PhpStorm.
 * User: Bharatwaaj
 * Date: 07-06-2017
 * Time: 15:06
 */
include 'firebaseConnectivity.php';
?>
<script type="text/javascript">
    // Counting Notification count from firebase
    var no_of_notifications = 0, firstChildrenvalue = 0;
    database.ref('users').once('value', function (snapshot) {
        firstChildrenvalue = snapshot.numChildren();
    });
    database.ref('users').on('child_added', function (snapshot) {
        if (firstChildrenvalue >= no_of_notifications) {
            document.getElementById("no_of_newjoin").innerHTML = 0;
            document.getElementById("no_of_notifications").innerHTML = 0;
            document.getElementById("notify_no").innerHTML = 0;
        }
        else{
            document.getElementById("no_of_newjoin").innerHTML = no_of_notifications-firstChildrenvalue;
            document.getElementById("no_of_notifications").innerHTML = no_of_notifications-firstChildrenvalue;
            document.getElementById("notify_no").innerHTML = no_of_notifications-firstChildrenvalue;
        }
        no_of_notifications++;
    });
</script>
<header class="main-header">
    <!-- Logo -->
    <a href="dashboard.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>R</b>IO</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Rover</b>IO</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning" id="notify_no">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have <span id="no_of_notifications">0</span> notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="usersList.php">
                                        <i class="fa fa-users text-aqua"></i> <span id="no_of_newjoin">0</span> new
                                        members joined
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="dist/img/avatar04.png" class="user-image" alt="User Image">
                        <span class="hidden-xs">Admin</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="dist/img/avatar04.png" class="img-circle" alt="User Image">

                            <p>
                                Admin - Rover App IO
                                <small>Member since 9th June, 2017</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Settings</a>
                            </div>
                            <div class="pull-right">
                                <a href="logoutAction.php" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
