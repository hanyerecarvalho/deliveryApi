# Delivery API
API REST de sistema de delivery desenvolvida com PHP + Slim Framework 4, arquitetura MVC em camadas, injeção de dependência com PHP-DI e MySQL.


# 🍕 Delivery API REST

API REST para sistema de delivery desenvolvida com PHP e Slim Framework 4.

## 📋 Sobre o Projeto

Sistema de gerenciamento de delivery com controle completo de clientes,
restaurantes, produtos, pedidos e itens de pedido.
Desenvolvido como projeto acadêmico aplicando boas práticas de
arquitetura e desenvolvimento backend.

## 🛠️ Tecnologias

- PHP 8+
- Slim Framework 4
- MySQL
- PHP-DI (Injeção de Dependência)
- Composer
- XAMPP

## 🏗️ Arquitetura

O projeto segue a arquitetura MVC em camadas:
Request → Middleware → Controller → Service → DAO → Banco de Dados

- **Controller** — recebe a requisição e retorna a resposta JSON
- **Service** — contém as regras de negócio
- **DAO** — acesso e manipulação dos dados no banco
- **Model** — representação das entidades
- **Middleware** — validação dos dados antes de chegar ao controller

## 📦 Instalação

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/seu-repositorio.git

# Instale as dependências
composer install

# Configure o banco de dados
# Importe o arquivo SQL na pasta /database

# Inicie o servidor
composer start
```

## 🗄️ Banco de Dados

```sql
clientes → pedidos → itens_pedidos
restaurantes → produtos → itens_pedidos
restaurantes → pedidos
```

Todos os relacionamentos utilizam `ON DELETE CASCADE`.

## 🔗 Endpoints

### Clientes
| Método | Rota | Descrição |
|--------|------|-----------|
| GET | /clientes | Lista todos |
| GET | /clientes/{id} | Busca por ID |
| GET | /clientes/count | Total de registros |
| POST | /clientes | Cadastra novo |
| PUT | /clientes/{id} | Atualiza |
| DELETE | /clientes/{id} | Remove |

### Restaurantes
| Método | Rota | Descrição |
|--------|------|-----------|
| GET | /restaurantes | Lista todos |
| GET | /restaurantes/{id} | Busca por ID |
| POST | /restaurantes | Cadastra novo |
| PUT | /restaurantes/{id} | Atualiza |
| DELETE | /restaurantes/{id} | Remove |

### Produtos
| Método | Rota | Descrição |
|--------|------|-----------|
| GET | /produtos | Lista todos |
| GET | /produtos/{id} | Busca por ID |
| POST | /produtos | Cadastra novo |
| PUT | /produtos/{id} | Atualiza |
| DELETE | /produtos/{id} | Remove |

### Pedidos
| Método | Rota | Descrição |
|--------|------|-----------|
| GET | /pedidos | Lista todos |
| GET | /pedidos/{id} | Busca por ID |
| POST | /pedidos | Cadastra novo |
| PUT | /pedidos/{id} | Atualiza |
| DELETE | /pedidos/{id} | Remove |

### Itens do Pedido
| Método | Rota | Descrição |
|--------|------|-----------|
| GET | /itensPedidos | Lista todos |
| GET | /itensPedidos/{id} | Busca por ID |
| POST | /itensPedidos | Cadastra novo |
| PUT | /itensPedidos/{id} | Atualiza |
| DELETE | /itensPedidos/{id} | Remove |

## 📝 Exemplos de Requisição

### Cadastrar Cliente
```json
POST /clientes
{
    "cliente": {
        "nomeCliente": "João Silva",
        "telefoneCliente": "11999990001"
    }
}
```

### Cadastrar Pedido
```json
POST /pedidos
{
    "pedidos": {
        "valorTotal": 63.90,
        "idCliente": 1,
        "idRestaurante": 1
    }
}
```
```
## 📁 Estrutura de Pastas
src/
└── api/
├── Controllers/
├── DAO/
├── Database/
├── Http/
├── Middlewares/
├── Models/
├── Routes/
├── Server/
└── Services/
public/
└── index.php
banco/
└── banco.db
```

## 👨‍💻 Autor

Desenvolvido por **Hanyere**
