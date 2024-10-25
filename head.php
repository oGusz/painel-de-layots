<!DOCTYPE html>
<html lang="pt-br">

<?php
$url = 'http://localhost/painel-de-layots/'

    ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Codes</title>
    <link rel="icon" type="image/png" href="favicon.png">


    <!-- highlight js -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/atom-one-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>


    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Toastr CSS e JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- CodeMirror e os módulos necessários -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/edit/closetag.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/edit/closebrackets.min.js"></script>


    <!-- Owl Carousel js -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>





    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="reset.css">

</head>

<body>
    <header>
        <div class="blur"></div>
        <div class="wrapper container-header">
            <a href="<?= $url ?>" class="logo">
                <figure>
                    <img width="100" height="100" src="logo.png" alt="Logo" title="Logo">
                </figure>
            </a>
            <?php
            include 'db_connection.php';

            // Consulta para obter todas as categorias
            $result = $conn->query("SELECT * FROM categories");

            // Contador de itens
            $items_count = $result->num_rows;
            ?>

            <nav id="menu" class="<?= $items_count > 6 ? 'hamburger-menu' : '' ?>">
                <ul id="ul-menu" class="<?= $items_count > 6 ? 'overflow' : '' ?>">
                    <!-- Adiciona a classe 'overflow' -->
                    <?php if ($items_count > 0): ?>
                        <!-- Gerar links de categorias dinâmicas -->
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <li><a href="category.php?id=<?= $row['id']; ?>"><?= htmlspecialchars($row['name']); ?></a></li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No categories found.</p>
                    <?php endif; ?>
                </ul>

                <!-- Ícone de Menu Hamburger (aparece apenas quando há mais de 6 itens) -->
                <button class="hamburger-icon" onclick="toggleMenu()">&#9776;</button>
            </nav>


            <script>
                function toggleMenu() {
                    var ulMenu = document.querySelector('#ul-menu');
                    var hamburgerIcon = document.querySelector('.hamburger-icon');

                    ulMenu.classList.toggle('open'); // Alterna a classe 'open' no UL

                    // Troca o ícone entre o "hambúrguer" e o ícone "x" com uma transição
                    if (ulMenu.classList.contains('open')) {
                        hamburgerIcon.innerHTML = "&#9932;"; // Ícone de "x"
                        hamburgerIcon.classList.add('open'); // Adiciona a classe de estado aberto
                    } else {
                        hamburgerIcon.innerHTML = "&#9776;"; // Ícone de "hambúrguer"
                        hamburgerIcon.classList.remove('open'); // Remove a classe de estado aberto
                    }
                }
            </script>





        </div>
    </header>