<?php
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
}
?>
<script type="text/javascript">
    var uid = '<?php echo $uid ?>';
//    document.getElementById('userIdDashboardSidebar').innerHTML = 'Admin';
</script>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/avatar04.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p id="userIdDashboardSidebar">Admin</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="dashboard.php">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="usersList.php">
                    <i class="fa fa-users"></i> <span>Users</span>
                    <small class="label pull-right bg-green">new</small>
                </a>
            </li>
            <li>
                <a href="analytics.php">
                    <i class="fa fa-bar-chart"></i> <span>Analytics</span>
                    <small class="label pull-right bg-red">beta</small>
                </a>
            </li>
            <li>
                <a href="calendar.php">
                    <i class="fa fa-calendar"></i> <span>Calendar</span>
                    <small class="label pull-right bg-red">3</small>
                </a>
            </li>
            <li>
                <a href="tripsTimeline.php" onclick="location.href=this.href+'?uid='+uid;return false;">
                    <i class="fa fa-line-chart"></i> <span>Timeline</span>
                    <small class="label pull-right bg-red">beta</small>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
