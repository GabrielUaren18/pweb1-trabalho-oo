<?php
declare(strict_types=1);

// =====================================================================
// Roteiro de testes no terminal: php teste.php
// Mostre cada regra funcionando e cada recusa. Cole a saída em docs/testes.md.
// =====================================================================

// Aqui eu carrego as seis classes do estacionamento.
require_once __DIR__ . '/src/Veiculo.php';
require_once __DIR__ . '/src/Carro.php';
require_once __DIR__ . '/src/Moto.php';
require_once __DIR__ . '/src/Caminhonete.php';
require_once __DIR__ . '/src/Estadia.php';
require_once __DIR__ . '/src/Estacionamento.php';

// =====================================================
// TESTE 1 - HERANÇA E POLIMORFISMO
// =====================================================

echo "=== Teste 1: Herança e polimorfismo ===\n";

// Aqui eu crio três veículos diferentes.
$veiculos = [
    new Carro("CAR1234", "Gol"),
    new Moto("MOT1234", "Honda Biz"),
    new Caminhonete("CAM1234", "Hilux")
];

// Aqui eu percorro os veículos usando o mesmo método.
// Cada tipo de veículo calcula sua própria tarifa.
foreach ($veiculos as $veiculo) {

    $valor = $veiculo->calcularTarifa(2);

    echo get_class($veiculo) . ": R$ "
        . number_format($valor, 2, ',', '.') . "\n";
}

// =====================================================
// TESTE 2 - PLACA VAZIA
// =====================================================

echo "\n=== Teste 2: Recusar placa vazia ===\n";

try {

    // Aqui eu tento criar um carro sem informar a placa.
    new Carro("", "Gol");

    // Se chegar aqui, significa que a regra falhou.
    echo "ERRO: a operação foi aceita\n";

} catch (Exception $e) {

    // Aqui eu mostro que o sistema recusou o cadastro.
    echo "OK, recusado: {$e->getMessage()}\n";
}

// =====================================================
// TESTE 3 - MODELO VAZIO
// =====================================================

echo "\n=== Teste 3: Recusar modelo vazio ===\n";

try {

    // Aqui eu tento cadastrar uma moto sem modelo.
    new Moto("MOT1234", "");

    echo "ERRO: a operação foi aceita\n";

} catch (Exception $e) {

    // O sistema deve avisar que o modelo é obrigatório.
    echo "OK, recusado: {$e->getMessage()}\n";
}

// =====================================================
// TESTE 4 - ESTADIA COM ZERO HORAS
// =====================================================

echo "\n=== Teste 4: Recusar zero horas ===\n";

try {

    // Aqui eu crio um carro e uma estadia.
    $carro = new Carro("ABC1234", "Gol");
    $estadia = new Estadia($carro);

    // Tento encerrar a estadia com zero horas.
    $estadia->encerrar(0);

    echo "ERRO: a operação foi aceita\n";

} catch (Exception $e) {

    // O sistema deve recusar porque o tempo é inválido.
    echo "OK, recusado: {$e->getMessage()}\n";
}

// =====================================================
// TESTE 5 - ESTADIA COM HORAS NEGATIVAS
// =====================================================

echo "\n=== Teste 5: Recusar horas negativas ===\n";

try {

    // Aqui eu crio uma estadia para uma moto.
    $moto = new Moto("MOT1234", "Honda Biz");
    $estadia = new Estadia($moto);

    // Tento informar um tempo negativo.
    $estadia->encerrar(-2);

    echo "ERRO: a operação foi aceita\n";

} catch (Exception $e) {

    // O sistema deve impedir essa operação.
    echo "OK, recusado: {$e->getMessage()}\n";
}

// =====================================================
// TESTE 6 - ENCERRAR A MESMA ESTADIA DUAS VEZES
// =====================================================

echo "\n=== Teste 6: Recusar encerramento repetido ===\n";

try {

    // Aqui eu crio uma estadia para um carro.
    $carro = new Carro("CAR1234", "Gol");
    $estadia = new Estadia($carro);

    // Primeiro eu encerro normalmente com três horas.
    $estadia->encerrar(3);

    // Agora tento encerrar a mesma estadia novamente.
    $estadia->encerrar(4);

    echo "ERRO: a operação foi aceita\n";

} catch (Exception $e) {

    // O sistema deve avisar que ela já foi encerrada.
    echo "OK, recusado: {$e->getMessage()}\n";
}

// =====================================================
// TESTE 7 - CÁLCULO DE UMA ESTADIA
// =====================================================

echo "\n=== Teste 7: Calcular valor da estadia ===\n";

// Aqui eu crio um carro.
$carro = new Carro("ABC1234", "Gol");

// Crio uma estadia e informo três horas.
$estadia = new Estadia($carro);
$estadia->encerrar(3);

// Aqui eu calculo o valor usando o método da classe.
$valor = $estadia->calcularValor();

// O carro cobra R$ 6,00 por hora.
// Então três horas devem custar R$ 18,00.
echo "Valor calculado: R$ "
    . number_format($valor, 2, ',', '.') . "\n";

if ($valor === 18.0) {
    echo "OK, cálculo correto\n";
} else {
    echo "ERRO: cálculo incorreto\n";
}

// =====================================================
// TESTE 8 - COMPOSIÇÃO E TOTAL ARRECADADO
// =====================================================

echo "\n=== Teste 8: Composição e total arrecadado ===\n";

// Aqui eu crio um estacionamento.
$estacionamento = new Estacionamento("Estacionamento Teste");

// Aqui eu crio uma estadia de carro com duas horas.
$carro = new Carro("CAR1234", "Gol");
$estadiaCarro = new Estadia($carro);
$estadiaCarro->encerrar(2);

// Aqui eu crio uma estadia de moto com duas horas.
$moto = new Moto("MOT1234", "Honda Biz");
$estadiaMoto = new Estadia($moto);
$estadiaMoto->encerrar(2);

// Aqui eu crio uma estadia de caminhonete com duas horas.
$caminhonete = new Caminhonete("CAM1234", "Hilux");
$estadiaCaminhonete = new Estadia($caminhonete);
$estadiaCaminhonete->encerrar(2);

// Adiciono as três estadias ao estacionamento.
$estacionamento->adicionarEstadia($estadiaCarro);
$estacionamento->adicionarEstadia($estadiaMoto);
$estacionamento->adicionarEstadia($estadiaCaminhonete);

// Aqui eu somo os valores das três estadias.
// Carro: R$ 12,00
// Moto: R$ 6,00
// Caminhonete: R$ 16,00
// Total: R$ 34,00
$total = $estacionamento->calcularTotal();

echo "Total arrecadado: R$ "
    . number_format($total, 2, ',', '.') . "\n";

if ($total === 34.0) {
    echo "OK, total correto\n";
} else {
    echo "ERRO: total incorreto\n";
}

// =====================================================
// TESTE 9 - CONVERSÃO PARA ARRAY
// =====================================================

echo "\n=== Teste 9: Conversão para array ===\n";

// Aqui eu transformo os dados do estacionamento em array.
$dados = $estacionamento->paraArray();

// Confiro se o array tem as três estadias cadastradas.
if (
    $dados['nome'] === "Estacionamento Teste" &&
    count($dados['estadias']) === 3 &&
    $dados['total'] === 34.0
) {
    echo "OK, dados convertidos corretamente\n";
} else {
    echo "ERRO: dados incorretos no array\n";
}

// =====================================================
// FIM DOS TESTES
// =====================================================

echo "\n=== Fim dos testes ===\n";
