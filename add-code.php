<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';
include('head.php');

$successMessage = '';
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura e escape dos dados
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $html = isset($_POST['html']) ? trim($_POST['html']) : '';
    $css = isset($_POST['css']) ? trim($_POST['css']) : '';
    $js = isset($_POST['js']) ? trim($_POST['js']) : '';

    // Validação
    if (!empty($name) && !empty($html)) {
        $name = mysqli_real_escape_string($conn, $name);
        $html = mysqli_real_escape_string($conn, $html);
        $css = mysqli_real_escape_string($conn, $css);
        $js = mysqli_real_escape_string($conn, $js);

        // Consulta SQL
        $sql = "INSERT INTO layouts (name, category_id, html, css, js) VALUES ('$name', '$category_id', '$html', '$css', '$js')";

        if ($conn->query($sql) === TRUE) {
            $successMessage = "Layout adicionado com sucesso!";
        } else {
            $errorMessage = "Houve um erro ao adicionar o layout: " . $conn->error;
        }
    } else {
        $errorMessage = "Nome e HTML são obrigatórios!";
    }
}

// Deletando layout
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $sql = "DELETE FROM layouts WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Layout deletado com sucesso!";
    } else {
        $errorMessage = "Erro ao deletar layout: " . $conn->error;
    }
}
?>

<div class="container">
    <div class="wrapper">
        <div class="wrapper-form-add">
            <h2>Adicionar novo Layout</h2>
            <form method="post" action="add-code.php">
                <label class="input" for="name">
                    <input class="input__field" type="text" id="name" placeholder="" name="name" required>
                    <span class="input__label">NOME LAYOUT:</span>
                </label>
                <label class="input" for="category_id">
                    <select class="input__field" id="category_id" name="category_id" required>
                        <?php
                        $result = $conn->query("SELECT * FROM categories");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <span class="input__label">CATEGORIA :</span>
                </label>
                <label class="input input-textarea" for="html">
                    <span class="input__label">HTML :</span>
                    <div id="html-editor" contenteditable="true" class="editor"></div>
                </label>
                <label class="input input-textarea" for="css">
                    <span class="input__label">CSS :</span>
                    <div id="css-editor" contenteditable="true" class="editor"></div>
                </label>
                <label class="input input-textarea" for="js">
                    <span class="input__label">JAVASCRIPT :</span>
                    <div id="js-editor" contenteditable="true" class="editor"></div>
                </label>
                <input class="btn-submit-add-code" type="submit" value="Enviar Layout">
            </form>
        </div>
    </div>
</div>

<script>
    // Exibir mensagens de sucesso e erro usando Toastr
    <?php if ($successMessage): ?>
        toastr.success(<?= json_encode($successMessage) ?>);
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        toastr.error(<?= json_encode($errorMessage) ?>);
    <?php endif; ?>

    // Inicializa o Highlight.js para realçar a sintaxe
    function highlightCode() {
        document.querySelectorAll('.editor').forEach((editor) => {
            editor.innerHTML = editor.innerHTML.replace(/&/g, '&amp;')
                                               .replace(/</g, '&lt;')
                                               .replace(/>/g, '&gt;');
            const pre = document.createElement('pre');
            const code = document.createElement('code');
            code.className = editor.id === 'html-editor' ? 'language-html' : editor.id === 'css-editor' ? 'language-css' : 'language-javascript';
            code.textContent = editor.innerText;
            pre.appendChild(code);
            editor.innerHTML = '';
            editor.appendChild(pre);
            hljs.highlightElement(code);
        });
    }

  
    document.querySelector('form').addEventListener('submit', function(e) {
        const htmlField = document.createElement('textarea');
        htmlField.name = 'html';
        htmlField.value = document.getElementById('html-editor').innerText; 
        e.target.appendChild(htmlField);

        const cssField = document.createElement('textarea');
        cssField.name = 'css';
        cssField.value = document.getElementById('css-editor').innerText; 
        e.target.appendChild(cssField);

        const jsField = document.createElement('textarea');
        jsField.name = 'js';
        jsField.value = document.getElementById('js-editor').innerText; 
        e.target.appendChild(jsField);
    });

    document.addEventListener("DOMContentLoaded", highlightCode);
</script>

<?php include('footer.php'); ?>
