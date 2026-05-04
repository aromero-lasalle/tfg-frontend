<?php

namespace App\Http\Controllers;

use App\Models\TicketHistory;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->rol === 'admin') {
            $tickets = Ticket::with(['user', 'creator', 'assignedBy'])->latest()->get();
        } elseif ($user->rol === 'tecnico') {
            $tickets = Ticket::with(['user', 'creator', 'assignedBy'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        } else {
            $tickets = Ticket::with(['user', 'creator', 'assignedBy'])
                ->where('created_by', $user->id)
                ->latest()
                ->get();
        }

        $total = $tickets->count();
        $abiertos = $tickets->whereIn('estado', ['nuevo', 'en_curso'])->count();
        $cerrados = $tickets->whereIn('estado', ['resuelto', 'cerrado'])->count();
        $vencidos = 0;

        $prioridadAlta = $tickets->where('prioridad', 'alta')->count();
        $prioridadMedia = $tickets->where('prioridad', 'media')->count();
        $prioridadBaja = $tickets->where('prioridad', 'baja')->count();

        $ultimosTickets = $tickets->take(5);

        return view('tickets.dashboard', compact(
            'total',
            'abiertos',
            'cerrados',
            'vencidos',
            'prioridadAlta',
            'prioridadMedia',
            'prioridadBaja',
            'ultimosTickets'
        ));
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $estado = $request->get('estado');
        $buscar = $request->get('buscar');
        $user_id = $request->get('user_id');
        $prioridad = $request->get('prioridad');

        $query = Ticket::with(['user', 'creator', 'assignedBy']);

        if ($user->rol === 'tecnico') {
            $query->where('user_id', $user->id);
        }

        if ($user->rol === 'usuario') {
            $query->where('created_by', $user->id);
        }

        if ($estado) {
            $query->where('estado', $estado);
        }

        if ($prioridad) {
            $query->where('prioridad', $prioridad);
        }

        if ($user_id && $user->rol === 'admin') {
            $query->where('user_id', $user_id);
        }

        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', '%' . $buscar . '%')
                    ->orWhere('descripcion', 'like', '%' . $buscar . '%');
            });
        }

        $tickets = $query->latest()->get();
        $users = User::where('rol', 'tecnico')->get();

        return view('tickets.index', compact(
            'tickets',
            'users',
            'estado',
            'buscar',
            'user_id',
            'prioridad'
        ));
    }

    public function misTickets()
    {
        $tickets = Ticket::with(['user', 'creator', 'assignedBy'])
            ->where('created_by', Auth::id())
            ->latest()
            ->get();

        return view('tickets.mis_tickets', compact('tickets'));
    }

    public function ticketsAsignados()
    {
        if (Auth::user()->rol !== 'tecnico') {
            abort(403, 'Solo los técnicos pueden acceder a esta página.');
        }

        $tickets = Ticket::with(['user', 'creator', 'assignedBy'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('tickets.tickets_asignados', compact('tickets'));
    }

    public function sinAsignar()
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Solo el administrador puede acceder a esta página.');
        }

        $tickets = Ticket::with(['creator', 'user', 'assignedBy'])
            ->where('estado', 'nuevo')
            ->whereNull('user_id')
            ->latest()
            ->get();

        $tecnicos = User::where('rol', 'tecnico')->get();

        return view('tickets.sin_asignar', compact('tickets', 'tecnicos'));
    }

    public function asignar(Request $request, $id)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Solo el administrador puede asignar tickets.');
        }

        $request->validate([
            'tecnico_id' => 'required|exists:users,id',
        ]);

        $ticket = Ticket::findOrFail($id);

        $estadoAnterior = $ticket->estado;

        $ticket->user_id = $request->tecnico_id;
        $ticket->assigned_by = Auth::id();
        $ticket->estado = 'en_curso';
        $ticket->save();

        if ($estadoAnterior !== $ticket->estado) {
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $ticket->estado,
            ]);
        }

        return redirect()->back()->with('success', 'Ticket asignado correctamente');
    }

    public function create()
    {
        $users = User::where('rol', 'tecnico')->get();

        return view('tickets.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'prioridad' => 'required',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Ticket::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estado' => 'nuevo',
            'prioridad' => $request->prioridad,
            'created_by' => Auth::id(),
            'user_id' => Auth::user()->rol === 'admin' ? ($request->user_id ?: null) : null,
            'assigned_by' => Auth::user()->rol === 'admin' && $request->user_id ? Auth::id() : null,
        ]);

        return redirect('/tickets')->with('success', 'Ticket creado correctamente');
    }

    public function show($id)
    {
        $ticket = Ticket::with(['user', 'creator', 'assignedBy', 'comments.user', 'histories.user'])->findOrFail($id);

        $this->authorizeTicketAccess($ticket);

        return view('tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);

        $this->authorizeTicketAccess($ticket);

        $users = User::where('rol', 'tecnico')->get();

        return view('tickets.edit', compact('ticket', 'users'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        $this->authorizeTicketAccess($ticket);

        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'prioridad' => 'required',
            'estado' => 'required',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $estadoAnterior = $ticket->estado;

        $data = [
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'prioridad' => $request->prioridad,
            'estado' => $request->estado,
        ];

        if ($user->rol === 'admin') {
            $data['user_id'] = $request->user_id ?: null;
            $data['assigned_by'] = $request->user_id ? Auth::id() : null;

            if ($request->user_id && $ticket->estado === 'nuevo') {
                $data['estado'] = 'en_curso';
            }
        }

        $ticket->update($data);

        if ($estadoAnterior !== $ticket->estado) {
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $ticket->estado,
            ]);
        }

        return redirect('/tickets')->with('success', 'Ticket actualizado correctamente');
    }

    public function cerrar($id)
    {
        $ticket = Ticket::findOrFail($id);

        $this->authorizeTicketAccess($ticket);

        $estadoAnterior = $ticket->estado;

        $ticket->estado = 'cerrado';
        $ticket->save();

        if ($estadoAnterior !== 'cerrado') {
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'cerrado',
            ]);
        }

        return redirect('/tickets')->with('success', 'Ticket cerrado correctamente');
    }

    public function reabrir($id)
    {
        $ticket = Ticket::findOrFail($id);

        $this->authorizeTicketAccess($ticket);

        $estadoAnterior = $ticket->estado;

        $ticket->estado = 'nuevo';
        $ticket->save();

        if ($estadoAnterior !== 'nuevo') {
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'nuevo',
            ]);
        }

        return redirect('/tickets')->with('success', 'Ticket reabierto correctamente');
    }

    public function destroy($id)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'Solo el administrador puede eliminar tickets.');
        }

        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect('/tickets')->with('success', 'Ticket eliminado correctamente');
    }

    public function addComment(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $this->authorizeTicketAccess($ticket);

        $request->validate([
            'contenido' => 'required',
        ]);

        Comment::create([
            'contenido' => $request->contenido,
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Comentario añadido correctamente');
    }

    private function authorizeTicketAccess(Ticket $ticket)
    {
        $user = Auth::user();

        if ($user->rol === 'admin') {
            return true;
        }

        if ($user->rol === 'tecnico' && $ticket->user_id === $user->id) {
            return true;
        }

        if ($ticket->created_by === $user->id) {
            return true;
        }

        abort(403, 'No tienes permiso para acceder a este ticket.');
    }
}