 


<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2>Login Form</h2>
            </div>
             <?php
                echo $this->Form->create('User', array(
                    'url' => array('controller' => 'admins', 'action' => 'login'),
                    'id' => 'loginform', 'class' => 'form-horizontal'
                ));
                $msg = $this->Session->flash() . $this->Session->flash('auth');

                if ($msg != '') {
                    ?>
                    <div class="alert alert-danger fade in"> 
                        <?php echo $msg; ?>
                    </div><?php }
                    ?>
            <div class="panel-body"> 
                <div class="form-group mb-md">
                    <div class="col-xs-12">
                        <div class="input-group">							
                            <span class="input-group-addon">
                                <i class="ti ti-user"></i>
                            </span>
                            <?php
                            echo $this->Form->input("User.username", array(
                                "type" => "text",
                                "class" => "form-control",
                                "div" => false,
                                "label" => false,
                                "placeholder" => "Username",
                                "autofocus"
                                    )
                            );
                            ?>

                        </div>
                    </div>
                     </div>

                    <div class="form-group mb-md">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="ti ti-key"></i>
                                </span>
                                <?php
                                echo $this->Form->input("User.password", array(
                                    "type" => "password",
                                    "class" => "form-control",
                                    "div" => false,
                                    "label" => false,
                                    "placeholder" => "Password"
                                ));
                                ?>

                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-n">
                        <div class="col-xs-12">
                            
                            
                            <?php echo $this->Html->link(__('Forgot Password?', true), array(
                                'admin' => true, 
                                'controller' => 'admins',
                                'action' => 'forgot_password'
                                ), array("escape" => false,"class"=>"pull-left")); ?>
                            <div class="checkbox-inline icheck pull-right p-n">
                                <label for="">
                                    <?php echo $this->Form->input('User.remember_me', array(
                                        'type' => 'checkbox',
                                        'label' => false,
                                        'div' => false,
                                        )); ?>
                                  
                                    Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <div class="panel-footer">
                    <div class="clearfix"> 
                        <?php echo $this->Form->submit("Sign in", array("class" => "btn btn-primary pull-right", 'div' => false)); ?>
                         
                    </div>
                </div>
             <?php echo $this->Form->end(); ?>
            </div>

        </div>
    </div>

 