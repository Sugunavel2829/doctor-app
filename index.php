<?php
session_start();
include_once './assets/config/config.php';
//$request=$_POST['signin'];
if(isset($_POST['apply'])=='Sign In'){
  $username=trim(mysqli_real_escape_string($conn,$_POST['signinname']));
  $pass=trim(mysqli_real_escape_string($conn,$_POST['signinpassword']));
  
  $sql="SELECT * FROM login WHERE username='".$username."' AND pass='".$pass."'";
  $result=mysqli_query($conn,$sql);
  $fet_obj=mysqli_fetch_object($result);
  $numrows=mysqli_num_rows($result);
  if($numrows>0){
     
    $_SESSION['AUTH_ID']=$fet_obj->id;
    $_SESSION['AUTH_NAME']=$fet_obj->username;
    $_SESSION['AUTH_TYPE']=$fet_obj->type;
    echo '
      <script>
        alert("Login Success");
        window.location.href="doctor.php";
      </script>
    ';
  }else{
    unset($_SESSION['AUTH_ID']);
    unset($_SESSION['AUTH_NAME']);
    unset($_SESSION['AUTH_TYPE']);
    echo '
      <script>
        alert("Invalid Login detais");
        window.location.href="index.php";
      </script>
    ';
  }
}else{
    session_destroy();
unset($_SESSION['AUTH_ID']);
    unset($_SESSION['AUTH_NAME']);
    unset($_SESSION['AUTH_TYPE']);
?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="./assets/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="css/form-style-z.css" type="text/css">
  
  <title>Doctor Appointment System</title>

</head>

<body style="background: url(https://images.pexels.com/photos/1558732/pexels-photo-1558732.jpeg) no-repeat center center; background-size:cover cover; height:100vh;">
  <div class="overlay"></div>
  <div class="container">
    <div class="mt-2 mb-4">
      <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 ml-auto mr-auto">
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-signin" role="tabpanel" aria-labelledby="pills-signin-tab">
            <div class="col-sm-12 border border-primary shadow rounded bg-white pt-2">
              <div class="text-center"><label align="center" ><b>Doctors Only<b></label></div>
              <em id="signInMsg"></em>
              <form method="post" id="singninFrom" onSubmit="return true;">

                <div class="form-group">
                  <label class="font-weight-bold">Login Name <span class="text-danger">*</span></label>
                  <input type="text" name="signinname" id="signinname" class="form-control form-control-lg" autocomplete="off" placeholder="user name" required>
                </div>
                <div class="form-group">
                  <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="password" name="signinpassword" id="signinpassword" class="form-control form-control-lg" autocomplete="off" placeholder="***********" required>
                    <div class="input-group-append" data-toggle="tooltip" title="Forgot Password?" data-placement="left">
                      <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#forgotPass"><i class="fa fa-fw fa-key"></i></button>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" name="apply" id="" value="Sign In" class="btn btn-block btn-primary"><i class="fa fa-fw fa-sign-in-alt"></i> Sign In</button><br>
                  <a href="./doctor.php"><button type="button" class="btn btn-block btn-primary"><i class="fa fa-fw fa-sign-in-alt"></i> Patients Book Appointment</button></a>
                </div>
              </form>
            </div>
          </div>
           
        </div>
      </div> <!--/.col-xs-12 col-sm-8 col-md-6 col-lg-4-->
      
      
    </div> <!--/.mt-2 mb-4-->
  </div> <!--/.container-->
  
  <!-- Optional JavaScript --> 
  <!-- jQuery first, then Popper.js, then Bootstrap JS --> 
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> 
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="js/form-script.js"></script>
</body>
</html>
<?php
 }