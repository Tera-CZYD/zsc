<?php if (hasAccess('inventory bibliography/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW BIBLIOGRAPHY INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.Bibliography.code }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> TITLE: </th>
                  <td class="italic">{{ data.Bibliography.title }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> AUTHOR: </th>
                  <td class="italic">{{ data.Bibliography.author }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TYPE OF MATERIAL : </th>
                  <td class="italic">{{ data.Bibliography.material_type.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TYPE OF COLLECTION : </th>
                  <td class="italic">{{ data.Bibliography.collection_type.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SHOW IN OPAC : </th>
                  <td class="italic">{{ data.Bibliography.show_in_opac }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CALL NUMBER : </th>
                  <td class="italic">{{ data.Bibliography.call_number1 }}</td>
                </tr>
                <tr ng-show="data.Bibliography.call_number2 != null">
                  <th class="text-right"></th>
                  <td class="italic">{{ data.Bibliography.call_number2 }}</td>
                </tr>
                <tr ng-show="data.Bibliography.call_number3 != null">
                  <th class="text-right"></th>
                  <td class="italic">{{ data.Bibliography.call_number3 }}</td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-3 pull-left">
            <a class="btn btn-warning btn-sm btn-block" id="save" ng-click="addInventoryBibliography()"><i class="fa fa-plus"></i> ADD NEW COPY</a><br/>
          </div>

          <div class="clearfix"></div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
        </div>
        <div class="header-title">BIBLIOGRAPHY COPY INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thread>
                  <tr class="bg-info">
                      <th class="text-center w30px">#</th>
                      <th class="text-center"> BARCODE NO. </th>
                      <th class="text-center"> DESCRIPTION </th>
                      <th class="text-center"> TERM OF AVAILABILITY </th>
                      <th class="text-center"> STATUS DATE TIME </th>
                      <th class="text-center"> DUE BACK </th>
                      <th class="w90px"></th>
                    </tr>
                </thread>
                <tbody>
                  <tr ng-repeat="datax in data.InventoryBibliography">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="uppercase text-center">{{ datax.barcode_no }}</td>
                    <td class="text-left">{{ datax.description }}</td>
                    <td class="uppercase text-center" style="font-weight: bold;">{{ datax.status }}</td>
                    <td class="text-center">{{ datax.status_dt }}</td>
                    <td class="text-center">{{ datax.dueback | date: 'MM/dd/yyyy' }}</td>
                    <td class="text-center">
                      <div class="btn-group btn-group-xs">
                        <a href="javascript:void(0)" ng-click="editInventoryBibliography($index, datax)" class="btn btn-success" title="EDIT"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" ng-click="removeInventoryBibliography(datax)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                      </div>
                    </td>
                    <tr ng-if="data.InventoryBibliography == '' || data.InventoryBibliography == null">
                      <td colspan="8" class="text-center">No data available</td>
                    </tr>
                  </tr>
                </tbody>
              </table>
            </div> 
          </div>
        </div>

        <div class="header-title">ADDITIONAL BIBLIOGRAPHIC INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">

          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> AUTHOR : </th>
                  <td class="italic">{{ data.Bibliography.author }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> INTERNATIONAL STANDARD BOOK NUMBER : </th>
                  <td class="italic">{{ data.Bibliography.isbn }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CLASSIFICATION NUMBER : </th>
                  <td class="italic">{{ data.Bibliography.library_of_congress1 }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PLACE OF PUBLICATION, DISTRIBUTION : </th>
                  <td class="italic">{{ data.Bibliography.place_of_publication }}</td>
                </tr>
                <tr>
                  <th class="text-right"> NAME OF PUBLICHER, DISTRIBUTOR : </th>
                  <td class="italic">{{ data.Bibliography.name_of_publisher }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE OF PUBLICATION, DISTRIBUTION : </th>
                  <td class="italic">{{ data.Bibliography.date_of_publication }}</td>
                </tr>
                <tr>
                  <th class="text-right">EXTENT :</th>
                  <td class="italic">{{ data.Bibliography.physical_description1 }}</td>
                </tr>
                <tr>
                  <th class="text-right">OTHER PHYSICAL DETAILS :</th>
                  <td class="italic">{{ data.Bibliography.physical_description2 }}</td>
                </tr>
                <tr>
                  <th class="text-right">DIMENSIONS :</th>
                  <td class="italic">{{ data.Bibliography.physical_description3 }}</td>
                </tr>
                <tr>
                  <th class="text-right">SUMMARY, ETC. NOTE :</th>
                  <td class="italic">{{ data.Bibliography.summary }}</td>
                </tr>
              </table>
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
  #border-title {
    margin-block: 20px 20px;
    padding-left: 20px;
  }
  .close {
    margin-block: 10px 20px;
  }
</style>
<script>
$('#form').validationEngine('attach');
</script>

<div class="modal fade" id="add-inventory-bibliography-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="header-title">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="header-title" id="border-title"> ADD INVENTORY BIBLIOGRAPHY </h4>
      </div>
      <div class="modal-body">
        <form id="add_inventory_bibliography">   

          <div class="col-md-12">
            <div class="form-group">
              <label> BARCODE NO. <i class="required">*</i></label>
              <input type="text" class="form-control" ng-model="adata.barcode_no" data-validation-engine="validate[required]" autocomplete="off">
            </div>
          </div> 
          <div class="col-md-12">
            <div class="form-group">
              <label> DESCRIPTION <i class="required">*</i></label>
              <input type="text" class="form-control" ng-model="adata.description" data-validation-engine="validate[required]" autocomplete="off">
            </div>
          </div>
        </form>
       </div>  
      <div class="modal-footer">
        <button type="button" id="cancel" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
        <button type="button" id="save" class="btn btn-primary btn-sm btn-min" ng-click="saveInventoryBibliography(adata)">SAVE</button>
      </div>
    </div>
  </div>
</div>  

<div class="modal fade" id="edit-inventory-bibliography-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="header-title">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="header-title" id="border-title"> EDIT INVENTORY BIBLIOGRAPHY </h4>
      </div>
      <div class="modal-body">
        <form id="edit_inventory_bibliography">   

          <div class="col-md-12">
            <div class="form-group">
              <label> BARCODE NO. <i class="required">*</i></label>
              <input type="text" class="form-control" ng-model="adata.barcode_no" data-validation-engine="validate[required]" autocomplete="off">
            </div>
          </div> 
          <div class="col-md-12">
            <div class="form-group">
              <label> DESCRIPTION <i class="required">*</i></label>
              <input type="text" class="form-control" ng-model="adata.description" data-validation-engine="validate[required]" autocomplete="off">
            </div>
          </div>
        </form>
       </div>  
      <div class="modal-footer">
        <button type="button" id="cancel" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
        <button type="button" id="save" class="btn btn-primary btn-sm btn-min" ng-click="updateInventoryBibliography(adata)">SAVE</button>
      </div>
    </div>
  </div>
</div>

