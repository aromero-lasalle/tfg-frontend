# InfraTicket - Portal de Gestión de Incidencias

InfraTicket es una aplicación web desarrollada con Laravel para la gestión de incidencias mediante un sistema de tickets.

El proyecto permite que los usuarios registren incidencias, los técnicos gestionen los tickets asignados y el administrador supervise y asigne las incidencias a los técnicos correspondientes.

Este proyecto forma parte del Trabajo de Fin de Grado de Desarrollo de Aplicaciones Web.

---

## Tecnologías utilizadas

- Laravel 12
- PHP 8.2
- Blade
- Tailwind CSS
- Vite
- SQLite / MariaDB
- Eloquent ORM
- Laravel Breeze
- Composer
- NPM
- Git y GitHub

---

## Funcionalidades principales

- Autenticación de usuarios.
- Control de roles.
- Dashboard de tickets.
- Creación de tickets.
- Listado de tickets.
- Filtros por estado, prioridad y técnico.
- Vista de detalle de ticket.
- Edición de tickets.
- Asignación de tickets a técnicos.
- Página de tickets sin asignar.
- Página de tickets asignados.
- Página de mis tickets.
- Sistema de comentarios.
- Historial de cambios de estado.
- Diseño responsive.

---

## Roles del sistema

### Administrador

El administrador puede:

- Ver todos los tickets.
- Asignar tickets a técnicos.
- Acceder a tickets sin asignar.
- Editar tickets.
- Cambiar estados.
- Eliminar tickets.
- Consultar comentarios e historial.

### Técnico

El técnico puede:

- Ver los tickets que tiene asignados.
- Consultar el detalle de sus tickets.
- Añadir comentarios.
- Cambiar el estado de sus tickets.

No puede asignar tickets a otros técnicos.

### Usuario

El usuario puede:

- Crear tickets.
- Ver sus propios tickets.
- Añadir comentarios en sus tickets.
- Consultar el estado de sus incidencias.

No puede ver tickets de otros usuarios ni asignar técnicos.

---

## Estados de los tickets

Los tickets pueden tener los siguientes estados:

- Nuevo
- En curso
- Resuelto
- Cerrado

Cuando un usuario crea un ticket, se crea en estado **Nuevo**.  
Cuando el administrador asigna un técnico, el ticket pasa a **En curso**.

---

## Prioridades

Los tickets pueden tener tres prioridades:

- Alta
- Media
- Baja

---

## Estructura principal del proyecto

```text
app/
├── Http/
│   └── Controllers/
│       └── TicketController.php
├── Models/
│   ├── User.php
│   ├── Ticket.php
│   ├── Comment.php
│   └── TicketHistory.php

database/
└── migrations/

resources/
└── views/
    ├── layouts/
    │   └── navigation.blade.php
    └── tickets/
        ├── dashboard.blade.php
        ├── index.blade.php
        ├── create.blade.php
        ├── edit.blade.php
        ├── show.blade.php
        ├── sin_asignar.blade.php
        ├── mis_tickets.blade.php
        └── tickets_asignados.blade.php

routes/
└── web.php
