<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se os campos estão sendo recebidos corretamente
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0; // Se category_id for número
    $html = isset($_POST['html']) ? $_POST['html'] : '';
    $css = isset($_POST['css']) ? $_POST['css'] : '';
    $js = isset($_POST['js']) ? $_POST['js'] : '';

    // Verifique se as variáveis têm os valores corretos
    if ($name && $html) {
        $sql = "INSERT INTO layouts (name, category_id, html, css, js) VALUES ('$name', '$category_id', '$html', '$css', '$js')";

        if ($conn->query($sql) === TRUE) {
            echo "Layout added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Name and HTML are required!";
    }
}

if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $sql = "DELETE FROM layouts WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Layout deleted successfully!";
        
        // Checar se a tabela está vazia
        $result = $conn->query("SELECT COUNT(*) AS total FROM layouts");
        $row = $result->fetch_assoc();
        
        if ($row['total'] == 0) {
            // Resetar o AUTO_INCREMENT se não houver mais layouts
            $conn->query("ALTER TABLE layouts AUTO_INCREMENT = 1");
        }
    } else {
        echo "Error deleting layout: " . $conn->error;
    }
}
?>

<h2>Add New Layout</h2>
<form method="post" action="add_code.php">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>
    
    <label for="category_id">Category:</label><br>
    <select id="category_id" name="category_id" required>
        <?php
        // Carregar as categorias da tabela categories
        $result = $conn->query("SELECT * FROM categories");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
        }
        ?>
    </select><br><br>

    <label for="html">HTML:</label><br>
    <textarea id="html" name="html" required></textarea><br><br>
    
    <label for="css">CSS:</label><br>
    <textarea id="css" name="css"></textarea><br><br>
    
    <label for="js">JavaScript:</label><br>
    <textarea id="js" name="js"></textarea><br><br>
    
    <input type="submit" value="Add Layout">
</form>


<?php

echo "Name: " . $name . "<br>";
echo "Category ID: " . $category_id . "<br>";
echo "HTML: " . $html . "<br>";
echo "CSS: " . $css . "<br>";
echo "JS: " . $js . "<br>";

?>