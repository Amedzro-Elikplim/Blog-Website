<?php require_once("Includes/Db.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login(); ?>
<?php
if(isset($_POST["Submit"])){
  $UserName        = $_POST["Username"];
  $Name            = $_POST["Name"];
  $Password        = $_POST["Password"];
  $ConfirmPassword = $_POST["ConfirmPassword"];
  $Admin           =   $_SESSION["UserName"];


  if(empty($UserName)||empty($Password)||empty($ConfirmPassword)){
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("Admins.php");
  }elseif (strlen($Password)<4) {
    $_SESSION["ErrorMessage"]= "Password should be greater than 3 characters";
    Redirect_to("Admins.php");
  }elseif ($Password !== $ConfirmPassword) {
    $_SESSION["ErrorMessage"]= "Password and Confirm Password should match";
    Redirect_to("Admins.php");
  }elseif (CheckUserNameExistsOrNot($UserName)) {
    $_SESSION["ErrorMessage"]= "Username Exists. Try Another One! ";
    Redirect_to("Admins.php");
  }else{
    // Query to insert new admin in DB When everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO admins(datetime,username,password,aname,addedby)";
    $sql .= "VALUES(:dateTime,:userName,:password,:aName,:adminName)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':userName',$UserName);
    $stmt->bindValue('password',$Password);
    $stmt->bindValue(':aName',$Name);
    $stmt->bindValue(':adminName',$Admin);
    $Execute=$stmt->execute();
    if($Execute){
      $_SESSION["SuccessMessage"]="New Admin with the name of ".$Name." added Successfully";
      Redirect_to("Admins.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("admins.php");
    }
  }
} //Ending of Submit Button If-Condition
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
  <title>Admin Page</title>
</head>
<body>
  <!-- NAVBAR -->

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a href="#" class="navbar-brand"> DENYUNGGH.COM</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a href="MyProfile.php" class="nav-link">  My Profile</a>
        </li>
        <li class="nav-item">
          <a href="Dashboard.php" class="nav-link">Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="Post.php" class="nav-link">Posts</a>
        </li>
        <li class="nav-item">
          <a href="Categories.php" class="nav-link">Categories</a>
        </li>
        <li class="nav-item">
          <a href="Admins.php" class="nav-link">Manage Admins</a>
        </li>
        <li class="nav-item">
          <a href="Comments.php" class="nav-link">Comments</a>
        </li>
        <li class="nav-item">
          <a href="Blog.php?page=1" class="nav-link" target="_blank">Live Blog</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="Logout.php" class="nav-link">
           Logout</a></li>
      </ul>
      </div>
    </div>
  </nav>

    <!-- NAVBAR END -->
    <!-- HEADER -->
    <header class="bg-primary text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          <h1><i class="fas fa-user"></i> Manage Admins</h1>
          </div>
        </div>
      </div>
    </header>
    <!-- HEADER END -->

     <!-- Main Area -->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
        <?php
         echo ErrorMessage();
         echo SuccessMessage();
         ?>
        <form class="" action="Admins.php" method="post">
          <div class="card mb-3">
            <div class="card-header">
              <h1>Add New Admin</h1>
            </div>
            <div class="card-body bg-light">
              <div class="form-group">
                <label for="username"> <span class="FieldInfo"> Username: </span></label>
                 <input class="form-control" type="text" name="Username" id="username"  value="">
              </div>
              <div class="form-group">
                <label for="Name"> <span class="FieldInfo"> Name: </span></label>
                 <input class="form-control" type="text" name="Name" id="Name" value="">
                 <small class="text-muted">*Optional</small>
              </div>
              <div class="form-group">
                <label for="Password"> <span class="FieldInfo"> Password: </span></label>
                 <input class="form-control" type="password" name="Password" id="Password" value="">
              </div>
              <div class="form-group">
                <label for="ConfirmPassword"> <span class="FieldInfo"> Confirm Password:</span></label>
                 <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword"  value="">
              </div>
              <div class="row">
                <div class="col-lg-6 mb-2">
                  <a href="Dashboard.php" class="btn btn-primary btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                </div>
                <div class="col-lg-6 mb-2">
                  <button type="submit" name="Submit" class="btn btn-primary btn-block">
                    <i class="fas fa-check"></i> Publish
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <h2>Existing Admins</h2>
    <table class="table table-striped table-hover">
      <thead class="thead-light">
        <tr>
          <th>No. </th>
          <th>Date&Time</th>
          <th>Username</th>
          <th>Admin Name</th>
          <th>Added by</th>
          <th>Action</th>
        </tr>
      </thead>
    <?php
    global $ConnectingDB;
    $sql = "SELECT * FROM admins ORDER BY id desc";
    $Execute =$ConnectingDB->query($sql);
    $SrNo = 0;
    while ($DataRows=$Execute->fetch()) {
      $AdminId = $DataRows["id"];
      $DateTime = $DataRows["datetime"];
      $AdminUsername = $DataRows["username"];
      $AdminName= $DataRows["aname"];
      $AddedBy = $DataRows["addedby"];
      $SrNo++;
    ?>
    <tbody>
      <tr>
        <td><?php echo htmlentities($SrNo); ?></td>
        <td><?php echo htmlentities($DateTime); ?></td>
        <td><?php echo htmlentities($AdminUsername); ?></td>
        <td><?php echo htmlentities($AdminName); ?></td>
        <td><?php echo htmlentities($AddedBy); ?></td>
        <td> <a href="DeleteAdmin.php?id=<?php echo $AdminId;?>" class="btn btn-primary">Delete</a>  </td>

    </tbody>
    <?php } ?>
    </table>

      </div>

    </div>

  </section>





  <!-- Main Area End -->
    <!-- FOOTER -->
    <footer class="bg-primary text-white">
      <div class="container">
        <div class="row">
          <div class="col">
          <p class="lead text-center">Theme By | Dennis Abayateye | <span id="year"></span> &copy; ----All right Reserved.</p>
           </div>
         </div>
      </div>
    </footer>

    <!-- FOOTER END-->

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
  $('#year').text(new Date().getFullYear());
</script>
</body>
</html>
