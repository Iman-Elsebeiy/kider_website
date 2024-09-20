<?php
require_once "includes/logged.php";
require_once "includes/conn.php";
require_once "includes/helpers.php";

if($_SERVER["REQUEST_METHOD"] === "POST") {
try {
  $sql = "INSERT INTO `users`(`fullName`, `userName`, `email`, `pwd`, `phone`, `active`) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  // dd($_POST);
  $fullName = $_POST['fullName'];
  $userName = $_POST['userName'];
  $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  if (isset($_POST['active'])) {
    $active =1;
} else {
    $active =0;
}
  $stmt->execute([$fullName, $userName, $email, $pwd, $phone, $active]);

  //echo "data inserted successfuly";
  header('Location: users.php');
  die();
}catch(PDOException $e){
  $error = "Connection failed: " . $e->getMessage();
}

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/main.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <main>
    <?php
  require_once "includes/nav.php";
  ?>
      <div class="container my-5">
        <div class="bg-light p-5 rounded">
          <h2 class="fw-bold fs-2 mb-5 pb-2">Add User</h2>
          <form action="" method="POST" class="px-md-5">
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Fullname:</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="fullName"
                  placeholder="e.g. John Doe"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Username:</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="userName"
                  placeholder="Username"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Email:</label
              >
              <div class="col-md-10">
                <input
                  type="email"
                  name="email"
                  placeholder="email@example.com"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Password:</label
              >
              <div class="col-md-10">
                <input
                  type="password"
                  name="pwd"
                  placeholder="Password"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Phone:</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="phone"
                  placeholder="+20133332323"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Active:</label
              >
              <div class="col-md-10">
                <input
                  type="checkbox"
                  name="active"
                  class="form-check-input"
                  style="padding: 0.7rem;"
                />
              </div>
            </div>
            <div class="text-md-end">
            <button
              class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5"
            >
              Add User
            </button>
          </div>
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
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
