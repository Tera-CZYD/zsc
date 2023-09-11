
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">STUDENT CLUB INFORMATION</div>
          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped">

                  <tr>
                    <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                    <td class="italic">{{ data.StudentClub.code }}</td>
                  </tr>
                  <tr>
                    <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                    <td class="italic">{{ data.StudentClub.student_name }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> DATE : </th>
                    <td class="italic">{{ data.StudentClub.date }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> POSITION : </th> 
                    <td class="italic">{{ data.StudentClub.position }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> CLUB : </th>
                    <td class="italic">{{ data.Club.title }}</td>
                  </tr>
                </table>
              </div>
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
                <a href="#/registrar/student-club/edit/{{ data.StudentClub.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <!-- <button type="button" class="btn btn-info btn-min" ng-show="data.RequestForm.approve == 1" ng-disabled="data.StudentClub.isprint == 1"  ng-click="print(data.StudentClub.id )"><i class="fa fa-print"></i> PRINT REQUEST FORM </button> -->
                <button class="btn btn-danger btn-min" ng-click="remove(data.StudentClub)"><i class="fa fa-trash"></i> DELETE </button>
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