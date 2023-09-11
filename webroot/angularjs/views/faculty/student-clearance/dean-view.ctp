<?php if (hasAccess('student clearance/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">STUDENT CLEARANCE INFORMATION</div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.StudentClearance.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.StudentClearance.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COURSE : </th>
                  <td class="italic">{{ data.Course.code }} - {{ data.StudentClearance.major }}</td>
                </tr>
              </table>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="col-md-9">
            <div class="single-table mb-5">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thread>
                  <tr class="bg-info">
                    <th class="text-center w30px">#</th>
                    <th class="text-center"> SUBJECT </th>
                    <th class="text-center"> TEACHER </th>
                    <th class="text-center"> REMARKS </th>
                  </tr>
                </thread>
                <tbody>
                    <tr ng-repeat="data in datas">
                      <td class="text-center">
                          {{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                      <td class="text-center">{{ data.code }}</td>
                      <td class="text-left">{{ data.student_name }}</td>
                      <td class="text-center">{{ data.course }}</td>
                    </tr>
                    <tr ng-show="datas == null || datas == ''">
                      <td colspan="10">No available data</td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> ASSESSMENT : </th>
                  <td class="italic"> N/A </td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> CASHIER : </th>
                  <td class="italic"> CLEARED </td>
                </tr>
                <tr>
                  <th class="text-right"> LIBRARIAN : </th>
                  <td class="italic"> CLEARED </td>
                </tr>
              </table>
            </div>
            <div class="clearfix"></div>
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