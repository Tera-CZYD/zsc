<?php if (hasAccess('payment/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW PAYMENT INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NO. : </th>
                  <td class="italic">{{ data.Payment.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT NAME : </th>
                  <td class="italic">{{ data.Payment.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> EMAIL : </th>
                  <td class="italic">{{ data.Payment.email }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONTACT NO. : </th>
                  <td class="italic">{{ data.Payment.contact_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> OR NO. : </th>
                  <td class="italic">{{ data.Payment.or_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> AMOUNT : </th>
                  <td class="italic">{{ data.Payment.amount | number : 2 }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TYPE : </th>
                  <td class="italic">{{ data.Payment.type }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('payment/edit', $currentUser)): ?>
                <a href="#/cashier/payment/edit/{{ data.Payment.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
               <?php endif ?>
              <?php if (hasAccess('payment/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.Payment)"><i class="fa fa-trash"></i> DELETE </button>
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
