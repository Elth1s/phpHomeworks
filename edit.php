<?php
include "connection_database.php";
$sqlGet = "SELECT * FROM `news` WHERE Id=?;";
$id = $_GET['id'];
$reader = $conn->query("SELECT * FROM `news` WHERE Id='$id'");
$data = false;
foreach ($reader as $row)
    $data = $row;
if($data===false) {
    header("Location: /news.php");
    exit();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filename = uniqid() . '.jpg';
    if($_FILES['Image']['tmp_name']!=="") {
        $filesavepath = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $filename;
        move_uploaded_file($_FILES['Image']['tmp_name'], $filesavepath);
        $filedeletepath = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $data['Image'];
        unlink($filedeletepath);
    }
    /*$sql = "INSERT INTO `news` (`Title`, `Image`, `Description`) VALUES (?, ?, ?);";*/
    $sql = "UPDATE `news` SET `Title` = ?,`Image` = ?, `Description` = ? WHERE `news`.`Id` = ?;";
    $name = $_POST['Title'];
    if($_FILES['Image']['tmp_name']=="")
        $filename = $data['Image'];
    $description = $_POST['Description'];
    $conn->prepare($sql)->execute([$name, $filename, $description,$data["Id"]]);
    header("Location: /");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <title>Edit news</title>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
</head>

<body>
<?php include "navbar.php"; ?>

<div class="container">
    <h2 class="py-3">Edit news</h2>
    <form method="post" class="row" enctype="multipart/form-data">
        <div class="col col-6">
            <div class="mb-3">
                <label for="Title" class="form-label">Title</label>
                <input type="text" class="form-control" name="Title" id="Title" value='<?php echo "{$data['Title']}";?>'>
            </div>
            <div class="mb-3">
                <label for="Description" class="form-label">Description</label>
                <textarea name="Description" id="Description"><?php echo "{$data['Description']}";?></textarea>
            </div>
            <div class="col-2 offset-10 text-end">
                <button type="submit" class="btn btn-success">Edit</button>
            </div>
        </div>
        <div class="col col-6">
            <div class="mb-3">
                <label for="Image">
                    <img src='/images/<?php echo "{$data['Image']}";?>'
                         width="400px"
                         style="cursor: pointer"
                         id="img_preview">
                </label>
                <input class="form-control d-none" type="file" multiple name="Image" id="Image">
            </div>
        </div>
    </form>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    window.addEventListener('load', function () {
        const file = document.getElementById('Image');
        file.addEventListener("change", function (e) {
            const uploadFile = e.currentTarget.files[0];
            document.getElementById("img_preview").src = URL.createObjectURL(uploadFile);
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#Description').summernote({
            tabsize: 2,
            height: 150
        });
    });
</script>
</body>
</html>