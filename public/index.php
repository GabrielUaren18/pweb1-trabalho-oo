<?php
declare(strict_types=1);

// =====================================================
// SISTEMA DE GESTÃO DE ESTACIONAMENTO
// Programação Web I - Orientação a Objetos
// =====================================================

// 1. Aqui eu carrego as seis classes do sistema.
require_once __DIR__ . '/../src/Veiculo.php';
require_once __DIR__ . '/../src/Carro.php';
require_once __DIR__ . '/../src/Moto.php';
require_once __DIR__ . '/../src/Caminhonete.php';
require_once __DIR__ . '/../src/Estadia.php';
require_once __DIR__ . '/../src/Estacionamento.php';

// 2. Aqui eu crio o objeto do estacionamento.
$estacionamento = new Estacionamento("Estacionamento Central");

// 3. O formulário POST será implementado depois.

// 4. A resposta JSON também será adicionada depois.

// 5. Aqui eu verifico qual página o usuário quer abrir.
// Se não informar nenhuma, o sistema abre a página inicial.
$pagina = $_GET['pagina'] ?? 'inicio';

// Aqui eu defino quais páginas existem no sistema.
$paginasPermitidas = ['inicio', 'veiculos', 'sobre'];

// Se a página não existir, eu retorno o erro 404.
if (!is_string($pagina) || !in_array($pagina, $paginasPermitidas, true)) {
    http_response_code(404);
    $pagina = 'erro';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Estacionamento Central</title>

    <link rel="stylesheet" href="estilo.css">
</head>

<body>

    <!-- 6. Aqui fica o cabeçalho do sistema. -->
    <header>
        <h1>Estacionamento Central</h1>
        <p>Sistema de Gestão de Estacionamento</p>
    </header>

    <!-- Aqui eu crio o menu de navegação. -->
    <nav>
        <a href="?pagina=inicio">Início</a>
        <a href="?pagina=veiculos">Veículos</a>
        <a href="?pagina=sobre">Sobre</a>
    </nav>

    <!-- 7. Aqui eu mostro o conteúdo da página escolhida. -->
    <main>

        <?php if ($pagina === 'inicio'): ?>

            <!-- Página inicial do sistema. -->
            <h2>Bem-vindo ao estacionamento!</h2>

            <p>
                Aqui você pode gerenciar veículos,
                registrar estadias e consultar valores.
            </p>

            <p>
                <strong>Estacionamento:</strong>
                <?= htmlspecialchars($estacionamento->getNome(), ENT_QUOTES, 'UTF-8') ?>
            </p>

        <?php elseif ($pagina === 'veiculos'): ?>

            <!-- Página de gerenciamento dos veículos. -->
            <h2>Gerenciamento de Veículos</h2>

            <p>
                Nesta página vamos cadastrar carros,
                motos e caminhonetes.
            </p>

            <p>
                Cada tipo de veículo possui sua própria tarifa.
            </p>

            <ul>
                <li>Carro: R$ 6,00 por hora</li>
                <li>Moto: R$ 3,00 por hora</li>
                <li>Caminhonete: R$ 8,00 por hora</li>
            </ul>

        <?php elseif ($pagina === 'sobre'): ?>

            <!-- Página com as informações do projeto. -->
            <h2>Sobre o sistema</h2>

            <p>
                Este sistema foi desenvolvido utilizando PHP
                e os conceitos de Orientação a Objetos.
            </p>

            <p>
                Disciplina: Programação Web I.
            </p>

            <p>
                O projeto utiliza classes, herança,
                polimorfismo, composição e encapsulamento.
            </p>

        <?php else: ?>

            <!-- Essa parte aparece quando a página não existe. -->
            <h2>Erro 404</h2>

            <p>
                A página solicitada não foi encontrada.
            </p>

            <a href="?pagina=inicio">
                Voltar para a página inicial
            </a>

        <?php endif; ?>

    </main>

    <!-- 8. Aqui fica o rodapé do sistema. -->
    <footer>
        <p>
            Estacionamento Central - Projeto PHP OO
        </p>
    </footer>

</body>
</html>
