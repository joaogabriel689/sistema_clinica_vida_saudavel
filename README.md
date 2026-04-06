# 🏥 Sistema Clínica Vida Saudável

## 📄 Visão Geral

O **Sistema Clínica Vida Saudável** é uma aplicação web para gestão completa de clínicas médicas, abrangendo desde o cadastro de usuários até o agendamento e comunicação automatizada com pacientes.

Inicialmente desenvolvido como projeto acadêmico na disciplina de Banco de Dados, o sistema evoluiu para uma aplicação estruturada com foco em:

- Boas práticas de desenvolvimento
- Regras de negócio consistentes
- Escalabilidade
- Potencial de se tornar um SaaS multi-tenant

---

## 🎯 Objetivos do Projeto

- Aplicar modelagem relacional na prática
- Desenvolver backend robusto com Laravel
- Implementar controle de acesso (RBAC)
- Criar regras de negócio reais de clínicas
- Construir base para um sistema SaaS escalável
- Integrar automações (WhatsApp e notificações)

---

## 🧰 Tecnologias Utilizadas

- Laravel
- PHP
- MySQL
- Bootstrap
- JavaScript (Fetch API)
- RBAC (Role-Based Access Control)
- Integração com API de WhatsApp (Z-API)

---

## 🏗️ Arquitetura

O sistema segue uma estrutura baseada em:

- Controllers (entrada das requisições)
- Services (regras de negócio e integrações)
- Models (Eloquent ORM)
- Requests (validação)
- Jobs (processos assíncronos - recomendado)

---

## 🔐 Controle de Acesso (RBAC)

O sistema possui controle de acesso baseado em papéis:

### Papéis

- **Administrador**
- **Recepcionista**
- **Médico**

### Permissões

#### Administrador
- Gerenciar clínicas
- Gerenciar médicos
- Gerenciar recepcionistas
- Gerenciar convênios
- Visualizar pacientes e relatórios

#### Recepcionista
- Cadastrar pacientes
- Agendar consultas
- Gerenciar agenda
- Confirmar pagamentos
- Visualizar atendimentos

#### Médico
- Visualizar agenda
- Visualizar pacientes agendados

---

## 📅 Sistema de Agendamento

O sistema possui validações para garantir consistência:

- Um médico não pode ter duas consultas no mesmo horário
- Um paciente não pode ter duas consultas no mesmo horário
- Validação automática de conflitos
- Controle de status da consulta

---

## ⚙️ Funcionalidades Implementadas

- Autenticação (login/logout)
- CRUD completo:
  - Clínicas
  - Médicos
  - Recepcionistas
  - Pacientes
  - Convênios
- Agendamento de consultas
- Controle de conflitos de horário
- RBAC (controle de acesso)
- Dashboard por perfil
- Insights básicos (consultas, faturamento)
- Filtros e buscas
- Paginação
- Alteração de status de consultas
- Confirmação de pagamento
- Auditoria de ações
- Interface responsiva
- Melhorias de UX (loading, feedback, interações)

---

## 📱 Integração com WhatsApp

O sistema possui integração com envio de mensagens via API.

### Funcionalidades

- Envio automático de mensagens
- Lembretes de consultas
- Confirmação de agendamento
- Comunicação direta com pacientes

---

## 🔔 Sistema de Notificações Inteligentes

### Tipos de notificações implementadas/planejadas:

- Confirmação ao agendar consulta
- Lembrete 24 horas antes
- Lembrete no dia (ex: 2 horas antes)
- Notificação de falta
- Pós-consulta (follow-up)
- Retorno automático (ex: 6 meses)

---

### 📊 Estrutura sugerida
notificacoes
- id
- paciente_id
- consulta_id
- tipo
- data_envio
- status

### Tipos

- confirmacao
- lembrete_24h
- lembrete_2h
- falta
- pos_consulta
- retorno

---

### ⏱️ Automação

Uso do scheduler do Laravel:

* * * * * php artisan schedule:run

---

## 🧩 Multi-Tenancy (Preparação para SaaS)

O sistema está sendo preparado para suportar múltiplas clínicas:

- Cada clínica possui seus próprios dados
- Integração de WhatsApp por tenant
- Isolamento de informações

---

## 📲 Gestão de Instâncias WhatsApp

Cada clínica possui sua própria instância:

### Estrutura
whatsapp_instancias
- id
- tenant_id
- instance_id
- token
- status


---

### Fluxo de conexão

1. Clínica acessa "Conectar WhatsApp"
2. Sistema cria instância
3. Exibe QR Code
4. Usuário escaneia
5. Instância fica conectada

---

### Status da conexão

- conectado
- desconectado
- aguardando_qr

---

### Observações

- Cada instância requer leitura de QR Code
- Conexão é persistente após autenticação
- Sistema deve tratar reconexões automaticamente

---

## 🖥️ Interface

- Layout responsivo (Bootstrap)
- Componentes reutilizáveis
- Feedback visual
- Interações dinâmicas com JavaScript

---

## 🔒 Práticas de Segurança

- Rate limit em login
- Proteção contra SQL Injection (bindings)
- Hash de senhas (bcrypt/argon)
- Proteção contra XSS
- Validação de dados via Form Requests

---

## 📚 Contexto Acadêmico

Projeto desenvolvido com foco em:

- Modelagem relacional
- Normalização de banco
- Regras de negócio
- Integração sistema + banco

---

## 🚧 Status do Projeto

🟡 Em desenvolvimento ativo  
🟢 Base funcional sólida  
🚀 Evoluindo para SaaS

---

## 🔮 Próximos Passos

### 📊 Relatórios

- Financeiro completo
- Por médico
- Por recepcionista
- Por paciente
- Por período

---

### 📈 Dashboard Avançado

- Comparação entre períodos
- Indicadores de crescimento
- Métricas estratégicas
- Alertas inteligentes

---

### 📱 Comunicação

- Confirmação via WhatsApp
- Cancelamento automático
- Resposta do paciente integrada ao sistema (webhook)

---

### 🧠 Melhorias Técnicas

- Service Layer completo
- Uso de Jobs (filas)
- Otimização de queries
- Padronização de API
- Melhor estrutura multi-tenant

---

## 📌 Considerações Finais

O projeto foi além do escopo acadêmico e evoluiu para um sistema com:

- Arquitetura organizada  
- Regras reais de negócio  
- Integrações externas  
- Potencial de produto SaaS  

Base sólida para crescimento profissional e comercial.