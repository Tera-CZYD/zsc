<body>
  <div class="login-area login-bg">
    <div class="container-fluid p-0">
      <div class="row no-gutters">
        <div class="col-xl-5 offset-xl-7 col-lg-5 offset-lg-7" style="padding-left: 0px; padding-right: 0px;">
          <div class="login-box-s2">
            <div class="myContainer">
              <section id="login" style="margin-top: -240px;">
                <header>
                  <h2 style="font-size: 35px; text-align: center; color: white;"><font face="Times New Roman">Zamboanga State College of Marine Sciences and Technology</font></h2>
                  <p style="font-size: 20px; text-align: center;"><font face="Times New Roman">Student Management System</font></p>
                </header>
              </section>
              <div class="myContainer2">
                <div class="card" id="myCard">
                  <div class="card-header">
                    <img src="<?php echo $base ?>/assets/img/mcp-zam.png" width="100%" style="float: left; margin-left: 0;">
                    <h3 style="font-family: 'Times New Roman'; color: black;">SIGN IN</h3>
                  </div>
                  <div class="card-body" style="padding: 10px">
                   
                    <?php 

                      $flasMessage = $this->Flash->render(); 

                      if($flasMessage !== null){ ?>

                        <div class="alert">
                          <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                          <strong onclick="this.parentElement.style.display='none'; resetDefault();"><?php echo $flasMessage; ?></strong>
                        </div>

                        <script type="text/javascript">
                          var element = document.getElementById("myCard");
                          element.style.height = "600px";
                          function resetDefault(){

                            var element = document.getElementById("myCard");
                            element.style.height = "528px";

                          }
                        </script>

                <?php }
                 
                     

                    ?>

                 


                    <?php echo $this->Form->create(
                      array(),
                      array(
                        'url' => array('controller' => 'Main', 'action' => 'login'),
                        'class' => '',
                        'id' => '',
                        'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control')
                      )
                    ) ?>
                    <div class="form-group">
                      <label for="username" class="sr-only">Username</label>
                      <div class="input-group">
                        <span class="input-group-addon" style="color: black"><i class="fa fa-user"></i></span>
                        <?php echo $this->Form->input('username', array('required' => true, 'placeholder' => 'USERNAME', 'autofocus' => true, 'class' => 'form-control input-form')) ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="password" class="sr-only">Password</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <?php echo $this->Form->input('password', array('type' => 'password', 'required' => true, 'placeholder' => 'PASSWORD', 'class' => 'form-control input-form')) ?>
                      </div>
                    </div>

                    <div class="form-group">
                      <button class="btn btn-primary pull-right btn-min">SIGN IN</button>
                      <div class="card-header" style="color: white;padding:0; margin: 0;">
                        <a href="https://play.google.com/store/apps/details?id=com.zscmst.smisv1&hl=en-PH"><img src="<?php echo $base ?>/assets/img/google_play.png" width="25%" style="float:left;margin-left:0;"></a>
                      </div>
                    </div>

                    
                    <?php echo $this->Form->end() ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div style="color: #FFF; font-size: 12px; width: 100%; position: fixed; margin-top: 130px; bottom: 0px; padding: 0px; background: rgba(0, 0, 0, 0.15);">
          <div class="copyright">COPYRIGHT &copy <script>document.write(/\d{4}/.exec(Date())[0])</script> | ALL RIGHTS RESERVED</div>
          <div class="poweredby">POWERED BY: <a href="http://mycreativepanda.com"> My Creative Panda Web Design and Development Consultancy Services</a></div>
        </div>
      </div>
    </div>
  </div>
</body>

<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>