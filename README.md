# Loja de Natal (Christmas Store)

Um sistema simples de e-commerce desenvolvido em PHP para uma loja temática de Natal.

## 📋 Descrição

Este projeto é uma implementação básica de uma loja virtual com tema natalino, desenvolvida utilizando PHP puro. O sistema inclui funcionalidades essenciais para um e-commerce, como carrinho de compras, área administrativa e gestão de produtos.

## 🚀 Funcionalidades

- Sistema de login e autenticação
- Painel administrativo
- Gerenciamento de produtos
- Carrinho de compras
- Processo de checkout
- Interface temática natalina

## 🛠️ Estrutura do Projeto

O projeto está organizado da seguinte forma:

- admin.php - Painel administrativo
- bd/ - Arquivos do banco de dados
- carrinho.php - Funcionalidades do carrinho
- comprar.php - Processo de compra
- conexao.php - Configuração da conexão com o banco
- delete.php - Exclusão de itens
- editar_produto.php - Edição de produtos
- index.php - Página principal
- login.php - Sistema de login
- logout.php - Sistema de logout

## 📦 Pré-requisitos

- PHP 7.0 ou superior
- MySQL
- Servidor web (Apache)

## 🔧 Instalação

1. Clone o repositório:
```
git clone [https://github.com/VitorF/loja_natal.git](https://github.com/VitorF/loja_natal.git)
```

2. Configure seu servidor web para apontar para o diretório do projeto

3. Importe o arquivo de banco de dados localizado na pasta `bd`

4. Configure as credenciais do banco de dados no arquivo `conexao.php`

## 🔑 Informações de Login

Para acessar o sistema, utilize as seguintes credenciais:
ADM:
- **Usuário:** admin
- **Senha:** admin123

Usuarios:

- **Usuário:** usuario1
- **Senha:** senha123

- **Usuário:** usuario2
- **Senha:** senha456
- 
Estas credenciais estão configuradas no arquivo do banco de dados. 
## 👩‍💻 Uso

### Área do Cliente
- Acesse a página inicial para visualizar os produtos
- Adicione produtos ao carrinho
- Finalize a compra através do processo de checkout

### Área Administrativa
- Acesse `/admin.php` para gerenciar produtos
- Utilize as credenciais de administrador fornecidas acima para fazer login
- Gerencie produtos, estoque e pedidos

## 🔐 Segurança

- Todas as senhas são armazenadas de forma segura
- Sistema de autenticação para área administrativa
- Validação de dados em formulários

## 🤝 Contribuindo

Contribuições são sempre bem-vindas! Sinta-se à vontade para:

1. Fazer um fork do projeto
2. Criar uma branch para sua feature (`git checkout -b feature/NovaMelhoria`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova melhoria'`)
4. Push para a branch (`git push origin feature/NovaMelhoria`)
5. Abrir um Pull Request

## ⚠️ Observações

Este é um projeto educacional/demonstrativo. Para uso em produção, recomenda-se:
- Implementar medidas adicionais de segurança
- Realizar testes extensivos
- Adicionar validações mais robustas
- Implementar backup automático do banco de dados
- Alterar as credenciais padrão de administrador

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## ✒️ Autor

* **Vitor F** - [GitHub](https://github.com/VitorF)
