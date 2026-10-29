# Estacionamento Central

> Trabalho individual de Programação Web I (IFCE Campus Boa Viagem): sistema web orientado a objetos em PHP.

**Autor:** Gabriel Uaren Melo Sousa
**Tema:** Sistema de Estacionamento (número do tema a confirmar no enunciado)
**Vídeo:** Aguardando gravação e publicação.

## O problema

O Estacionamento Central é um sistema desenvolvido para facilitar o controle de veículos em um estacionamento. Ele permite cadastrar carros, motos e caminhonetes, registrar o tempo de permanência e calcular automaticamente o valor cobrado. O sistema também guarda o histórico das estadias e mostra o total arrecadado. A ideia é ajudar quem administra um estacionamento a organizar essas informações de maneira simples.

## Como executar

Requisitos: PHP 8.3 ou superior.

```powershell
git clone https://github.com/GabrielUaren18/pweb1-trabalho-oo.git
cd pweb1-trabalho-oo
php -S localhost:8000 -t public -d display_errors=1 -d output_buffering=0
```

Abra http://localhost:8000

Para rodar o roteiro de testes no terminal:

```powershell
php teste.php
```

O sistema utiliza um arquivo JSON para guardar o histórico das estadias. É necessário que a pasta `data/` exista e tenha permissão de escrita.

## Telas

O sistema possui as seguintes telas:

**1. Página inicial:** apresenta o Estacionamento Central e permite navegar pelas outras páginas.

**2. Página de veículos:** permite cadastrar uma estadia informando o tipo de veículo, placa, modelo e tempo de permanência. Também mostra o histórico dos veículos cadastrados e o total arrecadado.

**3. Página sobre:** apresenta informações sobre o sistema e os conceitos de orientação a objetos utilizados.

**Prints das telas:** serão adicionados à pasta `docs/` antes da entrega.

## Rotas

| URL | O que mostra | Método | Status |
|---|---|---|---|
| `/` | Página inicial do estacionamento | GET | 200 |
| `/?pagina=inicio` | Página inicial | GET | 200 |
| `/?pagina=veiculos` | Formulário e histórico das estadias | GET | 200 |
| `/?pagina=sobre` | Informações sobre o sistema | GET | 200 |
| `/?pagina=inexistente` | Página de erro | GET | 404 |
| `/?formato=json` | Dados do estacionamento em JSON | GET | 200 |
| `/?pagina=veiculos` (formulário) | Cadastra uma estadia ou mostra uma mensagem de erro | POST | 200 |

## Regras de negócio

| Nº | Regra | Classe e método | Mensagem da exceção |
|---|---|---|---|
| 1 | Não permitir veículo sem placa ou modelo | `Veiculo::__construct()` | Placa e modelo são obrigatórios. |
| 2 | Não permitir estadias com zero horas ou tempo negativo | `Estadia::encerrar()` | O tempo deve ser maior que zero. |
| 3 | Não permitir encerrar a mesma estadia duas vezes | `Estadia::encerrar()` | Esta estadia já foi encerrada. |
| 4 | Não permitir estacionamento sem nome | `Estacionamento::__construct()` | O nome do estacionamento é obrigatório. |

## Orientação a objetos utilizada

O sistema foi desenvolvido com seis classes PHP:

- **Veiculo:** classe principal que guarda a placa e o modelo do veículo.
- **Carro:** herda de Veiculo e cobra R$ 6,00 por hora.
- **Moto:** herda de Veiculo e cobra R$ 3,00 por hora.
- **Caminhonete:** herda de Veiculo e cobra R$ 8,00 por hora.
- **Estadia:** registra o veículo, o tempo de permanência e calcula o valor cobrado.
- **Estacionamento:** guarda as estadias cadastradas e calcula o total arrecadado.

**Herança:** as classes Carro, Moto e Caminhonete aproveitam características da classe Veiculo.

**Polimorfismo:** cada tipo de veículo possui sua própria forma de calcular a tarifa, utilizando o método `calcularTarifa()`.

**Encapsulamento:** os atributos são protegidos ou privados, evitando o acesso direto de outras partes do sistema.

**Composição:** o estacionamento guarda uma lista de estadias, e cada estadia possui um veículo.

**Exceções:** o sistema utiliza `throw new Exception` para impedir operações inválidas e `try/catch` para tratar os erros.

## Testes realizados

O sistema foi testado utilizando PHP no terminal, comandos curl e o navegador.

Foram realizados nove testes no arquivo `teste.php`, verificando herança, polimorfismo, validações, cálculo de tarifas, composição e conversão para array.

Também foram testados:

- Acesso à página de veículos, com resposta HTTP 200.
- Acesso a uma página inexistente, com resposta HTTP 404.
- Consulta à rota JSON, com resposta HTTP 200.
- Envio de formulário com zero horas, recusado corretamente.
- Verificação de que o cadastro inválido não altera o histórico.

Nos testes da aplicação web, o histórico permaneceu com nove estadias e total de R$ 121,80 após a tentativa de cadastro inválido.

## Documentação

- [Modelagem (diagrama de classes)](docs/modelagem.md)
- [Testes](docs/testes.md)
- [Diário de uso de LLM](docs/llm.md)
- [Relatório (PDF)](docs/relatorio.pdf)

## Ferramentas utilizadas

| Ferramenta | Para que usei |
|---|---|
| PHP 8.5.11 | Desenvolver as classes, as regras de negócio e as páginas do sistema |
| VS Code | Escrever, editar e organizar os arquivos do projeto |
| Git e GitHub | Controlar as versões do código e publicar o repositório |
| curl | Testar as rotas HTTP, o JSON e o envio de formulários |
| Navegador e DevTools | Visualizar o sistema e conferir a apresentação das páginas |
| LLM: ChatGPT | Auxiliar na compreensão do PHP, na implementação, nos testes e na documentação |
| Gravador de tela | A definir antes da gravação do vídeo |

## Repositório

Código-fonte disponível em:

https://github.com/GabrielUaren18/pweb1-trabalho-oo
