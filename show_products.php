<?php
class Database
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct()
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "scandiweb";
    }

    public function connect()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

}
?>


<!--HTML Page -->


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@1,300&family=Poppins&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="show_product.css">
        <title>Product List</title>
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                height: 100vh;
                padding: 40px;
                padding-top: 60px;
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
                z-index: 1;
                transition: 1;
            }
            .header a:hover{
                font-size: 25px;
                transition: 0.3s;
            }
            .head{
                text-align: center;
                justify-content: center;
                margin-right: 30px;
            }
            .head h2{
                color: black;
                font-weight: lighter;
            }

            .card {
                margin: 10px;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3);
                background-color: rgba(76,175,80, 0.25);
                transition: 0.3s;
                width: 320px;
                text-align: center;
                display: inline-block;
                position: relative;
                border-radius: 15px;
            }

            .card:hover {
                box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.5);
            }

            .list-group {
                list-style: none;
                padding: 10px;
            }

            .list-group-item {
                padding-top: 0;
                font-weight: bold;
                border-bottom: 1px solid #ddd;
                margin-top: -20px;
            }

            #add_button {
                background-color: #4CAF50;
                color: white;
                height: 40px;
                width: 80px;
                margin: 7px 0px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                position: absolute;
                right: 210px;
                top: 10px;
                z-index: 1;
                transition: 0.3s;
            }

            #delete-product-btn{
                background-color: #DC0000;
                color: white;
                height: 40px;
                margin: 7px 10px;
                transition: 0.3s;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                float: right;
                position: absolute;
                right: 74px;
                top: 10px;
                z-index: 1;
            }
            #delete-product-btn:hover, #add_button:hover{
                box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.4);
                transition: 0.3s;
            }
            .delete-checkbox{
                cursor: pointer;
                height: 20px;
                width: 20px;
                margin-top: 20px;
                background-color: rgb(230, 0, 0);
            }
           
        </style>
    </head>
    <body>
        <div class="header">
            <a href="https://scandiweb.com/">scandiweb</a>
        </div>
        <div class="head">
            <h2>Product List</h2>
        </div>

        <button type="button" id="add_button" onclick="window.location.href='add_product.php'">ADD</button>

        <div class="container">
            <!--card klasına sahip bir div yaptık, her bir veri bir li olarak ul içinde yer alıyor-->
            <?php
            class Product {
                private $conn;
                private $sku;
                private $name;
                private $price;
                private $type;
                private $size;
                private $dimensions;
                private $weight;

                public function __construct($conn) {
                    $this->conn = $conn;
                }

                public function getData() {
                    $sql = "SELECT sku, name, price, type, size, dimensions, weight FROM products";
                    $result = mysqli_query($this->conn, $sql);
                    $output = '<form action="delete.php" method="post">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        $this->sku = $row['sku'];
                        $this->name = $row['name'];
                        $this->price = $row['price'];
                        $this->type = $row['type'];
                        $this->size = $row['size'];
                        $this->dimensions = $row['dimensions'];
                        $this->weight = $row['weight'];

                        $output .= '<div class="card">'.
                                        '<input type="checkbox" class="delete-checkbox" name="selected[]" value="'.$this->sku.'" />'.
                                        '<ul class="list-group">'.
                                            '<li class="list-group-item">SKU: '.$this->sku.
                                            '</li><li>Name: '.$this->name.
                                            '</li><li>Price: '.$this->price.' €'.
                                            '</li><li>Type: '.$this->type.
                                            $this->displayAttribute().
                                        '</li></ul>'.
                                    '</div>';
                    }

                    $output .= '<input type="submit" id="delete-product-btn" name="delete" value="MASS DELETE" /></form>';

                    return $output;
                }

                private function displayAttribute() {
                    switch ($this->type) {
                        case 'DVD':
                            return '</li><li>Size: '.$this->size.' MB';
                            break;
                        case 'Book':
                            return '</li><li>Weight: '.$this->weight.' KG';
                            break;
                        case 'Furniture':
                            return '</li><li>Dimensions: '.$this->dimensions;
                            break;
                    }
                }
            }

            $conn = mysqli_connect("localhost", "root", "", "scandiweb");
            $product = new Product($conn);
            echo $product->getData();
            mysqli_close($conn);
            ?>
        </div>
        
    </body>

</html>