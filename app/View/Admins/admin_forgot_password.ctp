<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2>Forgot Password</h2>
            </div>
            <?php
            $this->Layout->sessionFlash();

            echo $this->Form->create('User', array(
                'url' => array('controller' => 'admins', 'action' => 'forgot_password'),
                'id' => 'loginform', 'class' => 'form-horizontal',
                'inputDefaults' => array(
                    'error' => array(
                        'attributes' => array(
                            'wrap' => 'span',
                            'class' => 'error-message danger'
                        )
                    )
                )
            ));

            $msg = $this->Session->flash() . $this->Session->flash('auth');

            if ($msg != '') {
                ?>
                <div class="alert alert-danger fade in">
                    <?php echo $msg; ?>
                </div><?php }
                ?>
            <div class="panel-body">
                
                    <div class="form-group mb-n">
                        <div class="col-xs-12">
                            <p>Enter your email to reset your password</p>
                            <div class="input-group">							
                                <span class="input-group-addon">
                                    <i class="ti ti-user"></i>
                                </span>
                                <?php echo $this->Form->input("User.username", array(
                                    "type" => "text",
                                    "class" => "form-control",
                                    "div" => false, 
                                    "label" => false, 
                                    "placeholder" => "Email Address",
                                    "autofocus"
                                    )); ?>
                              
                            </div>
                        </div>
                    </div>
              
            </div>
            <div class="panel-footer">
                <div class="clearfix">
                    <?php echo $this->Html->link(__('Go Back', true), array(
                        'admin' => true,
                        'controller' => 'admins',
                        'action' => 'login'
                        ), array(
                            "escape" => false,
                            'class'=>'btn btn-default pull-left'
                            )); ?>
                  
                 
                    <?php echo $this->Form->submit("Get your Password", array("class" => "btn btn-primary pull-right", 'div' => false)); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
  