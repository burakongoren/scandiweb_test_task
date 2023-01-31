<?php
require 'connection.php';

class Product{
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    protected $size;
    protected $dimensions;
    protected $weight;

    public function __construct($sku, $name, $price, $type, $size, $dimensions, $weight)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
        $this->size = $size;
        $this->dimensions = $dimensions;
        $this->weight = $weight;
    }

    public function addProduct()
    {
        global $conn;
        $sql = "INSERT INTO products VALUES('$this->sku', '$this->name', '$this->price', '$this->type', '$this->size', '$this->dimensions', '$this->weight')";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            
        } else {
            echo "<script> alert('Please enter a different sku. The sku you entered has been used before'); </script>";
        }
    }
}

if (isset($_POST["add"])) {
    $sku = $_POST["sku"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $type = $_POST["productType"];
    if ($type === "DVD") {
        $size = $_POST["size"];
        $weight = "0";
        $dimensions = "0";
    } else if ($type === "Book") {
        $size = "0";
        $weight = $_POST["weight"];
        $dimensions = "0";
    } else if ($type === "Furniture") {
        $size = "0";
        $weight = "0";
        $dimensions = $_POST["height"] . " x " . $_POST["width"] . " x " . $_POST["length"];
    }
    $product = new Product($sku, $name, $price, $type, $size, $dimensions, $weight);
    $product->addProduct();
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/add_product.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@1,300&family=Poppins&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="add_product_style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="script/add_product.js" ></script>
        <title>Adding Product</title>
    </head>
    <body>
        <div class="header">
            <a href="https://scandiweb.com/">scandiweb</a>
        </div>
        <div class="head">
            <h2>Adding Product</h2>
        </div>
        <form id="product_form" action="" method="POST" autocomplete="off"><!--method = post -->
            <label for="sku">SKU</label>
            <input id="sku" type="text" name="sku" required>
            <br><br>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" required>
            <br><br>
            <label for="price">Price (€)</label>
            <input id="price" type="number" name="price" required>
            <br><br>
            <label for="productType">Select Product Type</label>
            <select id="productType" onchange="showForm()" name="productType" required>
                <option value="DVD" selected>DVD</option>
                <option value="Book">Book</option>
                <option value="Furniture">Furniture</option>
            </select>
            <br><br>
            <label id="type_label1" for="size">Size (MB)</label>
            <input type="number" id="size" name="size" required>
            <label class="description" id="type_label11" for="size">Please, provide disk space in MB</label>
            <label id="type_label2" for="weight" style="display: none;">Weight (KG)</label>
            <input type="number" id="weight" name="weight" style="display: none;">
            <label class="description" id="type_label22" for="size" style="display: none;"></label>
            <label class="furn_labels" id="type_label3" for="height" style="display: none;">Height (CM)</label>
            <input type="number" id="height" name="height" style="display: none;">
            <label class="furn_labels" id="type_label4" for="width" style="display: none;">Width (CM)</label>
            <input type="number" id="width" name="width" style="display: none;">
            <label class="furn_labels" id="type_label5" for="length" style="display: none;">Length(CM)</label>
            <input type="number" id="length" name="length" style="display: none;">
            <label class="description" id="type_label33" for="size" style="display: none;"></label>
            <br>
        <div class="buttons">
            <button id="add" type="add" value="add" name="add">Save</button>
            <button type="button" id="cancel" onclick="window.location.href='index.php'">Cancel</button>
        </div>
        
            

        </form>
        
    </body>

</html>