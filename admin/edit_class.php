<?php
require_once "includes/conn.php";
require_once "includes/helpers.php";
require_once "includes/logged.php";

// update in database
if ($_SERVER["REQUEST_METHOD"] === "POST") {

      $sql = "UPDATE `classes` SET `className`=?,`price`=?,`capacity`=?,`ageFrom`=?,`ageTo`=?,`timeFrom`=?,`timeTo`=?,`published`=?,`image`=?,`teach_id`=? WHERE `id`=?;";
      $stmt = $conn->prepare($sql);

      $className = $_POST['className'];
      $ageFrom = $_POST['ageFrom'];
      $capacity = $_POST['capacity'];
      $price = $_POST['price'];
      $timeFrom = $_POST['timeFrom'];
	    $timeTo = $_POST['timeTo'];
	    $ageTo = $_POST['ageTo'];
      $teach_id = $_POST['teach_id'];
		  $id = $_POST['id'];

      if (isset($_POST['published'])) {
        $published = 1;
      } else {
        $published = 0;
      }

		  $oldImage = $_POST['oldImage'];
		  require_once "includes/updateImage.php";

	  	$stmt->execute([$className, $price, $capacity, $ageFrom, $ageTo, $timeFrom, $timeTo, $published, $image_name, $teach_id, $id]);
		  //echo "data updated successfully";
      header('Location: classes.php');
      die();
}
if (isset($_GET['id'])) {

  $sql = "SELECT * FROM `classes` WHERE id = ?";
  $stmt = $conn->prepare($sql);

  $id = $_GET['id'];

  $stmt->execute([$id]);
  $class = $stmt->fetch();

  if ($class === false) {
      header('Location: classes.php');
      die();
  }
} else {
  header('Location: classes.php');
  die();
}

$sqlCat = "SELECT * FROM `teachers`";
$stmtCat = $conn->prepare($sqlCat);
$stmtCat->execute();

$teachers = $stmtCat->fetchAll();

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
          <h2 class="fw-bold fs-2 mb-5 pb-2">Edit Class</h2>
          <form action="" method="POST" class="px-md-5" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo $id ?>">
          <input type="hidden" name="oldImage" value="<?php echo $class['image'] ?>">
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Class Name:</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="className" value="<?php echo $class['className'] ?>" 
                  placeholder="e.g. Art & Design"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Teacher:</label
              >
              <div class="col-md-10">
                <select id="" class="form-control py-1" name="teach_id">
                  <option value="">Select teacher</option>
                  <?php
                  foreach($teachers as $teacher){
                  ?>
                  <option value="<?php echo $teacher['id']?>" <?php echo ($teacher["id"] == $class['teach_id']) ? "selected" : ""; ?> ><?php echo $teacher["fullName"] ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Price:</label
              >
              <div class="col-md-10">
                <input
                  type="number"
                  name="price" value="<?php echo $class['price'] ?>" 
                  step="0.1"
                  placeholder="Enter price"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Capacity:</label
              >
              <div class="col-md-10">
                <input
                  type="number"
                  name="capacity" value="<?php echo $class['capacity'] ?>" 
                  step="1"
                  placeholder="Enter catpacity"
                  class="form-control py-2"
                />
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Age:</label
              >
              <div class="col-md-10">
                <label for="" class="form-label">From <input type="number" name="ageFrom" value="<?php echo $class['ageFrom'] ?>" class="form-control"></label>
                <label for="" class="form-label">To <input type="number" name="ageTo" value="<?php echo $class['ageTo'] ?>" class="form-control"></label>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Time:</label
              >
              <div class="col-md-10">
                <label for="" class="form-label">From <input type="time" name="timeFrom" value="<?php echo $class['timeFrom'] ?>" class="form-control"></label>
                <label for="" class="form-label">To <input type="time" name="timeTo" value="<?php echo $class['timeTo'] ?>" class="form-control"></label>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Published:</label
              >
              <div class="col-md-10">
                <input
                  type="checkbox"
                  name="published" <?php echo ($class['published'] ==1)? 'checked':''?> 
                  class="form-check-input"           
                  style="padding: 0.7rem;"
                />
              <f/div>
            </div>
            <hr>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Image:</label
              >
              <div class="col-md-10">
                <input
                  type="file"
                  name="image"
                  class="form-control"
                  style="padding: 0.7rem;"
                />
              </div>
            </div>
            <div class="row justify-content-end">
              <div class="col-md-10">
                <img
                  src="../img/<?php echo $class['image'] ?>"
                  alt="class-image"
                  style="max-width: 150px"
                />
              </div>
            </div>
            <div class="text-md-end">
            <button
              class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5"
            >
              Edit Class
            </button>
          </div>
          </form>
        </div>
      </div>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
