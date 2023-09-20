<section id="login">
    <div class="row">
      <div class="col-md-3 col-md-offset-3" style="padding-top:-30px;">
        <img src="<?php echo $base ?>/assets/img/mcp-zam.png" width="100%" style="float:left;margin-left:0;"> 
        <div class="clearfix"></div>
      </div>
      <div class="col-md-6">
        <header>
          <p style="font-size:3rem;text-align: left;margin-top: 10%;margin-bottom: -5px"><font face="Times New Roman"></font></p>
          <h1 style="font-size:75px;text-align: left;"><font face="Times New Roman">ESMIS</font></h1>
          <p style="font-size:2rem;text-align: left;"><font face="Times New Roman">Electronic Student Management Information System</font></p>
        </header>
      </div>
    </div>
    <div class="clearfix"></div>
  </section>
  <div class="col-md-12" style="margin:auto;padding:0px 0px 20px 0px">
  <div class="col-md-4" style="margin-top: 2%">
  </div>
  <div class="col-md-4" style="margin-top: 2%">

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
   

    </div>

  </div>

  <div class="col-md-4" style="margin-top: 2%">

  </div>
</div>

    
  <div style="  color: #FFF;
    font-size:12px;
    width: 100%;
    position:fixed;
    margin-top:130px;

    bottom: 0px;
    padding: 0px;
    background: rgba(0,0,0,0.15);
">
        <div class="copyright">COPYRIGHT &copy <script>document.write(new Date().getFullYear())</script> | ALL RIGHTS RESERVED</div>
        <div class="poweredby">POWERED BY: <a href="http://mycreativepanda.com"> My Creative Panda Web Design and Development Consultancy Services</a></div>
    </div>
