# Sistema Clínica Vida Saudável

## 📌 Sobre o Projeto

O Sistema Clínica Vida Saudável está sendo desenvolvido a partir de um estudo de caso aplicado em aula de Banco de Dados.

No estudo, foi proposto analisar a necessidade de uma clínica chamada **Vida Saudável**, que deseja gerenciar melhor seus processos internos por meio de um sistema de agendamento de consultas.

O objetivo principal é praticar modelagem de banco de dados de forma simples, considerando que este é o primeiro contato de muitos alunos com SGBDs.

Por esse motivo, o projeto não utiliza um banco totalmente idêntico ao proposto no estudo original, pois adaptações foram feitas para permitir evolução futura.

---

## 🚀 Tecnologias Utilizadas

- Laravel
- MySQL
- Bootstrap 5
- RBAC (Role-Based Access Control)

---

## 🔐 Controle de Acesso (RBAC)

O sistema utiliza controle de permissões baseado em papéis (RBAC), com os seguintes perfis:

- **Admin**
- **Médico**
- **Recepcionista**

---

## 👥 Regras de Negócio

### 👤 Administrador
- Pode gerenciar sua clínica
- Pode criar contas para médicos
- Pode criar contas para recepcionistas

### 🧾 Recepcionista
- Pode criar pacientes
- Pode visualizar e gerenciar a agenda da clínica
- Pode gerenciar consultas

> Observação: Pacientes não possuem conta no sistema e não podem acessá-lo atualmente.

### 🩺 Médico
- Pode visualizar apenas suas próprias consultas agendadas

---

## ⚙️ Funcionalidades Já Implementadas

- Sistema de autenticação (login)
- CRUD de recepcionistas
- CRUD de pacientes
- Estrutura inicial de agendamento

---

## 🎯 Objetivo Futuro

Apesar de ter começado como um projeto acadêmico, o sistema está sendo desenvolvido com foco em melhorias futuras e possível utilização como produto real.

A arquitetura foi pensada para permitir expansão, novas funcionalidades e evolução do modelo de dados.

---

## 🖥️ Interface

O front-end do sistema utiliza **Bootstrap 5**, garantindo layout responsivo e organização visual.

---

## 📚 Contexto Acadêmico

Este projeto faz parte de um estudo prático de modelagem de banco de dados, com foco no aprendizado dos fundamentos de:

- Modelagem relacional
- Entidades e relacionamentos
- Normalização
- Regras de negócio
- Integração entre aplicação e banco de dados

---

## 📌 Status do Projeto

Em desenvolvimento.
