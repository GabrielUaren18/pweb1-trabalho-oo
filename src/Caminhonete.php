<?php
declare(strict_types=1);

// Aqui eu carrego a classe mãe Veiculo.
require_once __DIR__ . '/Veiculo.php';

// Caminhonete herda as informações e métodos de Veiculo.
class Caminhonete extends Veiculo
{
    // Aqui eu recebo a placa e o modelo da caminhonete.
    public function __construct(string $placa, string $modelo)
    {
        // Aproveito o construtor da classe mãe.
        parent::__construct($placa, $modelo);
    }

    // Aqui eu defino a tarifa da caminhonete.
    // Cada hora de estacionamento custa R$ 8,00.
    public function calcularTarifa(float $horas): float
    {
        return $horas * 8.00;
    }

    // Aqui eu preparo os dados para serem usados no JSON.
    public function paraArray(): array
    {
        // Aproveito os dados da classe mãe e adiciono o tipo.
        return array_merge(parent::paraArray(), [
            'tipo' => 'Caminhonete'
        ]);
    }
}