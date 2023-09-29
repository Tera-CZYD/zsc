<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="#/dashboard" class="site_title">&nbsp;<img width="49" height="49" src="<?php echo $base ?>/assets/img/zam.png"> <span>ZSCMST</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">

        <?php if (is_null($currentUser['image']) && $currentUser['image'] == "" || !file_exists('uploads/users/'.$currentUser['id'].'/'.$currentUser['image'])) { ?>

          <img class="img-circle profile_img" src="assets/img/user.jpg">

        <?php } else { ?>

          <img class="img-circle profile_img" src="<?php echo $base . '/uploads/users/'.$currentUser['id'].'/'.$currentUser['image']; ?>">

        <?php  }?>

      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2><?php echo $currentUser['first_name'] . ' ' . $currentUser['last_name'] ?> </h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">  
        <ul class="nav side-menu">

          <li class="nav-link-side nav-dashboard"><a href="#/dashboard" onclick="change('dashboard')"><i class="fa fa-dashboard"></i> Dashboard </a></li>

          <?php if (hasAccess('faculty/menu', $currentUser)): ?>
            <li class="nav-link-side nav-faculty-clearance nav-student-clearance nav-faculty-management nav-grades"><a><i class="fa fa-user"></i> Faculty </a>
              <ul class="nav child_menu collapse collapse-faculty-clearance collapse-student-clearance collapse-faculty-management collapse-grades">

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

              <?php if (hasAccess('faculty management/index', $currentUser)): ?>
                <li class="nav-link-side nav-faculty-management">
                  <a href="#/faculty/grades" onclick="change('grades')"> Grades </a>
                </li>
              <?php endif ?>
              </ul>
            </li>
          <?php endif ?>

          <?php if (hasAccess('club/index', $currentUser)): ?>
            <li class="nav-link-side nav-club">
              <a href="#/registrar/club" onclick="change('club')"><i class="fa fa-cc-diners-club "></i> Club Management</a>
            </li>
          <?php endif ?>
          </li>
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->
  </div>
</div>