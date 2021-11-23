<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <title>News</title>
</head>

<body>
<?php include "navbar.php"; ?>
<?php
function foo($id)
{
    echo "<h1>$id</h1>";
}

?>
<div class="container">
    <h2 class="py-3">News</h2>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Image</th>
            <th style="width: 150px" scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $conn = new PDO("mysql:host=localhost;dbname=NewsPHP", "root", "");
        $reader = $conn->query("SELECT * FROM `news`");
        foreach ($reader as $row) {
            echo "
            <tr>
                <th>{$row["Id"]}</th>
                <td>{$row["Title"]}</td>
                <td>{$row["Description"]}</td>
                <td>{$row["Image"]}</td>
                <td>
                    <div class='d-flex justify-content-between'>
                        <a  href='edit.php?id={$row["Id"]}' class='btn btn-primary'>Edit</a>
                        <input type='button' class='btn btn-danger btnDelete' data-id='{$row["Id"]}' data-image='{$row["Image"]}' value='Delete'>
                    </div>
                </td>
            </tr>
                    ";
        }
        ?>
        </tbody>
    </table>

</div>
<?php include "modal_delete.php"?>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/axios.min.js"></script>
<script>
    let myModal = new bootstrap.Modal(document.getElementById("myModal"),{});

    window.addEventListener('load', function () {
        const list = document.querySelectorAll(".btnDelete");
        let removeId=0;
        let removeImage="";
        for (let i=0; i < list.length; i++) {
            list[i].addEventListener("click", function (e) {
                e.preventDefault();
                removeId = e.currentTarget.dataset.id;
                removeImage=e.currentTarget.dataset.image;
                myModal.show();

            })
        }
        document.querySelector("#btnDeleteNews").addEventListener("click",function () {
            const formData = new FormData();
            formData.append("Id",removeId);
            formData.append("Image",removeImage);

            console.log(removeImage)
            axios.post("/delete.php",formData)
                .then(response=>{
                    window.location.reload();
                })
        })
    })
</script>
</body>
</html>