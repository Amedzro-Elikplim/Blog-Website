<?php require_once("Includes/Db.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login(); ?>
<?php
if(isset($_POST["Submit"])){
  $Category = $_POST["CategoryTitle"];
  $Admin =  $_SESSION["UserName"];
  date_default_timezone_set("Africa/Accra");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($Category)){
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("Categories.php");
  }elseif (strlen($Category)<3) {
    $_SESSION["ErrorMessage"]= "Category title should be greater than 2 characters";
    Redirect_to("Categories.php");
  }elseif (strlen($Category)>49) {
    $_SESSION["ErrorMessage"]= "Category title should be less than than 50 characters";
    Redirect_to("Categories.php");
  }else{
    // Query to insert category in DB When everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO category(title,author,datetime)";
    $sql .= "VALUES(:categoryName,:adminName,:dateTime)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':categoryName',$Category);
    $stmt->bindValue(':adminName',$Admin);
    $stmt->bindValue(':dateTime',$DateTime);
    $Execute=$stmt->execute();

    if($Execute){
      $_SESSION["SuccessMessage"]="Category with id : " .$ConnectingDB->lastInsertId()." added Successfully";
      Redirect_to("Categories.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("Categories.php");
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
  <title>Categories</title>
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
          <h1><i class="fas fa-edit"></i> Manage Categories</h1>
          </div>
        </div>
      </div>
    </header>
    <!-- HEADER END -->

     <!-- Main Area -->
<section class="container py-2 mb-4">
  <div class="row">
    <div class="offset-lg-1 col-lg-10" style="min-height:410px;">
      <?php
       echo ErrorMessage();
       echo SuccessMessage();
       ?>
      <form class="" action="Categories.php" method="post">
        <div class="card mb-3">
          <div class="card-header">
            <h1>Add New Category</h1>
          </div>
          <div class="card-body bg-light">
            <div class="form-group">
              <label for="title"> <span class="FieldInfo"> Categroy Title: </span></label>
               <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type title here" value="">
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
      <h2>Existing Categories</h2>
      <table class="table table-striped table-hover">
        <thead class="thead-light">
          <tr>
            <th>No. </th>
            <th>Date&Time</th>
            <th> Category Name</th>
            <th>Creator Name</th>
            <th>Action</th>
          </tr>
        </thead>
      <?php
      global $ConnectingDB;
      $sql = "SELECT * FROM category ORDER BY id desc";
      $Execute =$ConnectingDB->query($sql);
      $SrNo = 0;
      while ($DataRows=$Execute->fetch()) {
        $CategoryId = $DataRows["id"];
        $CategoryDate = $DataRows["datetime"];
        $CategoryName = $DataRows["title"];
        $CreatorName= $DataRows["author"];
        $SrNo++;
      ?>
      <tbody>
        <tr>
          <td><?php echo htmlentities($SrNo); ?></td>
          <td><?php echo htmlentities($CategoryDate); ?></td>
          <td><?php echo htmlentities($CategoryName); ?></td>
          <td><?php echo htmlentities($CreatorName); ?></td>
          <td> <a href="DeleteCategory.php?id=<?php echo $CategoryId;?>" class="btn btn-primary">Delete</a>  </td>

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
