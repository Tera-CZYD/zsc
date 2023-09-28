
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

                <a href="uploads/affidavit-of-loss/{{data.AffidavitOfLoss.id}}/{{ data.AffidavitOfLoss.image }}"><img src="uploads/affidavit-of-loss/{{data.AffidavitOfLoss.id}}/{{ data.AffidavitOfLoss.image }}" class="img-responsive" style="max-height: 50vh; max-width: 80%;" /></a>

            </div>
            


              </div>
            </div>
            <div class="col-md-12">
              <div class="clearfix"></div>
              <hr>
            </div>
            <div class="col-md-12">
              <div class="pull-right">
                <!-- <button type="button" class="btn btn-warning btn-min" ng-show="data.StudentClub.approve == 1" ng-disabled="data.RequestForm.is_request_printed == 1"  ng-click="printRequested(data.RequestForm.id )"><i class="fa fa-print"></i> PRINT REQUESTED FORM </button> -->
                <a href="#/registrar/affidavit-of-loss/edit/{{ data.AffidavitOfLoss.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <!-- <button type="button" class="btn btn-info btn-min" ng-show="data.RequestForm.approve == 1" ng-disabled="data.StudentClub.isprint == 1"  ng-click="print(data.StudentClub.id )"><i class="fa fa-print"></i> PRINT REQUEST FORM </button> -->
                <button class="btn btn-danger btn-min" ng-click="remove(data.AffidavitOfLoss)"><i class="fa fa-trash"></i> DELETE </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<style type="text/css">
  th {
    white-space: nowrap;
  }

  td {
    white-space: nowrap;
  }
</style>