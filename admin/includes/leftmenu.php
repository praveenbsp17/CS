<!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="template/img/avatar5.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $_SESSION['name'];?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li <?php if($_GET['op'] == 'main') { ?>class="active" <?php } ?> >
                            <a href="index.php?op=main">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
						<li <?php if($_GET['op'] == 'articles') { ?>class="active" <?php } ?>>
                            <a href="index.php?op=articles">
                                <i class="fa fa-arrow-circle-right"></i> <span>Articles</span> 
                            </a>
                        </li>
                        <li <?php if($_GET['op'] == 'admin') { ?>class="active" <?php } ?>>
                            <a href="index.php?op=admin">
                                <i class="fa fa-arrow-circle-right"></i> <span>Admins</span> 
                            </a>
                        </li>
                        
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>