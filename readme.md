# Notificações de Cota de Hospedagem para WHMCS

[![versão](https://img.shields.io/github/v/release/gofas/gofasquotanotifications?label=vers%C3%A3o&color=005071&style=flat-square)](https://github.com/gofas/gofasquotanotifications/releases/latest)
[![downloads](https://img.shields.io/github/downloads/gofas/gofasquotanotifications/total?label=downloads&color=005071&style=flat-square)](https://github.com/gofas/gofasquotanotifications/releases/latest)
[![licença](https://img.shields.io/badge/licen%C3%A7a-propriet%C3%A1ria-005071?style=flat-square)](https://gofas.net/contrato-de-venda-de-licenca-de-uso-de-software/)
[![suporte](https://img.shields.io/badge/suporte-f%C3%B3rum%20gratuito-ff8700?style=flat-square)](https://gofas.net/foruns/)

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

O download é contabilizado no site pelo contador de instalações do módulo.

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

Fórum de suporte gratuito: https://gofas.net/foruns/

## Licença

Software proprietário da Gofas Software. O código é público apenas para transparência e consulta; isso não concede licença de uso, modificação ou redistribuição. É vedado modificar, redistribuir, sublicenciar ou realizar engenharia reversa sem autorização prévia por escrito. Veja [LICENSE](LICENSE) e o contrato completo em https://gofas.net/contrato-de-venda-de-licenca-de-uso-de-software/.
