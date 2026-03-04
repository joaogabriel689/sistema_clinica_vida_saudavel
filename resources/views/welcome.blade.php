@extends('layouts.base')

@section('title', 'Home')

@section('content')
<!-- HERO SECTION -->
<section class="bg-primary text-white text-center py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Cuidando da sua saúde com excelência</h1>
        <p class="lead mt-3">
            Atendimento humanizado, profissionais qualificados e tecnologia a favor do seu bem-estar.
        </p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg mt-3">Agendar Consulta</a>
    </div>
</section>

<!-- SOBRE -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="fw-bold">Sobre a Clínica</h2>
                <p>
                    A Clínica Vida Saudável oferece atendimento médico especializado com foco
                    no cuidado integral do paciente. Trabalhamos com diversas especialidades
                    e convênios para melhor atender você.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid" width="250">
            </div>
        </div>
    </div>
</section>

<!-- SERVIÇOS -->
<section class="bg-light py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Nossos Serviços</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5>Consultas Médicas</h5>
                    <p>Atendimento com profissionais qualificados em diversas especialidades.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5>Convênios</h5>
                    <p>Aceitamos diversos convênios com percentual de desconto.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5>Agendamento Online</h5>
                    <p>Facilidade para marcar sua consulta de forma rápida e segura.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="py-5 text-center bg-primary text-white">
    <div class="container">
        <h2 class="fw-bold">Pronto para cuidar da sua saúde?</h2>
        <p class="mt-3">Agende sua consulta hoje mesmo.</p>
        <a href="https://wa.me/5599999999999" class="btn btn-light btn-lg">telefone</a>
    </div>
</section>
@endsection