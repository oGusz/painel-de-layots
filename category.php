<?php
include 'db_connection.php';
include 'head.php';

if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']);

    $result = $conn->query("SELECT layouts.*, categories.name as category_name FROM layouts
                            LEFT JOIN categories ON layouts.category_id = categories.id
                            WHERE categories.id = $category_id");

    if ($result->num_rows > 0) {
        $category_name = htmlspecialchars($result->fetch_assoc()['category_name']);
        ?>

        <h2 class="title-primary-category">Layouts na Categoria: <?= $category_name ?></h2>

        <div class="carrosel-owl-category owl-carousel owl-theme">
            <?php
            $result->data_seek(0); // Reinicializa o ponteiro do resultado
    
            while ($row = $result->fetch_assoc()) {
                $layout_name = htmlspecialchars($row['name']);
                $html_code = htmlspecialchars($row['html']);
                $css_code = !empty($row['css']) ? htmlspecialchars($row['css']) : null;
                $js_code = !empty($row['js']) ? htmlspecialchars($row['js']) : null;
                $layout_id = intval($row['id']);

                $html_id = "html-code-" . $layout_id;
                $css_id = $css_code ? "css-code-" . $layout_id : null;
                $js_id = $js_code ? "js-code-" . $layout_id : null;
                $iframe_id = "iframe-preview-" . $layout_id;
                ?>
                <div class="layout item">
                    <div class="wrapper">
                        <h3><?= $layout_name ?> (<?= $category_name ?>)</h3>

                        <h4>Preview:</h4>
                        <div>
                            <iframe class="preview" id="<?= $iframe_id ?>"></iframe>
                        </div>
                        <div class="content-general-code">
                            <div class="content-code">
                                <h4>HTML Code:</h4>
                                <pre><code class="language-html" id="<?= $html_id ?>"><?= $html_code ?></code></pre>
                                <button onclick="copyToClipboard('<?= $html_id ?>')">Copiar HTML</button>
                            </div>
                            <?php if ($css_code): ?>
                                <div class="content-code">
                                    <h4>CSS Code:</h4>
                                    <pre><code class="language-css" id="<?= $css_id ?>"><?= $css_code ?></code></pre>
                                    <button onclick="copyToClipboard('<?= $css_id ?>')">Copiar CSS</button>
                                </div>
                            <?php endif; ?>
                            <?php if ($js_code): ?>
                                <div class="content-code">
                                    <h4>JS Code:</h4>
                                    <pre><code class="language-javascript" id="<?= $js_id ?>"><?= $js_code ?></code></pre>
                                    <button onclick="copyToClipboard('<?= $js_id ?>')">Copiar JS</button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Botão de deletar layout manter comentado -->
                        <!--
                        <form method="get" action="category.php" onsubmit="return confirm('Deseja realmente deletar este layout?');">
                            <input type="hidden" name="id" value="<?= $category_id ?>">
                            <input type="hidden" name="delete_id" value="<?= $layout_id ?>">
                            <button type="submit" class="delete-button">Deletar Layout</button>
                        </form>
                        -->
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <?php
    } else {
        echo "<p>No layouts found in this category.</p>";
    }

    if (isset($_GET['delete_id'])) {
        $id = intval($_GET['delete_id']);
        $sql = "DELETE FROM layouts WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>toastr.success('Layout deletado com sucesso!');</script>";
            $result = $conn->query("SELECT COUNT(*) AS total FROM layouts");
            $row = $result->fetch_assoc();

            if ($row['total'] == 0) {
                $conn->query("ALTER TABLE layouts AUTO_INCREMENT = 1");
            }
        } else {
            echo "<script>toastr.error('Erro ao deletar layout: " . htmlspecialchars($conn->error) . "');</script>";
        }
    }
} else {
    echo "<script>toastr.error('Nenhum ID de categoria fornecido.');</script>";
}
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
            <?php
            $result->data_seek(0); // Reinicializa o ponteiro do resultado
            while ($row = $result->fetch_assoc()) {
                $layout_id = intval($row['id']);
                echo "updatePreview($layout_id);";
            }
            ?>
            hljs.highlightAll();
        }, 0); // Aguarda o carregamento total do DOM
    });


    function copyToClipboard(elementId) {
        const codeElement = document.getElementById(elementId);

        if (!codeElement) {
            toastr.error("Elemento não encontrado: " + elementId);
            return;
        }

        navigator.clipboard.writeText(codeElement.textContent.trim())
            .then(() => {
                toastr.success("Código copiado para a área de transferência!");
            })
            .catch(err => {
                console.error('Falha ao copiar: ', err);
                toastr.error("Falha ao copiar o código.");
            });
    }

    // Função para atualizar a pré-visualização do layout
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
                    <head><style>${cssCode}</style></head>
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
</script>

<script>
    $(document).ready(function () {
        $(".carrosel-owl-category").owlCarousel({
            items: 1,             // Número de itens a serem exibidos
            loop: false,           // Loop contínuo
            autoplay: false,      // Desativar autoplay
            nav: true,            // Ativar navegação
            dots: true            // Ativar pontos de navegação
        });
    });
</script>

<?php include('footer.php'); ?>