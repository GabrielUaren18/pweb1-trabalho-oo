<?php

declare(strict_types=1);

// Aqui eu carrego a classe Veiculo, que é a classe mãe.
require_once __DIR__ . '/Veiculo.php';

// O extends faz Carro herdar as características de Veiculo.
class Carro extends Veiculo
{
    // O construtor recebe a placa e o modelo do carro.
    public function __construct(string $placa, string $modelo)
    {
        // Aqui eu chamo o construtor da classe mãe.
        // Assim não preciso repetir o código que guarda os dados.
        parent::__construct($placa, $modelo);
    }

    // Aqui eu modifico o cálculo da tarifa só para carros.
    // Cada hora de estacionamento custa R$ 6,00.
    public function calcularTarifa(float $horas): float
    {
        return $horas * 6.00;
    }

    // Aqui eu aproveito os dados da classe mãe
    // e acrescento o tipo do veículo.
    public function paraArray(): array
    {
        return array_merge(parent::paraArray(), [
            'tipo' => 'Carro'
        ]);
    }
}

