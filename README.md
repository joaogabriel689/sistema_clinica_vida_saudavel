# 🏥 Sistema Clínica Vida Saudável — Plataforma SaaS Multi-Tenant

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![Docker](https://img.shields.io/badge/Docker-Compose_v2-2496ED?style=for-the-badge&logo=docker)](https://docker.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.4-4479A1?style=for-the-badge&logo=mysql)](https://mysql.com)
[![Redis](https://img.shields.io/badge/Redis-7.0-DC382D?style=for-the-badge&logo=redis)](https://redis.io)
[![MinIO S3](https://img.shields.io/badge/MinIO-S3_Storage-C42B1C?style=for-the-badge&logo=minio)](https://min.io)
[![Evolution API](https://img.shields.io/badge/Evolution_API-v2.1-25D366?style=for-the-badge&logo=whatsapp)](https://evolution-api.com)
[![Caddy SSL](https://img.shields.io/badge/Caddy-On--Demand_TLS-008080?style=for-the-badge&logo=caddy)](https://caddyserver.com)

Plataforma completa de gestão clínica desenvolvida em arquitetura **SaaS Multi-Tenant**, com isolamento estrito de dados, suporte a **domínios e subdomínios personalizados com SSL automático On-Demand (Caddy)**, **Object Storage S3 (MinIO)** para assets de marca, automação de WhatsApp via **Evolution API (Docker)**, processamento assíncrono via **Redis Queue**, billing de assinaturas automatizado com **Webhooks Asaas**, lembretes automáticos agendados e infraestrutura containerizada com **4 redes segmentadas, auditoria de segurança em 14 camadas, backups automáticos e observabilidade**.

---

## 📋 Sumário
- [🛠️ Stack Tecnológica](#️-stack-tecnológica)
- [🏗️ Arquitetura de Infraestrutura & Redes Docker](#️-arquitetura-de-infraestrutura--redes-docker)
- [🌐 Domínios Personalizados & SSL Automático On-Demand (Caddy)](#-domínios-personalizados--ssl-automático-on-demand-caddy)
- [🖼️ Object Storage S3 (MinIO)](#️-object-storage-s3-minio)
- [💳 Billing SaaS & Webhooks Asaas/Stripe](#-billing-saas--webhooks-asaasstripe)
- [🔐 Segurança, LGPD & Auditoria de 14 Camadas](#-segurança-lgpd--auditoria-de-14-camadas)
- [📱 Módulo Evolution API (WhatsApp Docker)](#-módulo-evolution-api-whatsapp-docker)
- [⏰ Lembretes Automáticos de Consulta](#-lembretes-automáticos-de-consulta)
- [⚡ Módulos & Funcionalidades do Sistema](#-módulos--funcionalidades-do-sistema)
- [🚀 Como Executar o Projeto](#-como-executar-o-projeto)
- [🛠️ Guia de Operação (`Makefile`)](#️-guia-de-operação-makefile)
- [📊 Monitoramento & Métricas](#-monitoramento--métricas)
- [🧪 Testes Automatizados & Testes de Carga](#-testes-automatizados--testes-de-carga)
- [🔮 Guia para Lançamento Comercial (Roadmap SaaS)](#-guia-para-lançamento-comercial-roadmap-saas)

---

## 🛠️ Stack Tecnológica

| Camada | Tecnologia | Descrição / Papel na Aplicação | Exposto no Host? |
| :--- | :--- | :--- | :--- |
| **Proxy Reverso / SSL** | **Nginx (Alpine) & Caddy** | Roteamento HTTP/HTTPS, SSL On-Demand automático para domínios de clientes | **Sim (Porta 8080 / 80 / 443)** |
| **Aplicação Web** | **PHP 8.3 FPM / Laravel 12** | Core da aplicação web rodando sob usuário não-root (`appuser`, UID 1000) | Não (Rede interna) |
| **Fila & Workers** | **Laravel Queue (Redis)** | Processamento assíncrono de notificações de agendamento em segundo plano | Não (Rede interna) |
| **Storage (S3)** | **MinIO S3** | Object storage para uploads de logos e banners personalizados por clínica | **Sim (Portas 9000/9001)** |
| **WhatsApp Engine** | **Evolution API v2.1 (Docker)** | Motor containerizado com banco MySQL isolado `evolution` para automação WhatsApp | Não (Rede interna) |
| **Banco de Dados** | **MySQL 8.4** | Armazenamento relacional isolado. **Zero portas expostas no host** | Não (Rede interna) |
| **Cache & Filas** | **Redis 7 (Alpine)** | Cache em memória e mensageria de filas de jobs | Não (Rede interna) |
| **Backup & Restore** | **Alpine 3.20 + dcron + tini** | Execução de backups a cada 4h, snapshots automáticos e teste de carga | Não (Rede interna) |
| **Métricas Infra** | **Prometheus** | Coleta de métricas e séries temporais a cada 15s | **Sim (Porta 9090)** |
| **Coletor Métricas** | **cAdvisor (v0.49)** | Leitura de uso de CPU, Memória e I/O dos containers Docker | **Sim (Porta 8081)** |
| **Dashboards** | **Grafana** | Visualização de dashboards de saúde da infraestrutura | **Sim (Porta 3000)** |

---

## 🏗️ Arquitetura de Infraestrutura & Redes Docker

A stack é orquestrada via `docker-compose.yml` com **quatro redes independentes**. Duas dessas redes são estritamente **internas (`internal: true`)**, garantindo que containers de banco e backend não possuam rotas diretas para a internet ou para o host.

```
Navegador → nginx (8080) ─(frontend)─ app (PHP 8.3 FPM) ─(backend, internal)─ evolution-api, minio & redis
                                       └─(banco_dados, internal)─ db (MySQL 8.4) ─ alpine (backup/restore)
Prometheus (9090) ─(monitoring)─ cAdvisor (8081) & Grafana (3000)
```

---

## 🌐 Domínios Personalizados & SSL Automático On-Demand (Caddy)

- **Apontamento CNAME pelo Cliente**: A clínica aponta `agendar.clinicadasilva.com.br` (CNAME) para o domínio principal do SaaS.
- **Emissão Automática de SSL (On-Demand TLS)**:
  - O Caddy (ou Nginx com Certbot) intercepta o acesso HTTP/HTTPS.
  - O Caddy consulta a API do Laravel em `GET /api/v1/check-domain?domain=agendar.clinicadasilva.com.br`.
  - Se a clínica existir no banco de dados, o Laravel retorna HTTP 200 e o Caddy gera o certificado SSL grátis (Let's Encrypt / ZeroSSL) em **2 segundos** sem nenhuma intervenção manual!

---

## 🖼️ Object Storage S3 (MinIO)

A plataforma integra o driver S3 do Laravel conectado ao contêiner MinIO S3 local (`clinica_minio`):
- **Logos e Banners**: Upload direto no formulário de perfil (`/me`) com armazenamento seguro no bucket S3 `clinica-uploads`.
- **Hashes Únicos**: Geração de nomes aleatórios e seguros para impedir previsibilidade de URLs.

---

## 💳 Billing SaaS & Webhooks Asaas/Stripe

- **Endpoint de Webhook**: `POST /api/webhooks/asaas`.
- **Automação Financeira**: Processamento de confirmações de pagamento (`PAYMENT_RECEIVED`, `PAYMENT_CONFIRMED`) com baixa automática de faturas para `paga` e renovação da assinatura para `ativa` (+30 dias).
- **Gestão de Inadimplência**: Tratamento de boletos e Pix vencidos (`PAYMENT_OVERDUE`), suspendendo a conta da clínica.

---

## 🔐 Segurança, LGPD & Auditoria de 14 Camadas

A plataforma foi submetida a um plano de auditoria de segurança cobrindo **14 camadas de proteção**:
1. **Isolamento Tenant & Anti-IDOR**: Modelo relacional protegido por `BelongsToClinica` e `TenantScope`.
2. **Políticas RBAC**: Middlewares estritos de controle de papéis (`role:admin`, `role:medico`, `role:admin,recepcionista`).
3. **Proteção Contra Força Bruta**: Rate limiting (`throttle:5,1`) em formulários de acesso.
4. **Containers Não-Root**: Container `app` rodando com usuário `appuser` (UID 1000).
5. **Redes Internas Seguras**: Redes `backend` e `banco_dados` isoladas (`internal: true`).
6. **Hardening Nginx**: Bloqueio de `.env`, `.git`, `.bkp`, `storage/` e `vendor/`.
7. **Limpeza de Logs & Dados**: Ocultação de dados sensíveis em logs (`dontFlash`).

---

## 📱 Módulo Evolution API (WhatsApp Docker)

- **Banco de Dados Dedicado**: Instância com schema isolado no MySQL (`evolution`).
- **Geração de QR Code Dinâmico**: Exibição em tempo real na interface `/whatsapp` com conversão base64 / PNG escaneável.
- **Jobs em Fila Redis**: Disparo de mensagens através de `EnviarNotificacaoWhatsAppJob`.

---

## ⏰ Lembretes Automáticos de Consulta

- **Comando Artisan**: `php artisan consultas:enviar-lembretes`.
- **Scheduler Automático**: Agendado no `routes/console.php` para rodar a cada hora via Cron.
- **Filtro de 24h**: Filtra consultas com status `agendada` ou `confirmada` nas próximas 24h e dispara os lembretes automaticamente para o WhatsApp do paciente.

---

## ⚡ Módulos & Funcionalidades do Sistema

### 👑 Painel de Administração (`/admin`)
- Gestão de Médicos, Recepcionistas e Convênios por clínica.
- Dashboard financeiro e estatístico com métricas em tempo real.
- Configuração de Domínio Personalizado e marcas (Logo/Banner).

### 🩺 Painel do Médico (`/medicos/dashboard`)
- Agenda médica personalizada do dia e próxima consulta.
- Prontuário eletrônico e registro de consultas.

### 📋 Painel da Recepção (`/recepcionista`)
- Cadastro e edição de Pacientes.
- Agendamento de Consultas com verificação automática de conflitos.

### 💳 Módulo de Billing & Assinaturas SaaS (`/billing`)
- Planos de assinatura por clínica.
- Faturas, boletos/Pix e controle de adimplência.

---

## 🚀 Como Executar o Projeto

```bash
# 1. Clonar o repositório
git clone https://github.com/joaogabriel689/sistema_clinica_vida_saudavel.git
cd sistema_clinica_vida_saudavel

# 2. Criar o arquivo de ambiente
cp .env.example .env

# 3. Subir toda a stack containerizada
docker compose up -d --build

# 4. Acessar a aplicação no navegador
# Application URL: http://localhost:8080
```

---

## 🛠️ Guia de Operação (`Makefile`)

```bash
make backup           # Executa um backup MySQL manual imediato via mysqldump
make restore          # Restaura o backup mais recente (com confirmação interativa)
make restore-latest   # Restaura o backup mais recente SEM pedir confirmação
make restore-file FILE=clinica_20260830_015000.sql # Restaura um arquivo específico
make logs-restore     # Exibe o histórico de logs de restaurações efetuadas
make tests            # Executa a bateria de teste de carga (Apache Bench) contra o Nginx
make logs             # Acompanha logs de todos os containers em tempo real
```

---

## 📊 Monitoramento & Métricas

- 📈 **Grafana:** `http://localhost:3000`
- 📊 **Prometheus:** `http://localhost:9090`
- 🐳 **cAdvisor:** `http://localhost:8081`

---

## 🧪 Testes Automatizados & Testes de Carga

### Suíte de Testes PHPUnit
```bash
docker compose exec app ./vendor/bin/phpunit
# Retorno: OK (13 tests, 43 assertions) — 100% Sucesso
```

---

## 🔮 Guia para Lançamento Comercial (Roadmap SaaS)

```
┌───────────────────────────────────────────────────────────────────────────┐
│                    GUIA DE LANÇAMENTO COMERCIAL SAAS                      │
└───────────────────────────────────────────────────────────────────────────┘
 ├── 1. Painel Backoffice SuperAdmin (/superadmin)
 │    └─ Visão global do proprietário do SaaS: MRR, ARR, clínicas ativas,
 │       ações de bloqueio/desbloqueio e logs de auditoria.
 │
 ├── 2. Confirmação Interativa de Consultas via WhatsApp
 │    └─ Endpoint webhook para receber "SIM/1" do paciente e atualizar
 │       o status da consulta para "confirmada" automaticamente.
 │
 ├── 3. E-mails Transacionais (Reset de Senha & Boas-Vindas)
 │    └─ Configuração SMTP/Resend para redefinição de senha e alertas.
 │
 └── 4. Chaves de Produção (Asaas & Evolution API)
      └─ Troca das credenciais sandbox pelas chaves reais de produção.
```

---

## 📄 Licença
Este projeto é distribuído sob a licença **MIT**. Consulte `LICENSE` para mais detalhes.