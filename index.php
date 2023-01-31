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
        <link rel="stylesheet" href="style/index.css">
        <title>Product List</title>
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