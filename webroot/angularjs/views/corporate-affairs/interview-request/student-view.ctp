<div class="row">
<div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW INTERVIEW REQUEST INFORMATION</div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.InterviewRequest.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.InterviewRequest.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.InterviewRequest.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th> 
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.InterviewRequest.year }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <a href="#/corporate-affairs/interview-request/student-edit/{{ data.InterviewRequest.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <button class="btn btn-danger btn-min" ng-click="remove(data.InterviewRequest)"><i class="fa fa-trash"></i> DELETE </button>
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