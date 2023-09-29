<!-- angularjs -->
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/angular/angular.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/angular/angular-animate.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/angular/angular-route.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/angular/angular-resource.min.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/angular-loading/loading-bar.js"></script>
<script type="text/javascript" src="<?php echo $base ?>/assets/plugins/angular/angular-selectize.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js"></script> -->
<!-- .angularjs -->

<!-- angularjs app -->
<script type="text/javascript" src="<?php echo $base ?>app/app.js?version=<?php echo time() ?>"></script>
<script type="text/javascript" src="<?php echo $base ?>app/directives.js?version=<?php echo time() ?>"></script>
<script type="text/javascript" src="<?php echo $base ?>app/filters.js?version=<?php echo time() ?>"></script>
<script type="text/javascript" src="<?php echo $base ?>app/services.js"></script>
<script type="text/javascript" src="<?php echo $base ?>app/controllers.js"></script>


<!-- angularjs scripts -->

<?php

  $scripts = array(

    //ADMIN SIDE BAR

    'dashboard',

    //CURRICULUM

    'curriculum',

    'year-level-term',

    'academic-term',

    'degree',

    'major',

    //ADMISSION

    'student-admission',

    'student-details',

    'campus',

    'department',

    'college-department',

    'college-department-program',

    'college-block',

    'course-schedule',
    
    'program-major',
    
    'program-term',

    //COURSES

    'course',

    'course-level',

    'course-mode',

    'course-type-reference',

    //ACCOUNTING

    'account-classification',

    'account-category',

    'account-set',

    'account-fees',

    'table-of-fees',

    'faculty-load-account',

    'faculty-load',

    'designation',

    //REGISTRATION

    'student-advising',
    
    //SCHOLARSHIP

    'provider',

    'category',

    'scholarship',
    
    // SETTINGS

    'settings/accounts',

    'settings/award-management',

    'settings/awardee-management',

    'settings/announcement',

    'settings/memorandum',

    'settings/office-reference',

    'settings/admin-management',

    'settings',
    
    'permissions',

    'roles',

    'users',

    'user-logs',

    'backup',



    //ADMISSION

    'admission/student-application',

    // 'admission/transferee',

    'admission/cat',

    'admission/registered-students',

    'admission/student-profiles',

    'admission/enrollment',

    'admission/scholarship-application',

    'admission/school',

    'admission/scholarship-name',

    //REGISTRAR

    'registrar/completion',

    'registrar/request-form',

    'registrar/affidavit-of-loss',

    // 'registrar/prospectus',

    'registrar/purpose',

    'registrar/tor',

    'registrar/adding-dropping-subject',

    'registrar/club',

    'registrar/student-club',

    'registrar/approval-enrolled-course',

    'registrar/transferee',

    'registrar/student-profile',

    //CASHIER

    'cashier/payment',

    'cashier/assessment',

    'cashier/requested-form',

    //GUIDANCE AND COUNSELING

    'guidance/counseling-appointment',

    'guidance/attendance-counseling',

    'guidance/counseling-type',

    'guidance/referral-slip',

    'guidance/appointment-slip',

    'guidance/promissory-note',

    'guidance/student-behavior',

    'guidance/good-moral',

    'guidance/gco-evaluation',

    'guidance/affidavit',

    'guidance/calendar-activities',

    'guidance/counseling-intake',

    'guidance/customer-satisfaction',

    'guidance/participant-evaluation',

    'guidance/student-exit',

    'guidance/student-profile',

    //HEALTH AND MEDICAL SERVICES

    'medical-services/medical-student-profile',

    'medical-services/medical-employee-profile',

    'medical-services/nurse-profile',

    'medical-services/student-log',

    'medical-services/medical-certificate',

    'medical-services/referral-recommendation',

    'medical-services/dental',

    'medical-services/property-log',

    'medical-services/medical-consent',

    'medical-services/illness-recommendation',

    'medical-services/prescription',

    'medical-services/consultation',

    'medical-services/item-issuance',

    'medical-services/student-profile',
    
    //LEARNING RESOURCE CENTER

    'learning-resource-center/learning-resource-member',

    'learning-resource-center/bibliography',

    'learning-resource-center/visitors-alumni',

    'learning-resource-center/material-type',

    'learning-resource-center/collection-type',

    'learning-resource-center/inventory-bibliography',

    'learning-resource-center/check-out',

    'learning-resource-center/check-in',

    'learning-resource-center/student-profile',

    //CORPORATE AFFAIRS

    'corporate-affairs/apartelle',

    'corporate-affairs/apartelle-registration',

    'corporate-affairs/apartelle-student-clearance',

    'corporate-affairs/student-list',

    'corporate-affairs/interview-request',

    'corporate-affairs/student-profile',


    //CURRICULUM

    'class-schedule',

    'block-section',

    'sections',

    'prospectus',

    'student-profile',

    //FACULTY

    'faculty/faculty-management',

    'faculty/student-clearance',

    'faculty/faculty-clearance',

    'faculty/student-attendance',

    'faculty/grades',

    'faculty/program-adviser',

    'faculty/specialization',

    'faculty/faculty-student-attendance',

    'faculty/student-profile',

    'faculty/academic-rank',

    //COLLEGES

    'college',

    //PROGRAM

    'college-program',

    //BUILDING

    'building',

    //ROOM

    'room',

    //STUDENT SIDEBAR

    'enrollment',

    'self-enroll',

    'student-ledger',

    'faculty-qce',

    'student-schedule',

    //REPORTS

    'reports/registrar',

    //ACADEMIC REPORTS

    'reports/academic-report',

    //ADMISSION

    'reports/admission',

    //CORPORATE AFFAIRS

    'reports/corporate-affairs',

    //GUIDANCE

    'reports/guidance',

    //LEARNING RESOURCE

    'reports/learning-resource-center/check-outs/',

    'reports/learning-resource-center/check-ins/',

    'reports/learning-resource-center/bibliographies/',

    //MEDICAL SERCIES

    'reports/medical-services',


    //STUDENT PROFILE

    'profile/student-profile',
      
  );

?>

<?php foreach ($scripts as $script): ?>
  <?php $script = str_replace('__', '/', $script) ?>
  <!-- <?php echo $script ?> -->
  <script type="text/javascript" src="<?php echo $base ?>app/<?php echo $script ?>/service.js<?php echo '?version=' . time() ?>"></script>
  <script type="text/javascript" src="<?php echo $base ?>app/<?php echo $script ?>/route.js<?php echo '?version=' . time() ?>"></script>
  <script type="text/javascript" src="<?php echo $base ?>app/<?php echo $script ?>/controller.js<?php echo '?version=' . time() ?>"></script>
  <!-- .<?php echo $script ?> -->
<?php endforeach ?>

