<?php if (hasAccess('check out/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW CHECK-OUT INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div>
              <div class="table-responsive">
                <table class="table table-striped">
                  <tr>
                    <th class="text-right" style="width:15%"> LIBRARY ID NUMBER : </th>
                    <td class="italic">{{ data.CheckOut.learning_resource_member_id }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> MEMBER NAME : </th>
                    <td style="{{ data.CheckOut.member_name == undefined ? 'padding:15px':'padding:13px !important'}}" class="uppercase">{{ data.CheckOut.member_name }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> EMAIL : </th>
                    <td class="italic">{{ data.CheckOut.email }}</td>
                  </tr>
                </table>
              </div> 
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
          <div class="single-table mb-5">
              <div class="table-responsive">
                <table class="table table-bordered text-center">
                  <thread> 
                    <tr class="bg-info">
                      <th class="text-center w30px">#</th>
                      <th class="text-center"> BARCODE NO. </th>
                      <th class="text-center"> TITLE </th>
                      <th class="text-center"> DESCRIPTION </th>
                      <th class="text-center"> AUTHOR </th>
                      
                    </tr>
                  </thread>
                  <tbody>
                    <tr ng-repeat="datas in data.CheckOutSub">
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="text-center">{{ datas.barcode_no}}</td>
                      <td class="text-left uppercase">{{ datas.title }}</td>
                      <td class="text-center uppercase">{{ datas.description }}</td>
                      <td class="text-center">{{ datas.author }}</td>
                    <tr ng-show="data.CheckOutSub == null || data.CheckOutSub == ''">
                      <td colspan="5">No available data</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            </div>

          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('check out/edit', $currentUser)): ?>
                <a href="#/learning-resource-center/check-out/edit/{{ data.CheckOut.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('check out/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.CheckOut)"><i class="fa fa-trash"></i> DELETE </button>
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
