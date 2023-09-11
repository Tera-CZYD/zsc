<div class="card">
  <div class="card-header"> 
    <h3 style="font-family: 'Times New Roman';">SIGN IN</h3>
  </div>
  <div class="card-body" style="padding: 10px">
    <br>
    <?php echo $this->Form->create(array(),array('url'=>array('controller'=>'Main', 'action'=>'login'), 'class'=>'', 'id'=>'', 'inputDefaults'=>array('label'=>false, 'div'=>false, 'class'=>'form-control' )))?>
      <div class="input-group">
        <span class="input-group-addon" style="color: black"><i class="fa fa-user"></i></span>
        <?php echo $this->Form->input('username', array('required'=>true, 'placeholder'=>'USERNAME', 'autofocus'=>true, 'class'=>'form-control input-form')) ?>
      </div>
      <br>
      <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-key"></i></span>
        <?php echo $this->Form->input('password', array('type'=>'password', 'required'=>true, 'placeholder'=>'PASSWORD', 'class'=>'form-control input-form')) ?>
      </div>
      <br>
      <button class="btn btn-primary pull-right btn-min">
        SIGN IN
      </button>
      <div class="clearfix"></div>
      <!-- <a class="pull-right" href="forgot-password" style="margin-top: 10px">Forgot password ?</a> -->
    <?php echo $this->Form->end() ?>
  </div>
  <!-- <div class="card-header" style="color: white;padding-left: 10px">
    <p>For Student Application. <a href="application">Signup here</a></p>
  </div> -->
  <br>
  <br>
  <br>

</div>