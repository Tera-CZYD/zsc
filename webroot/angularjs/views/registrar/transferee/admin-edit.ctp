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
  handleAccess('pageEdit', 'transferee/edit', currentUser);

</script>

<div class="row" id="pageEdit">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT SCHOOL TRANSFER REQUEST</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label> SERIAL NUMBER <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Transferee.serial_number" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> TYPE <i class="required">*</i></label>
                <select class="form-control" autocomplete="false" disabled ng-model="data.Transferee.type" ng-change="clearData()" data-validation-engine="validate[required]">
                  <option value=""></option>
                  <option value="Transfer In">Transfer In</option>
                  <option value="Transfer Out">Transfer Out</option>
                </select>
              </div>
            </div>
            <div class="col-md-12" ng-show="data.Transferee.type != 'Transfer Out'">
              <div class="form-group">
                <label> STUDENT NO. <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Transferee.student_no" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12" ng-show="data.Transferee.type != 'Transfer Out'">
              <div class="form-group">
                <label> FIRST NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Transferee.first_name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12" ng-show="data.Transferee.type != 'Transfer Out'">
              <div class="form-group">
                <label> MIDDLE NAME </label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Transferee.middle_name">
              </div>
            </div>
            <div class="col-md-12" ng-show="data.Transferee.type != 'Transfer Out'">
              <div class="form-group">
                <label> LAST NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Transferee.last_name" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6" ng-show="data.Transferee.type == 'Transfer Out'">
              <div class="form-group">
                <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchStudent({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6" ng-show="data.Transferee.type == 'Transfer Out'">
              <div class="form-group">
                <label> STUDENT <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.Transferee.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.Transferee.student_name }}</td>
                    <td style="{{ data.Transferee.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.Transferee.student_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.Transferee.student_name = null; data.Transferee.student_id = null;" ng-init="data.Transferee.student_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label> YEAR TERM </label>
                <select selectize ng-model="data.Transferee.year_term_id" ng-options="opt.id as opt.value for opt in year_terms">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> College </label>
                <select selectize ng-model="data.Transferee.college_id" ng-change="getProgram(data.Transferee.college_id)" ng-options="opt.id as opt.value for opt in colleges">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> PROGRAM </label>
                <select selectize ng-model="data.Transferee.program_id" ng-options="opt.id as opt.value for opt in programs">
                  <option value=""></option>
                </select>
              </div>
            </div>


            <div class="col-md-6">
              <div class="form-group">
                <label> EMAIL <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Transferee.email" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> CONTACT NO. <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Transferee.contact_no" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> ADDRESS <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Transferee.address" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> GENDER <i class="required">*</i></label>
                <select class="form-control" ng-model="data.Transferee.gender" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> APPLICATION DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.Transferee.date" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
            <div class="col-md-12 mb-2">
              <button class="btn btn-primary btn-min btn-file" ng-click="addImage()"><i class="fa fa-upload"></i> UPLOAD FILE </button>
            </div>
            <div class="clearfix"></div><hr>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th class = "text-left" colspan="4">UPLOADED FILES</th>
                    </tr>
                    <tr>
                      <th class="w30px text-center">#</th>
                      <th class="text-center">FILE NAME</th>
                      <th class="text-center" style="width: 100px"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="data in transfereeImage">
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="uppercase text-left"> <a href="{{ data.imageSrc }}">{{ data.name }}</a></td>
                      <td class="uppercase text-center">
                        <button class="btn btn-danger modal-form no-border-radius" ng-click="removeImage($index,data)"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                    <tr ng-if = "transfereeImage == ''">
                      <td class="text-center" colspan="3">No data available . . .</td>
                    </tr>
                  </tbody>
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

<div class="modal fade" id="searched-student-modal">
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
                  <th class="text-center">STUDENT NUMBER</th>
                  <th class="text-center">NAME</th>
                  <th class="w30px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="student in students">
                  <td>{{ (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
                  <td class="uppercase text-center">{{ student.code }}</td>
                  <td class="uppercase text-center">{{ student.name }}</td>
                  <td>
                    <input icheck type="radio" ng-init="student.selected = false" ng-model="student.selected" name="iCheck" ng-selected="student.selected = true" ng-change="selectedStudent(student)">
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
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="studentData(employee.id)" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
        </div> 
        
      </div>
    </div>  
  </div><!-- /.modal-content -->
</div>

<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>

<style type="text/css">
  .myRadio{
    height:20px; 
    width:20px;
  }
</style>

<style>

 .fileUpload {
  position: relative;
    overflow: hidden;
    margin: 10px 3px;
  }
  .fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    background-color:#fff;
    filter: alpha(opacity=0);
  }

  .filenameupload {
    width:50%;  
    overflow-y:auto;
  }

  #upload_prev {
    font-size: 
    width: 50%;
    padding:0.5em 1em 1.5em 1em;
  }

  #upload_prev span {
    display: flex;
    padding: 0 5px;
    font-size:13px;
  }

  p.close {
    cursor: pointer;
  }

</style>

<script>
  $(document).on('click','#close',function(){
    $(this).parents('span').remove();

  })

  document.getElementById('transfereeImage').onchange = uploadOnChange;

  function uploadOnChange() {

    var filename = this.value;

    var lastIndex = filename.lastIndexOf("\\");

    if (lastIndex >= 0) {

      filename = filename.substring(lastIndex + 1);

    }

    var files = $('#transfereeImage')[0].files;

    for (var i = 0; i < files.length; i++) {

      $("#upload_prev").append('<span><u>'+'<div class="filenameupload">'+files[i].name+'</u></div>'+'<p id = "close" class="btn btn-danger xbutton fa fa-times" style "background-color :red !important"></p></span>');
    
    }
  }
  
</script>
<style>
  .imagewrap {display:inline-block;position:relative;}
</style>

<div class="modal fade" id="edit-upload-image" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-plus"></i>ADD FILE</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <center>
            <ul class="list-group">
              <span class="btn btn-primary btn-min btn-file">
                <i class="fa fa-upload"></i> UPLOAD FILE
                <input ng-file-model="files" id="transfereeImage" multiple="multiple" name="picture" class="form-control" type="file">
              </span>
            </ul>
          </center>
        </div>
        <div class="clearfix"></div>
        <div id="upload_prev"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveImages(files)">ADD</button>
      </div>
    </div>
  </div>
</div>