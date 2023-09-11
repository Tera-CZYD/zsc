<!-- add permission -->
<div class="modal fade" id="add-miscellaneous-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp;ADD MISCELLANEOUS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="add_miscellaneous">
          <div class="col-md-12 table-wrapper">
            <div class="table-responsive">
              <table class="table table-bordered center">
                <thead>
                  <th class="w30px"></th>
                  <th>CODE</th>
                  <th>MISCELLANEOUS FEE</th>
                  <th>UNIT</th>
                  <th>AMOUNT</th>
                </thead>
                <tbody>
                <tr ng-repeat="account in accounts">
                    <td>
                      <input icheck type="checkbox" ng-model="account.selected">
                    </td>
                    <td class="uppercase text-left">{{ account.code }}</td>
                    <td class="uppercase text-left">{{ account.name }}</td>
                    <td class="uppercase text-left">{{ account.unit }}</td>
                    <td class="uppercase text-left">{{ account.amount }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
        <button type="button" class="btn btn-primary btn-sm btn-min saveMiscellaneous" ng-click="saveMiscellaneous()"> <i class="fa fa-save"></i> SAVE</button>
      </div>
    </div>
  </div>
</div>