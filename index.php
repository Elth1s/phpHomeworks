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

<div class="container">
    <h2 class="py-3">News</h2>

    <div class="row">
    <?php
           include "connection_database.php";
            $reader = $conn->query("SELECT * FROM `news`");
            foreach ($reader as $row) {
                echo
                    "
<div class='col-6'>
        <div class='card mb-3'>
            <img src='/images/{$row['Image']}' class='card-img-top'
                 alt='...'>
            <div class='card-body'>
                <div class='d-flex justify-content-between'>
                    <h5 class='card-title col-7'>{$row["Title"]}</h5>
                    <p class='card-text col-4 text-end'><small class='text-muted'>Last updated 3 mins ago</small></p>
                </div>
                <p class='card-text'>{$row["Description"]}</p>
            </div>
        </div>
    </div>";
            }

    ?>
    </div>


</div>


<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>