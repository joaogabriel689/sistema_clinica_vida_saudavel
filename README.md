# 🏥 Sistema Clínica Vida Saudável

## 📄 Visão Geral

O Sistema Clínica Vida Saudável é uma aplicação web desenvolvida para gerenciar operações de uma clínica médica, incluindo cadastro de pacientes, médicos, recepcionistas, convênios e agendamento de consultas.

O projeto foi iniciado como um estudo acadêmico na disciplina de Banco de Dados, com foco em modelagem relacional e regras de negócio. Atualmente, evoluiu para um projeto mais estruturado, com foco em boas práticas de desenvolvimento e potencial para se tornar um produto real (SaaS).

---

## 🎯 Objetivos do Projeto

- Aplicar modelagem de banco de dados relacionais
- Desenvolver backend com Laravel
- Implementar controle de acesso baseado em papéis (RBAC)
- Criar regras de negócio consistentes
- Estruturar uma aplicação web organizada
- Integrar sistema web com banco de dados

---

## 🧰 Tecnologias Utilizadas

- Laravel
- PHP
- MySQL
- Bootstrap
- JavaScript (Fetch API)
- RBAC (Role-Based Access Control)

---

## 🔐 Controle de Acesso (RBAC)

O sistema utiliza controle de acesso baseado em papéis.

### Papéis

- Administrador
- Recepcionista
- Médico

Cada papel possui permissões específicas dentro do sistema.

---

## 👥 Regras de Negócio

### Administrador

Responsável pela gestão geral da clínica.

- Gerenciar clínicas
- Gerenciar médicos
- Gerenciar recepcionistas
- Gerenciar convênios
- Visualizar pacientes

---

### Recepcionista

Responsável pelo fluxo operacional da clínica.

- Cadastrar pacientes
- Agendar consultas
- Gerenciar agenda
- Visualizar atendimentos

---

### Médico

Possui acesso apenas às suas informações.

- Visualizar agenda
- Visualizar pacientes agendados

---

## 📅 Sistema de Agendamento

O sistema possui regras para garantir consistência da agenda.

### Regras

- Um médico não pode ter duas consultas no mesmo horário
- Um paciente não pode ter duas consultas no mesmo horário
- O sistema valida conflitos antes do agendamento

---

## ⚙️ Funcionalidades Implementadas

- Sistema de autenticação (login e logout)
- Cadastro de clínicas
- CRUD de médicos
- CRUD de recepcionistas
- CRUD de pacientes
- CRUD de convênios
- Agendamento de consultas
- Validação de conflitos de horário
- Controle de acesso por papéis (RBAC)
- Dashboard separado por tipo de usuário
- Insights básicos (consultas, faturamento, pacientes)
- Integração dinâmica entre especialidade e médicos
- Exibição de horários de atendimento por médico
- Filtros e buscas nas listagens
- Paginação de dados
- Alteração de status de consultas
- Confirmação de pagamento diretamente na listagem
- Interface responsiva com Bootstrap
- Melhorias de UX (feedback visual, loading, interações)
- Auditoria de ações feita

---

## 🖥️ Interface

A interface foi construída com Bootstrap e aprimorada com estilos customizados.

- Layout responsivo
- Componentes reutilizáveis
- Organização visual clara
- Feedback visual para ações do usuário
- Interações dinâmicas com JavaScript

---



---

## 📚 Contexto Acadêmico

Projeto desenvolvido com foco em:

- Modelagem relacional
- Normalização de banco de dados
- Regras de negócio
- Integração entre sistema e banco

---

## 🚧 Status do Projeto

O sistema encontra-se em desenvolvimento ativo e já possui base sólida funcional.

---

## 🔮 Próximos Passos

### 📊 Relatórios

- Relatórios financeiros completos
- Relatórios por médico
- Relatórios por recepcionista
- Relatórios por paciente
- Relatórios por período

---

### 📈 Dashboard Avançada

- Comparação entre períodos
- Indicadores de crescimento
- Métricas mais estratégicas
- Alertas inteligentes

---



### 📱 Comunicação com Pacientes

- Confirmação automática de consultas
- Lembretes via WhatsApp
- Cancelamento automático

---

### 🧠 Melhorias Técnicas

- Refatoração para Service Layer
- Melhor organização de código
- Otimização de queries
- Padronização de APIs

---

## 📌 Observação Final

O sistema está sendo desenvolvido com foco em:

- Boas práticas de programação
- Código limpo
- Escalabilidade

Com potencial real de evolução para um produto SaaS de gestão de clínicas.