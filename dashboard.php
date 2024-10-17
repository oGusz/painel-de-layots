
<?php
include('head.php'); // Inclui o cabeçalho
?>

<body>

<?php
include 'db_connection.php';


// Consulta com JOIN para obter o nome da categoria
$result = $conn->query("SELECT layouts.*, categories.name as category_name FROM layouts
                        LEFT JOIN categories ON layouts.category_id = categories.id");

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='layout'>";
        echo "<h2>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['category_name']) . ")</h2>"; // Mostrando o nome da categoria
        echo "<pre><code>" . htmlspecialchars($row['html']) . "</code></pre>";
        echo "<button onclick='copyToClipboard(`" . addslashes($row['html']) . "`)'>Copy HTML</button>";
        
        if (!empty($row['css'])) {
            echo "<pre><code>" . htmlspecialchars($row['css']) . "</code></pre>";
            echo "<button onclick='copyToClipboard(`" . addslashes($row['css']) . "`)'>Copy CSS</button>";
        }
        
        if (!empty($row['js'])) {
            echo "<pre><code>" . htmlspecialchars($row['js']) . "</code></pre>";
            echo "<button onclick='copyToClipboard(`" . addslashes($row['js']) . "`)'>Copy JS</button>";
        }
        echo "</div><hr>";
    }
} else {
    echo "<p>No layouts found.</p>";
}

// Verificar se a solicitação é para deletar um layout
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $sql = "DELETE FROM layouts WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Layout deleted successfully!</p>";
        
        // Checar se a tabela está vazia
        $result = $conn->query("SELECT COUNT(*) AS total FROM layouts");
        $row = $result->fetch_assoc();
        
        if ($row['total'] == 0) {
            // Resetar o AUTO_INCREMENT se não houver mais layouts
            $conn->query("ALTER TABLE layouts AUTO_INCREMENT = 1");
        }
    } else {
        echo "<p>Error deleting layout: " . htmlspecialchars($conn->error) . "</p>";
    }
}

// Aqui você pode listar os layouts e fornecer opções para deletá-los
$result = $conn->query("SELECT * FROM layouts");
?>

<h2>Layouts</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Ação</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td>
                <a href="edit_layout.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this layout?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<script>
function copyToClipboard(text) {
    // Cria um elemento temporário para copiar o texto
    const tempInput = document.createElement("textarea");
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy"); // Copia o texto
    document.body.removeChild(tempInput); // Remove o elemento temporário

    // Alerta opcional para informar que o texto foi copiado
    alert("Código copiado para a área de transferência!");
}
</script>

<?php
include('footer.php'); // Inclui o rodapé
?>

