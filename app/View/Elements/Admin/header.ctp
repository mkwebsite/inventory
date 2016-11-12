  <header id="topnav" class="navbar navbar-fixed-top navbar-cyan" role="banner">

            <div class="logo-area">
                <span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
                    <a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar">
                        <span class="icon-bg">
                            <i class="ti ti-menu"></i>
                        </span>
                    </a>
                </span>
                <?php echo $this->Html->link($this->Html->image("../images/logo.png", array("alt" => "logo")), array("admin" => true, "controller" => "admins", "action" => "dashboard"), array("escape" => false, "class" => " ")); ?>
 
            </div><!-- logo-area -->

            <ul class="nav navbar-nav toolbar pull-right">
                <li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">


                    <a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="ti ti-fullscreen"></i></span></i></a>
                </li> 
                <li class="dropdown toolbar-icon-bg">
                    <a href="#" class="dropdown-toggle username" data-toggle="dropdown"> 
                        <?php echo $this->Html->image("../images/mini.jpg", array("alt" => "logo", "class" => "img-circle")); ?>
                    </a>
                    <ul class="dropdown-menu userinfo arrow">
                        <li><?php echo $this->Html->link('<i class="fa fa-user"></i><span>Profile</span>', array('controller' => 'admins', 'action' => 'edit'), array('role' => 'button', 'tabindex' => '0', 'escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('<i class="fa fa fa-lock"></i>Change Password ', array('controller' => 'admins', 'action' => 'change_password'), array('role' => 'button', 'tabindex' => '0', 'escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('<i class="fa fa-cog"></i> System Settings', array('controller' => 'settings', 'action' => 'index'), array('role' => 'button', 'tabindex' => '0', 'escape' => false)); ?></li>                         
                        <li class="divider"></li>
                        <li><?php echo $this->Html->link('<i class="fa fa-sign-out"></i><span>Sign Out</span>', array('controller' => 'admins', 'action' => 'logout'), array('role' => 'button', 'tabindex' => '0', 'escape' => false)); ?></li>
                    </ul>
            </ul>

        </header>