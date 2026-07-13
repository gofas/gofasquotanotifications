# Notificações de Cota de Hospedagem para WHMCS

[![versão](https://img.shields.io/github/v/release/gofas/gofasquotanotifications?label=vers%C3%A3o&color=005071&style=flat-square)](https://github.com/gofas/gofasquotanotifications/releases/latest)
[![downloads](https://img.shields.io/endpoint?url=https%3A%2F%2Fgofas.net%2Fwp-json%2Fgofas%2Fv1%2Fbadge%2Fgofasquotanotifications&style=flat-square)](https://github.com/gofas/gofasquotanotifications/releases/latest)
[![abrir issue](https://img.shields.io/badge/suporte-abrir%20issue-ff8700?style=flat-square)](https://gofas.net/?p=13810/#new-post)

Módulo addon que monitora o uso de espaço em disco e de largura de banda dos serviços de hospedagem cadastrados no WHMCS, notificando o cliente e o administrador automaticamente ao atingir o limite configurado. Desenvolvido pela Gofas Software, é 100% gratuito e de código aberto.

## Sumário

- [Download](#download)
- [Funcionalidades](#funcionalidades)
- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Informações importantes](#informações-importantes)
- [Suporte](#suporte)
- [Licença](#licença)

## Download

**[Baixar a versão mais recente](https://github.com/gofas/gofasquotanotifications/releases/latest/download/gofasquotanotifications.zip)**

## Funcionalidades

- **Verificação diária** via cron do WHMCS do uso de disco e de banda de todos os serviços de hospedagem
- **Notificação ao cliente** por email ao atingir a porcentagem configurada de uso de disco ou de banda
- **Relatório consolidado** enviado ao departamento de suporte com os clientes acima do limite
- **Template de email** e **intervalo entre notificações** configuráveis
- **Modo diagnóstico**
- **Aviso de atualização** e verificação de versão na própria tela de configuração do módulo

## Requisitos

- WHMCS >= 7.9
- PHP >= 8.1
- Cron do WHMCS em execução

## Instalação

1. Baixe o arquivo pelo link de download e descompacte. Será criada a pasta `gofasquotanotifications`.
2. Copie a pasta `modules` de dentro de `gofasquotanotifications` para a raiz da instalação do WHMCS, mesclando com as pastas existentes.
3. Ative o módulo em `Configurações > Módulos Addon`, localizando "Gofas Notificações de Cota de Hospedagem".

## Configuração

### Opções do módulo

<img src="https://raw.githubusercontent.com/gofas/gofasquotanotifications/master/docs/img/tela-configuracoes-modulo-2.1.0.png" alt="Tela de configuracoes do modulo" width="640">

- **Administrador do WHMCS**: administrador com permissão para usar a API interna do WHMCS.
- **% de uso de disco para alerta**: porcentagem de uso que dispara a notificação ao cliente.
- **% de uso de banda para alerta**: porcentagem de uso de largura de banda que dispara a notificação.
- **Template de email**: template do WHMCS usado para notificar o cliente.
- **Departamento**: departamento de suporte que recebe o relatório consolidado.
- **Intervalo entre notificações**: frequência com que o mesmo cliente pode ser notificado.
- **Enviar estatísticas de uso (opcional)**: controla o envio identificado das estatísticas de uso do módulo. Desmarcado, os dados continuam sendo contabilizados de forma anônima.

## Informações importantes

- As notificações dependem do cron do WHMCS em execução diária.
- Sempre faça backup antes de mudar algo no seu sistema.

## Suporte

[Abrir issue](https://gofas.net/?p=13810/#new-post) no fórum do módulo.

## Licença

O código deste módulo é público para transparência e auditoria. Isso não transfere a titularidade nem concede licença livre de uso: o software é de propriedade da Gofas Software, protegido pela Lei 9.609/98 e pelos tratados de direitos autorais.

Trechos do [contrato de licença de uso](https://gofas.net/contrato-de-venda-de-licenca-de-uso-de-software/) que se aplicam diretamente a este repositório:

- **Não redistribuir**: é proibido o aluguel, o arrendamento, o empréstimo, a cessão e o licenciamento do software a terceiros, total ou parcial, assim como o fornecimento de serviços de hospedagem comercial do software (Cláusula 10ª, §3º).
- **Não modificar**: é vedado qualquer procedimento que implique engenharia reversa, descompilação, desmontagem, tradução, adaptação ou modificação do software, bem como qualquer alteração não autorizada de suas funcionalidades (Cláusula 10ª, §2º).
- **Módulo alterado perde o suporte**: a Gofas não se responsabiliza por defeitos decorrentes de alteração do software, de operação por pessoas não autorizadas ou da integração com softwares de terceiros (Cláusula 10ª, §7º). O suporte é uma cortesia e não é garantido pela licença (Cláusula 7ª, §1º).
