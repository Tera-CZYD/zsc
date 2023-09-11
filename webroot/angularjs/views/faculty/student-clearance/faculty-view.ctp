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
                  <td class="italic">{{ data.CollegeProgram.name }} - {{ data.StudentClearance.major }}</td>
                </tr>
                <tr>
                  <th class="text-right" colspan="1" style="width:15%"> STATUS : </th>
                  <td class="italic" colspan="3"> {{ data.StudentClearance.status_faculty == 1 ? 'CLEARED' : 'PENDING' }} </td>
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
                  <th class="text-right" colspan="1" style="width:15%"> ASSESSMENT : </th>
                  <td class="italic" colspan="3"> {{ data.StudentClearance.remarks != null ? data.StudentClearance.remarks : 'N/A' }} </td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> CASHIER : </th>
                  <td class="italic"> {{ data.StudentClearance.status_cashier == 1 ? 'CLEARED' : 'PENDING'  }} </td>
                  <th class="text-right" style="width:15%"> ADVISER/HEAD, STUDENT AFFAIRS : </th>
                  <td class="italic"> {{ data.StudentClearance.status_affairs == 1 ? 'CLEARED' : 'PENDING' }} </td>
                </tr>
                <tr>
                  <th class="text-right"> LIBRARIAN : </th>
                  <td class="italic"> {{ data.StudentClearance.status_librarian == 1 ? 'CLEARED' : 'PENDING'  }} </td>
                  <th class="text-right" style="width:15%"> IN-CHARGE, LABORATORY SUPPLIES : </th>
                  <td class="italic"> {{ data.StudentClearance.status_laboratory == 1 ? 'CLEARED' : 'PENDING' }} </td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE DEAN : </th>
                  <td class="italic"> {{ data.StudentClearance.status_dean == 1 ? 'CLEARED' : 'PENDING'  }} </td>
                  <th class="text-right"> DEPARTMENT HEAD : </th>
                  <td class="italic"> {{ data.StudentClearance.status_head == 1 ? 'CLEARED' : 'PENDING'  }} </td>
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