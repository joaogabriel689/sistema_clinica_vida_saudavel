<?php

function validarCPF(string $cpf): bool
{
    // Remove tudo que não for número
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se tem 11 dígitos
    if (strlen($cpf) !== 11) {
        return false;
    }

    // Bloqueia CPFs com todos os dígitos iguais (ex: 11111111111)
    if (preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }

    // Converte para array de números
    $cpf_array = array_map('intval', str_split($cpf));

    // ===== Primeiro dígito verificador =====
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf_array[$i] * (10 - $i);
    }

    $digito1 = ($soma * 10) % 11;
    if ($digito1 === 10) {
        $digito1 = 0;
    }

    if ($digito1 !== $cpf_array[9]) {
        return false;
    }

    // ===== Segundo dígito verificador =====
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf_array[$i] * (11 - $i);
    }

    $digito2 = ($soma * 10) % 11;
    if ($digito2 === 10) {
        $digito2 = 0;
    }

    if ($digito2 !== $cpf_array[10]) {
        return false;
    }

    return true;
}

function validarCelularBR($telefone) {

    $tel = preg_replace('/[^0-9]/', '', $telefone);
    

    $regex = '/^[1-9]{2}9[0-9]{8}$/';
    
    return preg_match($regex, $tel);
}

function validarCEP($cep)
{
    // Remove caracteres não numéricos
    $cep = preg_replace('/[^0-9]/', '', $cep);

    // Verifica se tem exatamente 8 dígitos
    if (strlen($cep) !== 8) {
        return false;
    }

    // Consulta a API ViaCEP
    $url = "https://viacep.com.br/ws/{$cep}/json/";
    $response = @file_get_contents($url);

    if ($response === false) {
        return false;
    }

    $dados = json_decode($response, true);

    // Verifica se o CEP existe
    if (isset($dados['erro']) && $dados['erro'] === true) {
        return false;
    }

    // Normaliza retorno para o padrão do banco
    return [
        'rua'          => $dados['logradouro'] ?? '',
        'bairro'       => $dados['bairro'] ?? '',
        'cidade'       => $dados['localidade'] ?? '',
        'uf'           => $dados['uf'] ?? '',
        'cep'          => (int) $cep,

        // Campos que NÃO vêm da API
        'numero'       => null,       // deve vir do frontend
        'complemento'  => null         // opcional
    ];
}



