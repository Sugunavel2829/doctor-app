<?php 
include_once './assets/config/config.php';
$docId=$_GET['docId'];
$from_date=$_GET['fromdate'];
$to_date=$_GET['todate'];
$docname=$_GET['docname'];
$from_time=$_GET['from_time'];
$to_time=$_GET['to_time'];

$from_date = date("d-m-Y",strtotime($from_date));
$to_date = date("d-m-Y",strtotime($to_date));
$from_time=date("h:i A", strtotime($from_time));
$to_time = date("h:i A",strtotime($to_time));
//$slot=10;

 $start_time = strtotime($from_time);
$end_time = strtotime($to_time);
$slot = strtotime(date('Y-m-d H:i',$start_time) . ' +30 minutes');
$data = [];
for ($i=0; $slot <= $end_time; $i++) { 
    $data[$i] = [ 
        'start' => date('H:i', $start_time),
        'end' => date('H:i', $slot),
    ];
    $start_time = $slot;
    $slot = strtotime(date('H:i',$start_time) . ' +30 minutes');
}

?>
<title> Doctor Schedule Appointment</title>
<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
<script src="./assets/js/jquery.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<script src="./assets/js/all.js" data-auto-replace-svg="nest"></script>
<script src="./assets/js/main.js"></script>
<script src="./assets/js/jquery.dataTables.min.js"></script>
<script src="./assets/js/dataTables.bootstrap.min.js"></script>        
<script src="./assets/js/jquery.ui.datepicker.js"></script>        

<link rel="stylesheet" href="./assets/css/dataTables.bootstrap.min.css" />

<div class="container contact"> 
    <h2>Doctor Schedule Appointment</h2>    
    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">        
       
     <div class="col-md-9 col-sm-9  user-wrapper">
            <div class="description">                                
                <div class="panel panel-default">
                    <div class="panel-body">
                        
                        
                        <form class="form" role="form" method="POST" accept-charset="UTF-8">
                                <div class="panel panel-default">
                            <div class="panel-heading">Appointment Information</div>
                                <div class="panel-body">
                                    <div class="col-lg-6">
                                    Doctor Name : <input type="text" name="doc_name" id="doc_name" required readonly class="form-control" value="<?php echo $docname;?>"><br>
                                    Date: <input type="text" name="date" id="date" required readonly class="form-control" value="<?php echo $from_date;?> To <?php echo $to_date;?>"><br>
                                    Time: <input type="text" name="time" id="time" required readonly class="form-control" value="<?php echo $from_time;?> To <?php echo $to_time;?>"><br>
                                </div>
                            </div>
                            </div>
                             <div class="panel panel-default">
                                <div class="panel-heading">Patient Information</div>
                                <div class="panel-body">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="recipient-name" class="control-label">Patient Name:</label>
                                        <input type="text" class="form-control" name="pat_name" required id="pat_name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="recipient-name" class="control-label">Contact Number:</label>
                                      <input type="number" name="pat_mobile" id="pat_mobile" min="6666666666" max="9999999999" required class="form-control">
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="recipient-name" class="control-label">Email:</label>
                                     <input type="email" name="pat_email" id="pat_email" required class="form-control">
                                     </div>
                                     </div>                                                
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Symptom:</label>
                                <input type="text" class="form-control" name="symptom" id="symptom" required="">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Comment:</label>
                                <textarea class="form-control" name="comment" id="comment"  required=""></textarea>
                            </div>
                            <?php 
                                foreach ($data as $key => $value) {
                                    $start_time=date("H:i", strtotime($value['start']));
                                    $end_time = date("H:i",strtotime($value['end']));
                                    $start_times = date("h:i A",strtotime($value['start']));
                                    $end_times = date("h:i A",strtotime($value['end']));
                                    $curtime=date('H:i');

                                    global $conn;
                                    $sql1="SELECT * FROM appointment WHERE appdate='".$from_date."' AND doc_name='".$docname."'";
                                    $result1=mysqli_query($conn,$sql1);                                    
                                    foreach ($result1 as $key => $value) {
                                        $bookftime=$value['from_time'];
                                        $bookttime=$value['to_time'];
                                         $type="";
                                        if(($curtime>=$start_time) && $bookftime==$start_time){
                                            $start_times='Booked '.$start_times;
                                            $type="Booked";
                                            $end_times=$end_times;
                                            $cls = 'btn-danger';
                                            $dis = 'disabled'; 
                                            $clk = '';
                                        }else if(($curtime>$end_time) && ($bookftime!=$start_time && $bookttime!=$end_time)){
                                             
                                                $cls = 'btn-primary';
                                                $type='';
                                                $dis = 'disabled';
                                                $clk = '';
                                             
                                        }else{
                                            $cls = 'btn-success';
                                            $dis = '';
                                            $type='';
                                            $clk = 'onclick="makeAppoinment(\''.$docname.'\',\''.$start_time.'\',\''.$end_time.'\',\''.$from_date.'\',1);"';
                                        }
                                         
                                    }
                                ?>
                                <div class="col-lg-4">

                                    <div class="form-group">
                                        <input type="sumit" name="appointment" id="submit" class="btn <?php echo $cls;?> <?php echo $dis; ?>" value="<?php echo $start_times;?> - <?php echo $end_times;?>" required readonly <?php echo $clk;?>>
                                        <!-- <?php echo $clk;?> -->
                                    </div>
                                </div>
                        <?php
                            }
                        ?>
                           
                            <!-- <div class="form-group">
                                <input type="submit" name="appointment" id="submit" class="btn btn-primary" value="Make Appointment">
                            </div> -->
                        </div>
                        </form>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
   
</div>  
<script>
    function makeAppoinment(docname,start_time,end_time,date){
        var pat_name=$("#pat_name").val();
        var pat_mobile=$("#pat_mobile").val();
        var pat_email=$("#pat_email").val();
        var symptom=$("#symptom").val();
        var comment=$("#comment").val();
        
        if(pat_name==''){
            $("#pat_name").focus();
        }else if(pat_mobile==''){
            $("#pat_mobile").focus();
        }else if(pat_email==''){
            $("#pat_email").focus();
        }else if(symptom==''){
            $("#symptom").focus();
        }else if(comment==''){
            $("#comment").focus();
        }else{
            var data={docname:docname,start_time:start_time,end_time:end_time,date:date,pat_name:pat_name,pat_mobile:pat_mobile,pat_email:pat_email,symptom:symptom,comment:comment}
             $.ajax({
                url:"action.php?request=AppointmentInsert",
                data : data,
                type : 'post',
                success:function(data){ 
                    if(data.trim()=='insert'){
                        alert("Doctor Appointment Booked");
                        window.location.href="appointmentlist.php";
                    }else{
                        alert("Please Try again later");
                        window.location.href="doctor.php";
                    }           
                }
            })
        }
    }
</script>