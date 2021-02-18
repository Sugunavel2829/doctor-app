<?php 
include_once './assets/config/config.php';
date_default_timezone_set("Asia/Kolkata");
session_start();
?>
<title> Doctor Schedule</title>
<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
<script src="./assets/js/jquery.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<script src="./assets/js/all.js" data-auto-replace-svg="nest"></script>

<script src="./assets/js/main.js"></script>

<script src="./assets/js/jquery.dataTables.min.js"></script>
<script src="./assets/js/dataTables.bootstrap.min.js"></script>        
 
<link rel="stylesheet" href="./assets/css/dataTables.bootstrap.min.css" />

<div class="container contact"> 
    <h2>Doctor Schedule </h2>    
    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">        
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="panel-title"></h3>
                </div>
               <?php
               if(isset($_SESSION['AUTH_TYPE'])=='Doctor'){
                ?>
                <div class="col-md-2" align="right">
                    <a href="./appointmentlist.php"><button type="button" name="add" id=""  class="btn btn-primary">Appointment List</button></a>
                </div>
                <div class="col-md-2" align="right">
                    <button type="button" name="add" id="addRecord" onclick="addDoctor(1);" class="btn btn-success">Add Doctor</button>
                </div>
                <div class="col-md-2" align="right">
                    <a href="./assets/config/logout.php"><button type="button" name="add" id=""  class="btn btn-info">Log Out</button></a>
                </div>
                <?php
               } 
                ?>
            </div>
        </div>
     <table id="recordListing" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>                   
                    <th>qualification</th>                    
                    <th>location</th>
                    <th>From date</th>
                    <th>To date</th>
                    <th>From Time</th>
                    <th>To Time</th>
                   <th>Availability</th>                                     
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM doctor_schedule ORDER BY id DESC";
                $result=mysqli_query($conn,$sql);
                $numrows = mysqli_num_rows($result);
                $sno=1;
                if($numrows){
                    $curdate=date('Y-m-d');
                    $curtime=date('H:i');
                   //print_r($curtime);
                    foreach ($result as $key => $value) {
                        $from_date = date("d-m-Y",strtotime($value['from_date']));
                        $to_date = date("d-m-Y",strtotime($value['to_date']));
                        $from_time=date("h:i A", strtotime($value['from_time']));
                        $to_time = date("h:i A",strtotime($value['to_time']));
                    ?>
                    <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['quali']; ?></td>
                        <td><?php echo $value['location']; ?></td>
                        <td><?php echo $from_date; ?></td>
                        <td><?php echo $to_date; ?></td>
                        <td><?php echo $from_time; ?></td>
                        <td><?php echo $to_time;?></td>
                        <td>
                            <?php if($curtime<$value['to_time']){
                                ?>
                            <a href="scheduleList.php?docId=<?php echo $value['id']; ?>&fromdate=<?php echo $value['from_date']; ?>&todate=<?php echo $value['to_date']; ?>&docname=<?php echo $value['name']; ?>&from_time=<?php echo $value['from_time']; ?>&to_time=<?php echo $value['to_time']; ?>">
                            <button type="button" name="update" id="<?php echo $value['id']; ?>" class="btn btn-warning btn-xs update">Book Now</button></a>

                            <?php 
                        }else{?>
                            <button type="button" class="btn btn-danger btn-xs" style="cursor:none;">Not Available</button>
                        <?php } ?>
                    </td>
                        
                    </tr>
                    <?php
                    $sno++;
                    } 
                }else{
                ?>
                <tr>
                    <td colspan="5">No Records Found</td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table> 
    </div>
    <div id="recordModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="recordForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Doctor</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>          
                        </div>
                        <div class="form-group">
                            <label class="control-label">Qualification</label>                          
                            <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Qualification">                            
                        </div>      
                        <div class="form-group">
                            <label class="control-label">Doctor Image</label>                          
                            <input type="file" class="form-control"  id="image" name="image" required>                           
                        </div>   
                        
                        <div class="form-group">
                            <label class="control-label">Location</label>                         
                            <input type="text" class="form-control" id="location" name="location" placeholder="Location">          
                        </div>   
                        <div class="form-group">
                            <label class="control-label">From Date</label>                         
                            <input autocomplete="off" type="date" class="form-control" name="fromDate" id="fromDate" >       
                        </div> 
                        <div class="form-group">
                            <label class="control-label">From Time</label>                         
                            <input autocomplete="off" type="time" class="form-control dateTime"  name="fromTime" id="fromTime" >       
                        </div>     
                        <div class="form-group">
                            <label class="control-label">To Date</label>                         
                            <input autocomplete="off" type="date" class="form-control"  name="toDate" id="toDate" >       
                        </div>  
                        
                        <div class="form-group">
                            <label class="control-label">To Time</label>                         
                            <input autocomplete="off" type="time" class="form-control dateTime"  name="toTime" id="toTime" >       
                        </div>                      
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id" />
                        <input type="hidden" name="action" id="action" value="" />
                        <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
 
<script>
$(document).ready(function() {
      $('#recordListing').DataTable( 
          {
             dom: 'Bfrtip',
                buttons: [
                    'print',
                {
                    extend: 'excelHtml5',
                     title: 'Employee Report'
                },
                
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: 'Employee Report'
                },
               
            ]
    });

});
    function addDoctor(){
        $('#recordModal').modal('show');
        $('#recordForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i>  Add Doctor");
        $('#action').val('addRecord');
        $('#save').val('Add');
    };  

    $("#recordModal").on('submit','#recordForm', function(event){
        event.preventDefault();
        $('#save').attr('disabled','disabled');
        var data = new FormData($('#recordForm')[0]);
            $.each($("input[type=file]"), function(i, obj) {
                var name = $(this).attr('id');
                $.each(obj.files,function(j,file){
                    data.append('files['+name+']', file);
                })
            });                 
        $.ajax({
            url:"action.php?request=DoctorInsert",
            data : data,
            type : 'post',
            cache: false,
            processData: false,
            contentType: false,
            success:function(data){ 
                if(data.trim()=='insert'){
                    alert("Doctor Added Successfully");
                    $('#recordForm')[0].reset();
                    $('#recordModal').modal('hide');                
                    $('#save').attr('disabled', false);
                    window.location.href="doctor.php";
                }else{
                    alert("Please try again later");
                }           
            }
        })
    });

    
</script>