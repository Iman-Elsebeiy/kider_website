<?php

require_once "includes/conn.php";
require_once "includes/logged.php";
require_once "includes/helpers.php";
try{
$sql = "SELECT * FROM `teachers`, `classes` WHERE classes.`teach_id` = `teachers`.`id`;";
$stmt = $conn->prepare($sql);
$stmt->execute();

$classes = $stmt->fetchAll();
//dd($classes);

} catch (PDOException $e) {
  $error = "Connection failed: " . $e->getMessage();
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
          <h2 class="fw-bold fs-2 mb-5 pb-2">All Classes</h2>
          <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Registration Date</th>
                <th scope="col">Class Name</th>
                <th scope="col">Teacher</th>
                <th scope="col">Published</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
            <?php
            foreach ($classes as $class) {
             ?>
              <tr>
                <th scope="row"><?php
             echo date("j M Y",(strtotime($class['regDate'])));
                   ?></th>
                <td><a href="class_details.php?id=<?php echo $class['id'] ?>"><?php echo $class['className'] ?></a></td>
                
                <td><?php echo $class['fullName'] ?></td>
                
                <td><?php if($class['published']==1){
                            echo 'YES';
                  	      } else {
                           echo 'NO';
                     	}?></td>
                <td><a href="edit_class.php?id=<?php echo $class['id'] ?>" class="text-decoration-none"><i>✒️</i></a></td>
                <td><a href="deleteclass.php?id=<?php echo $class['id'] ?>" onclick="return confirm('Are you sure you want to delete this?')" class="text-decoration-none"><img src="../img/trash-bin.png" alt="" style="max-width: 35px"></a></td>
              </tr>
              <?php
                }
                ?>
            </tbody>
          </table>
        </div>
        </div>
      </div>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
