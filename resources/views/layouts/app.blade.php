<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Livewire</title>

    <!-- Bootstrap 5 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Estilos personalizados para tema oscuro -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}">

    @livewireStyles

    <style>
        :root {
            --nav-item-margin-bottom: 10px;
            --sub-menu-padding-left: 15px;
            --icon-margin-right: 8px;
        }

        /* Aumentar espacio entre los elementos del menú */
        .nav-item {
            margin-bottom: var(--nav-item-margin-bottom);
        }

        /* Estilos para el submenú anidado */
        .nav .collapse {
            padding-left: var(--sub-menu-padding-left);
        }

        /* Agregar espacio adicional entre el icono y el texto del menú */
        .nav-link i {
            margin-right: var(--icon-margin-right);
        }
    </style>
</head>

<body>
    <!-- Barra de navegación a la izquierda -->
    <nav class="bg-secondary text-light" id="sidebar" style="padding: 20px;">
        <ul class="nav flex-column">
            <!-- Link 1: Dashboard -->
            <li class="nav-item">
                <a class="nav-link @if (request()->routeIs('admin.dashboard')) active @endif d-flex align-items-center"
                    href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house-fill"></i> Dashboard
                </a>
            </li>

            <!-- Link 2: External con submenú -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center @if (request()->routeIs('admin.external.*')) active @endif"
                    data-bs-toggle="collapse" href="#externalSubmenu" role="button"
                    aria-expanded="@if (request()->routeIs('admin.external.*')) true @else false @endif"
                    aria-controls="externalSubmenu">
                    <i class="bi bi-box-arrow-in-right"></i> External
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>

                <div class="collapse @if (request()->routeIs('admin.external.*')) show @endif" id="externalSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item submenu">
                            <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#voeSubmenu"
                                role="button" aria-expanded="@if (request()->routeIs('admin.external.voe.*')) true @else false @endif"
                                aria-controls="voeSubmenu">
                                <i class="bi bi-folder"></i> Voe
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </a>

                            <div class="collapse @if (request()->routeIs('admin.external.voe.*')) show @endif" id="voeSubmenu">
                                <ul class="nav flex-column ms-3 submenu2">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.external.voe.move') }}">
                                            <span class="@if (request()->routeIs('admin.external.voe.move')) active @endif">Mover</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <span>Clonar</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Área principal a la derecha -->
    <div class="main-content">
        <!-- Encabezado fijo -->
        <header class="bg-secondary text-light py-3 fixed-top">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Panel de Administración</h4>

                <!-- Menú de usuario -->
                <div class="dropdown">
                    <div class="d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- Imagen o logo de usuario -->
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                            alt="{{ Auth::user()->name }}" class="rounded-circle me-2"
                            style="width: 50px; height: 50px; object-fit: cover;">
                        <span class="text-light">{{ Auth::user()->name }}</span>
                    </div>

                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item text-light" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Desconectar
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Formulario de logout (oculto) -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </header>

        <!-- Contenido desplazable -->
        <main class="content overflow-auto">
            {{ $slot }}
        </main>

        <!-- Pie de página fijo -->
        <footer class="bg-secondary text-light py-3 fixed-bottom">
            <div class="container-fluid text-center">
                <small>&copy; {{ date('Y') }} Tu Nombre. Todos los derechos reservados.</small>
            </div>
        </footer>
    </div>

    <!-- Bootstrap 5 JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>

</html>
