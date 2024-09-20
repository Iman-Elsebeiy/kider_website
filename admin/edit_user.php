<?php
require_once "includes/conn.php";
require_once "includes/helpers.php";
require_once "includes/logged.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $sql ="UPDATE `users` SET `fullName`=?,`userName`=?,`email`=?,`pwd`=?,`phone`=?,`active`=? WHERE `id`=?";
    $stmt = $conn->prepare($sql);

    $fullName = $_POST['fullName'];
    $userName = $_POST['userName'];
    $email = $_POST['email'];
    $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $id = $_POST['id'];
  
  
	if (isset($_POST['active'])) {
			$active = 1;
	} else {
			$active = 0;
	}
		$stmt->execute([$fullName, $userName, $email, $pwd, $phone, $active, $id]);
		//echo "data updated successfully";
    header('Location: users.php');
    die();
}

if (isset($_GET['id'])) {

    $sql = "SELECT * FROM `users` WHERE id = ?";
    $stmt = $conn->prepare($sql);

    $id = $_GET['id'];

    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if ($user === false) {
        header('Location: users.php');
        die();
    }
} else {
    header('Location: users.php');
    die();
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
          <h2 class="fw-bold fs-2 mb-5 pb-2">Edit User</h2>
          <form action="" method="POST" class="px-5" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-end"
                >Fullname:</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="fullName" value="<?php echo $user['fullName'] ?>"
                  placeholder="e.g. John Doe"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-end"
                >Username:</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="userName" value="<?php echo $user['userName'] ?>" 
                  placeholder="Username"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-end"
                >Email:</label
              >
              <div class="col-md-10">
                <input
                  type="email"
                  name="email" value="<?php echo $user['email'] ?>"
                  placeholder="email@example.com"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-end"
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
              <label for="" class="form-label col-md-2 fw-bold text-end"
                >Phone:</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="phone" value="<?php echo $user['phone'] ?>"
                  placeholder="+20133332323"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-end"
                >Active:</label
              >
              <div class="col-md-10">
                <input
                  type="checkbox"
                  name="active" <?php echo ($user['active'] ==1)? 'checked':''?>
                  class="form-check-input"
                  style="padding: 0.7rem;"
                />
              </div>
            </div>
            <div class="text-end">
            <button
              class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5"
            >
              Update User
            </button>
          </div>
          </form>
        </div>
      </div>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
