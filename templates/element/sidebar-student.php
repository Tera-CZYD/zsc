<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="#/dashboard" class="site_title">&nbsp;<img width="49" height="49" src="<?php echo $base ?>/assets/img/zam.png"> <span>ZSCMST</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <?php if (is_null( $currentUser->image) &&  $currentUser->image == "" || !file_exists('uploads/users/'.$currentUser->id.'/'. $currentUser->image )) { ?>

          <img class="img-circle profile_img" src="<?= $base ?>assets/img/user.jpg">

        <?php } else { ?>

          <img class="img-circle profile_img" src="<?php echo $base . '/uploads/users/'.$currentUser->id.'/'. $currentUser->image  ?>">

        <?php  }?>
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2><?php echo $currentUser->first_name.' '. $currentUser->last_name ?> </h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">  
        <ul class="nav side-menu">

          <li class="nav-link-side nav-dashboard"><a href="#/dashboard" onclick="change('dashboard')"><i class="fa fa-dashboard"></i> Dashboard </a></li>

          <?php if($show_self_enrollment == 1 && $enrolment_count == 0){ ?>

            <li class="nav-link-side nav-enrollment"><a href="#/enrollment" onclick="change('enrollment')"><i class="fa fa-user-plus"></i> Enrollment </a></li>

          <?php }elseif ($show_self_enrollment == 1 && $enrolment_count == 1) { ?>

            <li class="nav-link-side nav-enrollment"><a href="javascript:void(0)" onclick="showModal()"><i class="fa fa-user-plus"></i> Enrollment </a></li>
            
          <?php } ?>

          <li class="nav-link-side nav-enrolled-course"><a href="#/curriculum/prospectus/view-student/<?php echo $currentUser->studentId ?>" onclick="change('enrolled-course')"><i class="fa fa-list-alt"></i> Enrolled Courses </a></li>

          <li class="nav-link-side nav-schedule"><a href="#/student/schedule" onclick="change('schedule')"><i class="fa fa-table"></i> Schedule </a></li>

          <li class="nav-link-side nav-scholarship-application"><a href="#/admission/scholarship-application" onclick="change('scholarship-application')"><i class="ti ti-write"></i> Scholarship Application </a></li>

          <li class="nav-link-side nav-request-form nav-club nav-transferee nav-adding-dropping-subject nav-student-club nav-affidavit-of-loss"><a><i class="fa fa-briefcase"></i> Registrar </a>
            <ul class="nav child_menu collapse collapse-request-form collapse-club collapse-student-club collapse-transferee collapse-adding-dropping-subject collapse-affidavit-of-loss">

              <li class="nav-link-side nav-transferee">
                <a href="#/registrar/transferee" onclick="change('transferee')">School Transfer Request</a>
              </li>
              
              <li class="nav-link-side nav-request-form">
                <a href="#/registrar/request-form" onclick="change('request-form')">Request Form</a>
              </li>

              <!-- <li class="nav-link-side nav-adding-dropping-subject">
                <a href="#/registrar/adding-dropping-subject" onclick="change('adding-dropping-subject')">Adding/Dropping Subject</a>
              </li> -->
              
              <li class="nav-link-side nav-student-club">
                <a href="#/registrar/student-club" onclick="change('student-club')">Student Clubs Application</a>
              </li>

              <li class="nav-link-side nav-affidavit-of-loss">
                <a href="#/registrar/affidavit-of-loss" onclick="change('affidavit-of-loss')">Affidavit Of Loss</a>
              </li>

              <!-- <li class="nav-link-side nav-club">
                <a href="#/registrar/club" onclick="change('club')">Club Management</a>
              </li> -->

            </ul>
          </li>

          <li class="nav-link-side nav-counseling-appointment nav-gco-evaluation"><a><i class="fa fa-users"></i> Guidance & Counseling </a>
            <ul class="nav child_menu collaps collapse-counseling-appointment collapse-gco-evaluation">
              <li class="nav-link-side nav-counseling-appointment">
                <a href="#/guidance/counseling-appointment" onclick="change('counseling-appointment')">Counseling Appointment</a>
              </li>
              <li class="nav-link-side nav-gco-evaluation">
                <a href="#/guidance/gco-evaluation" onclick="change('gco-evaluation')">GCO Evaluation</a>
              </li>
              <li class="nav-link-side nav-participant-evaluation">
                <a href="#/guidance/participant-evaluation" onclick="change('participant-evaluation')">Participant Evaluation Activity</a>
              </li>
            </ul>
          </li> 

          <li class="nav-link-side nav-medical-consent nav-consultation nav-dental nav-referral-recommendation nav-medical-certificate"><a><i class="fa fa-medkit"></i> Health & Medical Services </a>
            <ul class="nav child_menu collaps collapse-medical-consent collapse-dental collapse-referral-recommendation collapse-dental collapse-medical-certificate collapse-consultation">

             <!--  <li class="nav-link-side nav-medical-student-log">
                <a href="#/medical-services/student-log/student-index" onclick="change('student-log')">Log</a>
              </li>  -->
              
<!--               <li class="nav-link-side nav-medical-consent">
                <a href="#/medical-services/medical-consent" onclick="change('medical-consent')">Medical Consent</a>
              </li> -->

              <li class="nav-link-side nav-consultation">
                <a href="#/medical-services/consultation/student-index" onclick="change('consultation')">Consultation</a>
              </li>

              <li class="nav-link-side nav-dental">
                <a href="#/medical-services/dental/student-index" onclick="change('dental')">Dental</a>
              </li>

              <!-- <li class="nav-link-side nav-medical-certificate">
                <a href="#/medical-services/medical-certificate/student-index" onclick="change('medical-certificate')">Medical Certificate Request</a>
              </li> -->

              <li class="nav-link-side nav-referral-recommendation">
                <a href="#/medical-services/referral-recommendation/student-index" onclick="change('referral-recommendation')">Referral Recommendation</a>
              </li>


            </ul>
          </li>

          <li class="nav-link-side nav-request-form"><a><i class="fa fa-building"></i> Corporate Affairs </a>
            <ul class="nav child_menu collapse collapse-request-form ">

              <li class="nav-link-side nav-apartelle-registration">
                <a href="#/corporate-affairs/apartelle-registration" onclick="change('apartelle-registration')">Apartelle Registration</a>
              </li>

              <li class="nav-link-side nav-interview-request">
                <a href="#/corporate-affairs/interview-request/student-index" onclick="change('interview-request')">Interview Apartelle Request</a>
              </li>

              <li class="nav-link-side nav-apartelle-student-clearance"><a href="#/corporate-affairs/apartelle-student-clearance" onclick="change('apartelle-student-clearance')">Apartelle Student Clearance </a></li>

            </ul>
          </li> 
          
          <li class="nav-link-side nav-bibliography">
            <a href="#/learning-resource-center/bibliography" onclick="change('bibliography')"><i class="ti ti-book"></i> Bibliography</a>
          </li>

          
        
  
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->
  </div>
</div>

<script type="text/javascript">
  function showModal(){
    $("#promptModal").modal('show');
  }
</script>

<div class="modal fade" id="promptModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"> Come back later </h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <img src="<?php echo $base ?>/assets/img/come_back_later.png" width="100%">
        </div>
        <div class="col-md-12">
          <p>You have already enrolled for this semester.</p>
        </div>
      </div>
    </div>
  </div>
</div>