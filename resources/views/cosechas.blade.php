{{-- resources/views/cosechas.blade.php --}}
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosechas - SmartGarden</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --verde-hoja: #2E7D32;
            --verde-menta: #81C784;
            --verde-oscuro: #1B5E20;
            --tierra: #8D6E63;
            --naranja: #FF9800;
            --naranja-oscuro: #F57C00;
            --azul-cielo: #64B5F6;
            --fondo: #F8F9FA;
            --gris-oscuro: #2c3e50;
            --sombra-suave: 0 10px 30px rgba(0,0,0,0.1);
            --sombra-media: 0 15px 40px rgba(0,0,0,0.15);
            --transicion: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--fondo);
            color: #333;
            overflow-x: hidden;
        }

        /* Dashboard layout */
        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: white;
            box-shadow: 2px 0 20px rgba(0,0,0,0.05);
            transition: var(--transicion);
            position: relative;
            z-index: 10;
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(46,125,50,0.1);
        }

        .sidebar-header h3 {
            font-weight: 800;
            color: var(--verde-hoja);
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .sidebar-header h3 i {
            color: var(--naranja);
            margin-right: 10px;
        }

        .sidebar-header p {
            color: #888;
            font-size: 0.9rem;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: #555;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            font-weight: 500;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(46,125,50,0.05);
            color: var(--verde-hoja);
            border-left-color: var(--verde-hoja);
            transform: translateX(5px);
        }

        .sidebar-menu a i {
            width: 30px;
            font-size: 1.3rem;
            margin-right: 10px;
            color: var(--verde-hoja);
        }

        /* Main content */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        /* Header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px 30px;
            border-radius: 20px;
            box-shadow: var(--sombra-suave);
            transition: var(--transicion);
        }

        .dashboard-header:hover {
            box-shadow: var(--sombra-media);
        }

        .header-title h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--verde-hoja);
            margin-bottom: 5px;
        }

        .header-title p {
            color: #666;
            font-size: 0.95rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-badge {
            position: relative;
            font-size: 1.5rem;
            color: #666;
            transition: var(--transicion);
        }

        .notification-badge:hover {
            color: var(--naranja);
            transform: scale(1.1);
        }

        .notification-badge span {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--naranja);
            color: white;
            font-size: 0.7rem;
            padding: 2px 5px;
            border-radius: 10px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px 15px;
            border-radius: 50px;
            transition: var(--transicion);
            background: #f5f5f5;
        }

        .user-profile:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-profile span {
            font-weight: 600;
        }

        /* Botones */
        .btn-naranja {
            background: var(--naranja);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transicion);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-naranja:hover {
            background: var(--naranja-oscuro);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255,152,0,0.3);
        }

        .btn-outline-verde {
            background: transparent;
            border: 2px solid var(--verde-hoja);
            color: var(--verde-hoja);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transicion);
        }

        .btn-outline-verde:hover {
            background: var(--verde-hoja);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46,125,50,0.3);
        }

        /* Tarjetas de resumen */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: var(--sombra-suave);
            transition: var(--transicion);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid rgba(46,125,50,0.1);
        }

        .stat-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: var(--sombra-media);
        }

        .stat-info h3 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--verde-hoja);
            margin-bottom: 5px;
        }

        .stat-info p {
            color: #666;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .stat-info small {
            color: #999;
            font-size: 0.8rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--verde-menta), var(--verde-hoja));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            transition: var(--transicion);
        }

        .stat-card:hover .stat-icon {
            transform: rotate(5deg) scale(1.1);
        }

        /* Filtros */
        .filters-panel {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: var(--sombra-suave);
            transition: var(--transicion);
            margin-bottom: 30px;
        }

        .filters-panel:hover {
            box-shadow: var(--sombra-media);
        }

        .filters-panel h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--verde-hoja);
            margin-bottom: 20px;
        }

        .filters-panel h3 i {
            margin-right: 10px;
            color: var(--naranja);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-group label {
            font-weight: 500;
            margin-bottom: 5px;
            color: #666;
        }

        .filter-group select, .filter-group input {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            transition: var(--transicion);
            outline: none;
        }

        .filter-group select:focus, .filter-group input:focus {
            border-color: var(--verde-hoja);
            box-shadow: 0 0 0 3px rgba(46,125,50,0.1);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* Tabla de cosechas */
        .table-container {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: var(--sombra-suave);
            transition: var(--transicion);
        }

        .table-container:hover {
            box-shadow: var(--sombra-media);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--verde-hoja);
            margin: 0;
        }

        .table-header h2 i {
            margin-right: 10px;
            color: var(--naranja);
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #f5f5f5;
            border-radius: 50px;
            padding: 5px 5px 5px 20px;
            transition: var(--transicion);
        }

        .search-box:hover {
            background: #e9ecef;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            padding: 8px 10px;
            width: 200px;
        }

        .search-box button {
            background: var(--verde-hoja);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            transition: var(--transicion);
        }

        .search-box button:hover {
            background: var(--verde-oscuro);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 15px 10px;
            color: #666;
            font-weight: 600;
            border-bottom: 2px solid #f0f0f0;
        }

        td {
            padding: 15px 10px;
            border-bottom: 1px solid #f0f0f0;
            transition: var(--transicion);
        }

        tr {
            transition: var(--transicion);
        }

        tr:hover {
            background: rgba(46,125,50,0.02);
        }

        tr:hover td {
            background: rgba(46,125,50,0.02);
        }

        .badge-calidad {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-excelente {
            background: rgba(46,125,50,0.1);
            color: var(--verde-hoja);
        }

        .badge-buena {
            background: rgba(255,152,0,0.1);
            color: var(--naranja-oscuro);
        }

        .badge-regular {
            background: rgba(220,53,69,0.1);
            color: #dc3545;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: var(--transicion);
            margin: 0 3px;
            border: none;
        }

        .action-btn.ver {
            background: var(--azul-cielo);
        }

        .action-btn.editar {
            background: var(--verde-hoja);
        }

        .action-btn.eliminar {
            background: #dc3545;
        }

        .action-btn.descargar {
            background: var(--naranja);
        }

        .action-btn:hover {
            transform: scale(1.15);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .dashboard {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
<div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar" data-aos="fade-right" data-aos-duration="1000">
        <div class="sidebar-header">
            <h3><i class="fas fa-seedling"></i> SmartGarden</h3>
            <p>Gestión Inteligente</p>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="/dashboard"><i class="fas fa-home"></i> Vista general</a></li>
                <li><a href="/cultivos"><i class="fas fa-seedling"></i> Cultivos</a></li>
                <li><a href="/siembras"><i class="fas fa-sprout"></i> Siembras</a></li>
                <li><a href="/monitoreo"><i class="fas fa-thermometer-half"></i> Monitoreo</a></li>
                <li><a href="/alertas"><i class="fas fa-bell"></i> Alertas</a></li>
                <li><a href="/reportes"><i class="fas fa-file-alt"></i> Reportes</a></li>
                <li><a href="#" class="active"><i class="fas fa-carrot"></i> Cosechas</a></li>
                <li><a href="/evaluaciones"><i class="fas fa-chart-bar"></i> Evaluaciones</a></li>
                <li><a href="/configuracion"><i class="fas fa-cog"></i> Configuración</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="dashboard-header" data-aos="fade-down" data-aos-duration="1000">
            <div class="header-title">
                <h1>Registro de Cosechas</h1>
                <p>Gestiona las cosechas obtenidas de tus cultivos</p>
            </div>
            <div class="header-actions">
                <a href="#" class="notification-badge">
                    <i class="fas fa-bell"></i>
                    <span>3</span>
                </a>
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=Christopher+Kevin&background=2E7D32&color=fff&size=40" alt="Profile">
                    <span>Christopher</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="50">
                <div class="stat-info">
                    <h3>24</h3>
                    <p>Cosechas totales</p>
                    <small>Histórico</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-carrot"></i>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-info">
                    <h3>18.5 kg</h3>
                    <p>Peso total</p>
                    <small>Último mes</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-weight-scale"></i>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="150">
                <div class="stat-info">
                    <h3>6</h3>
                    <p>Cosechas pendientes</p>
                    <small>Próximos 7 días</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-info">
                    <h3>92%</h3>
                    <p>Calidad promedio</p>
                    <small>Excelente</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-panel" data-aos="fade-up" data-aos-delay="100">
            <h3><i class="fas fa-sliders-h"></i> Filtrar cosechas</h3>
            <div class="filter-row">
                <div class="filter-group">
                    <label>Cultivo</label>
                    <select>
                        <option>Todos</option>
                        <option>Lechuga</option>
                        <option>Espinaca</option>
                        <option>Tomate cherry</option>
                        <option>Albahaca</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Desde</label>
                    <input type="date" value="2025-03-01">
                </div>
                <div class="filter-group">
                    <label>Hasta</label>
                    <input type="date" value="2025-03-31">
                </div>
                <div class="filter-group">
                    <label>Calidad</label>
                    <select>
                        <option>Todas</option>
                        <option>Excelente</option>
                        <option>Buena</option>
                        <option>Regular</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button class="btn-naranja"><i class="fas fa-filter"></i> Aplicar</button>
                    <button class="btn-outline-verde"><i class="fas fa-redo"></i> Limpiar</button>
                </div>
            </div>
        </div>

        <!-- Tabla de cosechas -->
        <div class="table-container" data-aos="fade-up" data-aos-delay="200">
            <div class="table-header">
                <h2><i class="fas fa-carrot"></i> Listado de cosechas</h2>
                <div class="d-flex gap-3">
                    <div class="search-box">
                        <input type="text" placeholder="Buscar cosecha...">
                        <button><i class="fas fa-search"></i></button>
                    </div>
                    <button class="btn-naranja">
                        <i class="fas fa-plus"></i> Nueva Cosecha
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cultivo</th>
                        <th>Fecha cosecha</th>
                        <th>Cantidad (kg)</th>
                        <th>Calidad</th>
                        <th>Módulo</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>#COS-001</td>
                        <td>Lechuga</td>
                        <td>15/03/2025</td>
                        <td>2.3 kg</td>
                        <td><span class="badge-calidad badge-excelente">Excelente</span></td>
                        <td>Módulo 1</td>
                        <td>Hojas grandes y frescas</td>
                        <td>
                            <button class="action-btn ver"><i class="fas fa-eye"></i></button>
                            <button class="action-btn editar"><i class="fas fa-edit"></i></button>
                            <button class="action-btn descargar"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#COS-002</td>
                        <td>Espinaca</td>
                        <td>18/03/2025</td>
                        <td>1.8 kg</td>
                        <td><span class="badge-calidad badge-excelente">Excelente</span></td>
                        <td>Módulo 2</td>
                        <td>Muy tierna</td>
                        <td>
                            <button class="action-btn ver"><i class="fas fa-eye"></i></button>
                            <button class="action-btn editar"><i class="fas fa-edit"></i></button>
                            <button class="action-btn descargar"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#COS-003</td>
                        <td>Tomate cherry</td>
                        <td>20/03/2025</td>
                        <td>3.5 kg</td>
                        <td><span class="badge-calidad badge-buena">Buena</span></td>
                        <td>Módulo 4</td>
                        <td>Algunos verdes</td>
                        <td>
                            <button class="action-btn ver"><i class="fas fa-eye"></i></button>
                            <button class="action-btn editar"><i class="fas fa-edit"></i></button>
                            <button class="action-btn descargar"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#COS-004</td>
                        <td>Albahaca</td>
                        <td>22/03/2025</td>
                        <td>1.2 kg</td>
                        <td><span class="badge-calidad badge-excelente">Excelente</span></td>
                        <td>Módulo 3</td>
                        <td>Aroma intenso</td>
                        <td>
                            <button class="action-btn ver"><i class="fas fa-eye"></i></button>
                            <button class="action-btn editar"><i class="fas fa-edit"></i></button>
                            <button class="action-btn descargar"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#COS-005</td>
                        <td>Lechuga</td>
                        <td>25/03/2025</td>
                        <td>2.1 kg</td>
                        <td><span class="badge-calidad badge-regular">Regular</span></td>
                        <td>Módulo 1</td>
                        <td>Algunas hojas dañadas</td>
                        <td>
                            <button class="action-btn ver"><i class="fas fa-eye"></i></button>
                            <button class="action-btn editar"><i class="fas fa-edit"></i></button>
                            <button class="action-btn descargar"><i class="fas fa-download"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <nav>
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 50
    });
</script>
</body>
</html>
