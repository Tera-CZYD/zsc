<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title"> {{ data.Student.student_no }} :: {{ data.Student.full_name }} </h4>
        <div>College : {{ data.Student.college.name }}</div>
        <div>Program : {{ data.Student.college_program.name }}</div>
        <div class="clearfix"></div><hr>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
              <button type="button" class="btn btn-danger btn-min" ng-click="print()"><i class="fa fa-print"></i> PRINT </button>
            </div>
          </div>
        </div>
        <div class="clearfix"></div><hr>
        <div class="single-table mb-5">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr class="bg-info">
                  <th class="w10px" style="width: 50px">NO.</th>
                  <th>REFERENCE NO.</th>
                  <th>TRANSACTION DATE</th>
                  <th>PAYMENT</th>
                  <th>BALANCE</th>
                  <th>TRANSACTION</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="ledger in data.StudentLedger">
                  <td class="w10px" style="width: 50px">{{ $index + 1 }}</td>
                  <td class="text-center">{{ ledger.primary_refno }}</td>
                  <td class="text-center">{{ ledger.transaction_date }}</td>
                  <td class="text-right">{{ ledger.payment | number : 2 }}</td>
                  <td class="text-right">{{ ledger.balance | number : 2 }}</td>
                  <td class="text-center">{{ ledger.remarks }}</td>
                </tr>
                <tr ng-show="data.StudentLedger == null || data.StudentLedger == ''">
                  <td colspan="7">No available data</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
