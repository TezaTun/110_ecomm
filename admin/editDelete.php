<?php
require_once("dbconnect.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch all categories
try {
    $sql = "SELECT * FROM category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

$product = null; // Default null

// Edit: fetch product by ID
if (isset($_GET['eid'])) {
    $productId = $_GET['eid'];
    try {
        $sql = "SELECT p.productId, p.productName, c.catName, p.category, p.price, p.description, p.qty, p.imgPath
                FROM product p JOIN category c ON p.category = c.catId
                WHERE p.productId = ?";
        $statement = $conn->prepare($sql);
        $statement->execute([$productId]);
        $product = $statement->fetch();
        $_SESSION["product"] = $product;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Delete product
else if (isset($_GET['did'])) {
    try {
        $productId = $_GET['did'];
        $sql = 'DELETE FROM product WHERE productId = ?';
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([$productId]);

        if ($status) {
            $_SESSION['message'] = "Product ID $productId has been deleted";
            header("Location: viewProduct.php");
            exit();
        } else {
            echo "Failed to delete product ID $productId";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Update product
else if (isset($_POST['updateBtn'])) {
    $productName = $_POST['pname'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $description = $_POST['description'];
    $fileImg = $_FILES['file'];
    $pid = $_POST['pid'];

    $filePath = "productImage/" . basename($fileImg['name']);
    $status = move_uploaded_file($fileImg['tmp_name'], $filePath);

   


    if ($status) { $_SESSION['updateMessage']="Product with product id $pid is updated!!!";
        try {
            $sql = "UPDATE product 
                    SET productName = ?, category = ?, price = ?, qty = ?, description = ?, imgPath = ?
                    WHERE productId = ?";
            $stmt = $conn->prepare($sql);
            $flag = $stmt->execute([$productName, $category, $price, $qty, $description, $filePath, $pid]);
             if ($flag) {
                $_SESSION['updateMessage'] = "Product updated successfully!";
                header("Location: viewProduct.php");
                exit();
                }

            if ($flag) {
                echo "Update success!";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "Image upload failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php require_once "navbarcopy.php"; ?>
    </div>
    <div class="row">
        <div class="col-md-2">
            <a href="addProduct.php" class="btn btn-primary">Add New</a>
        </div>
        <div class="col-md-10 p-3">
            <div class="row my-5">
                <form action="editDelete.php" method="post" enctype="multipart/form-data" class="form card p-4">
                    <input type="hidden" name="pid" value="<?php echo isset($product) ? $product['productId'] : ''; ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="pname" class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="pname" id="pname"
                                       value="<?php echo isset($product) ? $product['productName'] : ''; ?>">
                            </div>

                            <div class="mb-2">
                                <?php if (isset($product)) {
                                    echo "<p class='alert alert-info'>Previous selected category: {$product['catName']}</p>";
                                } ?>
                                <select name="category" id="category" class="form-select" required>
                                    <option value="">Choose Category</option>
                                    <?php
                                    if (isset($categories))
                                        foreach ($categories as $cat) {
                                            $selected = (isset($product) && $cat['catId'] == $product['category']) ? 'selected' : '';
                                            echo "<option value='{$cat['catId']}' $selected>{$cat['catName']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" id="price" class="form-control" name="price"
                                       value="<?php echo isset($product) ? $product['price'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control"
                                          placeholder="write description here"><?php echo isset($product) ? $product['description'] : ''; ?></textarea>
                            </div>

                            <div class="mb-2">
                                <label for="qty" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="qty" id="qty"
                                       value="<?php echo isset($product) ? $product['qty'] : ''; ?>">
                            </div>

                            <div class="mb-2">
                                <?php
                                if (isset($product)) {
                                    echo "<img src='{$product['imgPath']}' style='width: 150px; height: auto;' class='img-thumbnail'><br>";
                                }
                                ?>
                                <label for="img" class="form-label">Product Image</label>
                                <input type="file" class="form-control" name="file" id="img">
                            </div>

                            <div class="mb-2">
                                <button type="submit" class="btn btn-primary" name="updateBtn">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
