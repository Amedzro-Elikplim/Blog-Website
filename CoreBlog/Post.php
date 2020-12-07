<?php require_once("Includes/Db.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://kit.fontawesome.com/670e962b43.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="Css/Style.css">
  <title>Posts</title>
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
          <h1><i class="fas fa-blog"></i> Blog Posts</h1>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="AddNewPost.php" class="btn btn-light btn-block">
              <i class="fas fa-edit"></i> Add New Post
            </a>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="Categories.php" class="btn btn-info btn-light btn-block">
              <i class="fas fa-folder-plus"></i> Add New Category
            </a>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="Admins.php" class="btn btn-light btn-block">
              <i class="fas fa-user-plus"></i> Add New Admin
            </a>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="Comments.php" class="btn btn-light btn-block">
              <i class="fas fa-check"></i> Approve Comments
            </a>
          </div>

        </div>
      </div>
    </header>
    <!-- HEADER END -->

    <!-- Main Area -->
<section class="container py-2 mb-4">
  <div class="row">
    <div class="col-lg-12">
      <?php
       echo ErrorMessage();
       echo SuccessMessage();
       ?>
      <table class="table table-striped table-hover">
        <thead class="thead-light">
        <tr>
        <th>#</th>
        <th>Title</th>
        <th>Categroy</th>
        <th>Date&Time</th>
        <th>Author</th>
        <th>Banner</th>
        <th>Comments</th>
        <th>Action</th>
        <th>Live Preview</th>
        </tr>
        </thead>
        <?php
                    global $ConnectingDB;
                    $sql  = "SELECT * FROM posts ORDER BY id desc";
                    $stmt = $ConnectingDB->query($sql);
                    $Sr = 0;
                    while ($DataRows = $stmt->fetch()) {
                      $Id        = $DataRows["id"];
                      $DateTime  = $DataRows["datetime"];
                      $PostTitle = $DataRows["title"];
                      $Category  = $DataRows["category"];
                      $Admin     = $DataRows["author"];
                      $Image     = $DataRows["image"];
                      $PostText  = $DataRows["post"];
                      $Sr++;
                    ?>
                    <tbody>
                    <tr>
                      <td><?php echo $Sr; ?></td>
                      <td>
                        <?php
                        if(strlen($PostTitle)>20){$PostTitle= substr($PostTitle,0,18).'..';}
                       echo $PostTitle;
                       ?>
                      </td>
                      <td>
                        <?php
                        if(strlen($Category)>8){$Category= substr($Category,0,8).'..';}
                         echo $Category;
                         ?>
                       </td>
                      <td>
                        <?php
                        if(strlen($DateTime)>11){$DateTime= substr($DateTime,0,11).'..';}
                        echo $DateTime;
                        ?>
                      </td>
                      <td>
                        <?php
                        if(strlen($Admin)>6){$Admin= substr($Admin,0,6).'..';}
                         echo $Admin;
                         ?>
                       </td>
                      <td>
                        <img src="Uploads/<?php echo $Image; ?>" width="170px;" height="50px;">
                      </td>
                      <td>
                 <?php
                 $Total =ApproveCommentsAccordingtoPost($Id);
                  if ($Total>0) {
                    ?>
                    <span class="badge badge-primary">
                      <?php
                    echo $Total;?>
                    </span>
                <?php   } ?>

                <?php
                 $Total =DisApproveCommentsAccordingtoPost($Id);
                 if ($Total>0) {
                   ?>
                   <span class="badge badge-danger">
                     <?php
                   echo $Total;?>
                   </span>
               <?php   } ?>

                      </td>
                      <td>
                <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-primary">Edit</span></a>
                <a href="DeletePost.php?id=<?php echo $Id ?>"><span class="btn btn-primary">Delete</span></a>
              </td>
                      <td>
                        <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
                      </td>
                    </tr>
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
