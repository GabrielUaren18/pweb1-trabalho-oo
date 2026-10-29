<?php

declare(strict_types=1);

// Aqui eu crio a classe mãe dos veículos.
class Veiculo
{
    // Aqui eu guardo a placa e o modelo.
    // Uso protected para as classes filhas também terem acesso.
    protected string $placa;
    protected string $modelo;

    // O construtor recebe os dados quando crio um veículo.
    public function __construct(string $placa, string $modelo)
    {
        // Se a placa ou o modelo estiverem vazios, recuso o cadastro.
        if (trim($placa) === '' || trim($modelo) === '') {
            throw new Exception("Placa e modelo são obrigatórios.");
        }

        // Aqui eu guardo os dados recebidos.
        $this->placa = strtoupper(trim($placa));
        $this->modelo = trim($modelo);
    }

    // Esse método devolve a placa.
    public function getPlaca(): string
    {
        return $this->placa;
    }

    // Esse método devolve o modelo.
    public function getModelo(): string
    {
        return $this->modelo;
    }

    // Essa é a tarifa padrão por hora.
    // Cada classe filha poderá ter um valor diferente.
    public function calcularTarifa(float $horas): float
    {
        return $horas * 5.00;
    }

    // Aqui transformo os dados do veículo em um array.
    // Isso será útil quando formos trabalhar com JSON.
    public function paraArray(): array
    {
        return [
            'placa' => $this->placa,
            'modelo' => $this->modelo
        ];
    }
}
