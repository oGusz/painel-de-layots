<?php
include('head.php');
?>


    <h1>Welcome to Layout Library</h1>
    <a href="dashboard.php">View Layouts</a>
    <a href="add_code.php">Add New Layout</a>


    <?php
    include 'db_connection.php';

    // Consulta para obter todas as categorias
    $result = $conn->query("SELECT * FROM categories");

    if ($result->num_rows > 0) {
        echo "<h2>Categories</h2>";
        echo "<div class='categories'>"; // Container para os botões
        while ($row = $result->fetch_assoc()) {
            // Cria um botão para cada categoria
            echo "<button onclick=\"window.location.href='category.php?id=" . $row['id'] . "'\">" . htmlspecialchars($row['name']) . "</button>";
        }
        echo "</div>";
    } else {
        echo "No categories found.";
    }
    ?>


<?php
include('footer.php');
?>


