
# EvenTeca

EvenTeca é uma plataforma web para gestão de eventos, inscrições e pagamentos, permitindo que administradores, organizadores e usuários interajam de forma eficiente. O sistema possibilita o cadastro de eventos, gerenciamento de participantes, controle de pagamentos, dentre outras funcionalidades.

## Tecnologias Utilizadas

- **PHP 8.2+**
- **Laravel 12**
- **Composer** (gerenciador de dependências PHP)
- **Filament** (admin, opcional)

## Passo a Passo para Execução

1. **Clone o repositório**
   ```bash
   git clone https://github.com/queirozPedro/even-teca
   cd even-teca
   ```

2. **Instale as dependências do backend**
   ```bash
   composer install
   ```

3. **Configure o ambiente**
   - Copie o arquivo `.env.example` para `.env`:
     ```bash
     cp .env.example .env
     ```
   - Ajuste as variáveis de ambiente conforme necessário (por padrão, o projeto usa SQLite).

4. **Gere a chave da aplicação**
   ```bash
   php artisan key:generate
   ```

5. **Execute as migrações do banco de dados**
   ```bash
   php artisan migrate
   ```

6. **Inicie o servidor de desenvolvimento**
   ```bash
   php artisan serve
   ```

7. **Acesse a aplicação**
    - Abra o navegador em: [http://localhost:8000](http://localhost:8000)

---
Pronto! O EvenTeca estará rodando localmente. Para dúvidas ou contribuições, consulte a documentação do Laravel ou abra uma issue no repositório.
