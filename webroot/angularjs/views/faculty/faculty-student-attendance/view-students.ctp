<?php if (hasAccess('course/index', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">HANDLED STUDENTS ON {{courses.code}}</h4>
        <div class="clearfix"></div><hr>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
              <button type="button" class="btn btn-warning btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
            </div>

            <div class="col-md-4 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
              <h4><strong>{{ month }} {{ year }}</strong></h4>
            </div>
            <div class="col-md-4 col-xs-12 pull-right">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search" ng-enter="searchy(searchTxt)" placeholder="SEARCH HERE" ng-model="searchTxt">
              </div>
              <sup style="font-color:gray">Press Enter to search</sup> 
            </div>
          </div>
        </div>
        <div class="clearfix"></div><hr>
        <div class="single-table mb-5">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr class="bg-info">
                  <th class="w10px" style="width: 50px" rowspan="2">NO.</th>
                  <th rowspan="2" style="white-space: nowrap;">STUDENT NAME</th>
                  <th ng-repeat="head in header">{{head.dayName}}</th>
                  <!-- <th class="w90px"></th> -->
                </tr>
                <tr class="bg-info">
                  <th ng-repeat="head in header">{{$index+1}}</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="data in students">
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td class="text-center" style="white-space: nowrap;">{{ data.last_name }}, {{data.first_name}} {{data.middle_name}}</td>
                  <td ng-repeat="head in header">
                    <div class="btn-group btn-group-xs" ng-show="head.dayName != 'Sat' && head.dayName != 'Sun'">
                      <?php if (hasAccess('course/view', $currentUser)): ?>
                        <span ng-show="attendances[$index].student_id == data.id && attendances[$index].date == $index+1"><i class="fa fa-check"></i></span>
                        <a href="javascript:void(0)" ng-click="attendance(data.id)" class="btn btn-print" style="color:white !important;" title="ABSENT/EXCUSED"><i class="fa fa-user-plus"></i></a>
                      <?php endif ?> 
                    </div>
                  </td> 
                </tr>
                <tr ng-show="students == null || students == ''">
                  <td colspan="4">No available data</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12">
            <ul class="pagination justify-content-center">
              <li class="page-item">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt })"><sub>&laquo;&laquo;</sub></a>
              </li>
              <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page - 1, search: searchTxt })">&laquo;</a>
              </li>
              <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt })">{{ page.number }}</a>
              </li>
              <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page + 1, search: searchTxt })">&raquo;</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub> </a>
              </li>
            </ul>
            <div class="clearfix"></div>
            <div class="text-center" ng-show="paginator.pageCount > 0">
              <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="add-attendance" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ADD STUDENT ATTENDANCE</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group">
            <label> STATUS  <i class="required">*</i></label>
            <select class="form-control" ng-model="attendanceData.status" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
              <option></option>
              <option value="absent">ABSENT</option>
              <option value="excused">EXCUSED</option>
              <option value="present">PRESENT</option>
            </select>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label> DATE <i class="required">*</i></label>
            <input type="text" class="form-control datepicker" autocomplete="false" ng-model="attendanceData.date" data-validation-engine="validate[required]">
          </div>
        </div>
        <div class="col-md-12" ng-show="attendanceData.status == 'absent' || attendanceData.status == 'excused'">
          <center>
            <ul class="list-group">
              <span class="btn btn-primary btn-min btn-file">
                <i class="fa fa-upload"></i> UPLOAD FILE
                <input ng-file-model="files" id="applicationImage" multiple="multiple" name="picture" class="form-control" type="file">
              </span>
            </ul>
          </center>
        </div>
        <div class="clearfix"></div>
        <div id="upload_prev"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveFile(files,attendanceData)">ADD</button>
      </div>
    </div>
  </div>
</div>
<style>

  a.mydata {
     --c:linear-gradient(#000 0 0); /* update the color here */
  
    padding-bottom: .15em;
    background: var(--c), var(--c);
    background-size: .3em .1em;
    background-position:50% 100%;
    background-repeat: no-repeat;
    transition: .3s linear, background-size .3s .2s linear;    
  }
  a.mydata:hover {
    color: #8cc0f5 !important;
    background-size: 45% .1em;
    background-position: 0% 100%, 100% 100%;    
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
    width:100%;  
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
    font-size:14px;
  }

  p.close {
    cursor: pointer;
  }
</style>
<script>

  $(document).on('click','#close',function(){

    $(this).parents('span').remove();

  })

  document.getElementById('applicationImage').onchange = uploadOnChange;
  function uploadOnChange() {
    // document.getElementById("uploadFile").value = this.value;
    var filename = this.value;
    var lastIndex = filename.lastIndexOf("\\");
    if (lastIndex >= 0) {
        filename = filename.substring(lastIndex + 1);
    }
    var files = $('#applicationImage')[0].files;
    for (var i = 0; i < files.length; i++) {
      $("#upload_prev").append('<span><u>'+'<div class="filenameupload">'+files[i].name+'</u></div>'+'<p id = "close" class="btn btn-danger xbutton fa fa-times" style "background-color :red !important"></p></span>');
    }
}
</script>
<style>
  .imagewrap {display:inline-block;position:relative;}
</style>
<?php endif ?>
