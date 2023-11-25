<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <h1>Add New Product</h1>

    <?php

    require_once 'db_connection.php';

       
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productName = $_POST['product_name'];
        $unitPrice = $_POST['unit_price'];
        $unitMeasure = $_POST['unit_measure'];

        
        $targetDir = "uploads/images/product-images";
        $targetFile = $targetDir . basename($_FILES["product_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

       
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

      
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        
        if ($_FILES["product_image"]["size"] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
                echo "The file ". htmlspecialchars(basename($_FILES["product_image"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        $sql = "INSERT INTO products (product_name, unit_price, unit_measure, product_image) VALUES ('$productName', '$unitPrice', '$unitMeasure', '$targetFile')";
        // Add more fields as needed

        if ($conn->query($sql) === TRUE) {
            echo "Product added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

        <label for="product_name">Product Name Kasun2:</label>
        <input type="text" name="product_name" required>

        <label for="unit_price">Unit Price:</label>
        <input type="number" name="unit_price" step="0.01" required>

        <label for="unit_measure">Unit of Measure:</label>
        <input type="text" name="unit_measure" required>

        <label for="product_image">Product Image:</label>
        <input type="file" name="product_image" accept="image/*" required>


        <input type="submit" value="Add Product">
    </form>

    <br><br>

<a href="viewProducts.php">
    <button >View Products</button>
</a>
</body>
</html>
