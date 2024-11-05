# Projeto de Teste para estagiário backend na empresa FOCO

## Tabela de Conteúdos

- [Funcionalidades](#funcionalidades)
- [Tecnologias](#tecnologias-utilizadas)
- [Instalação](#instalação)

## Funcionalidades

1. Modelagem de Dados: A modelagem foi feita no workbench utilizando os arquivos XML como base.
2. Importação dos dados no formato XML: Foi feito o script para a importação dos dados XML e depois para ser salvo no banco de dados .
3.CRUD dos quartos por meio de API REST: O crud foi desenvolvido utilizando API REST
4.POST de reservas: Foi feito utilizando a API REST



## Tecnoloogias

- PHP(versão 8.2.12)
- Laravel Framework(versão 11.30.0)
- MYSQL (versão 8.0.34)

## DIAGRAMA ENTIDADE RELACIONAMENTO

![diagrma](C:\Users\igors\Documentos\PROJETOS\ProjetoEstagio\diagrama EER.png)

## Configurando o Projeto




{
    "roomCode": 1,
    "hotelCode": 2,
    "checkIn": "2024-11-10",
    "checkOut": "2024-11-15",
    "total": 200.00,
    "guestName": "João",
    "guestLastName": "Silva",
    "guestPhone": "+55 11 91234-5678",
    "dailyDates": [
        "2024-11-10",
        "2024-11-11"
    ],
    "dailyValues": [
        100.00,
        100.00
    ],
    "paymentMethod": 1,
    "paymentValue": 100.00
}