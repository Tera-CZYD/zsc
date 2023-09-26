<!DOCTYPE html>

<html class="no-js" lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Application >> Zamboanga State College of Marine Sciences and Technology - MCP INC. - Electronic Student Management Information System - Copyright <?php echo date('Y')?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href = "<?php echo $base ?>/assets/img/zam.png">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/slicknav.min.css">
  
    <!-- others css -->
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/typography.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/default-css.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/styles.css">
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/responsive.css">
    <!-- modernizr css -->
    <script src="<?php echo $base ?>/assets/applications/js/vendor/modernizr-2.8.3.min.js"></script>

    <!-- date picker css -->
    <link rel="stylesheet" href="<?php echo $base ?>assets/applications/css/datepicker.css">

    <script>
      var base = '<?php echo $base ?>';
      var api  = '<?php echo $api  ?>';
      var tmp  = '<?php echo $tmp  ?>';
    </script>

  </head>


  <body ng-app="esmis" ng-controller="ApplicationController">
    <div id="preloader">
      <div class="loader"></div>
    </div>
    
    <div class="login-area login-bg" style="margin-top: -75px">
      <div class="container-fluid p-0">
        <div class="row no-gutters">
          <!-- <div class="col-xl-8 offset-xl-4 col-lg-6 offset-lg-6"> -->
            <div class="login-box-s2 ptb--100">
              <form id = "form">
                <div class="login-form-head">
                  <img src="<?php echo $base ?>/assets/img/zam.png" width="15%"> 
                  <h4>Sign up</h4>
                  <p>Hello there, Sign up and Join with Us</p>
                </div>

                <div class="col-lg-12" style="margin-top: 2%;">
                  <ul class="nav nav-tabs" id="myTab" role="tablist" style="cursor: pointer;">
                    <li class="nav-item">
                      <a class="nav-link active" data-target ="#pre_registration" role="tab">PRE-REGISTRATION</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-target ="#cat_application" role="tab">COLLEGE ADMISSION TEST APPLICATION</a>
                    </li>
                  </ul>
                </div>
                <br><br>
                <div class="login-form-body">
                  <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="pre_registration">

                      <div class="row">
                        <div class="col-lg-8">
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="student_no" style="margin-top: -18px">Student ID Number&emsp;<i class="required">*</i></label>
                                <input type="text" id="student_no" ng-model="data.StudentApplication.student_no" autocomplete="off" data-validation-engine="validate[required]" disabled>
                                <i class="ti-user"></i>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="student_no" style="margin-top: -18px">Student Application Number&emsp;<i class="required">*</i></label>
                                <input type="text" id="application_no" ng-model="data.StudentApplication.application_no" autocomplete="off" data-validation-engine="validate[required]" disabled>
                                <i class="ti-user"></i>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="college" style="margin-top: -11px">College&emsp;<i class="required">*</i></label>
                                <select id="college" class="form-control" style="border-bottom: 1px solid rgba(170, 170, 170, .3); border-top: none; border-left: none; border-right: none; font-size: 12px; margin-top: -8px" ng-model="data.StudentApplication.college_id" ng-options="opt.id as opt.value for opt in colleges" data-validation-engine="validate[required]" ng-change="getProgram(data.StudentApplication.college_id)">
                                  <option value=""></option>
                                </select>
                              </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="first_name">First Name&emsp;<i class="required">*</i></label>
                                <input type="text" id="first_name" ng-model="data.StudentApplication.first_name" autocomplete="off" data-validation-engine="validate[required]">
                                <i class="ti-user"></i>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="first" style="margin-top: -11px">Preferred Program&emsp;<i class="required">*</i></label>
                                <select id="first" class="form-control" ng-change="getProgramName(data.StudentApplication.preferred_program_id)" style="border-bottom: 1px solid rgba(170, 170, 170, .3); border-top: none; border-left: none; border-right: none; font-size: 12px; margin-top: -8px" ng-model="data.StudentApplication.preferred_program_id" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]">
                                  <option value=""></option>
                                </select>
                              </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" id="middle_name" ng-model="data.StudentApplication.middle_name" autocomplete="off">
                                <i class="ti-user"></i>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="second" style="margin-top: -11px">Secondary Program&emsp;<i class="required">*</i></label>
                                <select id="second" class="form-control" style="border-bottom: 1px solid rgba(170, 170, 170, .3); border-top: none; border-left: none; border-right: none; font-size: 12px; margin-top: -8px" ng-model="data.StudentApplication.secondary_program_id" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]">
                                  <option value=""></option>
                                </select>
                              </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="last_name">Last Name&emsp;<i class="required">*</i></label>
                                <input type="text" id="last_name" ng-model="data.StudentApplication.last_name" autocomplete="off">
                                <i class="ti-user"></i>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="last_school"  style="margin-top: -11px">Name of Last School Attended&emsp;<i class="required">*</i></label>
                                <select id="college" class="form-control" style="border-bottom: 1px solid rgba(170, 170, 170, .3); border-top: none; border-left: none; border-right: none; font-size: 12px; margin-top: -8px" ng-model="data.StudentApplication.last_school_id" ng-options="opt.id as opt.value for opt in school" data-validation-engine="validate[required]" ng-change="getSchool(data.StudentApplication.last_school_id)">
                                  <option value=""></option>
                                </select>
                              </div>
                            </div>

                            <div class="col-lg-6" ng-hide="data.StudentApplication.last_school_id == '7'">
                              <div class="form-gp">
                                <label for="address">School Address&emsp;<i class="required">*</i></label>
                                <input type="text" id="address" ng-model="data.StudentApplication.last_school_address" autocomplete="off" data-validation-engine="validate[required]">
                              </div>
                            </div>

                            <div class="col-lg-6" ng-show="data.StudentApplication.last_school_id == '7'">
                              <div class="form-gp">
                                <label for="address">Name of School&emsp;<i class="required">*</i></label>
                                <input type="text" id="address" ng-model="data.StudentApplication.last_school" autocomplete="off" data-validation-engine="validate[required]">
                              </div>
                            </div>

                            <div class="col-lg-6" ng-show="data.StudentApplication.last_school_id == '7'">
                              <div class="form-gp">
                                <label for="address">Other School Address&emsp;<i class="required">*</i></label>
                                <input type="text" id="address" ng-model="data.StudentApplication.last_school_address" autocomplete="off" data-validation-engine="validate[required]">
                              </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="email">Email address&emsp;<i class="required">*</i></label>
                                <input type="email" id="email" ng-model="data.StudentApplication.email" autocomplete="off" data-validation-engine="validate[required]">
                                <i class="ti-email"></i>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="grade">1st Semester Grade or GWA:&emsp;<i class="required">*</i></label>
                                <input type="text" id="grade" ng-model="data.StudentApplication.grade" autocomplete="off">
                              </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="address">Address&emsp;<i class="required">*</i></label>
                                <input type="text" id="address" ng-model="data.StudentApplication.address" autocomplete="off" data-validation-engine="validate[required]">
                              </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="contact_no">Contact No.&emsp;<i class="required">*</i></label>
                                <input type="text" id="contact_no" ng-model="data.StudentApplication.contact_no" autocomplete="off" data-validation-engine="validate[required]">
                              </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="form-gp">
                                <label for="gender">Gender&emsp;<i class="required">*</i></label><br><br>
                                <div style="position: relative; display: -webkit-inline-box;">
                                  <div class="col-xl-12">
                                    <label for="male">Male</label>
                                    <input type="radio" name="gender" id="male" value="Male" ng-model="data.StudentApplication.gender" autocomplete="off" data-validation-engine="validate[required]" style="margin-left: 15%">
                                  </div>
                                  <div class="col-xl-12">
                                    <label for="female">Female</label>
                                    <input type="radio" name="gender" id="female" value="Female" ng-model="data.StudentApplication.gender" autocomplete="off" data-validation-engine="validate[required]" style="margin-left: 37%">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-gp">
                                <span ng-click="showRequirement()" style="cursor: pointer; color: #3366CC">Show Program Requirement</span>
                              </div>
                            </div>

                          </div>
                        </div>

                        <div class="col-lg-4">
                          <div class="form-gp">
                            <div class="form-gp">
                              <ul class="list-group mb-12">
                                <div class="col-xl-12">
                                  <span class="btn btn-primary btn-min btn-file">
                                    <i class="fa fa-upload"></i>UPLOAD FILE
                                    <input ng-file-model="files" id="applicationImage" multiple="multiple" name="picture" class="form-control" type="file">
                                  </span>
                                </div>
                              </ul>
                              <div class="clearfix"></div>
                              <div id="upload_prev"></div> 
                            </div>
                          </div>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-gp">
                            <p style="text-align: center;">DATA PRIVACY CONSENT</p>
                            <p style="text-align: justify;">The registrants are assured that the personal data and other sensitive data entrusted to the institution shall be used with due diligence and prudence, for the sole purpose of gathering data related to the registration. As such, upon accessing the registration form, you acknowledge and agree that the information may be used and disclosed by the institution - Zamboanga State College of Marine Sciences and Technology in accordance with any legal and regulatory standards and in compliance with the "Data Privacy Act of 2012".</p><br>
                            <p style="font-style: italic;">Please write down the generated Student ID, you will need it for Admission and Enrollment Process.</p>
                          </div>
                        </div>

                      </div>

                      <div class="col-xl-12">
                        <div class="clearfix"></div><hr>
                      </div>
                      <div class="submit-btn-area">
                        <button id="" type="" ng-click = "next()">Next <i class="ti-arrow-right"></i></button>
                      </div>

                    </div>

                    <div class="tab-pane fade" id="cat_application">

                      <div>
                        <span><strong>PERSONAL DATA</strong></span>
                        <div class="clearfix"></div><hr>
                      </div>
                      <br>
                
                      <div class="row">                        
                        <div class="col-md-3">
                          <div class="form-group">
                            <label> First Name <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.first_name" data-validation-engine="validate[required]">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label> Middle Name </label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.middle_name">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label> Last Name <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.last_name" data-validation-engine="validate[required]">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label> Auxiliary Name </label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.auxilliary_name" placeholder="e.g. jr lll, etc.">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label> Date of Birth <i class="required">*</i></label>
                            <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.StudentApplication.birth_date" data-validation-engine="validate[required]">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label> Place of Birth <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.birth_place" data-validation-engine="validate[required]">
                          </div>
                        </div>
                          <div class="col-md-3">
                          <div class="form-group">
                            <label> Nationality <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.nationality" data-validation-engine="validate[required]">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label> Religion <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.religion" data-validation-engine="validate[required]">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label> Civil Status <i class="required">*</i></label>
                            <select class="form-control" ng-model="data.StudentApplication.civil_status" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                              <option></option>
                              <option value="Maried">Maried</option>
                              <option value="Single">Single</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label> Ethnic Group </label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.ethnic_group" placeholder="e.g. Chavacano, Tausug, Bisaya etc.">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label> Name of Parents or Guardian <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.guardian_name" data-validation-engine="validate[required]">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label> Contact No. Parents/Guardian <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.guardian_contact" data-validation-engine="validate[required]">
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label> Relationship <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.guardian_relationship" data-validation-engine="validate[required]">
                          </div>
                        </div>
                        

                        <div class="col-md-6">
                          <div class="form-group">
                            <label> Occupation of Parents/Guardian <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.guardian_occupation" data-validation-engine="validate[required]">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label> Complete Address of Parents/Guardian <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.guardian_address" data-validation-engine="validate[required]">
                          </div>
                        </div>

                        <br>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                          <span><strong>SCHOOL DATA</strong></span>
                          <div class="clearfix"></div><hr>
                        </div>
                        
                        <br>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label> Type of Student <i class="required">*</i></label>
                            <select class="form-control" ng-model="data.StudentApplication.student_type" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                              <option></option>
                              <option value="New">New</option>
                              <option value="Transferee">Transferee</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label> Highschool Curriculum  <i class="required">*</i></label>
                            <select class="form-control" ng-model="data.StudentApplication.curriculum" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                              <option></option>
                              <option value="ALS">ALS</option>
                              <option value="BEC">BEC</option>
                              <option value="K-12">K-12</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label> Year Graduated <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.year_graduated" data-validation-engine="validate[required]">
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label> School Type <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.school_type" data-validation-engine="validate[required]" placeholder="e.g. Private, public, SUC etc.">
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                            <label> Membership School Clubs, Organizations or Fraternities <i class="required">*</i></label>
                            <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.frat" data-validation-engine="validate[required]">
                          </div>
                        </div>


                        <div class="col-xl-12">
                          <div class="clearfix"></div><hr>
                        </div>
                        <div class="col-xl-6">
                          <div class="submit-btn-area">
                            <button id="form_submit" type="submit" ng-click = "back()"><i class="ti-arrow-left"></i> &nbsp; Back </button>
                          </div>
                        </div>
                        <div class="col-xl-6">
                          <div class="submit-btn-area">
                            <button id="form_submit" type="submit" ng-click = "saveImages(files);save();">Submit <i class="ti-arrow-right"></i></button>
                          </div>
                        </div>
                      
                      </div>

                    </div>

                    <!-- <div class="submit-btn-area">
                      <button id="form_submit" type="submit" ng-click = "saveImages(files);save();">Submit <i class="ti-arrow-right"></i></button>
                    </div> -->

                  </div>
                  
                </div>
              </form>
            </div>
          <!-- </div> -->
        </div>
      </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="<?php echo $base ?>assets/applications/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?php echo $base ?>assets/applications/js/popper.min.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/bootstrap.min.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/owl.carousel.min.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/metisMenu.min.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="<?php echo $base ?>assets/applications/js/plugins.js"></script>
    <script src="<?php echo $base ?>assets/applications/js/scripts.js"></script>

    <?php echo $this->element('scripts') ?>

    <?php echo $this->element('angularjs') ?>

  </body>

  <script type="text/javascript">

    app.controller('ApplicationController', function($scope, $timeout,Application, Select) {

      $('#form').validationEngine('attach');

      $('.datepicker').datepicker({

        format : 'mm/dd/yyyy',

        autoclose: true,

        todayHighlight: true,

      })

      $scope.data = {

        StudentApplication: {},

        StudentApplicationImage :[]

      };

      Select.get({ code: "school-list" }, function (e) {

        $scope.school = e.data;

      });
      $scope.getSchool = function(id){
        // console.log($scope.data.StudentApplication);
        // console.log($scope.school);
        if($scope.school.length > 0){

          $.each($scope.school, function(i,val){
            console.log(val);
            if(val.id == id){
              if(id!=7){
                $scope.data.StudentApplication.last_school = val.value;
              }
              // console.log($scope.data.StudentApplication.last_school);
              $scope.data.StudentApplication.last_school_address = val.school_address;

            }

          });

        }

      }

      Select.get({ code: 'college-list' }, function(e) {

        $scope.colleges = e.data;

      });

      $scope.getProgram = function(id){

        Select.get({ code: 'application-program-list', college_id : id }, function(e) {

          $scope.programs = e.data;

        });

      }

      $scope.saveImages = function (files) {

        if(files == undefined){

          files = '';

        }

        if(files.length > 0){

          $scope.data.StudentApplicationImage.push({

            images  : $scope.files,

          });  

        }

      } 

      $scope.generateRandomString = function(){

        var result = '';
       
        var characters = '0123456789';
       
        var charactersLength = characters.length;
       
        for (var i = 0; i < 5; i++) {
       
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
       
        }

        const d = new Date();

        $scope.data.StudentApplication.student_no = d.getFullYear()+'OA'+result;

      }

      $scope.generateRandomString();

      $scope.generateApplicationNumber = function(){

        var result = '';
       
        var characters = '0123456789';
       
        var charactersLength = characters.length;
       
        for (var i = 0; i < 5; i++) {
       
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
       
        }

        const d = new Date();

        $scope.data.StudentApplication.application_no = d.getFullYear()+'-AN-'+result;

      }

      $scope.generateApplicationNumber();

      $scope.showRequirement = function() {

        if($scope.data.StudentApplication.preferred_program_id == '' || $scope.data.StudentApplication.preferred_program_id == null || $scope.data.StudentApplication.preferred_program_id == null){

          $.gritter.add({

            title: 'Warning!',

            text:  '<span style="color:#f5f5f5; font-size: 13px">Please select preferred program first.</span>',

          });

        }else{

          $("#show-requirement").modal('show');

          Select.get({ code: 'college-program-requirements', program_id : $scope.data.StudentApplication.preferred_program_id }, function(e) {

            $scope.requirements = e.data;

          });

        }

      }

      $scope.getProgramName = function(id){

        if($scope.programs.length > 0){

          $.each($scope.programs, function(i,val){

            if(id == val.id){

              $scope.programName = val.value;

            }

          });

        }

      }

      $scope.next = function(){

        valid = $("#form").validationEngine('validate');

        if(valid){

          const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

          result = regex.test($scope.data.StudentApplication.email);

          // END 

          if(result){

            $('a[data-target="#cat_application"]').tab('show');

          }else{

            $.gritter.add({

              title: 'Warning!',

              text:  '<span style="color:#f5f5f5; font-size: 13px">Please input valid email address.</span>',

            });

          }

        }

      }

      $scope.back = function(){

        $('a[data-target="#pre_registration"]').tab('show');

      }

      $scope.save = function() {

        valid = $("#form").validationEngine('validate');

        if (valid) {

          // VALIDATE IF EMAIL IS VALID

          const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

          result = regex.test($scope.data.StudentApplication.email);

          // END 

          if(result){

            bootbox.confirm('Are you sure you want to submit application ?', function (c) {

              if (c) {

                Application.save($scope.data, function(e) {

                  if (e.ok) {

                    $.gritter.add({

                      title: 'Successful!',

                      text:  e.msg,

                    });

                    setTimeout(function(){

                      window.location = 'admission-portal';

                    },750)

                  }else{

                    $.gritter.add({

                      title: 'Warning!',

                      text:  e.msg,

                    });

                  }

                });
                
              }

            });

          }else{

            $.gritter.add({

              title: 'Warning!',

              text:  '<span style="color:#f5f5f5; font-size: 13px">Please input valid email address.</span>',

            });

          }

        }

      }

    });

  </script>

