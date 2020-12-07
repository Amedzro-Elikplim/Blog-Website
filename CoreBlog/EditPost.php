<?php require_once("Includes/Db.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
 Confirm_Login(); ?>
<?php
$SarchQueryParameter = $_GET['id'];
if(isset($_POST["Submit"])){
  $PostTitle = $_POST["PostTitle"];
  $Category  = $_POST["Category"];
  $Image     = $_FILES["Image"]["name"];
  $Target    = "Uploads/".basename($_FILES["Image"]["name"]);
  $PostText  = $_POST["PostDescription"];
  $Admin     = "Dennis";
  date_default_timezone_set("Africa/Accra");
  $CurrentTime = time();
  $DateTime    = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($PostTitle)){
    $_SESSION["ErrorMessage"]= "Title Cant be empty";
    Redirect_to("Post.php");
  }elseif (strlen($PostTitle)<5) {
    $_SESSION["ErrorMessage"]= "Post Title should be greater than 5 characters";
    Redirect_to("Post.php");
  }elseif (strlen($PostText)>19999) {
    $_SESSION["ErrorMessage"]= "Post Description should be less than than 20000 characters";
    Redirect_to("Post.php");
  }else{
    // Query to Update Post in DB When everything is fine
    global $ConnectingDB;
    if (!empty($_FILES["Image"]["name"])) {
      $sql = "UPDATE posts
              SET title='$PostTitle', category='$Category', image='$Image', post='$PostText'
              WHERE id='$SarchQueryParameter'";
    }else {
      $sql = "UPDATE posts
              SET title='$PostTitle', category='$Category', post='$PostText'
              WHERE id='$SarchQueryParameter'";
    }
    $Execute= $ConnectingDB->query($sql);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    //var_dump($Execute);
    if($Execute){
      $_SESSION["SuccessMessage"]="Post Updated Successfully";
      Redirect_to("Post.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("Post.php");
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
  <title>Edit Post</title>
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
          <a href="MyProfile.php" class="nav-link"> My Profile</a>
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
          <h1><i class="fas fa-edit"></i> Edit Post</h1>
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
       // Fetching Existing Content according to our
      global $ConnectingDB;
      $sql  = "SELECT * FROM posts WHERE id='$SarchQueryParameter'";
      $stmt = $ConnectingDB ->query($sql);
      while ($DataRows=$stmt->fetch()) {
        $TitleToBeUpdated    = $DataRows['title'];
        $CategoryToBeUpdated = $DataRows['category'];
        $ImageToBeUpdated    = $DataRows['image'];
        $PostToBeUpdated     = $DataRows['post'];
      }
       ?>
        <form class="" action="EditPost.php?id=<?php echo $SarchQueryParameter; ?>" method="post" enctype="multipart/form-data">
        <div class="card mb-3">
          <div class="card-body bg-light">
            <div class="form-group">
              <label for="title"> <span class="FieldInfo"> Post Title: </span></label>
               <input class="form-control" type="text" name="PostTitle" id="title"  value="<?php echo $TitleToBeUpdated; ?>">
            </div>
            <div class="form-group">
                <span class="FieldInfo">Existing Category: </span>
                <?php echo $CategoryToBeUpdated;?>
                <br>
              <label for="CategoryTitle"> <span class="FieldInfo"> Chose Category </span></label>
                <select class="form-control" id="CategoryTitle"  name="Category">
                  <?php
                //Fetchinng all the categories from category table
                global $ConnectingDB;
                $sql = "SELECT id,title FROM category";
                $stmt = $ConnectingDB->query($sql);
                while ($DataRows = $stmt->fetch()) {
                  $Id = $DataRows["id"];
                  $CategoryName = $DataRows["title"];
                 ?>
                 <option> <?php echo $CategoryName; ?></option>
                 <?php } ?>
               </select>
            </div>
            <div class="form-group">
                <span class="FieldInfo">Existing Image: </span>
                  <img  class="mb-1" src="Uploads/<?php echo $ImageToBeUpdated;?>" width="170px"; height="70px"; >
                <label for="imageSelect"> <span class="FieldInfo"></span></label>
                <div class="custom-file">
                <input type="File" name="Image" id="imageSelect" value="">
                  </div>
            </div>
            <div class="form-group">
              <label for="Post"> <span class="FieldInfo"> Post: </span></label>
              <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
                  <?php echo $PostToBeUpdated;?>
              </textarea>

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
