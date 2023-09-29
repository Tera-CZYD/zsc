<?php if (hasAccess('affidavit of loss/view', $currentUser)) : ?>
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">AFFIDAVIT OF LOSS INFORMATION</div>
          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col">
              <div class="table-responsive">
                <table class="table table-striped">

                  <tr>
                    <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                    <td class="italic">{{ data.AffidavitOfLoss.code }}</td>
                  </tr>
                  <tr>
                    <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                    <td class="italic">{{ data.AffidavitOfLoss.student_name }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> COLLEGE PROGRAM : </th>
                    <td class="italic">{{ data.CollegeProgram.name }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> DATE : </th>
                    <td class="italic">{{ data.AffidavitOfLoss.date }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> FORM : </th>
                    <td class="italic">{{ data.AffidavitOfLoss.form }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> DESCRIPTION : </th>
                    <td class="italic">{{ data.AffidavitOfLoss.description }}</td>
                  </tr>
                  <tr>
                      <th class="text-right"> REQUESTOR : </th>
                      <td class="italic">{{ data.AffidavitOfLoss.claim == 0 ? 'CLAIM' : (data.AffidavitOfLoss.claim == 1 ? 'AUTHORIZED PERSON' : '') }}</td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="col-md-4" style="display: flex; justify-content: center;" ng-show="data.AffidavitOfLoss.claim == 1">

                <a href="uploads/affidavit-of-loss/{{data.AffidavitOfLoss.id}}/{{ data.AffidavitOfLoss.image }}"><img src="uploads/affidavit-of-loss/{{data.AffidavitOfLoss.id}}/{{ data.AffidavitOfLoss.image }}" class="img-responsive" style="max-height: 50vh; max-width: 70%;" /></a>

            </div>

            <div class="clearfix"></div>
            


              </div>
            </div>
            <div class="col-md-12">
              <div class="clearfix"></div>
              <hr>
            </div>
            <div class="col-md-12">
              <div class="pull-right">
                <?php if (hasAccess('affidavit of loss/edit', $currentUser)) : ?>
                  <a href="#/registrar/admin-affidavit-of-loss/edit/{{ data.AffidavitOfLoss.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <?php endif ?>
                <?php if (hasAccess('affidavit of loss/approve', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="approve(data.AffidavitOfLoss)" ng-disabled="data.AffidavitOfLoss.approve > 0" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <?php endif ?>
                <?php if (hasAccess('affidavit of loss/disapprove', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="disapprove(data.AffidavitOfLoss)" ng-disabled="data.AffidavitOfLoss.approve > 0 " class="btn btn-warning  btn-min" ><i class="fa fa-times"></i> DISAPPROVE </button>
              <?php endif ?>
                <!-- <?php if (hasAccess('affidavit of loss/print', $currentUser)) : ?>
                  <button type="button" class="btn btn-info  btn-min" ng-click="print(data.RequestForm.id )"><i class="fa fa-print"></i> PRINT REQUEST FORM </button>
                <?php endif ?> -->
                <?php if (hasAccess('affidavit of loss/delete', $currentUser)) : ?>
                  <button class="btn btn-danger btn-min" ng-click="remove(data.AffidavitOfLoss)"><i class="fa fa-trash"></i> DELETE </button>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif ?>
<style type="text/css">
  th {
    white-space: nowrap;
  }

  td {
    white-space: nowrap;
  }
</style>