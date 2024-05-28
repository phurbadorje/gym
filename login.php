<?php
session_start();
error_reporting(0);
require_once('include/config.php');
$msg = "";
if (isset($_POST['submit'])) {
  $email = trim($_POST['email']);
  $password = md5(($_POST['password']));
  if ($email != "" && $password != "") {
    try {
      $query = "select id, fname, lname, email, mobile, password, address, create_date from tbluser where email=:email and password=:password";
      $stmt = $dbh->prepare($query);
      $stmt->bindParam('email', $email, PDO::PARAM_STR);
      $stmt->bindValue('password', $password, PDO::PARAM_STR);
      $stmt->execute();
      $count = $stmt->rowCount();
      $row   = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($count == 1 && !empty($row)) {
        $_SESSION['uid']   = $row['id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['fname'];
        header("location: index.php");
      } else {
        $msg = "Invalid Email and Password!";
      }
    } catch (PDOException $e) {
      echo "Error : " . $e->getMessage();
    }
  } else {
    $msg = "Both fields are required!";
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="admin/css/main.css?v=2">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Gym | User Login</title>
</head>

<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <div class="logo">
      <h1>GYM | User Login</h1>
    </div>
    <div class="login-box">
      <form class="login-form" method="post">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>LOG IN</h3>
        <?php if ($error) { ?><div class="errorWrap" style="color:red;"><strong>ERROR</strong> : <?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap" style="color:red;"><strong>ERROR</strong> : <?php echo htmlentities($msg); ?> </div><?php } ?>
        <div class="form-group">
          <label class="control-label">Email</label>
          <input class="form-control" name="email" id="email" type="text" placeholder="Email" autofocus>
        </div>
        <div class="form-group">
          <label class="control-label">Password</label>
          <input class="form-control" name="password" id="password" type="password" placeholder="Password">
        </div>
        <div class="form-group btn-container">
          <input type="submit" name="submit" id="submit" value="  LOG IN" class="btn btn-primary btn-block">
        </div>
        <hr />
        <!-- <a href="index.php">Back to Home Page</a> -->
        <p class="semibold-text mb-0">Don't have an account?<a href="registration.php" data-toggle="flip"> Register</a></p>
        <a href="index.php">Back to Home Page</a>
      </form>

    </div>
  </section>
  <!-- Essential javascripts for application to work-->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="js/plugins/pace.min.js"></script>
  <script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function() {
      $('.login-box').toggleClass('flipped');
      return false;
    });
  </script>
</body>

</html>