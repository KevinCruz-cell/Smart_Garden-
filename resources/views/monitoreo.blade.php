{{-- resources/views/monitoreo.blade.php --}}
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoreo - SmartGarden</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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

        /* Tarjetas de monitoreo rápido */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
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
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--verde-hoja);
            margin-bottom: 5px;
        }

        .stat-info p {
            color: #666;
            font-weight: 500;
            margin: 0;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--verde-menta), var(--verde-hoja));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            transition: var(--transicion);
        }

        .stat-card:hover .stat-icon {
            transform: rotate(5deg) scale(1.1);
        }

        /* Gráficos */
        .charts-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }

        .chart-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: var(--sombra-suave);
            transition: var(--transicion);
        }

        .chart-card:hover {
            box-shadow: var(--sombra-media);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .chart-header h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--verde-hoja);
            margin: 0;
        }

        .chart-header i {
            color: var(--naranja);
            margin-right: 5px;
        }

        canvas {
            max-height: 200px;
            width: 100% !important;
        }

        /* Sensores por módulo */
        .sensores-section {
            margin-bottom: 40px;
        }

        .sensores-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .sensores-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--verde-hoja);
        }

        .sensores-header h2 i {
            margin-right: 10px;
            color: var(--naranja);
        }

        .sensores-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
        }

        .sensor-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: var(--sombra-suave);
            transition: var(--transicion);
            border: 1px solid rgba(46,125,50,0.1);
        }

        .sensor-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--sombra-media);
        }

        .sensor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .sensor-header h6 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--verde-oscuro);
            margin: 0;
        }

        .sensor-status {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #28a745;
            box-shadow: 0 0 10px #28a745;
        }

        .sensor-status.warning {
            background: var(--naranja);
            box-shadow: 0 0 10px var(--naranja);
        }

        .sensor-reading {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .sensor-reading span:first-child {
            color: #666;
            font-size: 0.9rem;
        }

        .sensor-reading span:last-child {
            font-weight: 700;
            color: var(--verde-hoja);
            font-size: 1.2rem;
        }

        .progress {
            height: 6px;
            border-radius: 10px;
            margin-top: 10px;
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--verde-menta), var(--verde-hoja));
            border-radius: 10px;
        }

        /* Tabla de lecturas recientes */
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
        }

        .table-header h5 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--verde-hoja);
            margin: 0;
        }

        .table-header i {
            margin-right: 10px;
            color: var(--naranja);
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
            padding: 12px 10px;
            color: #666;
            font-weight: 600;
            border-bottom: 2px solid #f0f0f0;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        tr:hover {
            background: rgba(46,125,50,0.02);
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
            .charts-row {
                grid-template-columns: 1fr;
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
                <li><a href="/cultivos')"><i class="fas fa-seedling"></i> Cultivos</a></li>
                <li><a href="/siembras')"><i class="fas fa-sprout"></i> Siembras</a></li>
                <li><a href="#" class="active"><i class="fas fa-thermometer-half"></i> Monitoreo</a></li>
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
                <h1>Monitoreo Ambiental</h1>
                <p>Variables en tiempo real de tus cultivos</p>
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

        <!-- Tarjetas de resumen -->
        <div class="stats-grid">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="50">
                <div class="stat-info">
                    <h3>23.5°C</h3>
                    <p>Temperatura</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-thermometer-half"></i>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-info">
                    <h3>65%</h3>
                    <p>Humedad ambiente</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-tint"></i>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="150">
                <div class="stat-info">
                    <h3>4200 lux</h3>
                    <p>Luz</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-sun"></i>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-info">
                    <h3>7.2</h3>
                    <p>pH del suelo</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-flask"></i>
                </div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="250">
                <div class="stat-info">
                    <h3>1200 ppm</h3>
                    <p>Nutrientes</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-leaf"></i>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="charts-row">
            <div class="chart-card" data-aos="fade-right" data-aos-delay="100">
                <div class="chart-header">
                    <h5><i class="fas fa-temperature-high"></i> Temperatura (°C) - Últimas 24h</h5>
                    <select class="form-select-sm" style="width: auto;">
                        <option>Hoy</option>
                        <option>Ayer</option>
                        <option>Semana</option>
                    </select>
                </div>
                <canvas id="tempChart"></canvas>
            </div>
            <div class="chart-card" data-aos="fade-left" data-aos-delay="200">
                <div class="chart-header">
                    <h5><i class="fas fa-tint"></i> Humedad suelo (%) - Últimas 24h</h5>
                    <select class="form-select-sm" style="width: auto;">
                        <option>Hoy</option>
                        <option>Ayer</option>
                        <option>Semana</option>
                    </select>
                </div>
                <canvas id="humedadChart"></canvas>
            </div>
        </div>

        <!-- Sensores por módulo -->
        <div class="sensores-section">
            <div class="sensores-header">
                <h2><i class="fas fa-microchip"></i> Sensores por Módulo</h2>
                <button class="btn-naranja btn-sm" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i> Actualizar
                </button>
            </div>
            <div class="sensores-grid">
                <!-- Módulo 1 -->
                <div class="sensor-card" data-aos="zoom-in" data-aos-delay="50">
                    <div class="sensor-header">
                        <h6>Módulo 1 - Lechuga</h6>
                        <div class="sensor-status"></div>
                    </div>
                    <div class="sensor-reading">
                        <span>Humedad suelo:</span>
                        <span>68%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 68%"></div>
                    </div>
                    <div class="sensor-reading mt-2">
                        <span>Temperatura:</span>
                        <span>23°C</span>
                    </div>
                    <div class="sensor-reading">
                        <span>Luz:</span>
                        <span>3800 lux</span>
                    </div>
                </div>
                <!-- Módulo 2 -->
                <div class="sensor-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="sensor-header">
                        <h6>Módulo 2 - Espinaca</h6>
                        <div class="sensor-status warning"></div>
                    </div>
                    <div class="sensor-reading">
                        <span>Humedad suelo:</span>
                        <span>32%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 32%"></div>
                    </div>
                    <div class="sensor-reading mt-2">
                        <span>Temperatura:</span>
                        <span>24°C</span>
                    </div>
                    <div class="sensor-reading">
                        <span>Luz:</span>
                        <span>4100 lux</span>
                    </div>
                </div>
                <!-- Módulo 3 -->
                <div class="sensor-card" data-aos="zoom-in" data-aos-delay="150">
                    <div class="sensor-header">
                        <h6>Módulo 3 - Albahaca</h6>
                        <div class="sensor-status"></div>
                    </div>
                    <div class="sensor-reading">
                        <span>Humedad suelo:</span>
                        <span>75%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 75%"></div>
                    </div>
                    <div class="sensor-reading mt-2">
                        <span>Temperatura:</span>
                        <span>22°C</span>
                    </div>
                    <div class="sensor-reading">
                        <span>Luz:</span>
                        <span>3500 lux</span>
                    </div>
                </div>
                <!-- Módulo 4 -->
                <div class="sensor-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="sensor-header">
                        <h6>Módulo 4 - Tomate</h6>
                        <div class="sensor-status"></div>
                    </div>
                    <div class="sensor-reading">
                        <span>Humedad suelo:</span>
                        <span>70%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <div class="sensor-reading mt-2">
                        <span>Temperatura:</span>
                        <span>23°C</span>
                    </div>
                    <div class="sensor-reading">
                        <span>Luz:</span>
                        <span>3900 lux</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lecturas recientes -->
        <div class="table-container" data-aos="fade-up" data-aos-delay="100">
            <div class="table-header">
                <h5><i class="fas fa-history"></i> Últimas lecturas registradas</h5>
                <a href="#" class="btn-outline-verde btn-sm">Ver histórico</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                    <tr>
                        <th>Fecha/Hora</th>
                        <th>Módulo</th>
                        <th>Temperatura</th>
                        <th>Humedad suelo</th>
                        <th>Luz</th>
                        <th>pH</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>25/02/2026 10:30</td>
                        <td>Módulo 1</td>
                        <td>23.2°C</td>
                        <td>68%</td>
                        <td>3800 lux</td>
                        <td>7.2</td>
                    </tr>
                    <tr>
                        <td>25/02/2026 10:30</td>
                        <td>Módulo 2</td>
                        <td>24.1°C</td>
                        <td>32%</td>
                        <td>4100 lux</td>
                        <td>6.8</td>
                    </tr>
                    <tr>
                        <td>25/02/2026 10:30</td>
                        <td>Módulo 3</td>
                        <td>22.5°C</td>
                        <td>75%</td>
                        <td>3500 lux</td>
                        <td>7.0</td>
                    </tr>
                    <tr>
                        <td>25/02/2026 10:30</td>
                        <td>Módulo 4</td>
                        <td>23.0°C</td>
                        <td>70%</td>
                        <td>3900 lux</td>
                        <td>7.1</td>
                    </tr>
                    <tr>
                        <td>25/02/2026 10:15</td>
                        <td>Módulo 1</td>
                        <td>23.1°C</td>
                        <td>69%</td>
                        <td>3750 lux</td>
                        <td>7.2</td>
                    </tr>
                    </tbody>
                </table>
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

    // Gráfico de temperatura
    const ctxTemp = document.getElementById('tempChart').getContext('2d');
    new Chart(ctxTemp, {
        type: 'line',
        data: {
            labels: ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00'],
            datasets: [{
                label: '°C',
                data: [22, 21, 20, 23, 26, 27, 25, 23],
                borderColor: '#2E7D32',
                backgroundColor: 'rgba(46,125,50,0.05)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#2E7D32',
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: false, grid: { color: 'rgba(0,0,0,0.03)' } } }
        }
    });

    // Gráfico de humedad
    const ctxHum = document.getElementById('humedadChart').getContext('2d');
    new Chart(ctxHum, {
        type: 'line',
        data: {
            labels: ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00'],
            datasets: [{
                label: '%',
                data: [70, 68, 65, 63, 60, 58, 62, 65],
                borderColor: '#FF9800',
                backgroundColor: 'rgba(255,152,0,0.05)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#FF9800',
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: false, grid: { color: 'rgba(0,0,0,0.03)' } } }
        }
    });
</script>
</body>
</html>
