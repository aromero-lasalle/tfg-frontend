<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #1f2937;
        }

        .container {
            width: 1100px;
            margin: 40px auto;
        }

        h1 {
            margin-bottom: 25px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .user-box {
            text-align: right;
        }

        .logout-btn {
            margin-top: 8px;
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            background: #6b7280;
            color: white;
            cursor: pointer;
        }

        .top-actions {
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            margin-right: 10px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        }

        .card h2 {
            margin: 0 0 10px 0;
            font-size: 18px;
            color: #374151;
        }

        .card .number {
            font-size: 36px;
            font-weight: bold;
        }

        .total { color: #2563eb; }
        .abiertos { color: #16a34a; }
        .cerrados { color: #dc2626; }
        .alta { color: #dc2626; }
        .media { color: #f59e0b; }
        .baja { color: #16a34a; }
        .vencidos { color: #b91c1c; }

        .panel {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .panel h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .bar-group {
            margin-bottom: 18px;
        }

        .bar-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 15px;
        }

        .bar-bg {
            width: 100%;
            height: 16px;
            background: #e5e7eb;
            border-radius: 999px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            border-radius: 999px;
        }

        .fill-abiertos { background: #16a34a; }
        .fill-cerrados { background: #dc2626; }
        .fill-alta { background: #dc2626; }
        .fill-media { background: #f59e0b; }
        .fill-baja { background: #16a34a; }

        .ticket {
            border-bottom: 1px solid #e5e7eb;
            padding: 15px 0;
        }

        .ticket:last-child {
            border-bottom: none;
        }

        .estado-abierto {
            color: #16a34a;
            font-weight: bold;
        }

        .estado-cerrado {
            color: #dc2626;
            font-weight: bold;
        }

        .prioridad-alta {
            color: #dc2626;
            font-weight: bold;
        }

        .prioridad-media {
            color: #f59e0b;
            font-weight: bold;
        }

        .prioridad-baja {
            color: #16a34a;
            font-weight: bold;
        }

        .fecha-normal {
            color: #374151;
            font-weight: bold;
        }

        .fecha-vencida {
            color: #dc2626;
            font-weight: bold;
        }

        .tecnico {
            margin-top: 6px;
            color: #374151;
        }

        .empty {
            color: #6b7280;
            font-style: italic;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .ticket-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .ticket-description {
            margin-bottom: 10px;
        }

        .meta {
            color: #374151;
            margin-top: 6px;
        }

        @media (max-width: 1150px) {
            .container {
                width: 95%;
            }

            .cards {
                grid-template-columns: 1fr 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

@php
    $totalSeguro = $total > 0 ? $total : 1;

    $porcentajeAbiertos = ($abiertos / $totalSeguro) * 100;
    $porcentajeCerrados = ($cerrados / $totalSeguro) * 100;

    $porcentajeAlta = ($prioridadAlta / $totalSeguro) * 100;
    $porcentajeMedia = ($prioridadMedia / $totalSeguro) * 100;
    $porcentajeBaja = ($prioridadBaja / $totalSeguro) * 100;
@endphp

<div class="container">
    <div class="topbar">
        <h1>Dashboard de Tickets</h1>

        <div class="user-box">
            <div>Usuario: <strong>{{ auth()->user()->name }}</strong></div>
            <div>{{ auth()->user()->email }}</div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Cerrar sesión</button>
            </form>
        </div>
    </div>

    <div class="top-actions">
        <a href="/tickets" class="btn btn-primary">Ir al listado</a>
        <a href="/tickets/create" class="btn btn-secondary">Crear ticket</a>
    </div>

    <div class="cards">
        <div class="card">
            <h2>Total de tickets</h2>
            <div class="number total">{{ $total }}</div>
        </div>

        <div class="card">
            <h2>Tickets abiertos</h2>
            <div class="number abiertos">{{ $abiertos }}</div>
        </div>

        <div class="card">
            <h2>Tickets cerrados</h2>
            <div class="number cerrados">{{ $cerrados }}</div>
        </div>

        <div class="card">
            <h2>Tickets vencidos</h2>
            <div class="number vencidos">{{ $vencidos }}</div>
        </div>

        <div class="card">
            <h2>Prioridad alta</h2>
            <div class="number alta">{{ $prioridadAlta }}</div>
        </div>

        <div class="card">
            <h2>Prioridad media</h2>
            <div class="number media">{{ $prioridadMedia }}</div>
        </div>

        <div class="card">
            <h2>Prioridad baja</h2>
            <div class="number baja">{{ $prioridadBaja }}</div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="panel">
            <h2>Distribución por estado</h2>

            <div class="bar-group">
                <div class="bar-label">
                    <span>Abiertos</span>
                    <span>{{ $abiertos }}</span>
                </div>
                <div class="bar-bg">
                    <div class="bar-fill fill-abiertos" style="width: {{ $porcentajeAbiertos }}%"></div>
                </div>
            </div>

            <div class="bar-group">
                <div class="bar-label">
                    <span>Cerrados</span>
                    <span>{{ $cerrados }}</span>
                </div>
                <div class="bar-bg">
                    <div class="bar-fill fill-cerrados" style="width: {{ $porcentajeCerrados }}%"></div>
                </div>
            </div>
        </div>

        <div class="panel">
            <h2>Distribución por prioridad</h2>

            <div class="bar-group">
                <div class="bar-label">
                    <span>Alta</span>
                    <span>{{ $prioridadAlta }}</span>
                </div>
                <div class="bar-bg">
                    <div class="bar-fill fill-alta" style="width: {{ $porcentajeAlta }}%"></div>
                </div>
            </div>

            <div class="bar-group">
                <div class="bar-label">
                    <span>Media</span>
                    <span>{{ $prioridadMedia }}</span>
                </div>
                <div class="bar-bg">
                    <div class="bar-fill fill-media" style="width: {{ $porcentajeMedia }}%"></div>
                </div>
            </div>

            <div class="bar-group">
                <div class="bar-label">
                    <span>Baja</span>
                    <span>{{ $prioridadBaja }}</span>
                </div>
                <div class="bar-bg">
                    <div class="bar-fill fill-baja" style="width: {{ $porcentajeBaja }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <h2>Últimos tickets</h2>

        @if($ultimosTickets->count() > 0)
            @foreach($ultimosTickets as $ticket)
                <div class="ticket">
                    <div class="ticket-title">{{ $ticket->titulo }}</div>

                    <div class="ticket-description">
                        {{ $ticket->descripcion }}
                    </div>

                    <div>
                        Estado:
                        @if($ticket->estado == 'abierto')
                            <span class="estado-abierto">Abierto</span>
                        @else
                            <span class="estado-cerrado">Cerrado</span>
                        @endif
                    </div>

                    <div>
                        Prioridad:
                        <span class="prioridad-{{ $ticket->prioridad }}">
                            {{ ucfirst($ticket->prioridad) }}
                        </span>
                    </div>

                    <div class="meta">
                        <strong>Técnico asignado:</strong>
                        {{ $ticket->user ? $ticket->user->name : 'Sin asignar' }}
                    </div>

                    <div class="meta">
                        <strong>Comentarios:</strong>
                        {{ $ticket->comments->count() }}
                    </div>

                    <div class="meta">
                        <strong>Fecha límite:</strong>
                        @if($ticket->fecha_limite)
                            @if($ticket->estado == 'abierto' && $ticket->fecha_limite->isPast())
                                <span class="fecha-vencida">{{ $ticket->fecha_limite->format('d/m/Y') }} (Vencido)</span>
                            @else
                                <span class="fecha-normal">{{ $ticket->fecha_limite->format('d/m/Y') }}</span>
                            @endif
                        @else
                            Sin fecha
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <p class="empty">No hay tickets todavía.</p>
        @endif
    </div>
</div>

</body>
</html>