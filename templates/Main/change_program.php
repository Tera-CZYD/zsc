 <div class="login-area login-bg">
      <div class="container">
        <!-- <div class="row no-gutters"> -->
          <!-- <div class="col-xl-8 offset-xl-4 col-lg-6 offset-lg-6"> -->
            <div class="login-box ptb--100">
              <form id = "form">
                <div class="login-form-head">
                  <img src="<?php echo $base ?>/assets/img/zam.png" width="25%"> 
                  <h4>Change Program</h4>
                </div>
                <div class="login-form-body">

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-gp">
                            <label for="student_no" style="margin-top: -18px">Student ID Number&emsp;<i class="required">*</i></label>
                            <input type="text" id="student_no" ng-model="data.StudentApplication.student_no" autocomplete="off" data-validation-engine="validate[required]" disabled>
                            <i class="ti-user"></i>
                          </div>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-gp">
                            <label for="first_name" style="margin-top: -18px">First Name&emsp;<i class="required">*</i></label>
                            <input type="text" id="first_name" ng-model="data.StudentApplication.first_name" autocomplete="off" data-validation-engine="validate[required]" disabled="">
                            <i class="ti-user"></i>
                          </div>
                        </div>
                        
                        <div class="col-lg-12">
                          <div class="form-gp">
                            <label for="middle_name" style="margin-top: -18px">Middle Name</label>
                            <input type="text" id="middle_name" ng-model="data.StudentApplication.middle_name" autocomplete="off" disabled="">
                            <i class="ti-user"></i>
                          </div>
                        </div>
                   

                        <div class="col-lg-12">
                          <div class="form-gp">
                            <label for="last_name" style="margin-top: -18px">Last Name&emsp;<i class="required">*</i></label>
                            <input type="text" id="last_name" ng-model="data.StudentApplication.last_name" autocomplete="off" disabled="">
                            <i class="ti-user"></i>
                          </div>
                        </div>
                        
                        <div class="col-lg-12">
                          <div class="form-gp">
                            <label for="first" style="margin-top: -11px">Program&emsp;<i class="required">*</i></label>
                            <select id="first" class="form-control" ng-change="getProgramName(data.StudentApplication.preferred_program_id)" style="border-bottom: 1px solid rgba(170, 170, 170, .3); border-top: none; border-left: none; border-right: none; font-size: 12px;" ng-model="data.StudentApplication.preferred_program_id" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]">
                              <option value=""></option>
                            </select>
                          </div>
                        </div>

                      </div>
                    </div>

                  </div>

                  <div class="submit-btn-area">
                    <button id="form_submit" type="submit" ng-click = "saveImages(files);save();">Submit <i class="ti-arrow-right"></i></button>
                  </div>
                </div>
              </form>
            </div>
          <!-- </div> -->
        <!-- </div> -->
      </div>
    </div>