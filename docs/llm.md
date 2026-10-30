# Diário de uso de LLM

Durante o desenvolvimento do Estacionamento Central, utilizei o ChatGPT para me ajudar a entender os requisitos do trabalho, organizar o código PHP, fazer testes e corrigir erros. Não aceitei tudo automaticamente: fui executando os comandos, verificando os resultados e fazendo correções quando necessário.

## Interação 1

- **Ferramenta e data:** ChatGPT — outubro de 2026.
- **Prompt:**

```text
Quero fazer o projeto de PHP e orientação a objetos do professor Renato. Vamos fazer uma etapa de cada vez, com código simples e comentários explicando o que cada parte faz.
```

- **Resumo da resposta:** A IA ajudou a organizar o desenvolvimento em etapas, começando pelas classes PHP e deixando a interface web e a documentação para depois.
- **O que aceitei, modifiquei ou rejeitei, e por quê:** Aceitei trabalhar por etapas, porque assim consegui testar cada parte antes de continuar. Também pedi explicações mais simples e comentários diretamente no código, para facilitar meu entendimento.

## Interação 2

- **Ferramenta e data:** ChatGPT — outubro de 2026.
- **Prompt:**

```text
Vamos criar as classes do estacionamento. Quero uma classe Veiculo e as classes Carro, Moto e Caminhonete, com valores diferentes por hora.
```

- **Resumo da resposta:** A IA ajudou a montar a classe mãe `Veiculo` e as três classes filhas, utilizando `extends` e sobrescrevendo o método `calcularTarifa()`.
- **O que aceitei, modifiquei ou rejeitei, e por quê:** Utilizei essa organização porque evitou repetir placa e modelo em todas as classes. Depois testei os valores cobrados por cada veículo para conferir se os cálculos estavam corretos.

## Interação 3

- **Ferramenta e data:** ChatGPT — outubro de 2026.
- **Prompt:**

```text
Quero testar se o sistema recusa horas iguais a zero, horas negativas e se impede encerrar a mesma estadia duas vezes.
```

- **Resumo da resposta:** A IA orientou a testar as validações da classe `Estadia`, utilizando `try/catch` para mostrar as mensagens das exceções.
- **O que aceitei, modifiquei ou rejeitei, e por quê:** Aceitei os testes e executei no terminal. O sistema recusou horas inválidas e também impediu que uma estadia fosse encerrada novamente. Isso ajudou a verificar as regras de negócio.

## Interação 4

- **Ferramenta e data:** ChatGPT — outubro de 2026.
- **Prompt:**

```text
A tabela com o histórico das estadias não está aparecendo na página de veículos. Quero que ela apareça abaixo do formulário e continue mostrando os registros depois de atualizar a página.
```

- **Resumo da resposta:** A IA ajudou a revisar o arquivo `public/index.php` e identificar que o trecho da tabela estava dentro da condição da página errada.
- **O que aceitei, modifiquei ou rejeitei, e por quê:** Corrigi a posição do código para que a tabela aparecesse na página de veículos. Depois abri o sistema no navegador, cadastrei veículos e atualizei a página para confirmar que o histórico continuava aparecendo.

## Interação 5

- **Ferramenta e data:** ChatGPT — outubro de 2026.
- **Prompt:**

```text
Está aparecendo o erro "strict_types declaration must be the very first statement in the script". Como faço para corrigir?
```

- **Resumo da resposta:** A IA explicou que havia caracteres ou espaços antes de `<?php`, o que impedia o `declare(strict_types=1)` de funcionar corretamente.
- **O que aceitei, modifiquei ou rejeitei, e por quê:** Segui a orientação para remover os caracteres antes da abertura do PHP e salvar o arquivo em UTF-8 sem BOM. Depois utilizei `php -l` para verificar se o erro de sintaxe tinha sido resolvido.

## O erro que a LLM cometeu

O erro aconteceu na **interação 4**, quando a IA forneceu uma versão do arquivo `public/index.php` em que a tabela do histórico ficou dentro da condição da página `sobre`, em vez de aparecer na página `veiculos`.

Percebi o problema quando abri o sistema no navegador. O cadastro funcionava, mas a tabela não aparecia onde deveria.

Então mostrei o resultado para a IA e pedi a correção. Depois substituí o código, testei novamente e confirmei que a tabela passou a aparecer abaixo do formulário, mostrando os veículos cadastrados e o total arrecadado.

Esse erro mostrou que não basta copiar o código gerado pela IA. É importante executar, conferir o funcionamento e corrigir o que estiver errado.