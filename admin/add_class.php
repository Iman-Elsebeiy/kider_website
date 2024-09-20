<?php
require_once "includes/conn.php";
require_once "includes/helpers.php";
require_once "includes/logged.php";

if($_SERVER["REQUEST_METHOD"] === "POST") {
  //dd($_POST['teach_id']);
  if(!empty($_POST['teach_id'])){
    try {
      $sql = "INSERT INTO `classes`(`className`, `price`, `capacity`, `ageFrom`, `ageTo`, `timeFrom`, `published`,`timeTo`,`image`,`teach_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);

      // dd($_POST);
      $className = $_POST['className'];
      $price = $_POST['price'];
      $capacity = $_POST['capacity'];
      $ageFrom = $_POST['ageFrom'];
      $ageTo = $_POST['ageTo'];
      $timeFrom = $_POST['timeFrom'];
      $timeTo = $_POST['timeTo'];
      $teach_id = $_POST['teach_id'];
      // handle image
      require_once "includes/addimage.php";
     if (isset($_POST['published'])) {
         $published	 = 1;
     } else {
         $published	 = 0;
     }
      $stmt->execute([$className, $price, $capacity, $ageFrom, $ageTo, $timeFrom, $timeTo, $published, $image_name, $teach_id]);

      //echo "data inserted successfuly";
      header('Location: classes.php');
       die();
    }catch(PDOException $e){
      $error = "Connection failed: " . $e->getMessage();
   }
 }else{
  echo "Teacher's name is required";
}
}
$sqlte = "SELECT * FROM `teachers`";
$stmtte = $conn->prepare($sqlte);
$stmtte->execute();

$teachers = $stmtte->fetchAll();
//dd($teachers);
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
          <h2 class="fw-bold fs-2 mb-5 pb-2">Add Class</h2>
          <form action="" method="POST" class="px-md-5" enctype="multipart/form-data">
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Class Name:</label
              >
              <div class="col-md-10">
                <input
                  type="text"
                  name="className"
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
                  <option value="<?php echo $teacher['id']?>"><?php echo $teacher['fullName'] ?></option>
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
                  name="price"
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
                  name="capacity"
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
                <label for="" class="form-label">From <input type="number" class="form-control" name="ageFrom"></label>
                <label for="" class="form-label">To <input type="number" class="form-control" name="ageTo"></label>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Time:</label
              >
              <div class="col-md-10">
                <label for="" class="form-label">From <input  type="time" class="form-control" name="timeFrom"></label>
                <label for="" class="form-label">To <input type="time" class="form-control" name="timeTo"></label>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label for="" class="form-label col-md-2 fw-bold text-md-end"
                >Published:</label
              >
              <div class="col-md-10">
                <input
                  type="checkbox"
                  name="published"
                  class="form-check-input"
                  style="padding: 0.7rem;"
                />
              </div>
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
            <div class="text-md-end">
            <button
              class="btn mt-4 btn-secondary text-white fs-5 fw-bold border-0 py-2 px-md-5"
            >
              Add Class
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
