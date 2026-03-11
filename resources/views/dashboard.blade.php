{{-- resources/views/dashboard.blade.php --}}
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SmartGarden</title>
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
            --transicion: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
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
            transition: var(--transicion);
        }

        .sidebar-header h3 {
            font-weight: 800;
            color: var(--verde-hoja);
            font-size: 1.8rem;
            margin-bottom: 5px;
            transition: var(--transicion);
        }

        .sidebar-header h3 i {
            color: var(--naranja);
            margin-right: 10px;
            transition: transform 0.5s ease;
        }

        .sidebar-header:hover h3 i {
            transform: rotate(360deg);
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
            transition: var(--transicion);
            border-left: 4px solid transparent;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(46,125,50,0.1), transparent);
            transition: left 0.5s ease;
        }

        .sidebar-menu a:hover::before {
            left: 100%;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(46,125,50,0.05);
            color: var(--verde-hoja);
            border-left-color: var(--verde-hoja);
        }

        .sidebar-menu a i {
            width: 30px;
            font-size: 1.3rem;
            margin-right: 10px;
            color: var(--verde-hoja);
            transition: transform 0.3s ease;
        }

        .sidebar-menu a:hover i {
            transform: scale(1.2);
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
            transform: translateY(-2px);
        }

        .header-title h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--verde-hoja);
            margin-bottom: 5px;
            transition: var(--transicion);
        }

        .header-title h1:hover {
            color: var(--naranja);
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
            transform: scale(1.1) rotate(5deg);
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
            transition: var(--transicion);
        }

        .notification-badge:hover span {
            background: var(--verde-hoja);
            transform: scale(1.1);
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .user-profile:hover img {
            transform: scale(1.1);
        }

        .user-profile span {
            font-weight: 600;
        }

        /* Tarjetas de resumen */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
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
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: var(--sombra-media);
            border-color: var(--verde-hoja);
        }

        .stat-info h3 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--verde-hoja);
            margin-bottom: 5px;
            transition: var(--transicion);
        }

        .stat-card:hover .stat-info h3 {
            color: var(--naranja);
        }

        .stat-info p {
            color: #666;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .stat-info small {
            color: #999;
            font-size: 0.8rem;
            transition: var(--transicion);
        }

        .stat-card:hover .stat-info small {
            color: var(--verde-hoja);
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
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, var(--naranja), var(--naranja-oscuro));
        }

        /* Dos columnas */
        .row-custom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }

        .card-custom {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: var(--sombra-suave);
            transition: var(--transicion);
        }

        .card-custom:hover {
            box-shadow: var(--sombra-media);
            transform: translateY(-5px);
        }

        .card-custom h5 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--verde-hoja);
            margin-bottom: 20px;
            transition: var(--transicion);
        }

        .card-custom:hover h5 {
            color: var(--naranja);
        }

        .card-custom h5 i {
            margin-right: 10px;
            color: var(--naranja);
            transition: var(--transicion);
        }

        .card-custom:hover h5 i {
            transform: scale(1.2) rotate(5deg);
            color: var(--verde-hoja);
        }

        /* Monitoreo ambiental */
        .monitoring-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .monitor-item {
            text-align: center;
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px 10px;
            transition: var(--transicion);
            cursor: pointer;
        }

        .monitor-item:hover {
            background: var(--verde-menta);
            color: white;
            transform: scale(1.05) translateY(-5px);
            box-shadow: var(--sombra-media);
        }

        .monitor-item i {
            font-size: 2rem;
            color: var(--verde-hoja);
            margin-bottom: 10px;
            transition: var(--transicion);
        }

        .monitor-item:hover i {
            color: white;
            transform: scale(1.2);
        }

        .monitor-item h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            transition: var(--transicion);
        }

        .monitor-item:hover h4 {
            color: white;
        }

        .monitor-item p {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
            transition: var(--transicion);
        }

        .monitor-item:hover p {
            color: white;
        }

        /* Alertas */
        .alertas-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .alertas-header h5 {
            margin-bottom: 0;
            transition: var(--transicion);
        }

        .btn-naranja {
            background: var(--naranja);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transicion);
            cursor: pointer;
        }

        .btn-naranja:hover {
            background: var(--naranja-oscuro);
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 5px 15px rgba(255,152,0,0.4);
        }

        .alert-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 15px;
            background: #f8f9fa;
            margin-bottom: 10px;
            transition: var(--transicion);
            cursor: pointer;
        }

        .alert-item:hover {
            background: #e9ecef;
            transform: translateX(5px) scale(1.01);
            box-shadow: var(--sombra-suave);
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255,152,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--naranja);
            font-size: 1.2rem;
            transition: var(--transicion);
        }

        .alert-item:hover .alert-icon {
            background: var(--naranja);
            color: white;
            transform: rotate(5deg);
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 600;
            transition: var(--transicion);
        }

        .alert-item:hover .alert-title {
            color: var(--verde-hoja);
        }

        .alert-time {
            font-size: 0.8rem;
            color: #888;
            transition: var(--transicion);
        }

        .alert-item:hover .alert-time {
            color: var(--verde-oscuro);
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
            .row-custom {
                grid-template-columns: 1fr;
            }
            .monitoring-grid {
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
                <li><a href="#" class="active"><i class="fas fa-home"></i> Vista general</a></li>
                <li><a href="#"><i class="fas fa-seedling"></i> Cultivos</a></li>
                <li><a href="#"><i class="fas fa-sprout"></i> Siembras</a></li>
                <li><a href="#"><i class="fas fa-thermometer-half"></i> Monitoreo</a></li>
                <li><a href="#"><i class="fas fa-bell"></i> Alertas</a></li>
                <li><a href="#"><i class="fas fa-file-alt"></i> Reportes</a></li>
                <li><a href="#"><i class="fas fa-carrot"></i> Cosechas</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> Evaluaciones</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Configuración</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="dashboard-header" data-aos="fade-down" data-aos-duration="1000">
            <div class="header-title">
                <h1>Gestión General</h1>
                <p>Bienvenido, Christopher Kevin</p>
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
                    <h3>0</h3>
                    <p>Total Cultivos</p>
                    <small>En desarrollo</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-seedling"></i>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-info">
                    <h3>$0.00</h3>
                    <p>Inversión Total</p>
                    <small>Variedades</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="150">
                <div class="stat-info">
                    <h3>0</h3>
                    <p>Alertas Pendientes</p>
                    <small>Todo en orden</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-bell"></i>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-info">
                    <h3>0</h3>
                    <p>Total Siembras</p>
                    <small>Historial completo</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-sprout"></i>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="250">
                <div class="stat-info">
                    <h3>$0.00</h3>
                    <p>Ingresos Estimados</p>
                    <small>Proyección actual</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>

        <!-- Dos columnas: Siembras Recientes y Evaluaciones -->
        <div class="row-custom">
            <div class="card-custom" data-aos="fade-right" data-aos-delay="100">
                <h5><i class="fas fa-history"></i> Siembras Recientes</h5>
                <p class="text-muted">No hay siembras registradas.</p>
            </div>
            <div class="card-custom" data-aos="fade-left" data-aos-delay="200">
                <h5><i class="fas fa-chart-pie"></i> Evaluación de Rendimiento Recientes</h5>
                <p class="text-muted">No hay evaluaciones de rendimiento registradas.</p>
            </div>
        </div>

        <!-- Monitoreo Ambiental -->
        <div class="card-custom" data-aos="fade-up" data-aos-delay="100">
            <h5><i class="fas fa-leaf"></i> Monitoreo Ambiental</h5>
            <div class="monitoring-grid">
                <div class="monitor-item">
                    <i class="fas fa-thermometer-half"></i>
                    <h4>0.0°C</h4>
                    <p>Temperatura</p>
                </div>
                <div class="monitor-item">
                    <i class="fas fa-sun"></i>
                    <h4>0 lux</h4>
                    <p>Luz</p>
                </div>
                <div class="monitor-item">
                    <i class="fas fa-water"></i>
                    <h4>0%</h4>
                    <p>Charola 1</p>
                </div>
                <div class="monitor-item">
                    <i class="fas fa-water"></i>
                    <h4>0%</h4>
                    <p>Charola 2</p>
                </div>
                <div class="monitor-item">
                    <i class="fas fa-water"></i>
                    <h4>0%</h4>
                    <p>Charola 3</p>
                </div>
                <div class="monitor-item">
                    <i class="fas fa-water"></i>
                    <h4>0%</h4>
                    <p>Charola 4</p>
                </div>
            </div>
        </div>

        <!-- Alertas Recientes -->
        <div class="card-custom" data-aos="fade-up" data-aos-delay="200">
            <div class="alertas-header">
                <h5><i class="fas fa-exclamation-triangle"></i> Alertas Recientes</h5>
                <a href="#" class="btn-naranja btn-sm">Ver Todas</a>
            </div>
            <div class="alert-item">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-title">Humedad baja en charola 2</div>
                    <div class="alert-time">Hace 10 minutos</div>
                </div>
            </div>
            <div class="alert-item">
                <div class="alert-icon">
                    <i class="fas fa-sun"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-title">Luz insuficiente en módulo 3</div>
                    <div class="alert-time">Hace 1 hora</div>
                </div>
            </div>
            <div class="alert-item">
                <div class="alert-icon">
                    <i class="fas fa-tint"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-title">Riego programado para charola 1</div>
                    <div class="alert-time">Hace 2 horas</div>
                </div>
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
