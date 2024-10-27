-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27-Out-2024 às 05:58
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db__painel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Header'),
(2, 'Footer'),
(3, 'Button'),
(4, 'Text and Image');

-- --------------------------------------------------------

--
-- Estrutura da tabela `layouts`
--

CREATE TABLE `layouts` (
  `id` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `category` decimal(11,0) NOT NULL,
  `html` text DEFAULT NULL,
  `css` text DEFAULT NULL,
  `js` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `layouts`
--

INSERT INTO `layouts` (`id`, `name`, `category`, `html`, `css`, `js`, `category_id`) VALUES
(9, 'Footer 1', '0', '<footer>\r\n    <div class=\"container\">\r\n        <div class=\"wrapper\">\r\n\r\n     \r\n            <p class=\"text-copy\">Copyright &copy; Gustavo Aparecido da Silva. Todos os Direitos Reservados.</p>\r\n         \r\n        </div>\r\n    </div>\r\n</footer>\r\n</body>\r\n\r\n</html>', 'footer {}\r\n\r\n.text-copy {\r\n  text-align: center;\r\n  font-size: 12px;\r\n}\r\n', '', 2),
(11, 'HEADER 1', '0', '    <header>\r\n        <div class=\"blur\"></div>\r\n        <div class=\"wrapper container-header\">\r\n            <a href=\"<?= $url ?>\" class=\"logo\">\r\n                <figure>\r\n                    <img width=\"100\" height=\"100\" src=\"logo.png\" alt=\"Logo\" title=\"Logo\">\r\n                </figure>\r\n            </a>\r\n            <?php\r\n            include \'db_connection.php\';\r\n\r\n\r\n            // Consulta para obter todas as categorias\r\n            $result = $conn->query(\"SELECT * FROM categories\");\r\n\r\n\r\n            // Contador de itens\r\n            $items_count = $result->num_rows;\r\n            ?>\r\n\r\n\r\n            <nav id=\"menu\" class=\"<?= $items_count > 6 ? \'hamburger-menu\' : \'\' ?>\">\r\n                <ul id=\"ul-menu\" class=\"<?= $items_count > 6 ? \'overflow\' : \'\' ?>\">\r\n                    <!-- Adiciona a classe \'overflow\' -->\r\n                    <?php if ($items_count > 0): ?>\r\n                        <!-- Gerar links de categorias dinâmicas -->\r\n                        <?php while ($row = $result->fetch_assoc()): ?>\r\n                            <li><a href=\"category.php?id=<?= $row[\'id\']; ?>\"><?= htmlspecialchars($row[\'name\']); ?></a></li>\r\n                        <?php endwhile; ?>\r\n                    <?php else: ?>\r\n                        <p>No categories found.</p>\r\n                    <?php endif; ?>\r\n                </ul>\r\n\r\n\r\n                <!-- Ícone de Menu Hamburger (aparece apenas quando há mais de 6 itens) -->\r\n                <button class=\"hamburger-icon\" onclick=\"toggleMenu()\">&#9776;</button>\r\n            </nav>\r\n\r\n\r\n\r\n            <script>\r\n                function toggleMenu() {\r\n                    var ulMenu = document.querySelector(\'#ul-menu\');\r\n                    var hamburgerIcon = document.querySelector(\'.hamburger-icon\');\r\n\r\n\r\n                    ulMenu.classList.toggle(\'open\'); // Alterna a classe \'open\' no UL\r\n\r\n\r\n                    // Troca o ícone entre o \"hambúrguer\" e o ícone \"x\" com uma transição\r\n                    if (ulMenu.classList.contains(\'open\')) {\r\n                        hamburgerIcon.innerHTML = \"&#9932;\"; // Ícone de \"x\"\r\n                        hamburgerIcon.classList.add(\'open\'); // Adiciona a classe de estado aberto\r\n                    } else {\r\n                        hamburgerIcon.innerHTML = \"&#9776;\"; // Ícone de \"hambúrguer\"\r\n                        hamburgerIcon.classList.remove(\'open\'); // Remove a classe de estado aberto\r\n                    }\r\n                }\r\n            </script>\r\n\r\n\r\n\r\n\r\n\r\n\r\n        </div>\r\n    </header>', '/* HEADER */\r\n.blur {\r\n  position: absolute;\r\n  width: 10%;\r\n  height: 20%;\r\n  border-radius: 100%;\r\n  right: 0;\r\n  top: 0;\r\n  background-color: rgba(255, 255, 255, 0.567);\r\n  filter: blur(150px);\r\n}\r\n\r\n\r\n.logo figure {\r\n  width: 100px;\r\n}\r\n\r\n\r\n.logo figure img {\r\n  display: block;\r\n  width: 100%;\r\n  height: auto;\r\n  object-fit: contain;\r\n}\r\n\r\n\r\n.container-header {\r\n  display: flex;\r\n  justify-content: space-between;\r\n  align-items: center;\r\n}\r\n\r\n\r\n#menu {\r\n  position: relative;\r\n}\r\n\r\n\r\n#menu ul {\r\n  display: none;\r\n  opacity: 0;\r\n  /* Inicialmente invisível */\r\n  transform: scale(0.8);\r\n  /* Começa ligeiramente menor */\r\n  transform-origin: top right;\r\n  /* O ponto de origem da animação é no canto superior direito */\r\n  transition: opacity 0.3s ease, transform 0.3s ease;\r\n  /* Animação suave para opacidade e tamanho */\r\n}\r\n\r\n\r\n#menu ul li {\r\n  font-size: var(--font-size-sm);\r\n  padding: 0.5rem;\r\n  transition: all 0.1s ease-in-out;\r\n  text-align: center;\r\n}\r\n\r\n\r\n#menu ul li:hover {\r\n  transform: scale(1.25);\r\n}\r\n\r\n\r\n#menu ul.open {\r\n  width: max-content;\r\n  padding: 1rem;\r\n  display: flex;\r\n  flex-direction: column;\r\n  gap: 0.625rem;\r\n  position: absolute;\r\n  top: 2.8125rem;\r\n  right: 0;\r\n  background: var(--primary-color);\r\n  opacity: 1;\r\n  /* Totalmente visível quando aberto */\r\n  transform: scale(1);\r\n  /* Retorna ao tamanho original */\r\n}\r\n\r\n\r\n.hamburger-icon {\r\n  display: block;\r\n  font-size: 20px;\r\n  cursor: pointer;\r\n  transition: transform 0.3s ease, opacity 0.3s ease;\r\n  /* Transição suave para escala e opacidade */\r\n}\r\n\r\n\r\n.hamburger-icon.open {\r\n\r\n\r\n  background-color: var(--link-color);\r\n}\r\n\r\n\r\n#menu ul.overflow {\r\n  max-height: 18.75rem;\r\n  overflow-y: scroll;\r\n  scrollbar-width: thin;\r\n  scrollbar-color: var(--link-color) rgba(0, 0, 0, 0.1);\r\n}\r\n\r\n\r\n/* WebKit (Chrome, Safari, Edge) */\r\n#menu ul.overflow::-webkit-scrollbar {\r\n  width: 8px;\r\n  /* Largura da barra de rolagem */\r\n}\r\n\r\n\r\n#menu ul.overflow::-webkit-scrollbar-thumb {\r\n  background-color: var(--link-color);\r\n  border-radius: 10px;\r\n  border: 2px solid rgba(255, 255, 255, 0.3);\r\n}\r\n\r\n\r\n#menu ul.overflow::-webkit-scrollbar-track {\r\n  background-color: white;\r\n  border-radius: 10px;\r\n}\r\n\r\n\r\n#menu ul.overflow::-webkit-scrollbar-corner {\r\n  background-color: var(--text-color);\r\n}\r\n\r\n\r\n\r\n\r\n\r\n\r\n/* END HEADER */', '', 1),
(12, 'HEADER 2', '0', '<header>\r\n        <div class=\"blur\"></div>\r\n        <div class=\"wrapper container-header\">\r\n            <a href=\"<?= $url ?>\" class=\"logo\">\r\n                <figure>\r\n                    <img width=\"100\" height=\"100\" src=\"logo.png\" alt=\"Logo\" title=\"Logo\">\r\n                </figure>\r\n            </a>\r\n            <?php\r\n            include \'db_connection.php\';\r\n\r\n\r\n            // Consulta para obter todas as categorias\r\n            $result = $conn->query(\"SELECT * FROM categories\");\r\n\r\n\r\n            // Contador de itens\r\n            $items_count = $result->num_rows;\r\n            ?>\r\n\r\n\r\n            <nav id=\"menu\" class=\"<?= $items_count > 6 ? \'hamburger-menu\' : \'\' ?>\">\r\n                <ul id=\"ul-menu\" class=\"<?= $items_count > 6 ? \'overflow\' : \'\' ?>\">\r\n                    <!-- Adiciona a classe \'overflow\' -->\r\n                    <?php if ($items_count > 0): ?>\r\n                        <!-- Gerar links de categorias dinâmicas -->\r\n                        <?php while ($row = $result->fetch_assoc()): ?>\r\n                            <li><a href=\"category.php?id=<?= $row[\'id\']; ?>\"><?= htmlspecialchars($row[\'name\']); ?></a></li>\r\n                        <?php endwhile; ?>\r\n                    <?php else: ?>\r\n                        <p>No categories found.</p>\r\n                    <?php endif; ?>\r\n                </ul>\r\n\r\n\r\n                <!-- Ícone de Menu Hamburger (aparece apenas quando há mais de 6 itens) -->\r\n                <button class=\"hamburger-icon\" onclick=\"toggleMenu()\">&#9776;</button>\r\n            </nav>\r\n\r\n\r\n\r\n            <script>\r\n                function toggleMenu() {\r\n                    var ulMenu = document.querySelector(\'#ul-menu\');\r\n                    var hamburgerIcon = document.querySelector(\'.hamburger-icon\');\r\n\r\n\r\n                    ulMenu.classList.toggle(\'open\'); // Alterna a classe \'open\' no UL\r\n\r\n\r\n                    // Troca o ícone entre o \"hambúrguer\" e o ícone \"x\" com uma transição\r\n                    if (ulMenu.classList.contains(\'open\')) {\r\n                        hamburgerIcon.innerHTML = \"&#9932;\"; // Ícone de \"x\"\r\n                        hamburgerIcon.classList.add(\'open\'); // Adiciona a classe de estado aberto\r\n                    } else {\r\n                        hamburgerIcon.innerHTML = \"&#9776;\"; // Ícone de \"hambúrguer\"\r\n                        hamburgerIcon.classList.remove(\'open\'); // Remove a classe de estado aberto\r\n                    }\r\n                }\r\n            </script>\r\n\r\n\r\n\r\n\r\n\r\n\r\n        </div>\r\n    </header>', '/* HEADER */\r\n.blur {\r\n  position: absolute;\r\n  width: 10%;\r\n  height: 20%;\r\n  border-radius: 100%;\r\n  right: 0;\r\n  top: 0;\r\n  background-color: rgba(255, 255, 255, 0.567);\r\n  filter: blur(150px);\r\n}\r\n\r\n\r\n.logo figure {\r\n  width: 100px;\r\n}\r\n\r\n\r\n.logo figure img {\r\n  display: block;\r\n  width: 100%;\r\n  height: auto;\r\n  object-fit: contain;\r\n}\r\n\r\n\r\n.container-header {\r\n  display: flex;\r\n  justify-content: space-between;\r\n  align-items: center;\r\n}\r\n\r\n\r\n#menu {\r\n  position: relative;\r\n}\r\n\r\n\r\n#menu ul {\r\n  display: none;\r\n  opacity: 0;\r\n  /* Inicialmente invisível */\r\n  transform: scale(0.8);\r\n  /* Começa ligeiramente menor */\r\n  transform-origin: top right;\r\n  /* O ponto de origem da animação é no canto superior direito */\r\n  transition: opacity 0.3s ease, transform 0.3s ease;\r\n  /* Animação suave para opacidade e tamanho */\r\n}\r\n\r\n\r\n#menu ul li {\r\n  font-size: var(--font-size-sm);\r\n  padding: 0.5rem;\r\n  transition: all 0.1s ease-in-out;\r\n  text-align: center;\r\n}\r\n\r\n\r\n#menu ul li:hover {\r\n  transform: scale(1.25);\r\n}\r\n\r\n\r\n#menu ul.open {\r\n  width: max-content;\r\n  padding: 1rem;\r\n  display: flex;\r\n  flex-direction: column;\r\n  gap: 0.625rem;\r\n  position: absolute;\r\n  top: 2.8125rem;\r\n  right: 0;\r\n  background: var(--primary-color);\r\n  opacity: 1;\r\n  /* Totalmente visível quando aberto */\r\n  transform: scale(1);\r\n  /* Retorna ao tamanho original */\r\n}\r\n\r\n\r\n.hamburger-icon {\r\n  display: block;\r\n  font-size: 20px;\r\n  cursor: pointer;\r\n  transition: transform 0.3s ease, opacity 0.3s ease;\r\n  /* Transição suave para escala e opacidade */\r\n}\r\n\r\n\r\n.hamburger-icon.open {\r\n\r\n\r\n  background-color: var(--link-color);\r\n}\r\n\r\n\r\n#menu ul.overflow {\r\n  max-height: 18.75rem;\r\n  overflow-y: scroll;\r\n  scrollbar-width: thin;\r\n  scrollbar-color: var(--link-color) rgba(0, 0, 0, 0.1);\r\n}\r\n\r\n\r\n/* WebKit (Chrome, Safari, Edge) */\r\n#menu ul.overflow::-webkit-scrollbar {\r\n  width: 8px;\r\n  /* Largura da barra de rolagem */\r\n}\r\n\r\n\r\n#menu ul.overflow::-webkit-scrollbar-thumb {\r\n  background-color: var(--link-color);\r\n  border-radius: 10px;\r\n  border: 2px solid rgba(255, 255, 255, 0.3);\r\n}\r\n\r\n\r\n#menu ul.overflow::-webkit-scrollbar-track {\r\n  background-color: white;\r\n  border-radius: 10px;\r\n}\r\n\r\n\r\n#menu ul.overflow::-webkit-scrollbar-corner {\r\n  background-color: var(--text-color);\r\n}\r\n\r\n\r\n\r\n\r\n\r\n\r\n/* END HEADER */', '', 1),
(13, 'HEADER 3', '0', '<!DOCTYPE html>\r\n<html lang=\"pt-br\">\r\n\r\n\r\n<?php\r\n$url = \'http://localhost/painel-de-layots/\'\r\n\r\n\r\n    ?>\r\n\r\n\r\n<head>\r\n    <meta charset=\"UTF-8\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <title>Painel Codes</title>\r\n    <link rel=\"icon\" type=\"image/png\" href=\"favicon.png\">\r\n\r\n\r\n\r\n    <!-- highlight js -->\r\n    <link rel=\"stylesheet\"\r\n        href=\"https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/atom-one-dark.min.css\">\r\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js\"></script>\r\n\r\n\r\n\r\n    <!-- jQuery -->\r\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js\"></script>\r\n\r\n\r\n    <!-- Toastr CSS e JS -->\r\n    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css\">\r\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js\"></script>\r\n\r\n\r\n    <!-- CodeMirror e os módulos necessários -->\r\n    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css\">\r\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js\"></script>\r\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/xml/xml.min.js\"></script>\r\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/css/css.min.js\"></script>\r\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/javascript/javascript.min.js\"></script>\r\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/edit/closetag.min.js\"></script>\r\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/edit/closebrackets.min.js\"></script>\r\n\r\n\r\n\r\n    <!-- Owl Carousel js -->\r\n    <link rel=\"stylesheet\"\r\n        href=\"https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css\" />\r\n    <link rel=\"stylesheet\"\r\n        href=\"https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css\" />\r\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js\"></script>\r\n    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js\"></script>\r\n\r\n\r\n\r\n\r\n\r\n\r\n    <link rel=\"stylesheet\" href=\"style.css\">\r\n    <link rel=\"stylesheet\" href=\"reset.css\">\r\n\r\n\r\n</head>\r\n\r\n\r\n<body>\r\n    <header>\r\n        <div class=\"blur\"></div>\r\n        <div class=\"wrapper container-header\">\r\n            <a href=\"<?= $url ?>\" class=\"logo\">\r\n                <figure>\r\n                    <img width=\"100\" height=\"100\" src=\"logo.png\" alt=\"Logo\" title=\"Logo\">\r\n                </figure>\r\n            </a>\r\n            <?php\r\n            include \'db_connection.php\';\r\n\r\n\r\n            // Consulta para obter todas as categorias\r\n            $result = $conn->query(\"SELECT * FROM categories\");\r\n\r\n\r\n            // Contador de itens\r\n            $items_count = $result->num_rows;\r\n            ?>\r\n\r\n\r\n            <nav id=\"menu\" class=\"<?= $items_count > 6 ? \'hamburger-menu\' : \'\' ?>\">\r\n                <ul id=\"ul-menu\" class=\"<?= $items_count > 6 ? \'overflow\' : \'\' ?>\">\r\n                    <!-- Adiciona a classe \'overflow\' -->\r\n                    <?php if ($items_count > 0): ?>\r\n                        <!-- Gerar links de categorias dinâmicas -->\r\n                        <?php while ($row = $result->fetch_assoc()): ?>\r\n                            <li><a href=\"category.php?id=<?= $row[\'id\']; ?>\"><?= htmlspecialchars($row[\'name\']); ?></a></li>\r\n                        <?php endwhile; ?>\r\n                    <?php else: ?>\r\n                        <p>No categories found.</p>\r\n                    <?php endif; ?>\r\n                </ul>\r\n\r\n\r\n                <!-- Ícone de Menu Hamburger (aparece apenas quando há mais de 6 itens) -->\r\n                <button class=\"hamburger-icon\" onclick=\"toggleMenu()\">&#9776;</button>\r\n            </nav>\r\n\r\n\r\n\r\n            <script>\r\n                function toggleMenu() {\r\n                    var ulMenu = document.querySelector(\'#ul-menu\');\r\n                    var hamburgerIcon = document.querySelector(\'.hamburger-icon\');\r\n\r\n\r\n                    ulMenu.classList.toggle(\'open\'); // Alterna a classe \'open\' no UL\r\n\r\n\r\n                    // Troca o ícone entre o \"hambúrguer\" e o ícone \"x\" com uma transição\r\n                    if (ulMenu.classList.contains(\'open\')) {\r\n                        hamburgerIcon.innerHTML = \"&#9932;\"; // Ícone de \"x\"\r\n                        hamburgerIcon.classList.add(\'open\'); // Adiciona a classe de estado aberto\r\n                    } else {\r\n                        hamburgerIcon.innerHTML = \"&#9776;\"; // Ícone de \"hambúrguer\"\r\n                        hamburgerIcon.classList.remove(\'open\'); // Remove a classe de estado aberto\r\n                    }\r\n                }\r\n            </script>\r\n\r\n\r\n\r\n\r\n\r\n\r\n        </div>\r\n    </header>', '/* Reset CSS */\r\n*,\r\n*::before,\r\n*::after {\r\n  box-sizing: border-box;\r\n  margin: 0;\r\n  padding: 0;\r\n  border: 0;\r\n  font: inherit;\r\n  vertical-align: baseline;\r\n}\r\n\r\n\r\n/* HTML5 display-role reset for older browsers */\r\narticle, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {\r\n  display: block;\r\n}\r\n\r\n\r\n/* Reset body defaults */\r\nbody {\r\n  line-height: 1.5;\r\n  margin: 0;\r\n  font-family: var(--font-family);\r\n  background-color: var(--bg-color);\r\n  color: var(--text-color);\r\n  height: 100%;\r\n\r\n\r\n  display: flex;\r\n  flex-direction: column;\r\n}\r\n\r\n\r\nol, ul {\r\n  list-style: none;\r\n}\r\n\r\n\r\nblockquote, q {\r\n  quotes: none;\r\n}\r\n\r\n\r\nblockquote::before, blockquote::after,\r\nq::before, q::after {\r\n  content: \'\';\r\n  content: none;\r\n}\r\n\r\n\r\ntable {\r\n  border-collapse: collapse;\r\n  border-spacing: 0;\r\n}\r\n\r\n\r\n/* Inputs and buttons reset */\r\ninput, button, textarea, select {\r\n  font: inherit;\r\n  outline: none;\r\n}\r\n\r\n\r\n/* Anchor tag reset */\r\na {\r\n  text-decoration: none;\r\n  color: inherit;\r\n}\r\nhtml {\r\n  width: 100%;\r\n  max-width: var(--container-max-width);\r\n  margin: 0 auto;\r\n  height: 100%;\r\n}\r\nmain {\r\n    background-image: linear-gradient(to right top, #071427, #08162a, #08172d, #081930, #091a33);\r\n    background-size: 100%;\r\n    background-repeat: no-repeat;\r\n    font-family: var(--font-family);\r\n    font-size: var(--font-size-base);\r\n\r\n\r\n  }\r\n  \r\n  h1 {\r\n    font-size: var(--heading-size-h1);\r\n    color: var(--title-color);\r\n  }\r\n\r\n\r\n  h2 {\r\n    font-size: var(--heading-size-h2);\r\n    color: var(--title-color);\r\n  }\r\n  h3 {\r\n    font-size: var(--heading-size-h3);\r\n    color: var(--title-color);\r\n  }\r\n\r\n\r\n  p {\r\n    font-weight: 300;\r\n    margin: 5px 0;\r\n  }\r\n  \r\n  button {\r\n    background-color: var(--primary-color);\r\n    color: #fff;\r\n    border-radius: var(--button-radius);\r\n    box-shadow: var(--button-shadow);\r\n    padding: var(--spacing-sm) var(--spacing-md);\r\n  }\r\n  \r\n  .wrapper {\r\n  max-width: var(--wrapper-width);\r\n  width: 100%;\r\n  margin: 0 auto;\r\n  -webkit-box-sizing: border-box;\r\n  box-sizing: border-box;\r\n  padding: 0 10px;\r\n}\r\n\r\n\r\n.container {\r\n  max-width: var(--container-max-width);\r\n  width: 100%;\r\n  display: block;\r\n  margin-left: auto;\r\n  margin-right: auto;\r\n  padding: 32px 0;\r\n  clear: both;\r\n\r\n\r\n  flex: 1;\r\n}\r\n\r\n\r\n.grandient {\r\n  background: linear-gradient(90deg, #3382f8, #fcfeff);\r\n  -webkit-background-clip: text;\r\n  -webkit-text-fill-color: transparent;\r\n}\r\n  \r\n.bg-color {\r\n  background-color: var(--bg-color);\r\n}\r\n\r\n\r\n.sub-title {\r\n  margin: 0;\r\n}', '', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `layouts`
--
ALTER TABLE `layouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `layouts`
--
ALTER TABLE `layouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `layouts`
--
ALTER TABLE `layouts`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
