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

// Aqui eu informo onde fica o arquivo que guarda as estadias.
$arquivoDados = __DIR__ . '/../data/estadias.json';

// Aqui eu verifico se o arquivo já existe.
if (file_exists($arquivoDados)) {

    // Leio o conteúdo que foi salvo anteriormente.
    $conteudo = file_get_contents($arquivoDados);

    // Transformo o texto JSON em um array do PHP.
    $dadosSalvos = json_decode($conteudo ?: '[]', true);

    // Confiro se consegui recuperar uma lista.
    if (is_array($dadosSalvos)) {

        // Aqui eu percorro cada estadia salva no arquivo.
        foreach ($dadosSalvos as $dados) {

            // Confiro se o registro possui as informações necessárias.
            if (
                !is_array($dados) ||
                !isset($dados['veiculo'], $dados['horas']) ||
                !is_array($dados['veiculo'])
            ) {
                continue;
            }

            // Recupero os dados do veículo.
            $tipo = $dados['veiculo']['tipo'] ?? '';
            $placa = $dados['veiculo']['placa'] ?? '';
            $modelo = $dados['veiculo']['modelo'] ?? '';
            $horas = $dados['horas'];

            // Confiro os tipos antes de criar os objetos.
            if (
                !is_string($tipo) ||
                !is_string($placa) ||
                !is_string($modelo) ||
                !is_numeric($horas) ||
                (float) $horas <= 0
            ) {
                continue;
            }

            try {

                // Recrio o veículo usando sua classe correspondente.
                if ($tipo === 'Carro') {
                    $veiculo = new Carro($placa, $modelo);

                } elseif ($tipo === 'Moto') {
                    $veiculo = new Moto($placa, $modelo);

                } elseif ($tipo === 'Caminhonete') {
                    $veiculo = new Caminhonete($placa, $modelo);

                } else {
                    continue;
                }

                // Recrio a estadia e recupero as horas registradas.
                $estadia = new Estadia($veiculo);
                $estadia->encerrar((float) $horas);

                // Coloco a estadia recuperada na lista do estacionamento.
                $estacionamento->adicionarEstadia($estadia);

            } catch (Exception $e) {

                // Se algum registro estiver errado, pulo esse registro.
                continue;
            }
        }
    }
}

// 3. Aqui eu preparo as mensagens do formulário.
$mensagem = '';
$erro = '';
$resultado = null;

// Aqui eu verifico se o usuário enviou o formulário.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        // Aqui eu recebo os dados digitados no formulário.
        $tipo = $_POST['tipo'] ?? '';
        $placa = $_POST['placa'] ?? '';
        $modelo = $_POST['modelo'] ?? '';
        $horas = $_POST['horas'] ?? '';

        // Confiro se os dados recebidos são textos.
        if (
            !is_string($tipo) ||
            !is_string($placa) ||
            !is_string($modelo) ||
            !is_string($horas)
        ) {
            throw new Exception("Dados inválidos.");
        }

        // Não deixo o usuário enviar um tempo vazio ou inválido.
        if (!is_numeric($horas)) {
            throw new Exception("Informe um tempo válido.");
        }

        // Aqui eu crio o veículo de acordo com o tipo escolhido.
        if ($tipo === 'carro') {
            $veiculo = new Carro($placa, $modelo);

        } elseif ($tipo === 'moto') {
            $veiculo = new Moto($placa, $modelo);

        } elseif ($tipo === 'caminhonete') {
            $veiculo = new Caminhonete($placa, $modelo);

        } else {
            throw new Exception("Escolha um tipo de veículo válido.");
        }

        // Aqui eu crio uma estadia para esse veículo.
        $estadia = new Estadia($veiculo);

        // Registro quantas horas o veículo ficou estacionado.
        $estadia->encerrar((float) $horas);

        // Aqui eu preparo os dados da estadia cadastrada.
        $resultado = $estadia->paraArray();

        // Pego as estadias que já estavam no estacionamento.
        $historico = $estacionamento->paraArray()['estadias'];

        // Adiciono o novo registro ao histórico.
        $historico[] = $resultado;

        // Transformo toda a lista em texto JSON.
        $json = json_encode(
            $historico,
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );

        // Confiro se consegui preparar o JSON.
        if ($json === false) {
            throw new Exception("Não foi possível preparar o histórico.");
        }

        // Salvo a lista no arquivo.
        $salvou = file_put_contents(
            $arquivoDados,
            $json,
            LOCK_EX
        );

        // Se não conseguir salvar, aviso ao usuário.
        if ($salvou === false) {
            throw new Exception("Não foi possível salvar a estadia.");
        }

        // Depois de salvar, adiciono a estadia ao estacionamento.
        $estacionamento->adicionarEstadia($estadia);

        // Mostro uma mensagem confirmando o cadastro.
        $mensagem = "Estadia registrada com sucesso!";

    } catch (Exception $e) {

        // Se acontecer algum erro, mostro a mensagem sem derrubar o site.
        $erro = $e->getMessage();
    }
}

