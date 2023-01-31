<?php
$conn = mysqli_connect("localhost", "root", "", "scandiweb");

if (isset($_POST['delete'])) {
    $selected = $_POST['selected'];

    foreach ($selected as $sku) {
        $sql = "DELETE FROM products WHERE sku='".$sku."'";
        $result = mysqli_query($conn, $sql);
    }
}

mysqli_close($conn);
header("Location: show_products.php");
?>