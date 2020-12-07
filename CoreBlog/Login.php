<?php require_once("Includes/Db.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if(isset($_SESSION["UserId"])){
  Redirect_to("Dashboard.php");
}

if (isset($_POST["Submit"])) {
  $UserName = $_POST["Username"];
  $Password = $_POST["Password"];
  if (empty($UserName)||empty($Password)) {
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("Login.php");
  }else {
    // code for checking username and password from Database
    $Found_Account=Login_Attempt($UserName,$Password);
    if ($Found_Account) {
      $_SESSION["UserId"]=$Found_Account["id"];
      $_SESSION["UserName"]=$Found_Account["username"];
      $_SESSION["AdminName"]=$Found_Account["aname"];
      $_SESSION["SuccessMessage"]= "Welcome ".$_SESSION["UserName"]."!";
      if (isset($_SESSION["TrackingURL"])) {
        Redirect_to($_SESSION["TrackingURL"]);
      }else{
      Redirect_to("Dashboard.php");
    }
    }else {
      $_SESSION["ErrorMessage"]="Incorrect Username/Password";
      Redirect_to("Login.php");
    }
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://kit.fontawesome.com/670e962b43.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="Css/Style.css">
    <link rel="stylesheet" href="Css/Login.css">
  <title>Login</title>
</head>
<body>

    <!-- Main Area Start -->
    <section class="container py-2 mb-4">
    <div class="row">
      <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
        <br><br><br><br>
        <?php
         echo ErrorMessage();
         echo SuccessMessage();
         ?>
        <div class="card bg-primary text-light">
          <div class="card-header">
            <h4>Login Form</h4>
            </div>
            <div class="card-body bg-light">
            <form class="" action="Login.php" method="post">
              <div class="form-group">
                <label for="username"><span class="FieldInfo">Username:</span></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-white bg-primary"> <i class="fas fa-user"></i> </span>
                  </div>
                  <input type="text" class="form-control" name="Username" id="username" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="password"><span class="FieldInfo">Password:</span></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-white bg-primary"> <i class="fas fa-lock"></i> </span>
                  </div>
                  <input type="password" class="form-control" name="Password" id="password" value="">
                </div>
              </div>
              <input type="submit" name="Submit" class="btn btn-primary btn-block" value="Login">
            </form>

          </div>

        </div>

      </div>

    </div>

  </section>
    <!-- Main Area End -->


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
  $('#year').text(new Date().getFullYear());
</script>
</body>
</html>
