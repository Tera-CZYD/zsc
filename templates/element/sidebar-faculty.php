<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="#/dashboard" class="site_title">&nbsp;<img width="49" height="49" src="<?php echo $base ?>/assets/img/zam.png"> <span>ZSCMST</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">

        <?php if (is_null($currentUser->image) && $currentUser->image == "" || !file_exists('uploads/users/'.$currentUser->id.'/'.$currentUser->image)) { ?>

          <img class="img-circle profile_img" src="assets/img/user.jpg">

        <?php } else { ?>

          <img class="img-circle profile_img" src="<?php echo $base . '/uploads/users/'.$currentUser->id.'/'.$currentUser->image; ?>">

        <?php  }?>

      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2><?php echo $currentUser->first_name . ' ' . $currentUser->last_name ?> </h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">  
        <ul class="nav side-menu">

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

          <?php if (hasAccess('faculty/menu', $currentUser)): ?>
            <li class="nav-link-side nav-faculty-clearance nav-student-clearance nav-faculty-management nav-grades nav-faculty-student-attendance"><a><i class="fa fa-user"></i> Faculty </a>
              <ul class="nav child_menu collapse collapse-faculty-clearance collapse-student-clearance collapse-faculty-management collapse-grades collapse-faculty-student-attendance">

                <?php if (hasAccess('student clearance/index', $currentUser)): ?>
                  <li class="nav-link-side nav-student-clearance">
                    <a href="#/faculty/student-clearance/faculty-index" onclick="change('student-clearance')"> Student Clearance </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('faculty management/index', $currentUser)): ?>
                  <li class="nav-link-side nav-grades">
                    <a href="#/faculty/grades" onclick="change('grades')"> Grades </a>
                  </li>
                <?php endif ?>

                <?php if (hasAccess('faculty student attendance/index', $currentUser)): ?>
                  <li class="nav-link-side nav-faculty-student-attendance">
                    <a href="#/faculty/faculty-student-attendance" onclick="change('faculty-student-attendance')"> Student Attendance </a>
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

              <?php if (hasAccess('class schedule/index', $currentUser)): ?>
                <li class="nav-link-side nav-class-schedule">
                  <a href="#/class-schedule" onclick="change('class-schedule')"> Class Scheduling </a>
                </li>
              <?php endif ?>

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

        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->
  </div>
</div>