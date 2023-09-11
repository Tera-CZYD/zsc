<?php if (hasAccess('check out/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW CHECK-OUT</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="col-md-3">
            <div class="form-group">
              <label> SEARCH MEMBER </label>
              <input type="text" class="form-control search uppercase" placeholder="TYPE MEMBER HERE" ng-model="searchTxt" ng-enter="searchMember({ search: searchTxt })">
              <label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
            </div>
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <div class="header-title">MEMBER INFORMATION</div>
            <div class="clearfix"></div><hr>
           
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
      
           <div class="col-md-12" ng-show="data.CheckOut.member_name != undefined">
            <div class="clearfix"></div><hr>
            <div class="header-title">ITEMS AVAILABLE</div>

            <div class="clearfix"></div><hr>

            <button type="button" class="btn btn-warning  btn-min" ng-click="checkOut()">CHECK-OUT SELECTED ITEMS</button>
            <button type="button" id="btn"  class="btn btn-warning btn-min" ng-click="checkOutAll(data)">CHECK-OUT ALL ITEMS</button>
            
            <div class="single-table mb-5">
            <div class="table-responsive">
              <table class="table table-bordered text-center" id="myTable">
                <thread> 
                  <tr class="bg-info">
                    <th class="text-center w30px">
                      <input icheck type="checkbox" ng-init="selectAll = false" ng-model="selectAll" ng-change="selectall()">
                    </th>
                    <th class="text-center w30px">#</th>
                    <th class="text-center"> BARCODE NO. </th>
                    <th class="text-center"> TITLE </th>
                    <th class="text-center"> DESCRIPTION </th>
                    <th class="text-center"> AUTHOR </th>
                    
                  </tr>
                </thread>
                <tbody>
                  <tr ng-repeat="data in datax">
                    <td>
                      <input icheck type="checkbox" ng-init="data.selected = false" ng-model="data.selected">
                    </td>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ data.barcode_no}}</td>
                    <td class="text-left uppercase">{{ data.title }}</td>
                    <td class="text-center uppercase">{{ data.description }}</td>
                    <td class="text-center">{{ data.author }}</td>
                  <tr ng-show="datax == null || datax == ''">
                    <td colspan="7">No available data</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="searched-learning-resource-member-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ADVANCE SEARCH</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered vcenter table-striped table-condensed">
              <thead>
                <tr>
                  <th class="w30px">#</th>
                  <th class="text-center">LIBRARY ID NUMBER</th>
                  <th class="text-center">NAME</th>
                  <th class="w30px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="member in learning_resource_members">
                  <td>{{ (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
                  <td class="uppercase text-center">{{ member.library_id_number }}</td>
                  <td class="uppercase text-center">{{ member.member_name }}</td>
                  <td>
                    <input icheck type="radio" ng-init="member.selected = false" ng-model="member.selected" name="iCheck" ng-selected="member.selected = true" ng-change="selectedMember(member)">
                  </td>
                </tr>
              </tbody>
              <tfoot ng-show="paginator.pageCount > 0">
                <tr>
                  <td colspan="4" class="text-center">
                    <div class="clearfix"></div>
                    <div class="row">
                      <div class="col-md-12">
                        <ul class="pagination justify-content-center">
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&laquo;&laquo;</sub></a>
                          </li>
                          <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&laquo;</a>
                          </li>
                          <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                            <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">{{ page.number }}</a>
                          </li>
                          <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&raquo;</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&raquo;&raquo;</sub> </a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="text-center" ng-show="paginator.pageCount > 0">
                          <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>  
      </div> 

      <div class="modal-footer">
        <div class="pull-right">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="memberData(employee.id)" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
        </div> 
        
      </div>
    </div>  
  </div><!-- /.modal-content -->
</div>

<?php endif ?>
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
   #border-title {
    margin-block: 20px 20px;
    padding-left: 20px;
  }
  .close {
    margin-block: 10px 20px;
  }
</style>

<div class="modal fade" id="add-dueback-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="header-title">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="header-title" id="border-title"> PLEASE ENTER DATE OF RETURN </h4>
      </div>

      <div class="modal-body">
        <form id="add_dueback">
          <div class="col-md-12">
            <div class="form-group">
              <label> DATE <i class="required">*</i></label>
              <input type="text" class="form-control datepicker" autocomplete="off" ng-model="datas.dueback" data-validation-engine="validate[required]">
            </div>
          </div>
        </form>
       </div> 
       <div class="modal-footer">
        <button type="button" id="cancel" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
        <button type="button" id="save" class="btn btn-primary btn-sm btn-min" ng-click="saveCheckOut(datas)"> SAVE </button>
      </div> 
    </div>
  </div>
</div>

