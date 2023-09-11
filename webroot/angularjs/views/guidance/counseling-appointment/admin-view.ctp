<?php if (hasAccess('counseling appointment/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW COUNSELING APPOINTMENT INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width: 20%"> CONTROL NO. : </th>
                  <td class="italic">{{ data.CounselingAppointment.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TYPE : </th>
                  <td class="uppercase italic">{{ data.CounselingType.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT NAME : </th>
                  <td class="uppercase italic">{{ data.CounselingAppointment.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.CounselingAppointment.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TIME : </th>
                  <td class="italic">{{ data.CounselingAppointment.time }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DESCRIPTION : </th>
                  <td class="italic">{{ data.CounselingAppointment.description }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('counseling appointment/print no harm contact form', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print_no_harm_contract_form(data.CounselingAppointment.id )"><i class="fa fa-print"></i> NO HARM CONTRACT FORM </button>
              <?php endif ?>
              <?php if (hasAccess('counseling appointment/print counselee informed counsent form', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print_informed_consent_form(data.CounselingAppointment.id )"><i class="fa fa-print"></i> COUNSELEE INFORMED CONSENT FORM </button>
              <?php endif ?>
              <?php if (hasAccess('counseling appointment/print release information form', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print_release_info_form(data.CounselingAppointment.id )"><i class="fa fa-print"></i> RELEASE INFORMATION FORM </button>
              <?php endif ?>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('counseling appointment/approve', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="approve(data.CounselingAppointment)" ng-disabled="data.CounselingAppointment.approve == 1 || data.CounselingAppointment.approve == 4 || data.CounselingAppointment.approve == 3" class="btn btn-warning  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <?php endif ?>
              <?php if (hasAccess('counseling appointment/confirm', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="confirm(data.CounselingAppointment)" ng-disabled="data.CounselingAppointment.approve != 1" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> CONFIRM </button>
              <?php endif ?>
              <?php if (hasAccess('counseling appointment/disapprove', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="disapprove(data.CounselingAppointment)" ng-disabled="data.CounselingAppointment.approve == 2 || data.CounselingAppointment.approve == 4 || data.CounselingAppointment.approve == 3" class="btn btn-danger  btn-min" ><i class="fa fa-close"></i> DISAPPROVE </button>
              <?php endif ?>
              <?php if (hasAccess('counseling appointment/edit', $currentUser)): ?>
                <a href="#/guidance/admin-counseling-appointment/edit/{{ data.CounselingAppointment.id }}" ng-disabled="data.CounselingAppointment.approve == 1 || data.CounselingAppointment.approve == 2 || data.CounselingAppointment.approve == 4 || data.CounselingAppointment.approve == 3" class="btn btn-primary  btn-min"><i class="fa fa-edit"></i> EDIT</a>
                
              <?php endif ?>
              <?php if (hasAccess('counseling appointment/cancel', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="cancel(data.CounselingAppointment)" ng-disabled = "data.CounselingAppointment.approve == 3" class="btn btn-danger  btn-min" ><i class="fa fa-warning"></i> CANCEL </button> 
              <?php endif ?>
            </div> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<style>
  .table-wrapper{
    width:100%;
    height:500px;
    overflow-y:auto;
  }
</style>