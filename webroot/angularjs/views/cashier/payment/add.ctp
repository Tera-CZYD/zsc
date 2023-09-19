<script type="text/javascript">

  function handleAccess(elementId, permissionCode, currentUser) {
    const element = document.getElementById(elementId);
    const accessGranted = hasAccess(permissionCode, currentUser);
    
    if (accessGranted) {
      element.classList.remove('d-none'); // Remove Bootstrap's "d-none" class to show the element
    } else {
      element.classList.add('d-none'); // Add Bootstrap's "d-none" class to hide the element
    }
  }

  // INCLUDE ALL PAGE PERMISSION
  handleAccess('pageAdd', 'payment/add', currentUser);
  handleAccess('pageDelete', 'payment/delete', currentUser);

</script>

<div class="row" id="pageAdd">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title"> ADD NEW PAYMENT DATA </div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.Payment.code">
              </div>
            </div>

           <div class="col-md-9">
              <div class="form-group">
                <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchApprovalCourse({ search: searchTxt })">
              </div>
            </div>

            <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-left"> PROGRAM : </th>
                  <td class="italic">{{ data.Payment.program }}</td>
                </tr>
                <tr>
                  <th class="text-left"> STUDENT NAME : </th>
                  <td class="italic">{{ data.Payment.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-left"> EMAIL : </th>
                  <td class="italic">{{ data.Payment.email }}</td>
                </tr>
                <tr>
                  <th class="text-left"> CONTACT NO. : </th>
                  <td class="italic">{{ data.Payment.contact_no }}</td>
                </tr>
              </table>
            </div> 
          </div>

            <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12 table-wrapper">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <th class="bg-info" colspan="6">MISCELLANEOUS</th>
                </thead>
                <thead>
                  <tr >
                    <th class="w30px text-center">#</th>
                    <th class="text-center">CODE </th>
                    <th class="text-center">NAME</th>
                    <th class="text-center">UNIT</th>
                    <th class="text-center">AMOUNT</th>
                    <th class="w100px"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="datax in data.CashierSub">
                    <td class="w30px">{{ $index + 1 }}</td>
                    <td class="uppercase w200px">{{ datax.code }}</td>
                    <td class="uppercase">{{ datax.name }}</td>
                    <td class="uppercase"> {{ datax.unit }}</td>
                    <td class="text-right">{{ datax.amount | number : 2 }}</td>
                    <td class="w30px">
                      <div id="pageDelete" class="btn-group btn-group-xs">
                        <a class="btn btn-danger no-border-radius" ng-click="removeMiscellaneous($index,data);" ><i class="fa fa-trash"></i></a>
                      </div>
                    </td>
                    <tr ng-if="data.CashierSub == '' || data.CashierSub == null">
                      <td class="text-center" colspan="10">No available Miscellaneous</td>
                    </tr>
                  </tr>
                </tbody>
                <tfoot ng-if="data.CashierSub != ''">
                  <tr>
                    <th class="text-left" colspan="4">TOTAL</th>
                    <th class="text-right">{{ data.Payment.total | number : 2 }}</th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>

            <div class="col-md-12">
              <div class="col-md-3">
                <button id="pageAdd" type="button" class="btn btn-primary btn-min" data-toggle="modal" ng-click="addMiscellaneous()"><i class="fa fa-plus"></i> ADD MISCELLANEOUS</button>
              </div>
            </div>

            <div class="clearfix"></div><hr>
            <div class="row">
              <div class="col-md-12">
                <div class="pull-right">
                  <button class="btn btn-primary btn-min" id = "save" ng-click="save()" [class.disabled]="isClickedOnce"
                (click)="isClickedOnce = true"><i class="fa fa-save"></i> SAVE </button>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
$('#form').validationEngine('attach');
</script>



