# 🏥 Sistema Clínica Vida Saudável

## 📄 Visão Geral

O **Sistema Clínica Vida Saudável** é uma aplicação web desenvolvida para gerenciar operações básicas de uma clínica médica, incluindo cadastro de pacientes, médicos, recepcionistas, convênios e agendamento de consultas.

O projeto foi iniciado como um **estudo de caso acadêmico na disciplina de Banco de Dados**, com foco em modelagem relacional, implementação de regras de negócio e integração entre aplicação web e banco de dados.

Desde sua concepção, o sistema vem sendo estruturado com **boas práticas de desenvolvimento**, permitindo sua evolução para um possível **produto real de gestão de clínicas (SaaS)**.

---

# 🎯 Objetivos do Projeto

O projeto tem como objetivo principal aplicar conceitos fundamentais de:

- Modelagem de banco de dados relacionais
- Desenvolvimento backend com Laravel
- Controle de acesso baseado em papéis (RBAC)
- Implementação de regras de negócio
- Estruturação de aplicações web organizadas
- Integração entre sistema web e banco de dados

Além do caráter acadêmico, o sistema também funciona como **projeto de aprendizado e portfólio de desenvolvimento web**.

---

# 🧰 Tecnologias Utilizadas

O sistema foi desenvolvido utilizando as seguintes tecnologias:

- **Laravel 12**
- **PHP**
- **MySQL**
- **Bootstrap 5**
- **RBAC (Role-Based Access Control)**

---

# 🔐 Controle de Acesso (RBAC)

O sistema implementa controle de permissões baseado em papéis (**RBAC – Role-Based Access Control**).

Cada tipo de usuário possui permissões específicas dentro do sistema.

## Papéis Disponíveis

- **Administrador**
- **Recepcionista**
- **Médico**

---

# 👥 Regras de Negócio

## 👨‍💼 Administrador

O administrador possui controle total sobre a configuração da clínica e gestão de usuários.

### Funcionalidades

- Criar e gerenciar clínicas
- Criar contas de médicos
- Criar contas de recepcionistas
- Gerenciar convênios
- Visualizar pacientes cadastrados
- Gerenciar profissionais da clínica

---

## 🧾 Recepcionista

A recepcionista é responsável pelo atendimento ao paciente e pela organização da agenda médica.

### Funcionalidades

- Cadastrar pacientes
- Gerenciar consultas
- Organizar agenda médica
- Visualizar agenda da clínica

### Observação

Nesta versão do sistema, **pacientes não possuem acesso direto ao sistema**.

---

## 🩺 Médico

O médico possui acesso restrito apenas às suas informações e consultas.

### Funcionalidades

- Visualizar sua agenda diária
- Acessar seu dashboard médico
- Visualizar pacientes agendados para atendimento

---

# 📅 Sistema de Agendamento

O sistema já possui estrutura funcional de **agendamento de consultas**, incluindo regras básicas de consistência.

## Regras Implementadas

- Um **médico não pode possuir duas consultas no mesmo horário**
- Um **paciente não pode possuir duas consultas no mesmo horário**
- O sistema verifica conflitos antes de registrar uma nova consulta

Essas regras garantem integridade básica na agenda da clínica.

---

# ⚙️ Funcionalidades Implementadas

Atualmente o sistema possui as seguintes funcionalidades:

- Sistema de autenticação (Login / Logout)
- Cadastro de clínicas
- CRUD de médicos
- CRUD de recepcionistas
- CRUD de pacientes
- CRUD de convênios
- Agendamento de consultas
- Validação de conflitos de agenda
- Controle de acesso por papéis (RBAC)
- Dashboard separado por perfil
- APIs internas para consulta de horários médicos

---

# 🖥️ Interface

A interface do sistema foi desenvolvida utilizando **Bootstrap 5**, proporcionando:

- Layout responsivo
- Interface simples e organizada
- Facilidade de manutenção
- Componentização básica de interface

---

# 🔗 Estrutura de Rotas

## Rotas Gerais

```
GET     /
GET     login
POST    logout
GET     register
POST    store_login
POST    store_register
GET     dashboard_split
GET     me
```

---

## Rotas do Administrador

```
GET     admin
GET     admin/criar_clinica
POST    admin/store_clinica
```

---

## Rotas de Convênios

