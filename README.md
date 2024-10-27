# Painel de Layouts para Otimização de Desenvolvimento
Este repositório contém um painel de gerenciamento de layouts, desenvolvido com PHP e MySQL, projetado para otimizar o tempo de desenvolvimento de projetos web. Com este painel, você pode salvar, visualizar e gerenciar seus layouts em HTML, CSS e JavaScript de forma eficiente, permitindo uma fácil reutilização de código e uma experiência de desenvolvimento mais organizada.


# 📋 Funcionalidades

- Gerenciamento de Layouts: Salvar e visualizar snippets de código em HTML, CSS e JavaScript.

- Interface Intuitiva: Visualização organizada e funcional dos layouts salvos.

- Pré-visualização Interativa: Use iframe para ver os layouts aplicados em tempo real.

- Copiar Código com Um Clique: Use a Clipboard API para copiar snippets de código diretamente.

- Organização de Códigos por Categoria: Mantenha seus códigos organizados para fácil navegação.

- Animações e Feedback do Usuário: Use Toastr para notificações e mensagens de feedback ao usuário.

- Navegação Facilitada: Owl Carousel para navegação prática entre layouts.


## 🛠 Tecnologias Utilizadas

- Back-End: PHP para manipulação de dados e renderização de layouts dinâmicos.
- 
- Banco de Dados: MySQL para armazenamento e recuperação de dados dos layouts.
- 
- Front-End: HTML, CSS e JavaScript para interface e interação.
- 
#### Bibliotecas e Ferramentas Auxiliares:
- Highlight.js: Para destacar trechos de código com diferentes sintaxes.
  
- Clipboard API: Facilita a cópia de conteúdo para a área de transferência.
  
- jQuery: Auxilia na manipulação do DOM e em funcionalidades de interface.
  
- Toastr: Notificações amigáveis para feedback do usuário.
  
- CodeMirror: Editor de código para fácil manipulação de HTML, CSS e JavaScript.
  
- Owl Carousel: Carrossel para navegação fluida entre layouts.
  
- Font Awesome: Ícones visuais para melhorar a UI.


## 📋 Pré-requisitos
- PHP 7.0 ou superior
- MySQL
- Servidor local, como XAMPP ou WAMP


## 🗄 Configuração do Banco de Dados

1. Crie um banco de dados MySQL:
   
    CREATE DATABASE painel_layouts;

2. Importe o arquivo SQL com as tabelas e dados necessários:

    Abra o phpMyAdmin ou outro cliente MySQL.
 
    Importe o arquivo db__painel.sql incluído no repositório.

3. Configure a conexão do banco de dados:

    No arquivo db_connection.php, insira suas credenciais de banco de dados:

    ![image](https://github.com/user-attachments/assets/5133eebf-f474-4d20-b7c1-9c3419afb9bb)