// 4. Aqui eu verifico se o usuário pediu os dados em JSON.
$formato = $_GET['formato'] ?? 'html';

// Se o formato escolhido for JSON, eu devolvo os dados do estacionamento.
if ($formato === 'json') {

    // Aqui eu aviso ao navegador que a resposta será JSON.
    header('Content-Type: application/json; charset=utf-8');

    // Transformo os dados do estacionamento em JSON.
    echo json_encode(
        $estacionamento->paraArray(),
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );

    // Aqui eu encerro o PHP para não mostrar o HTML depois.
    exit;
}

// 5. Aqui eu verifico qual página o usuário quer abrir.
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

            <!-- Aqui eu mostro o formulário de cadastro. -->
            <h2>Cadastrar veículo</h2>

            <p>
                Preencha os dados do veículo para calcular
                o valor da estadia.
            </p>

            <!-- Se acontecer algum erro, mostro a mensagem. -->
            <?php if ($erro !== ''): ?>

                <div class="erro">
                    <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
                </div>

            <?php endif; ?>

            <!-- Se o cadastro funcionar, mostro a confirmação. -->
            <?php if ($mensagem !== ''): ?>

                <div class="sucesso">
                    <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>
                </div>

            <?php endif; ?>

            <!-- Aqui eu envio os dados para o próprio index.php. -->
            <form method="POST" action="?pagina=veiculos">

                <label for="tipo">Tipo de veículo</label>

                <select id="tipo" name="tipo" required>
                    <option value="">Selecione o tipo</option>
                    <option value="carro">Carro</option>
                    <option value="moto">Moto</option>
                    <option value="caminhonete">Caminhonete</option>
                </select>

                <label for="placa">Placa</label>

                <input
                    type="text"
                    id="placa"
                    name="placa"
                    placeholder="Ex.: ABC1234"
                    maxlength="7"
                    required
                >

                <label for="modelo">Modelo</label>

                <input
                    type="text"
                    id="modelo"
                    name="modelo"
                    placeholder="Ex.: Toyota Corolla"
                    required
                >

                <label for="horas">Tempo estacionado (horas)</label>

                <input
                    type="number"
                    id="horas"
                    name="horas"
                    min="0.1"
                    step="0.1"
                    placeholder="Ex.: 2"
                    required
                >

                <button type="submit">
                    Calcular estadia
                </button>

            </form>

            <!-- Aqui eu mostro o resultado do cálculo. -->
            <?php if ($resultado !== null): ?>

                <div class="sucesso">

                    <h3>Resultado da estadia</h3>

                    <p>
                        <strong>Placa:</strong>
                        <?= htmlspecialchars($resultado['veiculo']['placa'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <p>
                        <strong>Modelo:</strong>
                        <?= htmlspecialchars($resultado['veiculo']['modelo'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <p>
                        <strong>Tempo:</strong>
                        <?= htmlspecialchars((string) $resultado['horas'], ENT_QUOTES, 'UTF-8') ?>
                        hora(s)
                    </p>

                    <p>
                        <strong>Valor a pagar:</strong>
                        R$ <?= number_format($resultado['valor'], 2, ',', '.') ?>
                    </p>

                </div>

            <?php endif; ?>

            <!-- ========================================= -->
            <!-- HISTÓRICO DE ESTADIAS -->
            <!-- ========================================= -->

            <!-- Aqui eu mostro o histórico na página de veículos. -->
            <h2>Histórico de estadias</h2>

            <?php
            // Aqui eu pego os dados do estacionamento.
            $dadosEstacionamento = $estacionamento->paraArray();

            // Guardo a lista de estadias em uma variável.
            $listaEstadias = $dadosEstacionamento['estadias'];
            ?>

            <!-- Se não tiver nenhum registro, mostro um aviso. -->
            <?php if (empty($listaEstadias)): ?>

                <p>Nenhuma estadia cadastrada ainda.</p>

            <?php else: ?>

                <!-- Aqui eu monto a tabela com os veículos cadastrados. -->
                <div style="overflow-x: auto;">

                    <table>
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Modelo</th>
                                <th>Tipo</th>
                                <th>Horas</th>
                                <th>Valor</th>
                            </tr>
                        </thead>

                        <tbody>

                            <!-- Aqui eu percorro cada estadia da lista. -->
                            <?php foreach ($listaEstadias as $item): ?>

                                <tr>
                                    <td>
                                        <?= htmlspecialchars($item['veiculo']['placa'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($item['veiculo']['modelo'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($item['veiculo']['tipo'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars((string) $item['horas'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td>
                                        R$ <?= number_format($item['valor'], 2, ',', '.') ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>

                </div>

                <!-- Aqui eu mostro o total de todas as estadias. -->
                <h3>
                    Total arrecadado:
                    R$ <?= number_format($dadosEstacionamento['total'], 2, ',', '.') ?>
                </h3>

            <?php endif; ?>

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
