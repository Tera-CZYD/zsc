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
                  <th class="text-right"> TYPE OF MATERIAL : </th>
                  <td class="italic">{{ data.MaterialType.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TYPE OF COLLECTION : </th>
                  <td class="italic">{{ data.CollectionType.name }}</td>
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
            <div style="overflow-y: auto;">
              <table class="table table-bordered center">
                <tr>
                  <th colspan="4" class="text-center"> USMARC FIELDS </th>
                </tr>
                <tr>
                  <td class="text-left"> TITLE </td>
                  <td class="text-left">
                    {{ data.Bibliography.title }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> AUTHOR </td>
                  <td class="text-left">
                    {{ data.Bibliography.author }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> REMAINDER OF TITLE </td>
                  <td class="text-left">
                    {{ data.Bibliography.remainder_title }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> STATEMENT OF RESPONSIBILITY </td>
                  <td class="text-left">
                    {{ data.Bibliography.statement_responsibility }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> PERSONAL NAME </td>
                  <td class="text-left">
                    {{ data.Bibliography.personal_name }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> TOPICAL TERM OR GEOGRAPHIC NAME AS ENTRY ELEMENT </td>
                  <td class="text-left">
                    {{ data.Bibliography.topical_term1 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> TOPICAL TERM OR GEOGRAPHIC NAME AS ENTRY ELEMENT 2 </td>
                  <td class="text-left">
                    {{ data.Bibliography.topical_term2 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> TOPICAL TERM OR GEOGRAPHIC NAME AS ENTRY ELEMENT 3 </td>
                  <td class="text-left">
                    {{ data.Bibliography.topical_term3 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> TOPICAL TERM OR GEOGRAPHIC NAME AS ENTRY ELEMENT 4 </td>
                  <td class="text-left">
                    {{ data.Bibliography.topical_term4 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> TOPICAL TERM OR GEOGRAPHIC NAME AS ENTRY ELEMENT 5 </td>
                  <td class="text-left">
                    {{ data.Bibliography.topical_term5 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> EDITION STATEMENT </td>
                  <td class="text-left">
                    {{ data.Bibliography.edition_statement }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> LC CONTROL NUMBER </td>
                  <td class="text-left">
                    {{ data.Bibliography.lc_control_number }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> INTERNATIONAL STANDARD BOOK NUMBER </td>
                  <td class="text-left">
                    {{ data.Bibliography.isbn }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> LIBRARY OF CONGRESS CALL NUMBER (CLASSIFICATION NUMBER) </td>
                  <td class="text-left">
                    {{ data.Bibliography.library_of_congress1 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> LIBRARY OF CONGRESS CALL NUMBER (ITEM NUMBER) </td>
                  <td class="text-left">
                    {{ data.Bibliography.library_of_congress2 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> DEWEY DECIMAL CLASSIFICATION NUMBER (CLASSIFICATION NUMBER) </td>
                  <td class="text-left">
                    {{ data.Bibliography.dewey_decimal1 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> DEWEY DECIMAL CLASSIFICATION NUMBER (EDITION NUMBER) </td>
                  <td class="text-left">
                    {{ data.Bibliography.dewey_decimal2 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> PLACE OF PUBLICATION, DISTRIBUTION, ETC. </td>
                  <td class="text-left">
                    {{ data.Bibliography.place_of_publication }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> NAME OF PUBLISHER, DISTRIBUTOR, ETC. </td>
                  <td class="text-left">
                    {{ data.Bibliography.name_of_publisher }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> DATE OF PUBLICATION, DISTRIBUTOR, ETC. </td>
                  <td class="text-left">
                    {{ data.Bibliography.date_of_publication }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> SUMMARY, ETC. NOTE </td>
                  <td class="text-left">
                    {{ data.Bibliography.summary }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> PHYSICAL DESCRIPTION (EXTENT) </td>
                  <td class="text-left">
                    {{ data.Bibliography.physical_description1 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> PHYSICAL DESCRIPTION (OTHER PHYSICAL DETAILS) </td>
                  <td class="text-left">
                    {{ data.Bibliography.physical_description2 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> PHYSICAL DESCRIPTION (DIMENSIONS) </td>
                  <td class="text-left">
                    {{ data.Bibliography.physical_description3 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> PHYSICAL DESCRIPTION (ACCOMPANYING MATERIAL) </td>
                  <td class="text-left">
                    {{ data.Bibliography.physical_description4 }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> TERMS OF AVAILABILITY </td>
                  <td class="text-left">
                    {{ data.Bibliography.terms_of_availability }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> COPYRIGHT </td>
                  <td class="text-left">
                    {{ data.Bibliography.copyright }}
                  </td>
                </tr>
                <tr>
                  <td class="text-left"> PURCHASE PRICE </td>
                  <td class="text-left">
                    {{ data.Bibliography.purchase_price }}
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <!-- <div class="pull-right">
              
                <a href="#/learning-resource-center/bibliography/edit/{{ data.Bibliography.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              
                <button class="btn btn-danger btn-min" ng-click="remove(data.Bibliography)"><i class="fa fa-trash"></i> DELETE </button>
              
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>
