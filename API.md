# 📡 Documentação da API

Documentação completa dos endpoints disponíveis na API de Gestão de RH.

---

## 🌐 URL Base

```
http://localhost:8080
```

---

## 📦 Clientes

### 1. Listar Todos os Clientes

**Endpoint:** `GET /clientes`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "clientes": [
      {
        "idCliente": 1,
        "nomeCliente": "João Silva",
        "telefoneCliente":  "11999990001"
      },
      {
        "idCliente": 2,
        "nomeCliente": "Maria Oliveira",
        "telefoneCliente":  "11999990002"
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/clientes
```

### 2. Buscar Cargo por ID

**Endpoint:** `GET /clientes/{idCliente}`

**Parâmetros de URL:**
- `idCliente` (int obrigatório)

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Executado com sucesso",
  "data": {
    "clientes": {
      "idCargo": 1,
      "nomeCliente": "João Silva",
        "telefoneCliente":  "11999990001"
    }
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/clientes/1
```

### 3. Criar Cargo

**Endpoint:** `POST /clientes`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "clientes": {
    "nomeCliente": "João Silva",
    "telefoneCliente":  "11999990001"
  }
}
```

**Resposta (201 Created):**
```json
{
  "success": true,
  "message": "Cadastro realizado com sucesso"
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/clientes \
  -H "Content-Type: application/json" \
  -d '{"cliente":{"nomeCliente":"João Silva"}}'
```

### 4. Atualizar Cargo

**Endpoint:** `PUT /clientes/{idCliente}`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "cliente": {
    "nomeCliente": "João Silva",
    "telefoneCliente":  "11999990001"
  }
}
```

**Exemplo cURL:**
```bash
curl -X PUT http://localhost:8080/clientes/1 \
  -H "Content-Type: application/json" \
  -d '{"cliente":{"nomeCliente":"João Silva"}}'
```

### 5. Deletar Cargo

**Endpoint:** `DELETE /clientes/{idCliente}`

**Exemplo cURL:**
```bash
curl -X DELETE http://localhost:8080/clientes/1
```

### 6. Contar Cargos

**Endpoint:** `GET /clientes/count`

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/clientes/count
```

---

## 👤 Funcionários

### 1. Listar Todos os Funcionários

**Endpoint:** `GET /funcionarios`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "funcionarios": []
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/funcionarios
```

### 2. Buscar Funcionário por ID

**Endpoint:** `GET /funcionarios/{idFuncionario}`

**Parâmetros de URL:**
- `idFuncionario` (int obrigatório)

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/funcionarios/1
```

### 3. Criar Funcionário

**Endpoint:** `POST /funcionarios`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "funcionario": {
    "nomeFuncionario": "João Silva",
    "email": "joao@email.com",
    "senha": "123456",
    "recebeValeTransporte": 1,
    "cargo": {
      "idCargo": 1
    }
  }
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/funcionarios \
  -H "Content-Type: application/json" \
  -d '{
    "funcionario": {
      "nomeFuncionario": "João Silva",
      "email": "joao@email.com",
      "senha": "123456",
      "recebeValeTransporte": 1,
      "cargo": {"idCargo": 1}
    }
  }'
```

### 4. Atualizar Funcionário

**Endpoint:** `PUT /funcionarios/{idFuncionario}`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "funcionario": {
    "nomeFuncionario": "João Atualizado",
    "email": "novo@email.com",
    "senha": "123456",
    "recebeValeTransporte": 0,
    "cargo": {
      "idCargo": 2
    }
  }
}
```

**Exemplo cURL:**
```bash
curl -X PUT http://localhost:8080/funcionarios/1 \
  -H "Content-Type: application/json" \
  -d '{
    "funcionario": {
      "nomeFuncionario": "João Atualizado",
      "email": "novo@email.com",
      "senha": "123456",
      "recebeValeTransporte": 0,
      "cargo": {"idCargo": 2}
    }
  }'
```

### 5. Deletar Funcionário

**Endpoint:** `DELETE /funcionarios/{idFuncionario}`

**Exemplo cURL:**
```bash
curl -X DELETE http://localhost:8080/funcionarios/1
```

### 6. Contar Funcionários

**Endpoint:** `GET /funcionarios/count`

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/funcionarios/count
```

---

## 🔄 Códigos HTTP

| Código | Significado                  |
|--------|------------------------------|
| 200    | Requisição executada com sucesso |
| 201    | Registro criado com sucesso  |
| 204    | Exclusão realizada com sucesso |
| 400    | Erro de validação            |
| 404    | Registro não encontrado      |
| 500    | Erro interno do servidor     |

---

## 📊 Estrutura de Resposta

### Sucesso
```json
{
  "success": true,
  "message": "Descrição do resultado",
  "data": {}
}
```

### Erro
```json
{
  "success": false,
  "message": "Descrição do erro",
  "error": {}
}
```

---

## 🧪 Testando no Postman

1. **Criar Collection**
2. **Definir variável:**
   - `base_url = http://localhost:8080`
3. **Importar endpoints**
4. **Testar operações CRUD**

---

**Última atualização:** 2 de Maio de 2026