```
GET     admin/convenios
POST    admin/convenios
GET     admin/convenios/create
PUT     admin/convenios/{id}
DELETE  admin/convenios/{id}
GET     admin/convenios/{id}/edit
```

---

## Rotas de Médicos

```
GET     admin/medicos
POST    admin/medicos
GET     admin/medicos/create
GET     admin/medicos/{id}
PUT     admin/medicos/{id}
DELETE  admin/medicos/{id}
GET     admin/medicos/{id}/edit
```

---

## Rotas de Recepcionistas

```
GET     admin/recepcionistas
POST    admin/recepcionistas
GET     admin/recepcionistas/create
GET     admin/recepcionistas/{id}
PUT     admin/recepcionistas/{id}
DELETE  admin/recepcionistas/{id}
GET     admin/recepcionistas/{id}/edit
```

---

## Rotas de Pacientes

```
POST    pacientes
GET     pacientes/create
GET     pacientes/{id}
PUT     pacientes/{id}
DELETE  pacientes/{id}
GET     pacientes/{id}/edit
```

---

## Rotas de Consultas

```
GET     consultas
POST    consultas
GET     consultas/create
GET     consultas/{id}
PUT     consultas/{id}
DELETE  consultas/{id}
GET     consultas/{id}/edit
```

---

## Rotas de Dashboard

### Dashboard da Recepcionista

```
GET     recepcionista
```

### Dashboard do Médico

```
GET     medicos/dashboard
```

---

## Rotas de API Interna

Essas rotas são utilizadas para consultas dinâmicas dentro do sistema.

```
GET     api/medico/{id}/horarios
GET     api/medicos/{especialidade}
```

---

## Rotas de Arquivos

```
GET     storage/{path}
PUT     storage/{path}
```

---

# 🧑‍💻 Instalação do Projeto

## 1. Clonar o Repositório

```
git clone https://github.com/seu-usuario/sistema-clinica.git
```

Entrar no diretório do projeto:

```
cd sistema-clinica
```

---

## 2. Instalar Dependências

```
composer install
```

---

## 3. Criar Arquivo de Configuração

Copiar o arquivo de exemplo:

```
cp .env.example .env
```

---

## 4. Gerar Chave da Aplicação

```
php artisan key:generate
```

---

## 5. Configurar Banco de Dados

Editar o arquivo `.env`:

```
DB_DATABASE=clinica
DB_USERNAME=root
DB_PASSWORD=
```

---

## 6. Executar Migrations

```
php artisan migrate
```

---

## 7. Iniciar Servidor Local

```
php artisan serve
```

A aplicação estará disponível em:

```
http://localhost:8000
```

---

# 📚 Contexto Acadêmico

Este projeto foi desenvolvido como exercício prático envolvendo:

- Modelagem relacional
- Entidades e relacionamentos
- Normalização de banco de dados
- Implementação de regras de negócio
- Integração entre aplicação web e banco de dados

---

# 🚧 Status do Projeto

O sistema encontra-se **em desenvolvimento ativo**.

Novas funcionalidades e melhorias continuam sendo implementadas.

---

# 🔮 Melhorias Planejadas

As próximas evoluções previstas para o sistema incluem:

## Melhorias de Usabilidade

- Sistema de busca para:
  - pacientes
  - médicos
  - consultas

## Validações de Dados

- Validação de CPF
- Validação de CRM
- Validação de CNPJ
- Validação de telefone
- Validação de email

## Melhorias no Sistema de Autenticação

Reestruturação da lógica de acesso:

Fluxo planejado:

```
Página inicial
   ↓
Clique no ícone de usuário
   ↓
Dashboard do usuário
   ↓
Acesso ao /me ao clicar novamente
```

Atualmente o sistema redireciona diretamente para `/me`.

---

## Gestão de Consultas

- Alteração de status de consulta
- Estados possíveis:

```
Agendada
Confirmada
Cancelada
Realizada
```

---

## Comunicação com Pacientes

Implementação futura de **rotina de confirmação automática de consultas via WhatsApp**.

Possíveis recursos:

- confirmação de consulta
- lembrete de consulta
- cancelamento automático

---

# 📌 Observação Final

Embora tenha sido iniciado como um **projeto acadêmico**, o **Sistema Clínica Vida Saudável** está sendo estruturado com foco em:

- organização de código
- separação de responsabilidades
- arquitetura escalável

Isso permite que o sistema evolua gradualmente para um **produto real de gestão clínica (SaaS)**.

---