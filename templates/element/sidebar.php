<div class="col-md-3 left_col menu_fixed font-change" id="sidebar">
  <div class="left_col scroll-view" id="sidebarLeft">
    <div class="navbar nav_title" style="border: 0;" id="sidebarName">
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
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu bg-change">
      <div class="menu_section">  
        <ul class="nav side-menu">

          <li class="nav-link-side nav-learning"><a href="https://lmszscmst.mycreativepanda.ph/login" target="_blank" onclick="change('learning-management-system')"><i class="ti ti-agenda"></i> Learning Manangement System </a></li>
          <hr>

          <li class="nav-link-side nav-dashboard"><a href="#/dashboard" onclick="change('dashboard')"><i class="fa fa-dashboard"></i> Dashboard </a></li>

          <?php if (hasAccess('admission/menu', $currentUser)): ?>
            <li class="nav-link-side nav-student-admission nav-student-application nav-student-profiles nav-cat nav-registered-students nav-scholarship-application nav-school nav-scholarship-name"><a><i class="ti ti-bookmark-alt"></i> Admissions </a>
              <ul class="nav child_menu collapse collapse-student-admission collapse-student-application collapse-student-profiles collapse-cat collapse-registered-students collapse-scholarship-application collapse-school collapse-scholarship-name">


                <?php if (hasAccess('student application/index', $currentUser)): ?>
                  <li class="nav-link-side nav-student-application">
                    <a href="#/admission/student-application" onclick="change('student-application')">Student Application</a>
                  </li>
                <?php endif ?>
                
                <?php if (hasAccess('cat/index', $currentUser)): ?>
                  <li class="nav-link-side nav-cat">
                    <a href="#/admission/cat" onclick="change('cat')">CAT</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('registered students/index', $currentUser)): ?>
                  <li class="nav-link-side nav-registered-students">
                    <a href="#/admission/registered-students" onclick="change('registered-students')">Registered Students</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('student profiles/index', $currentUser)): ?>
                  <li class="nav-link-side nav-student-profiles">
                    <a href="#/admission/student-profiles" onclick="change('student-profiles')">Student Profiles</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('scholarship application/index', $currentUser)): ?>
                  <li class="nav-link-side nav-scholarship-application">
                    <a href="#/admission/admin-scholarship-application" onclick="change('scholarship-application')">Scholarship Application</a>
                  </li>
                <?php endif ?>

                 <?php if (hasAccess('scholarship name/index', $currentUser)): ?>
                  <li class="nav-link-side nav-scholarship-name">
                    <a href="#/admission/scholarship-name" onclick="change('scholarship-name')">Name of Scholarship</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('school graduated/index', $currentUser)): ?>
                  <li class="nav-link-side nav-school" style="margin-left: 20px;">
                    <a href="#/admission/school" onclick="change('school')">School Graduated Mgmt</a>
                  </li>
                <?php endif ?>

              </ul>
            </li>
          <?php endif ?>

          <?php if (hasAccess('registrar/menu', $currentUser)): ?>
            <li class="nav-link-side nav-completion nav-request-form nav-tor nav-transferee nav-adding-dropping-subject nav-approval-of-enrolled-course nav-club nav-student-club nav-registrar-student-profile nav-purpose nav-affidavit-of-loss"><a><i class="fa fa-briefcase"></i> Registrar </a>
              <ul class="nav child_menu collapse collapse-completion collapse-request-form collapse-tor collapse-transferee collapse-adding-dropping-subject collapse-club collapse-approval-of-enrolled-course collapse-student-club collapse-registrar-student-profile collapse-purpose collapse-affidavit-of-loss">

                <?php if (hasAccess('registrar /index', $currentUser)): ?>
                  <li class="nav-link-side nav-registrar-student-profile">
                    <a href="#/registrar/student-profile" onclick="change('registrar-student-profile')"> Student Profile  </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('completion form/index', $currentUser)): ?>
                  <li class="nav-link-side nav-completion">
                    <a href="#/registrar/completion" onclick="change('completion')">Completion Form</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('request form/index', $currentUser)): ?>
                  <li class="nav-link-side nav-request-form">
                    <a href="#/registrar/admin-request-form" onclick="change('request-form')">Request Form</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('admin transferee/index', $currentUser)): ?>
                  <li class="nav-link-side nav-transferee">
                    <a href="#/registrar/admin-transferee" onclick="change('transferee')">School Transfer Request</a>
                  </li>
                <?php endif ?>

                <!-- <?php if (hasAccess('student behavior/index', $currentUser)): ?>
                  <li class="nav-link-side nav-student-behavior">
                    <a href="#/registrar/student-behavior" onclick="change('student-behavior')">Student Behavior</a>
                  </li>
                <?php endif ?> -->

                <?php if (hasAccess('transcript of records/index', $currentUser)): ?>
                  <li class="nav-link-side nav-tor">
                    <a href="#/registrar/tor" onclick="change('tor')">Transcript of Records</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('adding dropping subject/index', $currentUser)): ?>
                  <li class="nav-link-side nav-adding-dropping-subject">
                    <a href="#/registrar/admin-adding-dropping-subject" onclick="change('adding-dropping-subject')">Dropping Subject</a>
                  </li>
                <?php endif ?>

                <!-- <?php if (hasAccess('approval of enrolled course/index', $currentUser)): ?>
                  <li class="nav-link-side nav-approval-of-enrolled-course">
                    <a href="#/registrar/approval-enrolled-course" onclick="change('approval-of-enrolled-course')">Approval of Enrolled Courses</a>
                  </li>
                <?php endif ?> -->

                <?php if (hasAccess('purpose/index', $currentUser)): ?>
                  <li class="nav-link-side nav-purpose">
                    <a href="#/registrar/purpose" onclick="change('purpose')">Purposes Management</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('club/index', $currentUser)): ?>
                  <li class="nav-link-side nav-club">
                    <a href="#/registrar/club" onclick="change('club')">Club Management</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('student club/index', $currentUser)): ?>
                  <li class="nav-link-side nav-student-club">
                    <a href="#/registrar/admin-student-club" onclick="change('student-club')">Student Club</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('affidavit of loss/index', $currentUser)): ?>
                <li class="nav-link-side nav-affidavit-of-loss">
                    <a href="#/registrar/admin-affidavit-of-loss" onclick="change('affidavit-of-loss')">Affidavit of loss</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('scholastic document/index', $currentUser)): ?>
                  <li class="nav-link-side nav-scholastic-document">
                    <a href="#/registrar/scholastic-document" onclick="change('scholastic-document')">Scholastic Document Management</a>
                  </li>
                <?php endif ?>

                </ul>
            </li>
          <?php endif ?>

          <?php if (hasAccess('cashier/menu', $currentUser)): ?>
            <li class="nav-link-side nav-payment nav-assessment nav-requested-form-payment"><a><i class="fa fa-credit-card"></i> Cashier </a>
              <ul class="nav child_menu collapse collapse-payment collapse-assessment collapse-requested-form-payment">

                <?php if (hasAccess('payment/index', $currentUser)): ?>
                  <li class="nav-link-side nav-payment">
                    <a href="#/cashier/payment" onclick="change('payment')">Payment Management</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('assessment/index', $currentUser)): ?>
                  <li class="nav-link-side nav-assessment">
                    <a href="#/cashier/assessment" onclick="change('assessment')">Assessment Management</a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('requested form payment/index', $currentUser)): ?>
                  <li class="nav-link-side nav-requested-form-payment">
                    <a href="#/cashier/requested-form-payment" onclick="change('requested-form-payment')">Requested Forms</a>
                  </li>
                <?php endif ?>

                </ul>
            </li>
          <?php endif ?>

          <?php if (hasAccess('guidance and counseling/menu', $currentUser)): ?>
            <li class="nav-link-side nav-referral-slip nav-counseling-appointment nav-attendance-counseling nav-counseling-type nav-student-profile nav-counseling-intake nav-promissory-note nav-good-moral nav-affidavit nav-gco-evaluation nav-calendar-activities nav-customer-satisfaction nav-participant-evaluation nav-student-exit nav-student-behavior"><a><i class="fa fa-users"></i> Guidance & Counseling </a>
              <ul class="nav child_menu collapse collapse-referral-slip collapse-counseling-appointment collapse-attendance-counseling collapse-counseling-type collapse-counseling-intake collapse-promissory-note collapse-good-moral collapse-affidavit collapse-gco-evaluation collapse-calendar-activities collapse-customer-satisfaction collapse-participant-evaluation collapse-student-exit collapse-student-profile collapse-student-behavior">

                <?php if (hasAccess('student profile/index', $currentUser)): ?>
                <li class="nav-link-side nav-student-profile">
                  <a href="#/guidance/student-profile" onclick="change('student-profile')">Student Profile</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('referral slip/index', $currentUser)): ?>
                <li class="nav-link-side nav-referral-slip">
                  <a href="#/guidance/referral-slip" onclick="change('referral-slip')">Referral Slip</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('counseling appointment/index', $currentUser)): ?>
                <li class="nav-link-side nav-counseling-appointment">
                  <a href="#/guidance/admin-counseling-appointment" onclick="change('counseling-appointment')">Counseling Appointment</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('attendance to counseling/index', $currentUser)): ?>
                <li class="nav-link-side nav-attendance-counseling">
                  <a href="#/guidance/attendance-counseling" onclick="change('attendance-counseling')">Attendance to Counseling</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('affidavit for lost id/index', $currentUser)): ?>
                <li class="nav-link-side nav-affidavit">
                  <a href="#/guidance/affidavit" onclick="change('affidavit')">Affidavit for Lost ID/Passbook</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('promissory note/index', $currentUser)): ?>
                <li class="nav-link-side nav-promissory-note">
                  <a href="#/guidance/promissory-note" onclick="change('promissory-note')">Promissory Note Waiver</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('student behavior/index', $currentUser)): ?>
                  <li class="nav-link-side nav-student-behavior">
                    <a href="#/guidance/student-behavior" onclick="change('student-behavior')">Student Behavior</a>
                  </li>
                <?php endif ?>
              <?php if (hasAccess('good moral certificate/index', $currentUser)): ?>
                <li class="nav-link-side nav-good-moral">
                  <a href="#/guidance/good-moral" onclick="change('good-moral')">Good Moral Certificate</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('gco evaluation/index', $currentUser)): ?>
                <li class="nav-link-side nav-gco-evaluation">
                  <a href="#/guidance/admin-gco-evaluation" onclick="change('gco-evaluation')">GCO Evaluation</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('calendar of activities/index', $currentUser)): ?>
                <li class="nav-link-side nav-calendar-activities">
                  <a href="#/guidance/calendar-activities" onclick="change('calendar-activities')">Calendar of Activities</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('counseling type/index', $currentUser)): ?>
                <li class="nav-link-side nav-counseling-type">
                  <a href="#/guidance/counseling-type" onclick="change('counseling-type')">Counseling Type</a>
                </li>
              <?php endif ?>

              <?php if (hasAccess('counseling intake/index', $currentUser)): ?>
                <li class="nav-link-side nav-counseling-intake">
                  <a href="#/guidance/counseling-intake" onclick="change('counseling-intake')">Counseling Intake</a>
                </li>
              <?php endif ?>

              <?php //if (hasAccess('customer satisfaction/index', $currentUser)): ?>
                <!-- <li class="nav-link-side nav-customer-satisfaction">
                  <a href="#/guidance/customer-satisfaction" onclick="change('customer-satisfaction')">Customer Satisfaction</a>
                </li> -->
              <?php //endif ?>

              <?php if (hasAccess('participant evaluation/index', $currentUser)): ?>
                <li class="nav-link-side nav-participant-evaluation">
                  <a href="#/guidance/participant-evaluation" onclick="change('participant-evaluation')">Participant Evaluation Activity</a>
                </li>
              <?php endif ?>
               <?php if (hasAccess('student exit/index', $currentUser)): ?>
                <li class="nav-link-side nav-student-exit">
                  <a href="#/guidance/student-exit" onclick="change('student-exit')">Student Exit Interview</a>
                </li>
              <?php endif ?>

              </ul>
            </li>
          <?php endif ?>

          <?php if (hasAccess('faculty/menu', $currentUser)): ?>
            <li class="nav-link-side nav-faculty-clearance nav-student-clearance nav-faculty-management nav-academic-rank nav-grades nav-program-advisers nav-student-attendance nav-faculty-student-profile"><a><i class="fa fa-user"></i> Faculty </a>
              <ul class="nav child_menu collapse collapse-faculty-clearance collapse-student-clearance collapse-faculty-management collapse-grades collapse-program-advisers collapse-student-attendance collapse-faculty-student-profile collapse-academic-rank">
                <?php if (hasAccess('student profile/index', $currentUser)): ?>
                  <li class="nav-link-side nav-faculty-student-profile">
                    <a href="#/faculty/student-profile" onclick="change('faculty-student-profile')"> Student Profile </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('faculty clearance/index', $currentUser)): ?>
                  <li class="nav-link-side nav-faculty-clearance">
                    <a href="#/faculty/faculty-clearance" onclick="change('faculty-clearance')"> Faculty Clearance </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('student clearance/index', $currentUser)): ?>
                  <li class="nav-link-side nav-student-clearance">
                    <a href="#/faculty/student-clearance" onclick="change('student-clearance')"> Student Clearance </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('faculty management/index', $currentUser)): ?>
                  <li class="nav-link-side nav-faculty-management">
                    <a href="#/faculty/faculty-management" onclick="change('faculty-management')"> Faculty Management </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('program adviser/index', $currentUser)): ?>
                  <li class="nav-link-side nav-program-advisers">
                    <a href="#/faculty/program-adviser" onclick="change('program-advisers')"> Program Adviser </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('grades/index', $currentUser)): ?>
                  <li class="nav-link-side nav-grades">
                    <a href="#/faculty/grades" onclick="change('grades')"> Grades </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('student attendance/index', $currentUser)): ?>
                  <li class="nav-link-side nav-student-attendance">
                    <a href="#/faculty/student-attendance" onclick="change('student-attendance')"> Student Attendance </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('specialization management/index', $currentUser)): ?>
                  <li class="nav-link-side nav-specialization">
                    <a href="#/faculty/specialization" onclick="change('specialization')"> Specialization Management </a>
                  </li>
                <?php endif ?>
                <?php if (hasAccess('academic rank management/index', $currentUser)): ?>
                  <li class="nav-link-side nav-academic-rank">
                    <a href="#/faculty/academic-rank" onclick="change('academic-rank')"> Academic Rank Management </a>
                  </li>
                <?php endif ?>
              </ul>
            </li>
          <?php endif ?>

          <?php if (hasAccess('health and medical service/menu', $currentUser)): ?>
            <li class="nav-link-side nav-student-log nav-prescription nav-medical-certificate nav-referral-recommendation nav-dental nav-property-log nav-medical-consent nav-illness-recommendation nav-consultation nav-invnetory-log nav-medical-student-profile nav-medical-employee-profile nav-nurse-profile nav-item-issuance nav-medical-service-student-profile"><a><i class="fa fa-medkit"></i> Health & Medical Services </a>
              <ul class="nav child_menu collapse collapse-student-log collapse-prescription collapse-medical-certificate collapse-referral-recommendation collapse-dental collapse-property-log collapse-medical-consent collapse-illness-recommendation collapse-consultation collapse-invnetory-log collapse-medical-student-profile collapse-medical-employee-profile collapse-nurse-profile collapse-item-issuance collapse-medical-service-student-profile">

                <?php if (hasAccess('medical service student profile/index', $currentUser)): ?>
                <li class="nav-link-side nav-medical-service-student-profile">
                  <a href="#/medical-services/student-profile" onclick="change('medical-service-student-profile')">Student Profile</a>
                </li>
              <?php endif ?>

              <?php if (hasAccess('medical student profile/index', $currentUser)): ?>
                <li class="nav-link-side nav-medical-student-profile">
                  <a href="#/medical-services/medical-student-profile" onclick="change('medical-student-profile')">Medical Student Profile</a>
                </li>
              <?php endif ?>

              <?php if (hasAccess('medical employee profile/index', $currentUser)): ?>
                <li class="nav-link-side nav-medical-employee-profile">
                  <a href="#/medical-services/medical-employee-profile" onclick="change('medical-employee-profile')">Medical Employee Profile</a>
                </li>
              <?php endif ?>

              <?php if (hasAccess('medical nurse profile/index', $currentUser)): ?>
                <li class="nav-link-side nav-nurse-profile">
                  <a href="#/medical-services/nurse-profile" onclick="change('nurse-profile')">Nurse Profile</a>
                </li>
              <?php endif ?>

              <?php if (hasAccess('student log/index', $currentUser)): ?>
                <li class="nav-link-side nav-student-log">
                  <a href="#/medical-services/student-log" onclick="change('student-log')">Log</a>
                </li>
              <?php endif ?>

              <?php if (hasAccess('consultation/index', $currentUser)): ?>
                <li class="nav-link-side nav-consultation">
                  <a href="#/medical-services/consultation" onclick="change('consultation')">Consultation</a>
                </li>
              <?php endif ?>

              <?php if (hasAccess('dental/index', $currentUser)): ?>
                <li class="nav-link-side nav-dental">
                  <a href="#/medical-services/dental" onclick="change('dental')">Dental</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('medical certificate request/index', $currentUser)): ?>
              <li class="nav-link-side nav-medical-certificate">
                  <a href="#/medical-services/medical-certificate" onclick="change('medical-certificate')">Medical Certificate Request</a>
              </li>
              <?php endif ?>
              <?php if (hasAccess('referral recommendation/index', $currentUser)): ?>
                <li class="nav-link-side nav-referral-recommendation">
                  <a href="#/medical-services/referral-recommendation" onclick="change('referral-recommendation')">Referral Recomendation</a>
                </li>
              <?php endif ?>

              <?php if (hasAccess('item issuance/index', $currentUser)): ?>
                <li class="nav-link-side nav-item-issuance">
                  <a href="#/medical-services/item-issuance" onclick="change('item-issuance')">Item Issuance</a>
                </li>
              <?php endif ?>
              
              <?php if (hasAccess('property & equipment/index', $currentUser)): ?>
                <li class="nav-link-side nav-property-log">
                  <a href="#/medical-services/property-log" onclick="change('property-log')">Property & Equipment</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('illness and recommendation/index', $currentUser)): ?>
                <li class="nav-link-side nav-illness-recommendation">
                  <a href="#/medical-services/illness-recommendation" onclick="change('illness-recommendation')">Illness Recommendation</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('prescription/index', $currentUser)): ?>
                <li class="nav-link-side nav-prescription">
                  <a href="#/medical-services/prescription" onclick="change('prescription')">Prescription</a>
                </li>
              <?php endif ?>
            
              </ul>
            </li>
          <?php endif ?>

          <?php if (hasAccess('learning resource center/menu', $currentUser)): ?>
            <li class="nav-link-side nav-learning-resource-member nav-bibliography nav-material-type nav-collection-type nav-member nav-check-out nav-check-in nav-inventory-bibliography nav-visitors nav-learning-student-profile"><a><i class="ti ti-book"></i> Learning Resource Center </a>
              <ul class="nav child_menu collapse collapse-learning-resource-member collapse-bibliography collapse-material-type collection-material-type collapse-member collapse-check-out collapse-check-in collapse-inventory-bibliography collapse-visitors collapse-learning-student-profile">
              <!-- <?php if (hasAccess('learning resource member/index', $currentUser)): ?>
                <li class="nav-link-side nav-learning-resource-member">
                  <a href="#/learning-resource-center/learning-resource-member" onclick="change('learning-resource-member')">Members</a>
                </li>
              <?php endif ?> -->

              <?php if (hasAccess('learning student profile/index', $currentUser)): ?>
                <li class="nav-link-side nav-learning-student-profile">
                  <a href="#/learning-resource-center/student-profile" onclick="change('learning-student-profile')">Student Profile</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('member management/index', $currentUser)): ?>
                <li class="nav-link-side nav-member">
                  <a href="#/learning-resource-center/learning-resource-member" onclick="change('member')">Members</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('member management/index', $currentUser)): ?>
                <li class="nav-link-side nav-visitors">
                  <a href="#/learning-resource-center/visitors-alumni" onclick="change('visitors')">Visitors/Alumni</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('bibliography/index', $currentUser)): ?>
                <li class="nav-link-side nav-bibliography">
                  <a href="#/learning-resource-center/admin-bibliography" onclick="change('bibliography')">Bibliography</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('inventory bibliography/index', $currentUser)): ?>
                <li class="nav-link-side nav-inventory-bibliography">
                  <a href="#/learning-resource-center/inventory-bibliography" onclick="change('inventory-bibliography')"> Inventory Bibliography</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('check out/index', $currentUser)): ?>
                <li class="nav-link-side nav-check-out">
                  <a href="#/learning-resource-center/check-out" onclick="change('check-out')"> Check-Out</a>
                </li>
              <?php endif ?><?php if (hasAccess('inventory bibliography/index', $currentUser)): ?>
                <li class="nav-link-side nav-check-in">
                  <a href="#/learning-resource-center/check-in" onclick="change('check-in')"> Check-In</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('material type management/index', $currentUser)): ?>
                <li class="nav-link-side nav-material-type">
                  <a href="#/learning-resource-center/material-type" onclick="change('material-type')">Material Type</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('collection type management/index', $currentUser)): ?>
                <li class="nav-link-side nav-collection-type">
                  <a href="#/learning-resource-center/collection-type" onclick="change('collection-type')">Collection Type</a>
                </li>
              <?php endif ?>
              </ul>
            </li>
          <?php endif ?>

          <?php if (hasAccess('corporate affairs/menu', $currentUser)): ?>
            <li class="nav-link-side nav-apartelle nav-apartelle-registration nav-student-list nav-corporate-affairs-student-profile nav-apartelle-student-clearance"><a><i class="fa fa-building-o"></i> Corporate Affairs </a>
              <ul class="nav child_menu collapse collapse-apartelle collapse-student-list collapse-apartelle-registration collapse-corporate-affairs-student-profile collapse-apartelle-student-clearance">

                <?php if (hasAccess('corporate affairs student profile/index', $currentUser)): ?>
                <li class="nav-link-side nav-corporate-affairs-student-profile">
                  <a href="#/corporate-affairs/student-profile" onclick="change('corporate-affairs-student-profile')">Student Profile</a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('apartelle/index', $currentUser)): ?>
                <li class="nav-link-side nav-apartelle">
                  <a href="#/corporate-affairs/apartelle" onclick="change('apartelle')">Apartelle/Dormitory</a>
                </li>
              <?php endif ?>

              <?php if (hasAccess('apartelle registration/index', $currentUser)): ?>
                <li class="nav-link-side nav-apartelle-registration">
                  <a href="#/corporate-affairs/admin-apartelle-registration" onclick="change('apartelle-registration')">Apartelle/Dormitory Registration</a>
                </li>
              <?php endif ?>

              <?php if (hasAccess('interview request/index', $currentUser)): ?>
                <li class="nav-link-side nav-interview-request">
                  <a href="#/corporate-affairs/interview-request" onclick="change('interview-request')">Interview Request</a>
                </li>
              <?php endif ?>

              
              <?php if (hasAccess('student list/index', $currentUser)): ?>
                <li class="nav-link-side nav-student-list">
                  <a href="#/corporate-affairs/student-list" onclick="change('student-list')">Student List</a>
                </li>
              <?php endif ?>

              <?php if (hasAccess('apartelle student clearance/index', $currentUser)): ?>
                <li class="nav-link-side nav-apartelle-student-clearance">
                  <a href="#/corporate-affairs/admin-apartelle-student-clearance" onclick="change('apartelle-student-clearance')">Apartelle Student Clearance</a>
                </li>
              <?php endif ?>


              </ul>
            </li>
          <?php endif ?>

          <?php if (hasAccess('curriculum/menu', $currentUser)): ?>
            <li class="nav-link-side nav-class-schedule nav-colleges nav-program nav-prospectus nav-room nav-building nav-course nav-sections nav-block-section nav-college nav-major nav-curriculum-student-profile"><a><i class="fa fa-industry"></i> Curriculum </a>
              <ul class="nav child_menu_bot collapse collapse-class-schedule collapse-colleges collapse-prospectus collapse-program collapse-room collapse-building collapse-course collapse-sections collapse-block-section collapse-college collapse-major collapse-curriculum-student-profile">

                <?php if (hasAccess('curriculum student profile/index', $currentUser)): ?>
                <li class="nav-link-side nav-curriculum-student-profile">
                  <a href="#/student-profile" onclick="change('curriculum-student-profile')"> Student Profile </a>
                </li>
              <?php endif ?>


              <?php if (hasAccess('prospectus/index', $currentUser)): ?>
                <li class="nav-link-side nav-prospectus">
                  <a href="#/curriculum/prospectus" onclick="change('prospectus')">Enrolled Students</a>
                </li>
              <?php endif ?>

              <!-- <?php if (hasAccess('class schedule/index', $currentUser)): ?>
                <li class="nav-link-side nav-class-schedule">
                  <a href="#/class-schedule" onclick="change('class-schedule')"> Class Scheduling </a>
                </li>
              <?php endif ?> -->

              <?php if (hasAccess('block section/index', $currentUser)): ?>
                <li class="nav-link-side nav-class-block-section">
                  <a href="#/block-section" onclick="change('block-section')"> Block Section </a>
                </li>
              <?php endif ?>
              
              <?php if (hasAccess('colleges/index', $currentUser)): ?>
                <li class="nav-link-side nav-colleges"><a href="#/college" onclick="change('college')"> Colleges </a></li>
              <?php endif ?>
              <?php if (hasAccess('program/index', $currentUser)): ?>
                <li class="nav-link-side nav-program"><a href="#/college-program" onclick="change('program')"> Programs </a></li>
              <?php endif ?>
              <?php if (hasAccess('course/index', $currentUser)): ?>
                <li class="nav-link-side nav-course">
                  <a href="#/course" onclick="change('course')"> Courses </a>
                </li>
              <?php endif ?>
              <?php if (hasAccess('rooms/index', $currentUser)): ?>
                <li class="nav-link-side nav-room"><a href="#/room" onclick="change('room')"> Rooms </a></li>
              <?php endif ?>
              <?php if (hasAccess('buildings/index', $currentUser)): ?>
                <li class="nav-link-side nav-building"><a href="#/building" onclick="change('building')"> Buildings </a></li>
              <?php endif ?>
              <?php if (hasAccess('section management/index', $currentUser)): ?>
                <li class="nav-link-side nav-sections"><a href="#/sections" onclick="change('sections')"> Sections </a></li>
              <?php endif ?>
              <?php if (hasAccess('major/index', $currentUser)): ?>
                <li class="nav-link-side nav-major"> <a href="#/major" onclick="change('major')"> Major </a></li>
              <?php endif ?>
              </ul>
            </li>
          <?php endif ?>

          <?php if (hasAccess('report/menu', $currentUser)): ?>
            <li class="nav-link-side"><a><i class="fa fa-files-o"></i> Report </a>
              <ul class="nav child_menu_bot">

                <li class="nav-link-side nav-apartelle-monthly-payment"><a><i></i> Corporate Affairs </a>
                  <ul class="nav child_menu_bot collapse collapse-apartelle-monthly-payment">
                    <?php if (hasAccess('corporate affairs/index', $currentUser)): ?>
                      <li class="nav-link-side nav-apartelle-monthly-payment">
                        <a href="#/reports/corporate-affairs/apartelle-monthly-payment" onclick="change('apartelle-monthly-payment')"> Monthly Payment </a>
                      </li>
                    <?php endif ?>
                  </ul>
                </li>

                <li class="nav-link-side nav-faculty-masterlists"><a><i></i> Academic Report </a>
                  <ul class="nav child_menu_bot collapse collapse-faculty-masterlists">
                    <?php if (hasAccess('report academic report/faculty masterlists', $currentUser)): ?>
                      <li class="nav-link-side nav-health nav-faculty-masterlists">
                        <a href="#/reports/academic-report/faculty-masterlists" onclick="change('faculty-masterlists')"> Faculty Masterlists </a>
                      </li>
                    <?php endif ?>
                  </ul>
                </li>

                <li class="nav-link-side nav-medical-services-report nav-monthly-accomplishment nav-property-equipment nav-report-consumption nav-daily-treatments nav-report-consultation nav-consultation-employee nav-employee-frequency"><a><i></i> Health and Medical Services </a>
                  <ul class="nav child_menu_bot collapse collapse-medical-services-report collapse-monthly-accomplishment collapse-property-equipment collapse-report-consumption collapse-daily-treatments collapse-report-consultation collapse-consultation-employee collapse-employee-frequency">
                    <?php if (hasAccess('health and medical service/index', $currentUser)): ?>
                      <li class="nav-link-side nav-health nav-monthly-accomplishment">
                        <a href="#/reports/medical-services/monthly-accomplishment" onclick="change('monthly-accomplishment')"> Monthly Accomplishments </a>
                      </li>
                    <?php endif ?>
                    <?php if (hasAccess('health and medical service/index', $currentUser)): ?>
                      <li class="nav-link-side nav-health nav-property-equipment">
                        <a href="#/reports/medical-services/property-equipment" onclick="change('property-equipment')"> Properties & Equipments </a>
                      </li>
                    <?php endif ?>
                    <?php if (hasAccess('health and medical service/index', $currentUser)): ?>
                      <li class="nav-link-side nav-health nav-report-consumption">
                        <a href="#/reports/medical-services/monthly-consumption" onclick="change('report-consumption')"> Consumption Report </a>
                      </li>
                    <?php endif ?>
                    <?php if (hasAccess('health and medical service/index', $currentUser)): ?>
                      <li class="nav-link-side nav-health nav-daily-treatments">
                        <a href="#/reports/medical-services/daily-treatments" onclick="change('daily-treatments')"> Daily Treatments </a>
                      </li>
                    <?php endif ?>
                    <?php if (hasAccess('health and medical service/index', $currentUser)): ?>
                      <li class="nav-link-side nav-health nav-report-consultation">
                        <a href="#/reports/medical-services/consultation" onclick="change('report-consultation')"> Consultation Report </a>
                      </li>
                    <?php endif ?>
                    <?php if (hasAccess('health and medical service/index', $currentUser)): ?>
                      <li class="nav-link-side nav-health nav-consultation-employee">
                        <a href="#/reports/medical-services/consultation-employee" onclick="change('consultation-employee')"> Employee Statistics Report </a>
                      </li>
                    <?php endif ?>
                    <?php if (hasAccess('health and medical service/index', $currentUser)): ?>
                      <li class="nav-link-side nav-health nav-employee-frequency">
                        <a href="#/reports/medical-services/employee-frequency" onclick="change('employee-frequency')"> Employee Consultation Frequency </a>
                      </li>
                    <?php endif ?>
                    </ul>
                </li>

                <li class="nav-link-side nav-subject-masterlists nav-enrollment-profile nav-enrollment-list nav-student-masterlist nav-academic-failures-list nav-student-club-list nav-student-ranking nav-promoted-student nav-reports-student-behavior nav-transcript-of-records nav-academic-list nav-list-academic-awardees nav-gwa nav-reports-student-behavior"><a><i></i> Registrar </a>
                  <ul class="nav child_menu_bot collapse collapse-subject-masterlists collapse-enrollment-profile collapse-enrollment-list collapse-student-masterlist collapse-academic-failures-list collapse-student-club-list collapse-student-ranking collapse-promoted-student collapse-reports-student-behavior collapse-transcript-of-records collapse-academic-list collapse-list-academic-awardees collapse-gwa collapse-reports-student-behavior" >
                    <?php if (hasAccess('registrar /index', $currentUser)): ?>
                      <li class="nav-link-side nav-enrollment-profile">
                        <a href="#/reports/registrar/enrollment-profile" onclick="change('enrollment-profile')"> Enrollment Profile  </a>
                      </li>
                    <?php endif ?>
                    <?php if (hasAccess('report registrar/subject masterlists', $currentUser)): ?>
                      <li class="nav-link-side nav-subject-masterlists">
                        <a href="#/reports/registrar/subject-masterlists" onclick="change('subject-masterlists')"> Subject Masterlists </a>
                      </li>
                    <?php endif ?>

                    <?php if (hasAccess('report registrar/enrollment list', $currentUser)): ?>
                      <li class="nav-link-side nav-enrollment-list">
                        <a href="#/reports/registrar/enrollment-list" onclick="change('enrollment-list')"> Enrollment List </a>
                      </li>
                    <?php endif ?>

                    <?php if (hasAccess('registrar /index', $currentUser)): ?>
                      <li class="nav-link-side nav-student-masterlist">
                        <a href="#/reports/registrar/student-masterlist" onclick="change('student-masterlist')"> Student Masterlist </a>
                      </li>
                    <?php endif ?>

                    <?php if (hasAccess('registrar /failures list', $currentUser)): ?>
                      <li class="nav-link-side nav-academic-failures-list">
                        <a href="#/reports/registrar/academic-failures-list" onclick="change('academic-failures-list')"> Academic Failures </a>
                      </li>
                    <?php endif ?>
                    <?php if (hasAccess('registrar /student club list', $currentUser)): ?>
                      <li class="nav-link-side nav-student-club-list">
                        <a href="#/reports/registrar/student-club-list" onclick="change('student-club-list')"> Student Clubs </a>
                      </li>
                    <?php endif ?>

                    <?php if (hasAccess('report registrar/student ranking', $currentUser)): ?>
                      <li class="nav-link-side nav-student-ranking">
                        <a href="#/reports/registrar/student-ranking" onclick="change('student-ranking')"> Student Rankings </a>
                      </li>
                    <?php endif ?>

                    <?php if (hasAccess('report registrar/promoted student', $currentUser)): ?>
                      <li class="nav-link-side nav-promoted-student">
                        <a href="#/reports/registrar/promoted-student" onclick="change('promoted-student')"> List of Promoted Students </a>
                      </li>
                    <?php endif ?>

                    <?php if (hasAccess('report registrar/student behavior', $currentUser)): ?>
                      <li class="nav-link-side nav-reports-student-behavior">
                        <a href="#/reports/registrar/student-behavior" onclick="change('reports-student-behavior')"> Student Behavior </a>
                      </li>
                    <?php endif ?>

                    <?php if (hasAccess('report registrar/transcript of records', $currentUser)): ?>
                      <li class="nav-link-side nav-transcript-of-records">
                        <a href="#/reports/registrar/transcript-of-records" onclick="change('transcript-of-records')"> Transcript of Records (TOR) </a>
                      </li>
                    <?php endif ?>

                    <?php if (hasAccess('registrar /index', $currentUser)): ?>
                      <li class="nav-link-side nav-academic-list">
                        <a href="#/reports/registrar/academic-list" onclick="change('academic-list')"> List of Best Academic Students  </a>
                      </li>
                    <?php endif ?>

                    
                    <?php if (hasAccess('report registrar/list academic awardees', $currentUser)): ?>
                      <li class="nav-link-side nav-list-academic-awardees">
                        <a href="#/reports/registrar/list-academic-awardees" onclick="change('list-academic-awardees')"> List of Academic Awardee </a>
                      </li>
                    <?php endif ?>

                    <?php if (hasAccess('registrar /index', $currentUser)): ?>
                      <li class="nav-link-side nav-gwa">
                        <a href="#/reports/registrar/gwa" onclick="change('gwa')"> General Weighted Average  </a>
                      </li>
                    <?php endif ?>
                    
                    </ul>
                </li>

                <li class="nav-link-side nav-list-students nav-list-scholar-students nav-list-applicants"><a><i></i> Admission </a>
                  <ul class="nav child_menu_bot collapse collapse-list-students collapse-list-scholar-students collapse-list-applicants" >
                    <?php if (hasAccess('report admission/list of students', $currentUser)): ?>
                      <li class="nav-link-side nav-list-students">
                        <a href="#/reports/admission/list-students" onclick="change('list-students')"> List of Students </a>
                      </li>
                    <?php endif ?>
                    <?php if (hasAccess('report admission/list of scholars', $currentUser)): ?>
                      <li class="nav-link-side nav-list-scholar-students">
                        <a href="#/reports/admission/list-scholar-students" onclick="change('list-scholar-students')"> List of Scholars </a>
                      </li>
                    <?php endif ?>

                    <?php if (hasAccess('report admission/list-applicants', $currentUser)): ?>
                      <li class="nav-link-side nav-list-applicants">
                        <a href="#/reports/admission/list-applicants" onclick="change('list-applicants')"> List of Applicants </a>
                      </li>
                    <?php endif ?>
                    </ul>
                </li>

                <li class="nav-link-side nav-list-requested-form nav-list-gco-evaluation"><a><i></i> Guidance </a>
                  <ul class="nav child_menu_bot collapse collapse-list-requested-form collapse-list-gco-evaluation " >
                    <?php if (hasAccess('report guidance/list of requested forms', $currentUser)): ?>
                      <li class="nav-link-side nav-list-requested-form">
                        <a href="#/reports/guidance/requested-form" onclick="change('list-requested-form')"> List of Requested Forms </a>
                      </li>
                    <?php endif ?>

                    <?php if (hasAccess('report guidance/list of requested forms', $currentUser)): ?>
                      <li class="nav-link-side nav-list-gco-evaluation ">
                        <a href="#/reports/guidance/gco-evaluation" onclick="change('list-gco-evaluation')"> GCO Evaluation Report </a>
                      </li>
                    <?php endif ?>

                    </ul>
                </li>

                <li class="nav-link-side nav-learning-resource-report nav-report-bibliography nav-report-check-out nav-report-check-in"><a><i></i> Learning Resource Center  </a>
                  <ul class="nav child_menu_bot collapse collapse-learning-resource-center collapse-report-bibliography collapse-report-checkout collapse-report-checkin" >
                    <?php if (hasAccess('learning resource center/index', $currentUser)): ?>
                      <li class="nav-link-side nav-report-bibliography">
                        <a href="#/reports/learning-resource-center/bibliographies" onclick="change('report-bibliography')"> Bibliography </a>
                      </li>
                      <?php endif ?>
                      <?php if (hasAccess('learning resource center/index', $currentUser)): ?>
                      <li class="nav-link-side nav-report-checkout">
                        <a href="#/reports/learning-resource-center/check-outs" onclick="change('report-checkout')"> Check-Out </a>
                      </li>
                      <?php endif ?>
                      <?php if (hasAccess('learning resource center/index', $currentUser)): ?>
                      <li class="nav-link-side nav-report-checkin">
                        <a href="#/reports/learning-resource-center/check-ins" onclick="change('report-checkin')"> Check-In </a>
                      </li>           

                    </ul>
                  </li>
                  <?php endif ?>

              </ul>
            </li>
          <?php endif ?>

          <?php if (hasAccess('settings/menu', $currentUser)): ?>
            <li class="nav-link-side nav-permissions nav-accounts nav-roles nav-users nav-user-logs nav-backup nav-settings nav-office-reference nav-admin-management nav-award-management nav-awardee-management nav-announcement nav-memorandum"><a><i class="fa fa-cog"></i> Settings </a>
              <ul class="nav child_menu_bot collapse collapse-permissions collapse-accounts collapse-roles collapse-users collapse-user-logs collapse-backup collapse-settings collapse-office-reference collapse-admin-management collapse-award-management collapse-awardee-management collapse-announcement collapse-memorandum">
                <?php if (hasAccess('organization information/index', $currentUser)): ?>
                  <li class="nav-link-side nav-settings">
                    <a href="#/settings" onclick="change('settings')"> Organization Information </a>
                  </li>
                <?php endif ?>
                <?php if (hasAccess('accounts/index', $currentUser)): ?>
                  <li class="nav-link-side nav-accounts">
                    <a href="#/settings/accounts" onclick="change('accounts')"> Chart of Accounts </a>
                  </li>
                <?php endif ?><?php if (hasAccess('office-reference/index', $currentUser)): ?>
                  <li class="nav-link-side nav-office-reference">
                    <a href="#/settings/office-reference" onclick="change('office-reference')"> Office References Management </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('admin management/index', $currentUser)): ?>
                  <li class="nav-link-side nav-admin-management">
                    <a href="#/settings/admin-management" onclick="change('admin-management')"> Admin Management </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('award management/index', $currentUser)): ?>
                  <li class="nav-link-side nav-award-management">
                    <a href="#/settings/award-management" onclick="change('award-management')"> Award Management </a>
                  </li>
                <?php endif ?>
                <?php if (hasAccess('awardee management/index', $currentUser)): ?>
                  <li class="nav-link-side nav-awardee-management">
                    <a href="#/settings/awardee-management" onclick="change('awardee-management')"> Awardee Management </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('announcement/index', $currentUser)): ?>
                  <li class="nav-link-side nav-announcement">
                    <a href="#/settings/announcement" onclick="change('announcement')"> Announcements </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('memorandum/index', $currentUser)): ?>
                  <li class="nav-link-side nav-memorandum">
                    <a href="#/settings/memorandum" onclick="change('memorandum')"> Memorandums </a>
                  </li>
                <?php endif ?>

                <hr>
                <?php if (hasAccess('permission management/index', $currentUser)): ?>
                  <li class="nav-link-side nav-permissions">
                    <a href="#/permissions" onclick="change('permissions')">Permission Management</a>
                  </li>
                <?php endif ?>
                <?php if (hasAccess('role management/index', $currentUser)): ?>
                  <li class="nav-link-side nav-roles">
                    <a href="#/roles" onclick="change('roles')">Role Management</a>
                  </li>
                <?php endif ?>
                
                <?php if (hasAccess('user management/index', $currentUser)): ?>
                  <li class="nav-link-side nav-users">
                    <a href="#/users" onclick="change('users')">User Management</a>
                  </li>
                <?php endif ?>
                <?php if (hasAccess('user logs/index', $currentUser)): ?>
                  <li class="nav-link-side nav-user-logs">
                    <a href="#/user-logs" onclick="change('user-logs')">User Logs</a>
                  </li>
                <?php endif ?>
                <?php if (hasaccess('backup manager/index', $currentUser)): ?>
                  <li class="nav-link-side nav-backup">
                    <a href="#/backup" onclick="change('backup')">Backup Manager</a>
                  </li>
                <?php endif ?>
              </ul>
            </li>
          <?php endif ?>

        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->
  </div>
</div>