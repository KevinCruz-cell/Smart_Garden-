{{-- resources/views/cultivos.blade.php --}}
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cultivos - SmartGarden</title>
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
            transition: var(--transicion);
            border-left: 4px solid transparent;
            font-weight: 500;
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

        /* Barra de herramientas */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .btn-primary-custom {
            background: var(--verde-hoja);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transicion);
            box-shadow: 0 5px 15px rgba(46,125,50,0.3);
        }

        .btn-primary-custom:hover {
            background: var(--verde-oscuro);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46,125,50,0.4);
        }

        .filter-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-group select, .filter-group input {
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            padding: 8px 20px;
            font-size: 0.9rem;
            outline: none;
            transition: var(--transicion);
        }

        .filter-group select:focus, .filter-group input:focus {
            border-color: var(--verde-hoja);
            box-shadow: 0 0 0 0.2rem rgba(46,125,50,0.1);
        }

        /* Tarjetas de cultivos */
        .cultivos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .cultivo-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: var(--sombra-suave);
            transition: var(--transicion);
            border: 1px solid rgba(46,125,50,0.1);
            position: relative;
            overflow: hidden;
        }

        .cultivo-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--sombra-media);
        }

        .cultivo-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--verde-hoja), var(--naranja));
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: left;
        }

        .cultivo-card:hover::before {
            transform: scaleX(1);
        }

        .cultivo-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .cultivo-nombre {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--verde-oscuro);
        }

        .cultivo-tipo {
            background: rgba(46,125,50,0.1);
            color: var(--verde-hoja);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .cultivo-info {
            margin-bottom: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            color: #555;
            font-size: 0.95rem;
        }

        .info-item i {
            width: 20px;
            color: var(--verde-hoja);
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .progress {
            height: 8px;
            border-radius: 10px;
            background: #f0f0f0;
            margin-bottom: 15px;
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--verde-hoja), var(--naranja));
            border-radius: 10px;
        }

        .cultivo-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-action {
            flex: 1;
            padding: 8px;
            border: 1px solid var(--verde-hoja);
            border-radius: 10px;
            background: transparent;
            color: var(--verde-hoja);
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transicion);
        }

        .btn-action:hover {
            background: var(--verde-hoja);
            color: white;
        }

        .btn-action.delete:hover {
            background: #dc3545;
            border-color: #dc3545;
        }

        /* Estado badge */
        .estado-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 10px;
        }

        .estado-optimo {
            background: rgba(46,125,50,0.15);
            color: var(--verde-oscuro);
        }

        .estado-atencion {
            background: rgba(255,152,0,0.15);
            color: var(--naranja-oscuro);
        }

        .estado-critico {
            background: rgba(220,53,69,0.15);
            color: #dc3545;
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
            .toolbar {
                flex-direction: column;
                align-items: stretch;
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
                <li><a href="/cultivos" class="active"><i class="fas fa-seedling"></i> Cultivos</a></li>
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
                <h1>Cultivos</h1>
                <p>Gestión de tus cultivos verticales</p>
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

        <!-- Toolbar -->
        <div class="toolbar" data-aos="fade-up" data-aos-delay="50">
            <button class="btn-primary-custom"><i class="fas fa-plus me-2"></i>Nuevo cultivo</button>
            <div class="filter-group">
                <select>
                    <option>Todos los tipos</option>
                    <option>Hortalizas de hoja</option>
                    <option>Frutales</option>
                    <option>Aromáticas</option>
                </select>
                <select>
                    <option>Todos los estados</option>
                    <option>Óptimo</option>
                    <option>Requiere atención</option>
                    <option>Crítico</option>
                </select>
                <input type="text" placeholder="Buscar cultivo...">
            </div>
        </div>

        <!-- Grid de cultivos -->
        <div class="cultivos-grid">
            <!-- Cultivo 1 -->
            <div class="cultivo-card" data-aos="fade-up" data-aos-delay="100">
                <div class="cultivo-header">
                    <span class="cultivo-nombre">Lechuga</span>
                    <span class="cultivo-tipo">Hoja</span>
                </div>
                <div class="cultivo-info">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Siembra: 15/02/2025</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-layer-group"></i>
                        <span>Módulo: 1 - Charola 1</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-tint"></i>
                        <span>Humedad: 75%</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-sun"></i>
                        <span>Luz: 350 lux</span>
                    </div>
                </div>
                <div class="progress-label">
                    <span>Crecimiento</span>
                    <span>75%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" style="width: 75%"></div>
                </div>
                <span class="estado-badge estado-optimo">Óptimo</span>
                <div class="cultivo-actions">
                    <button class="btn-action"><i class="fas fa-eye"></i> Ver</button>
                    <button class="btn-action"><i class="fas fa-edit"></i> Editar</button>
                    <button class="btn-action delete"><i class="fas fa-trash"></i></button>
                </div>
            </div>

            <!-- Cultivo 2 -->
            <div class="cultivo-card" data-aos="fade-up" data-aos-delay="150">
                <div class="cultivo-header">
                    <span class="cultivo-nombre">Espinaca</span>
                    <span class="cultivo-tipo">Hoja</span>
                </div>
                <div class="cultivo-info">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Siembra: 20/02/2025</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-layer-group"></i>
                        <span>Módulo: 2 - Charola 2</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-tint"></i>
                        <span>Humedad: 30%</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-sun"></i>
                        <span>Luz: 200 lux</span>
                    </div>
                </div>
                <div class="progress-label">
                    <span>Crecimiento</span>
                    <span>40%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" style="width: 40%"></div>
                </div>
                <span class="estado-badge estado-atencion">Requiere riego</span>
                <div class="cultivo-actions">
                    <button class="btn-action"><i class="fas fa-eye"></i> Ver</button>
                    <button class="btn-action"><i class="fas fa-edit"></i> Editar</button>
                    <button class="btn-action delete"><i class="fas fa-trash"></i></button>
                </div>
            </div>

            <!-- Cultivo 3 -->
            <div class="cultivo-card" data-aos="fade-up" data-aos-delay="200">
                <div class="cultivo-header">
                    <span class="cultivo-nombre">Albahaca</span>
                    <span class="cultivo-tipo">Aromática</span>
                </div>
                <div class="cultivo-info">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Siembra: 10/02/2025</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-layer-group"></i>
                        <span>Módulo: 3 - Charola 1</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-tint"></i>
                        <span>Humedad: 85%</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-sun"></i>
                        <span>Luz: 400 lux</span>
                    </div>
                </div>
                <div class="progress-label">
                    <span>Crecimiento</span>
                    <span>90%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" style="width: 90%"></div>
                </div>
                <span class="estado-badge estado-optimo">Óptimo</span>
                <div class="cultivo-actions">
                    <button class="btn-action"><i class="fas fa-eye"></i> Ver</button>
                    <button class="btn-action"><i class="fas fa-edit"></i> Editar</button>
                    <button class="btn-action delete"><i class="fas fa-trash"></i></button>
                </div>
            </div>

            <!-- Cultivo 4 -->
            <div class="cultivo-card" data-aos="fade-up" data-aos-delay="250">
                <div class="cultivo-header">
                    <span class="cultivo-nombre">Tomate cherry</span>
                    <span class="cultivo-tipo">Fruto</span>
                </div>
                <div class="cultivo-info">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Siembra: 05/02/2025</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-layer-group"></i>
                        <span>Módulo: 4 - Charola 3</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-tint"></i>
                        <span>Humedad: 70%</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-sun"></i>
                        <span>Luz: 380 lux</span>
                    </div>
                </div>
                <div class="progress-label">
                    <span>Crecimiento</span>
                    <span>65%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" style="width: 65%"></div>
                </div>
                <span class="estado-badge estado-optimo">Óptimo</span>
                <div class="cultivo-actions">
                    <button class="btn-action"><i class="fas fa-eye"></i> Ver</button>
                    <button class="btn-action"><i class="fas fa-edit"></i> Editar</button>
                    <button class="btn-action delete"><i class="fas fa-trash"></i></button>
                </div>
            </div>

            <!-- Cultivo 5 (ejemplo de estado crítico) -->
            <div class="cultivo-card" data-aos="fade-up" data-aos-delay="300">
                <div class="cultivo-header">
                    <span class="cultivo-nombre">Pimiento</span>
                    <span class="cultivo-tipo">Fruto</span>
                </div>
                <div class="cultivo-info">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Siembra: 25/02/2025</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-layer-group"></i>
                        <span>Módulo: 2 - Charola 4</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-tint"></i>
                        <span>Humedad: 15%</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-sun"></i>
                        <span>Luz: 100 lux</span>
                    </div>
                </div>
                <div class="progress-label">
                    <span>Crecimiento</span>
                    <span>20%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" style="width: 20%"></div>
                </div>
                <span class="estado-badge estado-critico">Crítico</span>
                <div class="cultivo-actions">
                    <button class="btn-action"><i class="fas fa-eye"></i> Ver</button>
                    <button class="btn-action"><i class="fas fa-edit"></i> Editar</button>
                    <button class="btn-action delete"><i class="fas fa-trash"></i></button>
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
