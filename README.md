
# 🛍️ Projeto Site de Ofertas e Cupons

Este repositório contém o código-fonte de um site desenvolvido em PHP para exibir ofertas e cupons de diversas lojas. O site apresenta produtos com descontos, permite busca por promoções e exibe cupons e lojas parceiras de forma organizada.

## 🚀 Funcionalidades

- 🏷️ Listagem de ofertas com nome, imagem, preço atual e preço original
- 🔍 Campo de busca por produtos ou cupons
- 🛒 Página com listagem de cupons
- 🏬 Listagem de lojas parceiras com seus respectivos logotipos
- 📅 Paginação para navegação entre páginas de cupons ou produtos
- 📦 Sistema conectado a banco de dados MySQL

## 🗂️ Estrutura do Projeto

```
Projeto Site PHP/
├── config.php          # Configuração da conexão com o banco de dados
├── index.php           # Página inicial com listagem de ofertas
├── cupons.php          # Página de exibição de cupons com paginação
├── lojas.php           # Página com todas as lojas cadastradas
├── ofertas.php         # Página com resultados de busca por produtos
├── header.php          # Cabeçalho reutilizável do site
├── footer.php          # Rodapé reutilizável com botão de voltar ao topo
└── assets/             # Pasta com imagens, estilos e scripts (não analisada aqui)
```

## ⚙️ Requisitos

- PHP 7.4+
- Servidor web Apache ou Nginx
- MySQL ou MariaDB

## 📦 Instalação

1. Clone este repositório:
   ```bash
   git clone https://github.com/seuusuario/nome-do-repositorio.git
   ```

2. Configure o arquivo `config.php` com os dados do seu banco:
   ```php
   $dbHost = 'localhost';
   $dbUsername = 'usuario';
   $dbPassword = 'senha';
   $dbName = 'banco';
   ```

3. Importe a estrutura do banco de dados (`.sql`) se necessário (não incluso neste repositório, deve ser adicionado manualmente).

4. Suba o projeto em um servidor local (XAMPP, WAMP ou VPS).

5. Acesse `http://localhost/index.php` para visualizar o site.

## ✅ Exemplos de uso

- Acessar `index.php` para ver as ofertas
- Usar `?q=palavra-chave` na URL para buscar
- Navegar em `cupons.php` ou `lojas.php` para explorar mais

## 📌 Observações

- Este projeto é uma versão estática com renderização server-side em PHP.
- Pode ser integrado com sistemas de afiliados, como Lomadee, AWIN, etc.
- O design e a organização visual podem ser aprimorados com CSS e JavaScript adicionais.

---

**Autor:** Matheus Souza  
💡 _Mineiro apaixonado por tecnologia_
