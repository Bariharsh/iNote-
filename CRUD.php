<?php 
// INSERT INTO `notes3` (`title`, `description`) VALUES ('$title','$description');
$insert = false;
$update = false;
$delete = false;
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    die("not connected!" . mysqli_connect_error());
} 

// echo $_SERVER['REQUEST_METHOD'];
// echo $_GET['update'];
// echo $_POST['snoEdit'];

// exit();
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;

  $sql = "DELETE FROM `notes3` WHERE `sno` = '$sno'";
  $result = mysqli_query($conn,$sql);

}

if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(isset($_POST['snoEdit'])){

    // upadte a record
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleedit"];
    $description = $_POST["descriptionedit"];
    
    $sql = "UPDATE `notes3` SET `title` = '$title' , `description` = '$description' WHERE `notes3`.`sno` = '$sno'";
    $result = mysqli_query($conn,$sql);

    if($result){
      $update = true;
    }
    
  } else {

    
    $title = $_POST["title"];
    $description = $_POST["description"];
    
    $sql = "INSERT INTO `notes3` (`title`, `description`) VALUES ('$title','$description')";
    $result = mysqli_query($conn,$sql);
    
    if($result){
      $insert = true;
    }
    
  }
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="jquery-3.7.1.min.js"></script>

  <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">


  <title>iNotes - Notes taking made easy</title>


</head>

<body>

  <!-- edit modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
    Edit Modal
  </button> -->

  <!-- edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModallabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit This Note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="CRUD.php" method="POST">
        <div class="modal-body">

            <input type="hidden" name="snoEdit" id="snoEdit">

            <div class="mb-3">
              <label for="title" class="form-label">Note title</label>
              <input type="text" class="form-control" id="titleedit" name="titleedit">
              
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Note Description</label>
              <textarea class="form-control" id="descriptionedit" rows="3" name="descriptionedit"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Note</button>
          </div>
        </form>

        
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>

        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <?php

        if($insert){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> Your notes has been inserted successfully
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }
      ?>

<?php

if($update){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been updated
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
}
?>

<?php

        if($delete){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> Your note has been deleted
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }
      ?>

  <div class="container my-4">
    <h2>Add a Note</h2>
    <form action="CRUD.php" method="POST">

      <div class="mb-3">
        <label for="title" class="form-label">Note title</label>
        <input type="text" class="form-control" id="title" name="title">
        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>

  </div>


  <div class="container my-4">

    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 

$sql = "SELECT * FROM notes3";
$result = mysqli_query($conn,$sql);
$sno = 0;

while($row = mysqli_fetch_assoc($result)){
  $sno = $sno + 1;
  echo "<tr>
  <th scope='row'>". $sno . "</th>
  <td>" . $row['title'] . "</td>
  <td>" . $row['description'] . " /td><td><button class='edit btn btn-sm btn-primary' id=". $row['sno'] . ">edit</button> <button class='del btn btn-sm btn-primary' id=d".$row['sno'].">delete</button></td></tr>";
}


?>


      </tbody>
    </table>
  </div>
  <hr>





  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>

  <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>


  <script>

    let table = new DataTable('#myTable');

  </script>
  <script>

    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ",);
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleedit.value = title;
        descriptionedit.value = description;
        snoEdit.value = e.target.id;

        console.log(e.target.id);
        $('#editModal').modal('toggle');

      });
    });

    deletes = document.getElementsByClassName('del');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
       
        sno = e.target.id.substr(1,);
        if(confirm("are you sure you want to delete this note!")){
          window.location = 'CRUD.php?delete=true';

        } else {
          console.log("No");
        }
      });
    });


  </script>
</body>

</html>