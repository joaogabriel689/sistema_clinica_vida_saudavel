<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="{{ route('admin.store_clinica') }}" method="post">
        @csrf
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>
        </div>
        <div>
            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" required>
        </div>
        <div>
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" required>
        </div>
        <div>
            <label for="cnpj">CNPJ:</label>
            <input type="text" name="cnpj" id="cnpj" required>
        </div>
        <button type="submit">Criar Clínica</button>
    </form>

</body>
</html>