
# Testes

## Roteiro de testes no terminal

Comando: `php teste.php`

```text
=== Teste 1: Herança e polimorfismo ===
Carro: R$ 12,00
Moto: R$ 6,00
Caminhonete: R$ 16,00

=== Teste 2: Recusar placa vazia ===
OK, recusado: Placa e modelo s├úo obrigat├│rios.

=== Teste 3: Recusar modelo vazio ===
OK, recusado: Placa e modelo s├úo obrigat├│rios.

=== Teste 4: Recusar zero horas ===
OK, recusado: O tempo deve ser maior que zero.

=== Teste 5: Recusar horas negativas ===
OK, recusado: O tempo deve ser maior que zero.

=== Teste 6: Recusar encerramento repetido ===
OK, recusado: Esta estadia j├í foi encerrada.

=== Teste 7: Calcular valor da estadia ===
Valor calculado: R$ 18,00
OK, c├ílculo correto

=== Teste 8: Composição e total arrecadado ===
Total arrecadado: R$ 34,00
OK, total correto

=== Teste 9: Conversão para array ===
OK, dados convertidos corretamente

=== Fim dos testes ===
```

**Explica├º├úo de cada linha:**

**Teste 1 ÔÇö Herança e polimorfismo:** criei um carro, uma moto e uma caminhonete. Usei o mesmo m├®todo para calcular duas horas de estacionamento. Cada ve├¡culo cobrou um valor diferente, mostrando que o polimorfismo est├í funcionando.

**Teste 2 ÔÇö Placa vazia:** tentei cadastrar um carro sem placa. O sistema recusou e mostrou que a placa e o modelo s├úo obrigat├│rios.

**Teste 3 ÔÇö Modelo vazio:** tentei cadastrar uma moto sem modelo. O sistema tamb├®m recusou o cadastro.

**Teste 4 ÔÇö Zero horas:** tentei encerrar uma estadia com zero horas. O sistema n├úo permitiu porque o tempo precisa ser maior que zero.

**Teste 5 ÔÇö Horas negativas:** tentei encerrar uma estadia com duas horas negativas. O sistema recusou porque esse tempo n├úo ├® v├ílido.

**Teste 6 ÔÇö Encerramento repetido:** encerrei uma estadia normalmente e depois tentei encerr├í-la de novo. O sistema impediu a segunda opera├º├úo.

**Teste 7 ÔÇö C├ílculo da estadia:** registrei um carro por tr├¬s horas. Como a tarifa ├® de R$ 6,00 por hora, o sistema calculou corretamente R$ 18,00.

**Teste 8 ÔÇö Composição:** adicionei tr├¬s estadias ao estacionamento. O sistema somou R$ 12,00 do carro, R$ 6,00 da moto e R$ 16,00 da caminhonete, chegando ao total de R$ 34,00.

**Teste 9 ÔÇö Conversão para array:** transformei os dados do estacionamento em um array. O teste confirmou que o nome, as tr├¬s estadias e o valor total estavam corretos.

## Camada web

**Uma p├ígina que existe:** `curl.exe -i "http://localhost:8000/?pagina=veiculos"` (cole s├│ at├® o in├¡cio do HTML)

```text
(Aguardando teste da p├ígina existente.)
```

**Uma p├ígina que n├úo existe:** `curl.exe -i "http://localhost:8000/?pagina=inexistente"`

```text
(Aguardando teste da p├ígina inexistente.)
```

**A rota JSON:** `curl.exe -i "http://localhost:8000/?formato=json"`

```text
(Aguardando teste da rota JSON.)
```

**O formul├írio com um dado inv├ílido:** print da p├ígina com a mensagem de recusa e o log do servidor.

```text
(Aguardando teste do formul├írio inv├ílido e log do servidor.)
```

---


### 1. Página existente

Comando:

```powershell
curl.exe -i "http://localhost:8000/?pagina=veiculos"
```

Saída do terminal (início):

```text
HTTP/1.1 200 OK
Host: localhost:8000
Content-type: text/html; charset=UTF-8

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Estacionamento Central</title>
```

**Resultado:** a página de veículos foi encontrada e carregada normalmente, mostrando o formulário e o histórico das estadias.

### 2. Página inexistente

Comando:

```powershell
curl.exe -i "http://localhost:8000/?pagina=inexistente"
```

Saída do terminal (resumida):

```text
HTTP/1.1 404 Not Found
Host: localhost:8000
Content-type: text/html; charset=UTF-8

<h2>Erro 404</h2>
<p>A página solicitada não foi encontrada.</p>
```

**Resultado:** o sistema reconheceu que a página não existe, retornou o status HTTP 404 e mostrou uma mensagem ao usuário.

### 3. Rota JSON

Comando:

```powershell
curl.exe -i "http://localhost:8000/?formato=json"
```

Saída do terminal (resumida):

```text
HTTP/1.1 200 OK
Host: localhost:8000
Content-Type: application/json; charset=utf-8

{
    "nome": "Estacionamento Central",
    "estadias": [
        {
            "veiculo": {
                "placa": "ABC1234",
                "modelo": "Honda Biz",
                "tipo": "Moto"
            },
            "horas": 2,
            "encerrada": true,
            "valor": 6
        }
    ],
    "total": 137.8
}
```

**Observação:** o exemplo acima foi abreviado. A resposta real contém dez estadias.

**Resultado:** a rota devolveu os dados em JSON, com o tipo de conteúdo correto e o total arrecadado de R$ 137,80.

### 4. Formulário com dado inválido

Comando:

```powershell
curl.exe -s -i -X POST "http://localhost:8000/?pagina=veiculos" -d "tipo=carro&placa=ABC1234&modelo=Gol&horas=0" | Select-String -Pattern "HTTP/|tempo deve|erro"
```

Saída do terminal:

```text
HTTP/1.1 200 OK
<!-- Se acontecer algum erro, mostro a mensagem. -->
<div class="erro">
    O tempo deve ser maior que zero.
</div>
```

**Resultado:** o sistema recusou uma estadia com zero horas e mostrou a mensagem da exceção na página, sem aceitar o cadastro inválido.

### Conclusão dos testes web

Os testes confirmaram que o sistema consegue abrir páginas existentes, retornar erro 404 para páginas inexistentes, fornecer dados em JSON e recusar informações inválidas enviadas pelo formulário.
