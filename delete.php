<?php
class Product
{
    private $conn;

    public function __construct($host, $user, $password, $db)
    {
        $this->conn = new mysqli($host, $user, $password, $db);
    }

    public function delete($selected)
    {
        foreach ($selected as $sku) {
            $sql = "DELETE FROM products WHERE sku='".$sku."'";
            $result = $this->conn->query($sql);
        }

        $this->conn->close();
    }
}

if (isset($_POST['delete'])) {
    $product = new Product("localhost", "root", "", "scandiweb");
    $selected = $_POST['selected'];
    $product->delete($selected);
}

header("Location: index.php");
?>
