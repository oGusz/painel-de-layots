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
        $category_name = htmlspecialchars($result->fetch_assoc()['category_name']);
        ?>

        <h2 class="title-primary-category">Layouts na Categoria: <?= $category_name ?></h2>

        <?php
        // Reposicionar a consulta para voltar ao início dos resultados
        $result->data_seek(0); // Volta para o início do resultado

        while ($row = $result->fetch_assoc()) {
            $layout_name = htmlspecialchars($row['name']);
            $category_name = htmlspecialchars($row['category_name']);
            $html_code = htmlspecialchars($row['html']);
            $css_code = !empty($row['css']) ? htmlspecialchars($row['css']) : null;
            $js_code = !empty($row['js']) ? htmlspecialchars($row['js']) : null;
            $layout_id = intval($row['id']);

            // IDs únicos para cada código e iframe
            $html_id = "html-code-" . $layout_id;
            $css_id = $css_code ? "css-code-" . $layout_id : null;
            $js_id = $js_code ? "js-code-" . $layout_id : null;
            $iframe_id = "iframe-preview-" . $layout_id;
            ?>

            <div class="layout">
                <div class="wrapper">
                    <h3><?= $layout_name ?> (<?= $category_name ?>)</h3>

                    <!-- Pré-visualização -->
                    <h4>Preview:</h4>
                    <div>
                        <iframe class="preview" id="<?= $iframe_id ?>">

                        </iframe>
                    </div>
                    <div class="content-general-code">
                    <!-- Exibir HTML -->
                    <div class="content-code">
                        <h4>HTML Code:</h4>
                        <pre><code class="language-html" id="<?= $html_id ?>"><?= $html_code ?></code></pre>
                        <button onclick="copyToClipboard('<?= $html_id ?>')">Copy HTML</button>
                    </div>
                    <!-- Exibir CSS, se disponível -->
                    <?php if ($css_code): ?>
                        <div class="content-code">
                            <h4>CSS Code:</h4>
                            <pre><code class="language-css" id="<?= $css_id ?>"><?= $css_code ?></code></pre>
                            <button onclick="copyToClipboard('<?= $css_id ?>')">Copy CSS</button>
                        </div>
                    <?php endif; ?>

                    <!-- Exibir JS, se disponível -->
                    <?php if ($js_code): ?>
                        <div class="content-code">
                            <h4>JS Code:</h4>
                            <pre><code class="language-javascript" id="<?= $js_id ?>"><?= $js_code ?></code></pre>
                            <button onclick="copyToClipboard('<?= $js_id ?>')">Copy JS</button>
                        </div>
                    <?php endif; ?>
                    </div>
                    <!-- Botão para deletar o layout -->
                    <br><br>
                    <!-- <a class="btn-delete-category" href="?id=<?= $category_id ?>&delete_id=<?= $layout_id ?>"
                        onclick="return confirm('Are you sure you want to delete this layout?');">Deletar Layout</a> -->
                </div>



            </div>

            <hr>

            <script>
                // Função para atualizar a pré-visualização de cada layout
                function updatePreview(layoutId) {
                    const htmlCode = document.getElementById('html-code-' + layoutId).textContent;
                    const cssCode = document.getElementById('css-code-' + layoutId) ? document.getElementById('css-code-' + layoutId).textContent : '';
                    const jsCode = document.getElementById('js-code-' + layoutId) ? document.getElementById('js-code-' + layoutId).textContent : '';

                    const iframe = document.getElementById('iframe-preview-' + layoutId);
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

                    try {
                        iframeDoc.open();
                        iframeDoc.write(`
                                        <html>
                                            <head>
                                                <style>${cssCode}</style>
                                            </head>
                                            <body>
                                                <div class="content-preview" style="height: 100%; width: 100%; display: flex; justify-content: center; align-items: center;">
                                                    ${htmlCode}
                                                    <script>${jsCode}<\/script>
                                                </div>
                                            </body>
                                        </html>
                                    `);
                        iframeDoc.close();
                    } catch (error) {
                        console.error("Error updating preview: ", error);
                    }
                }

                // Atualizar a pré-visualização desse layout específico
                updatePreview(<?= $layout_id ?>);
            </script>


            <?php
        }
    } else {
        echo "<p>No layouts found in this category.</p>";
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
    echo "<p>No category ID provided.</p>";
}
?>

<script>


    // Inicializa o Highlight.js e atualiza a pré-visualização
    document.addEventListener("DOMContentLoaded", function () {
        // Realiza a chamada para atualizar a pré-visualização
        <?php
        // Reposicionar a consulta para voltar ao início dos resultados
        $result->data_seek(0); // Volta para o início do resultado
        
        while ($row = $result->fetch_assoc()) {
            $layout_id = intval($row['id']);
            echo "updatePreview($layout_id);"; // Atualiza a pré-visualização de cada layout
        }
        ?>

        hljs.highlightAll(); // Chama o Highlight.js após a atualização da pré-visualização
    });


    function copyToClipboard(elementId) {
        const codeElement = document.getElementById(elementId);

        // Verifica se o elemento existe
        if (!codeElement) {
            alert("Elemento não encontrado: " + elementId);
            return;
        }

        // Usa a Clipboard API
        navigator.clipboard.writeText(codeElement.textContent.trim())
            .then(() => {
                alert("Código copiado para a área de transferência!");
            })
            .catch(err => {
                console.error('Falha ao copiar: ', err);
                alert("Falha ao copiar o código.");
            });
    }


</script>

<?php include('footer.php'); ?>