<?php $g=0; $rates=0; $counter=0; ?>
<div class="container body">
  <div class="main_container">

    <?php if($currentUser['role']['code'] == 'Student'){  ?>

      <script>
        var dashboard = 'student-dashboard.ctp';
      </script>
        
      <?php echo $this->element('sidebar-student');
    
    }elseif($currentUser['role']['code'] == 'Enrollee'){ 

      echo $this->element('sidebar-enrollee');

    }else if ($currentUser['role']['code'] == 'Dean') { ?>

      <script>
        var dashboard = 'dean-dashboard.ctp';
      </script>

      <?php echo $this->element('sidebar-dean');

    }else if ($currentUser['role']['code'] == 'Vice President') { ?>

      <script>
        var dashboard = 'vice-dashboard.ctp';
      </script>

      <?php echo $this->element('sidebar-vice'); 

    }else if ($currentUser['role']['code'] == 'Faculty') { ?>

      <script>
        var dashboard = 'faculty-dashboard.ctp';
      </script>

      <?php echo $this->element('sidebar-faculty') ?>

    <?php }else{ ?>

      <script>
        var dashboard = 'dashboard.ctp';
      </script>

      <?php echo $this->element('sidebar') ?>

    <?php }?>

    <?php echo $this->element('topnav') ?>

    <div class="right_col" role="main">

      <div>
        <button type="button" onclick="history.back()" class="btn btn-success btn-min btn-sm" style="background-color: #82cf82; color: black;" title="Go back one page"><i class="fa fa-arrow-left"></i> BACK </button>
        <button type="button" onclick="history.forward()" class="btn btn-warning btn-min btn-sm" title="Go forward one page"> FORWARD <i class="fa fa-arrow-right"></i></button>
      </div>

      <div ng-view id="ng-view"></div>
    </div>
    <!-- footer content -->
      <footer>
        <div>
          <b>Copyright © <?php echo date('Y')?> <a class="bu" href="http://zscmst.edu.ph/" target="_blank">Zamboanga State College of Marine Sciences and Technology</a></b> All rights reserved.
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->  
  </div>
</div>
<?php echo $this->element('scripts') ?>
<?php echo $this->element('angularjs') ?>

<script type="text/javascript">

  $(document).ready(function() {

    urls = (window.location.href.replace(window.location.origin,""));

    tmp_url = urls.substr(7,(urls.indexOf("/", 7) > 0 ? (urls.indexOf("/", 7)  - 7) : urls.length));

    var link = tmp_url.replace(/[`~!@#$%^&*()_|+\=?;:'",.<>\{\}\[\]\\\/]/gi, '');

    if($('.nav-link-side.nav-' + link).length > 0){

      $('.nav-link-side.nav-' + link).addClass('active');

      $('.nav-link-side.nav-' + link).addClass('current-page');

      let ul = document.querySelector('.collapse-' + link);

      if(ul !== null){
          
        ul.style.display = "block";

      }

    }

  });

  function change(url = null){

    var link = url;
    
    $('.nav-link-side').removeClass('active');
    
    $('.nav-link-side').removeClass('current-page');

    let ul = document.querySelector('.collapse');

    ul.style.display = "none";

    if($('.nav-link-side.nav-' + link).length > 0){

      $('.nav-link-side.nav-' + link).addClass('active');

      $('.nav-link-side.nav-' + link).addClass('current-page');

      let ul = document.querySelector('.collapse-' + link);

      ul.style.display = "block";

    }

  }

  // window.onbeforeunload = function () {
    
  //   window.scrollTo(0, 0);

  // }

</script>