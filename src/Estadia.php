<?php
declare(strict_types=1);

// Aqui eu carrego a classe Veiculo.
require_once __DIR__ . '/Veiculo.php';

// Essa classe representa a permanência de um veículo.
class Estadia
{
    // Aqui eu guardo o veículo e o tempo de permanência.
    private Veiculo $veiculo;
    private float $horas;
    private bool $encerrada;

    // O construtor recebe o veículo que vai estacionar.
    public function __construct(Veiculo $veiculo)
    {
        $this->veiculo = $veiculo;

        // A estadia começa com zero horas e ainda aberta.
        $this->horas = 0;
        $this->encerrada = false;
    }

    // Aqui eu registro a saída e o tempo de permanência.
    public function encerrar(float $horas): void
    {
        // Não aceito tempo igual ou menor que zero.
        if ($horas <= 0) {
            throw new Exception("O tempo deve ser maior que zero.");
        }

        // Não deixo encerrar a mesma estadia duas vezes.
        if ($this->encerrada) {
            throw new Exception("Esta estadia já foi encerrada.");
        }

        // Guardo o tempo e marco a estadia como encerrada.
        $this->horas = $horas;
        $this->encerrada = true;
    }

    // Aqui eu calculo o valor da estadia.
    public function calcularValor(): float
    {
        // Cada tipo de veículo calcula sua própria tarifa.
        return $this->veiculo->calcularTarifa($this->horas);
    }

    // Esse método devolve o veículo da estadia.
    public function getVeiculo(): Veiculo
    {
        return $this->veiculo;
    }

    // Aqui eu preparo as informações para o JSON.
    public function paraArray(): array
    {
        return [
            'veiculo' => $this->veiculo->paraArray(),
            'horas' => $this->horas,
            'encerrada' => $this->encerrada,
            'valor' => $this->calcularValor()
        ];
    }
}
