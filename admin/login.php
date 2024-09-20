<?php
session_start();
require_once "includes/conn.php";
require_once "includes/helpers.php";
//dd($_SESSION);
// check if the user is logged in
if(isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
  header('Location: classes.php');
  die();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
try {
    $userName = $_POST['userName'];
    $pwd = $_POST['pwd'];

    $sql = "SELECT * FROM `users` WHERE `userName` = ? AND `active` = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userName]);

    $user = $stmt->fetch();
   
    //dd($user);
    if ($user === false) {
        $error =  "user not found";
    } elseif (password_verify($pwd, $user['pwd'])) {
        // echo "login success";
        $_SESSION['logged'] = true;
        
        header('Location: classes.php');
        die();
    } else {
        $error = "password incorrect";
    }
  } catch(PDOException $e){
    $error = "Connection failed: " . $e->getMessage();
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login/Registeration</title>
  <link rel="stylesheet" href="css/main.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-dark">
  <div class="container" >
    <div class="row justify-content-center mt-5">
      <div class="col-lg-5 main position-relative mt-5 d-flex flex-column align-items-center">
        <h2 class="text-white mt-5 fw-bold">Login Form</h2>

        <form action="" method="POST" class="mt-3 w-100 px-3">
          <div class="form-group mb-3">
            <label for="" class="text-white form-label">Username</label>
            <input type="text" name="userName" placeholder="Username" class="form-control form-control-input py-2">
          </div>
          <div class="form-group mb-3">
            <label for="" class="text-white form-label">Password</label>
            <input type="password" name="pwd" placeholder="Password" class="form-control form-control-input py-2">
          </div>
          <button class="btn my-4 bg-light fs-5 fw-bold w-100 border-0 py-2">Log in</button>
          <a href="registeration.php" class="text-center d-block fs-4 text-white mb-5">Don't have account?</a>
        </form>
        <?php
        if(isset($error)) {
        ?>
        <div style="color: #ee0002; padding: 5px;">
          <?php echo $error ?>
        </div>
        <?php
        }
        ?>

      </div>
    </div>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>