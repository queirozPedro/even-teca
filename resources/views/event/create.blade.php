<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Novo Evento</title>
    <style>
        .eventos-centralizada {
            max-width: 700px;
            margin: 2rem auto;
            background: #f9f9f9;
            border-radius: 12px;
            padding: 2rem 1.5rem;
            box-shadow: 0 2px 12px #0001;
        }

        .home-event-title {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.7rem;
            font-weight: bold;
            color: #2563eb;
        }

        .form-control {
            width: 100%;
            padding: 8px 10px;
            margin: 6px 0 16px 0;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        label {
            font-weight: 500;
            color: #222;
        }

        .btn-primario {
            background: #3366FF;
            color: #fff;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: background 0.2s, transform 0.1s;
            border: none;
            cursor: pointer;
        }
        .btn-primario:hover {
            background: #174ea6;
            transform: scale(1.04);
        }
    </style>
</head>
<body>
    <div class="eventos-centralizada">
        <h2 class="home-event-title" style="text-align:center;">Criar Novo Evento</h2>
        <form method="POST" action="{{ route('events.store') }}">
            @csrf
            <div>
                <label for="title">Título</label>
                <input type="text" name="title" id="title" required class="form-control" value="{{ old('title') }}">
            </div>
            <div>
                <label for="category">Categoria</label>
                <input type="text" name="category" id="category" class="form-control" value="{{ old('category') }}" placeholder="Ex: Tecnologia, Saúde, Educação...">
            </div>
            <div>
                <label for="description">Descrição</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div>
                <label for="start_time">Data e Hora de Início</label>
                <input type="datetime-local" name="start_time" id="start_time" required class="form-control" value="{{ old('start_time') }}">
            </div>
            <div>
                <label for="end_time">Data e Hora de Fim</label>
                <input type="datetime-local" name="end_time" id="end_time" class="form-control" value="{{ old('end_time') }}">
            </div>
            <div>
                <label for="location">Local</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}">
            </div>
            <div>
                <label for="capacity">Capacidade</label>
                <input type="number" name="capacity" id="capacity" min="1" class="form-control" value="{{ old('capacity') }}">
            </div>
            <div>
                <label for="price">Preço</label>
                <input type="number" name="price" id="price" min="0" step="0.01" class="form-control" value="{{ old('price') }}">
            </div>
            <div style="margin-top:1rem;">
                <button type="submit" class="btn-primario">Salvar Evento</button>
                <a href="{{ route('events.index') }}" class="btn-primario" style="background:#888;">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>

