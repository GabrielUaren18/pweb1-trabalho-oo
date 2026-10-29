<?php
declare(strict_types=1);

// Aqui eu carrego a classe mãe, que é Veiculo.
require_once __DIR__ . '/Veiculo.php';

// O extends faz Moto herdar as características de Veiculo.
class Moto extends Veiculo
{
    // Esse construtor recebe a placa e o modelo da moto.
    public function __construct(string $placa, string $modelo)
    {
        // Aqui eu aproveito o construtor da classe mãe.
        parent::__construct($placa, $modelo);
    }

    // Aqui eu modifico o cálculo da tarifa para motos.
    // Cada hora custa R$ 3,00.
    public function calcularTarifa(float $horas): float
    {
        return $horas * 3.00;
    }

    // Aqui eu transformo os dados da moto em um array.
    // Também acrescento o tipo do veículo.
    public function paraArray(): array
    {
        return array_merge(parent::paraArray(), [
            'tipo' => 'Moto'
        ]);
    }
}
