<?php require_once("Includes/Db.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login(); ?>
 <?php
 // Fetching the existing Admin Data Start
 $AdminId = $_SESSION["UserId"];
 global $ConnectingDB;
 $sql  = "SELECT * FROM admins WHERE id='$AdminId'";
 $stmt =$ConnectingDB->query($sql);
 while ($DataRows = $stmt->fetch()) {
   $ExistingName     = $DataRows['aname'];
   $ExistingUsername = $DataRows['username'];
   $ExistingHeadline = $DataRows['aheadline'];
   $ExistingBio      = $DataRows['abio'];
   $ExistingImage    = $DataRows['aimage'];
 }
 // Fetching the existing Admin Data End
 if(isset($_POST["Submit"])){
   $AName     = $_POST["Name"];
   $AHeadline = $_POST["Headline"];
   $ABio      = $_POST["Bio"];
   $Image     = $_FILES["Image"]["name"];
   $Target    = "Images/".basename($_FILES["Image"]["name"]);
 if (strlen($AHeadline)>100) {
     $_SESSION["ErrorMessage"] = "Headline Should be less than 100 characters";
     Redirect_to("MyProfile.php");
   }elseif (strlen($ABio)>1000) {
     $_SESSION["ErrorMessage"] = "Bio should be less than than 1000 characters";
     Redirect_to("MyProfile.php");
   }else{
     // Query to Update Admin Data in DB When everything is fine
     global $ConnectingDB;
     if (!empty($_FILES["Image"]["name"])) {
       $sql = "UPDATE admins
               SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
               WHERE id='$AdminId'";
     }else {
       $sql = "UPDATE admins
               SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
               WHERE id='$AdminId'";
     }
     $Execute= $ConnectingDB->query($sql);
     move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
     if($Execute){
       $_SESSION["SuccessMessage"]="Details Updated Successfully";
       Redirect_to("MyProfile.php");
     }else {
       $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
       Redirect_to("MyProfile.php");
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
  <title>My Profile</title>
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
          <a href="MyProfile.php" class="nav-link"> <i class="fas fa-user text-success"></i> My Profile</a>
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
          <i class="fas fa-user-times"></i> Logout</a></li>
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
          <h1><i class="fas fa-user mr-2"></i>@<?php echo $ExistingUsername; ?></h1>
            <small><?php echo $ExistingHeadline; ?></small>
          </div>
        </div>
      </div>
    </header>
    <!-- HEADER END -->

     <!-- Main Area -->
<section class="container py-2 mb-4">
  <div class="row">
    <!-- Left Area -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header bg-primary text-light">
          <h3> <?php echo $ExistingName ?></h3>
        </div>
     <div class="card-body">
       <img src="images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">
       <div class="">
         <?php echo $ExistingBio; ?>
       </div>

     </div>
      </div>

    </div>
    <!-- Right Area -->
    <div class="col-md-9" style="min-height:410px;">
      <?php
       echo ErrorMessage();
       echo SuccessMessage();
       ?>
      <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
        <div class="card">
          <div class="card-header bg-primary text-light">
            <h4> Edit Profile </h4>

          </div>
          <div class="card-body">
            <div class="form-group">
               <input class="form-control" type="text" name="Name" id="title"  placeholder="Your name">
            </div>
            <div class="form-group">
               <input class="form-control" type="text"  id="title" placeholder="Headline"  name="Headline">
               <small class="text-muted"> Add a Professional Headline </small>
               <span class="text-primary">Not more than 100 Characters</span>
            </div>

            <div class="form-group">
              <textarea placeholder="Bio" class="form-control" id="Post" name="Bio" rows="8" cols="80"></textarea>

            </div>
            <div class="form-group">
                <label for="imageSelect"> <span class="FieldInfo"> Select Image </span></label>
                <div class="custom-file">
                <input type="File" name="Image" id="imageSelect" value="">
                  </div>
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
