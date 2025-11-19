@extends('layouts.app')

@section('content')
<div style="
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
    text-align: center;
">
    <div class="cuad" style="
        background: #ffffffcc;
        padding: 40px 60px;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        max-width: 600px;
    ">
        <h1 style="font-size: 2.5em; color: #333; margin-bottom: 20px;">
            Bienvenido a <span style="color:#0066cc;">FerroBalance</span>
        </h1>
        <p style="font-size: 1.2em; color: #555;">
            Selecciona una opción del menú superior para comenzar.
        </p>
    </div>
</div>
@endsection
