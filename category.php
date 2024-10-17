<?php
include 'db_connection.php';
include 'head.php';

// Verifica se o ID da categoria foi passado na URL
if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']);

    // Consulta para obter os layouts da categoria específica
    $result = $conn->query("SELECT layouts.*, categories.name as category_name FROM layouts
                            LEFT JOIN categories ON layouts.category_id = categories.id
                            WHERE categories.id = $category_id");

    if ($result->num_rows > 0) {
        echo "<h2>Layouts in Category: " . htmlspecialchars($result->fetch_assoc()['category_name']) . "</h2>";

        // Reposicione a consulta para voltar ao início dos resultados
        $result->data_seek(0); // Volta para o início do resultado

        while ($row = $result->fetch_assoc()) {
            echo "<div class='layout'>";
            echo "<h3>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['category_name']) . ")</h3>";
            
            // Exibir HTML
            echo "<h4>HTML Code:</h4>";
            echo "<pre><code class='language-html' id='html-code'>" . htmlspecialchars($row['html']) . "</code></pre>";
            echo "<button onclick='copyToClipboard(" . json_encode($row['html']) . ")'>Copy HTML</button>";
            
            // Exibir CSS
            if (!empty($row['css'])) {
                echo "<h4>CSS Code:</h4>";
                echo "<pre><code class='language-css' id='css-code'>" . htmlspecialchars($row['css']) . "</code></pre>";
                echo "<button onclick='copyToClipboard(" . json_encode($row['css']) . ")'>Copy CSS</button>";
            }
            
            // Exibir JS
            if (!empty($row['js'])) {
                echo "<h4>JS Code:</h4>";
                echo "<pre><code class='language-javascript' id='js-code'>" . htmlspecialchars($row['js']) . "</code></pre>";
                echo "<button onclick='copyToClipboard(" . json_encode($row['js']) . ")'>Copy JS</button>";
            }

            // Div para a pré-visualização
            echo "<h4>Preview:</h4>";
            echo "<iframe class='preview' style='width: 100%; height: 300px; border: 1px solid #ccc;'></iframe>";

            // Botão para deletar o layout
            echo "<br><br><a href='?id=" . $category_id . "&delete_id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this layout?');\">Delete</a>";
            echo "</div><hr>";
        }
    } else {
        echo "No layouts found in this category.";
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
} else {
    echo "No category ID provided.";
}
?>

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

// Função para atualizar a pré-visualização
function updatePreview() {
    const htmlCode = document.getElementById('html-code').textContent;
    const cssCode = document.getElementById('css-code') ? document.getElementById('css-code').textContent : '';
    const jsCode = document.getElementById('js-code') ? document.getElementById('js-code').textContent : '';

    const iframe = document.querySelector('.preview');
    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

    // Limpa o conteúdo do iframe
    iframeDoc.open();
    iframeDoc.write(`
        <html>
            <head>
                <style>${cssCode}</style>
            </head>
            <body>
                ${htmlCode}
                <script>${jsCode}<\/script>
            </body>
        </html>
    `);
    iframeDoc.close();
}

// Inicializa o Highlight.js
document.addEventListener("DOMContentLoaded", function() {
    hljs.highlightAll();
    updatePreview(); // Chama a função para atualizar a pré-visualização
});
</script>

<?php
include('footer.php'); // Inclui o rodapé
?>
