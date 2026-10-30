<?php
declare(strict_types=1);

// Aqui eu carrego a classe Estadia.
require_once __DIR__ . '/Estadia.php';

// Essa classe administra as estadias do estacionamento.
class Estacionamento
{
    // Aqui eu guardo o nome e a lista de estadias.
    private string $nome;
    private array $estadias;

    // O construtor recebe o nome do estacionamento.
    public function __construct(string $nome)
    {
        // Não deixo criar um estacionamento sem nome.
        if (trim($nome) === '') {
            throw new Exception("O nome é obrigatório.");
        }

        $this->nome = trim($nome);

        // A lista começa vazia.
        $this->estadias = [];
    }

    // Aqui eu adiciono uma estadia na lista.
    public function adicionarEstadia(Estadia $estadia): void
    {
        $this->estadias[] = $estadia;
    }

    // Aqui eu calculo o total arrecadado.
    public function calcularTotal(): float
    {
        $total = 0;

        // Percorro todas as estadias cadastradas.
        foreach ($this->estadias as $estadia) {
            // Somo o valor de cada estadia.
            $total += $estadia->calcularValor();
        }

        // Arredondo o total para duas casas decimais.
        return round($total, 2);
    }

    // Aqui eu devolvo o nome do estacionamento.
    public function getNome(): string
    {
        return $this->nome;
    }

    // Aqui eu preparo os dados para o JSON.
    public function paraArray(): array
    {
        $lista = [];

        // Transformo cada estadia em um array.
        foreach ($this->estadias as $estadia) {
            $lista[] = $estadia->paraArray();
        }

        return [
            'nome' => $this->nome,
            'estadias' => $lista,
            'total' => $this->calcularTotal()
        ];
    }
}
