<?php
include('head.php');
?>

<div class="container">
    <div class="wrapper content-home">


        <div class="content-title-home">
            <h1>Bem-vindo a Galeria de Layouts</h1>

            <!-- <a href="dashboard.php">Visualizar Layouts</a> -->
            <a href="add-code.php">Adicionar novo Layout</a>

        </div>
        <div class="group-button-categories">
            <?php
            include 'db_connection.php';

            // Consulta para obter todas as categorias
            $result = $conn->query("SELECT * FROM categories");

            if ($result->num_rows > 0): ?>
                <h2>Categorias</h2>
                <div class='categories'> <!-- Container para os botões -->
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <!-- Cria um botão para cada categoria -->
                        <button onclick="window.location.href='category.php?id=<?= $row['id']; ?>'">
                            <?= htmlspecialchars($row['name']); ?>
                        </button>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No categories found.</p>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php
include('footer.php');
?>