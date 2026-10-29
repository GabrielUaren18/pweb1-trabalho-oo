
# Testes

## Roteiro de testes no terminal

Comando: `php teste.php`

```text
=== Teste 1: Herança e polimorfismo ===
Carro: R$ 12,00
Moto: R$ 6,00
Caminhonete: R$ 16,00

=== Teste 2: Recusar placa vazia ===
OK, recusado: Placa e modelo são obrigatórios.

=== Teste 3: Recusar modelo vazio ===
OK, recusado: Placa e modelo são obrigatórios.

=== Teste 4: Recusar zero horas ===
OK, recusado: O tempo deve ser maior que zero.

=== Teste 5: Recusar horas negativas ===
OK, recusado: O tempo deve ser maior que zero.

=== Teste 6: Recusar encerramento repetido ===
OK, recusado: Esta estadia já foi encerrada.

=== Teste 7: Calcular valor da estadia ===
Valor calculado: R$ 18,00
OK, cálculo correto

=== Teste 8: Composição e total arrecadado ===
Total arrecadado: R$ 34,00
OK, total correto

=== Teste 9: Conversão para array ===
OK, dados convertidos corretamente

=== Fim dos testes ===
```

**Explicação de cada linha:**

**Teste 1 — Herança e polimorfismo:** criei um carro, uma moto e uma caminhonete. Usei o mesmo método para calcular duas horas de estacionamento. Cada veículo cobrou um valor diferente, mostrando que o polimorfismo está funcionando.

**Teste 2 — Placa vazia:** tentei cadastrar um carro sem placa. O sistema recusou e mostrou que a placa e o modelo são obrigatórios.

**Teste 3 — Modelo vazio:** tentei cadastrar uma moto sem modelo. O sistema também recusou o cadastro.

**Teste 4 — Zero horas:** tentei encerrar uma estadia com zero horas. O sistema não permitiu porque o tempo precisa ser maior que zero.

**Teste 5 — Horas negativas:** tentei encerrar uma estadia com duas horas negativas. O sistema recusou porque esse tempo não é válido.

**Teste 6 — Encerramento repetido:** encerrei uma estadia normalmente e depois tentei encerrá-la de novo. O sistema impediu a segunda operação.

**Teste 7 — Cálculo da estadia:** registrei um carro por três horas. Como a tarifa é de R$ 6,00 por hora, o sistema calculou corretamente R$ 18,00.

**Teste 8 — Composição:** adicionei três estadias ao estacionamento. O sistema somou R$ 12,00 do carro, R$ 6,00 da moto e R$ 16,00 da caminhonete, chegando ao total de R$ 34,00.

**Teste 9 — Conversão para array:** transformei os dados do estacionamento em um array. O teste confirmou que o nome, as três estadias e o valor total estavam corretos.

## Camada web

**Uma página que existe:** `curl.exe -i "http://localhost:8000/?pagina=veiculos"` (cole só até o início do HTML)

```text
(Aguardando teste da página existente.)
```

**Uma página que não existe:** `curl.exe -i "http://localhost:8000/?pagina=inexistente"`

```text
(Aguardando teste da página inexistente.)
```

**A rota JSON:** `curl.exe -i "http://localhost:8000/?formato=json"`

```text
(Aguardando teste da rota JSON.)
```

**O formulário com um dado inválido:** print da página com a mensagem de recusa e o log do servidor.

```text
(Aguardando teste do formulário inválido e log do servidor.)
```