</html>

<div class="modal fade" id="show-requirement" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"> {{ programName }} </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="requirement_form">  
          <div class="col-md-12">        
          
            <div class="row">
              <div class="col-md-12" style="width:100%; height:100%; overflow-y:auto;">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th style="width: 15px;">#</th>
                      <th class="text-center">REQUIREMENT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="dat in requirements">
                      <td style="width: 15px;"> {{ $index + 1 }} </td>
                      <td class="text-left uppercase">{{ dat.value }}</td>
                    </tr>
                    <tr ng-if="requirements == ''">
                      <td class="text-center" colspan="2">No data available.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
           
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="alertModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p id="alertMessage"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<style>

 .fileUpload {
  position: relative;
    overflow: hidden;
    margin: 10px 3px;
  }
  .fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    background-color:#fff;
    filter: alpha(opacity=0);
  }

  .filenameupload {
    width:100%;  
    overflow-y:auto;
  }

  #upload_prev {
    font-size: 
    width: 100%;
    padding:0.5em 1em 1.5em 1em;
  }

  #upload_prev span {
    display: flex;
    padding: 0 5px;
    font-size:13px;
  }

  p.close {
    cursor: pointer;
  }


</style>

<script>
  $(document).on('click','#close',function(){
    $(this).parents('span').remove();

  })


// Get the alert modal element
var alertModal = document.getElementById('alertModal');

// Get the alert message element
var alertMessage = document.getElementById('alertMessage');

// Get the input element
var input = document.getElementById('myInput');

// Function to show the alert modal
function showAlertModal(message) {
  alertMessage.textContent = message;
  $(alertModal).modal('show');
}


var errorMessage = 'Files should be 10MB or Less';


  document.getElementById('applicationImage').onchange = uploadOnChange;

  function uploadOnChange() {



    var filename = this.value;

    var lastIndex = filename.lastIndexOf("\\");

    if (lastIndex >= 0) {

      filename = filename.substring(lastIndex + 1);

    }

    var files = $('#applicationImage')[0].files;

    if(files[0].size>=1.25 *1024*1024){

      showAlertModal(errorMessage);

    }
    else{
          for (var i = 0; i < files.length; i++) {

      $("#upload_prev").append('<span><u>'+'<div class="filenameupload">'+files[i].name+'</u></div>'+'<p id = "close" class="btn btn-danger xbutton fa fa-times" style "background-color :red !important"></p></span>');
    
      }
    }
 // showAlertModal(errorMessage);
  }
  
</script>