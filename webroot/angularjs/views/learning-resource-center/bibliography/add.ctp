<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW BIBLIOGRAPHY</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input type="text" class="form-control" ng-model="data.Bibliography.code">
              </div>
            </div>
            <div class="col-md-4" >
              <div class="form-group">
                <label> MATERIAL TYPE <i class="required">*</i></label>
                <select selectize style="height: 100px" ng-model="data.Bibliography.material_type_id" ng-options="opt.id as opt.value for opt in material_type" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-4" >
              <div class="form-group">
                <label> COLLECTION TYPE <i class="required">*</i></label>
                <select selectize style="height: 100px" ng-model="data.Bibliography.collection_type_id" ng-options="opt.id as opt.value for opt in collection_type" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-4" >
              <div class="form-group">
                <label> SHOW IN OPAC? <i class="required">*</i></label>
                <select class="form-control" ng-model="data.Bibliography.show_in_opac" ng-init="data.Bibliography.show_in_opac = 'Yes'" data-validation-engine="validate[required]">
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <table class="table table-bordered center">
                <tr>
                  <th class="text-left" rowspan="3"> CALL NUMBER </th>
                  <td class="text-left">
                    <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.call_number1" data-validation-engine="validate[required]">
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.call_number2" data-validation-engine="validate[required]">
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.call_number3" data-validation-engine="validate[required]">
                  </td>
                </tr>
              </table>
            </div>
            
            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <div style="overflow-y: auto;">
                <table class="table table-bordered center">
                  <tr>
                    <th colspan="4" class="text-center"> USMARC FIELDS </th>
                  </tr>
                  <tr>
                    <td class="text-left"> TITLE </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.title">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> AUTHOR </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.author">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> REMAINDER OF TITLE </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.remainder_title">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> STATEMENT OF RESPONSIBILITY </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.statement_responsibility">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> PERSONAL NAME </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.personal_name">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> TOPICAL TERM OR GEOGRAPHIC NAME AS ENTRY ELEMENT </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.topical_term1">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> TOPICAL TERM OR GEOGRAPHIC NAME AS ENTRY ELEMENT 2 </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.topical_term2">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> TOPICAL TERM OR GEOGRAPHIC NAME AS ENTRY ELEMENT 3 </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.topical_term3">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> TOPICAL TERM OR GEOGRAPHIC NAME AS ENTRY ELEMENT 4 </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.topical_term4">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> TOPICAL TERM OR GEOGRAPHIC NAME AS ENTRY ELEMENT 5 </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.topical_term5">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> EDITION STATEMENT </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.edition_statement">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> LC CONTROL NUMBER </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.lc_control_number">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> INTERNATIONAL STANDARD BOOK NUMBER </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.isbn">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> LIBRARY OF CONGRESS CALL NUMBER (CLASSIFICATION NUMBER) </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.library_of_congress1">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> LIBRARY OF CONGRESS CALL NUMBER (ITEM NUMBER) </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.library_of_congress2">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> DEWEY DECIMAL CLASSIFICATION NUMBER (CLASSIFICATION NUMBER) </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.dewey_decimal1">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> DEWEY DECIMAL CLASSIFICATION NUMBER (EDITION NUMBER) </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.dewey_decimal2">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> PLACE OF PUBLICATION, DISTRIBUTION, ETC. </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.place_of_publication">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> NAME OF PUBLISHER, DISTRIBUTOR, ETC. </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.name_of_publisher">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> DATE OF PUBLICATION, DISTRIBUTOR, ETC. </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control datepicker" ng-model="data.Bibliography.date_of_publication">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> SUMMARY, ETC. NOTE </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.summary">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> PHYSICAL DESCRIPTION (EXTENT) </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.physical_description1">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> PHYSICAL DESCRIPTION (OTHER PHYSICAL DETAILS) </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.physical_description2">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> PHYSICAL DESCRIPTION (DIMENSIONS) </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.physical_description3">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> PHYSICAL DESCRIPTION (ACCOMPANYING MATERIAL) </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.physical_description4">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> TERMS OF AVAILABILITY </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.terms_of_availability">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> COPYRIGHT </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" ng-model="data.Bibliography.copyright">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"> PURCHASE PRICE </td>
                    <td class="text-left">
                      <input type="text" autocomplete="false" class="form-control" decimal ng-model="data.Bibliography.purchase_price">
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            
          </div>
        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $this->element('modals/search/searched-student-modal') ?>
<?php echo $this->element('modals/search/searched-employee-modal') ?>
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>