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
            header("Location: show_products.php");
            
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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@1,300&family=Poppins&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="add_product_style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script >
            function showForm() {
                var selectedOption = $("#productType").val();
                if (selectedOption === "DVD") {
                    $("#size, #type_label1, #type_label11").show();
                    $("#weight, #height, #width, #length, #type_label2, #type_label3, #type_label4, #type_label5, #type_label22, #type_label33").hide();
                    $("#type_label11").text("Please, provide disk space in MB");
                } else if (selectedOption === "Book") {
                    $("#weight, #type_label2, #type_label22").show();
                    $("#size, #height, #width, #length, #type_label1, #type_label3, #type_label4, #type_label5, #type_label11, #type_label33").hide();
                    $("#type_label22").text("Please, provide book weight in KG");
                } else if (selectedOption === "Furniture") {
                    $("#height, #width, #length, #type_label3, #type_label4, #type_label5 , #type_label33").show();
                    $("#size, #weight, #type_label1, #type_label2, #type_label11, #type_label22").hide();
                    $("#type_label33").text("Please, provide furniture dimensions in CM");
                } else {
                    $("#size, #weight, #height, #width, #length, #type_label1, #type_label2, #type_label3, #type_label4, #type_label5, #type_label11, #type_label22, #type_label33").hide();
                }
            }
            $(document).ready(function() {
                $("#productType").change(function() {
                    if ($(this).val() === "DVD") {
                        $("#size").prop("required", true);
                        $("#weight").prop("required", false);
                        $("#height").prop("required", false);
                        $("#width").prop("required", false);
                        $("#length").prop("required", false);
                    } else if ($(this).val() === "Book") {
                        $("#size").prop("required", false);
                        $("#weight").prop("required", true);
                        $("#height").prop("required", false);
                        $("#width").prop("required", false);
                        $("#length").prop("required", false);
                    } else if ($(this).val() === "Furniture") {
                        $("#size").prop("required", false);
                        $("#weight").prop("required", false);
                        $("#height").prop("required", true);
                        $("#width").prop("required", true);
                        $("#length").prop("required", true);
                    }
                });
            });
           

        </script>
        <title>Adding Product</title>
        <style>
            *{
                margin: 0;
                
            }
            body {
                margin: 0;
                font-family: 'Poppins', sans-serif;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: rgb(235,239,246);
            }
            .header, .head {
                position: absolute;
                display: flex;
                align-items: center;
                height: 70px;
                width: 100%;
                color: #fff;
                top: 0;
                text-align: center;
            }

            .header a {
                font-size: 24px;
                font-weight: bold;
                margin-left: 30px;
                color: rgb(224,79,79);
                text-decoration: none;
                transition: 0.3s;
                z-index: 1;
            }
            .header a:hover{
                font-size: 25px;
                transition: 0.3s;
            }
            .head{
                text-align: center;
                justify-content: center;
            }
            .head h2{
                color: black;
                font-weight: lighter;
            }
            #product_form{
                display: flex;
                flex-direction: column;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4);
                transition: 0.3s;
                width: 300px;
                text-align: center;
                align-items: center;
                padding: 20px;
                background-color: rgba(76,175,80, 0.25);
                margin-top: 65px;
                margin-bottom: 50px;
            }
            #product_form:hover{
                box-shadow: 0 6px 9px 0 rgba(0, 0, 0, 0.5);
                transition: 0.3s;
            }
            #product_form input:hover{
                box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.4);
                transition: 0.3s;
            }
            #product_form button{
                background-color: #4CAF50;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-top: 20px;
            }
            
            #productType{
                width: 100px;
                height: 25px;
            }
            #productType:hover{
                box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.4);
                transition: 0.3s;
            }
            .buttons button:hover{
                box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.4);
                transition: 0.3s;
            }
            .buttons #cancel{
                background-color: rgb(230, 0, 0);
            }
            .description{
                margin-top: 10px;
                font-weight: bold;
                font-size: smaller;
            }
            footer {
                height: 50px;
                background-color: #333;
                color: #fff;
                font-size: 15px;
                bottom: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }
            
            
        </style>
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
            <button type="button" id="cancel" onclick="window.location.href='show_products.php'">Cancel</button>
        </div>
        
            

        </form>
        
    </body>

</html>