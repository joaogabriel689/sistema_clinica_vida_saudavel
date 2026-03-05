# Sistema Clínica Vida Saudável

## 📌 Sobre o Projeto

O **Sistema Clínica Vida Saudável** está sendo desenvolvido a partir de um estudo de caso aplicado em aula de **Banco de Dados**.

No estudo, foi proposta a análise das necessidades de uma clínica fictícia chamada **Vida Saudável**, que deseja melhorar o gerenciamento de seus processos internos por meio de um sistema de **agendamento de consultas**.

O objetivo principal do projeto é praticar **modelagem de banco de dados**, desenvolvimento de aplicações web e implementação de regras de negócio de forma simples, considerando que este é o primeiro contato de muitos alunos com **SGBDs**.

Por esse motivo, o projeto não utiliza um banco de dados totalmente idêntico ao proposto no estudo original. Algumas adaptações foram realizadas para permitir **evolução futura do sistema**.

---

## 🚀 Tecnologias Utilizadas

- Laravel
- MySQL
- Bootstrap 5
- RBAC (Role-Based Access Control)

---

## 🔐 Controle de Acesso (RBAC)

O sistema utiliza controle de permissões baseado em papéis (**RBAC**).

Perfis existentes no sistema:

- **Admin**
- **Médico**
- **Recepcionista**

---

## 👥 Regras de Negócio

### 👤 Administrador

O administrador possui controle completo sobre a clínica.

Funções:

- Gerenciar a clínica
- Criar contas de médicos
- Criar contas de recepcionistas

---

### 🧾 Recepcionista

Responsável pelo atendimento e organização da agenda.

Funções:

- Criar pacientes
- Visualizar a agenda da clínica
- Gerenciar consultas

Observação:

Pacientes **não possuem conta no sistema** e não podem acessá-lo atualmente.

---

### 🩺 Médico

O médico possui acesso limitado apenas às suas informações.

Funções:

- Visualizar apenas suas próprias consultas agendadas

---

## ⚙️ Funcionalidades Implementadas

- Sistema de autenticação (Login)
- CRUD de recepcionistas
- CRUD de pacientes
- CRUD de médicos
- Estrutura inicial de agendamento
- Controle de acesso por papéis (RBAC)

---

## 🎯 Objetivos Futuros

Apesar de ter iniciado como um projeto acadêmico, o sistema está sendo desenvolvido com foco em **evolução futura e possível uso como produto real**.

Possíveis melhorias planejadas:

- Sistema completo de agendamento
- Controle de horários médicos
- Validação de conflitos de consulta
- Dashboard administrativo
- Melhorias de segurança
- Expansão do modelo de dados

A arquitetura foi planejada para permitir **expansão e manutenção do sistema ao longo do tempo**.

---

## 🖥️ Interface

O front-end do sistema utiliza **Bootstrap 5**, proporcionando:

- Layout responsivo
- Interface organizada
- Facilidade de manutenção

---

## 📚 Contexto Acadêmico

Este projeto faz parte de um estudo prático de **modelagem de banco de dados**, com foco no aprendizado dos seguintes conceitos:

- Modelagem relacional
- Entidades e relacionamentos
- Normalização
- Regras de negócio
- Integração entre aplicação e banco de dados

---

## 📌 Status do Projeto

Em desenvolvimento.

---

## 📂 Rotas do Sistema

### Rotas Gerais

```
GET     /
GET     login
POST    logout
GET     register
POST    store_login
POST    store_register
```

---

### Rotas do Administrador

```
GET     admin
GET     admin/criar_clinica
POST    admin/store_clinica
```

---

### Rotas de Médicos

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

### Rotas de Recepcionistas

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

### Rotas de Pacientes

```
POST    pacientes
GET     pacientes/create
GET     pacientes/{id}
PUT     pacientes/{id}
DELETE  pacientes/{id}
GET     pacientes/{id}/edit
```

---

### Rotas da Recepcionista

```
GET     recepcionista
```

---

### Rotas de Arquivos

```
GET     storage/{path}
PUT     storage/{path}
```

---

## 📎 Observação

Este projeto está sendo utilizado como **base de aprendizado em desenvolvimento web com Laravel e modelagem de banco de dados**, podendo evoluir futuramente para um sistema mais completo de gestão de clínicas.