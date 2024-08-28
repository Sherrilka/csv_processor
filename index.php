<?php
require_once('classes/DataProcessor.php');

if(isset($_POST['submit'])) {
    $data_processor = new DataProcessor($_FILES['file_men']['tmp_name'], $_FILES['file_women']['tmp_name']);
    $tables = $data_processor->getData();
    print_r($tables);
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Moje Webová Stránka</title>
</head>
<body class="w-100">
    <form class="w-50 m-auto my-5" id="form" method="post" name="form" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="file_women" class="form-label">Vložte CSV soubor se seznamem ženských oskarů</label>
            <input type="file" class="form-control" id="file_women" name="file_women" required accept="csv">
        </div>
        <div class="mb-3">
            <label for="file_men" class="form-label">Vložte CSV soubor se seznamem mužských oskarů</label>
            <input type="file" class="form-control" id="file_men" name="file_men" required accept="csv">
        </div>
        <button type="submit" class="btn btn-primary" id="submit" name="submit">Poslat</button>
    </form>
</body>
</html>
