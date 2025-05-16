<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard - Food Trace</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4CAF50;
            --primary-light: #7BC67E;
            --primary-dark: #3B8C3E;
            --accent-color: #FF9800;
            --text-light: #FFFFFF;
            --text-muted: rgba(255, 255, 255, 0.7);
            --text-dark: #E0E0E0; /* Changed from dark gray to light gray */
            --bg-dark: #121212;
            --bg-light: #1E1E1E;
            --border-color: rgba(255, 255, 255, 0.1);
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 1.5rem;
            --spacing-lg: 2rem;
            --border-radius-sm: 8px;
            --border-radius-md: 12px;
            --transition-speed: 0.3s;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        /* Force light text everywhere */
        body, .card, .table, .list-group-item,
        .text-dark, .text-muted, .card-title,
        .card-text, .list-unstyled, .dropdown-menu {
            color: var(--text-light) !important;
        }

        /* Make muted text slightly lighter */
        .text-muted {
            color: var(--text-muted) !important;
        }

        .sidebar {
            background-color: var(--bg-light);
            height: 100vh;
            position: fixed;
            width: 250px;
            transition: all var(--transition-speed);
            border-right: 1px solid var(--border-color);
        }

        .main-content {
            margin-left: 250px;
            transition: all var(--transition-speed);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            border-radius: var(--border-radius-sm);
            margin-bottom: var(--spacing-xs);
            transition: all var(--transition-speed);
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(76, 175, 80, 0.2);
            color: var(--text-light);
        }

        .nav-link i {
            margin-right: var(--spacing-xs);
            font-size: 1.25rem;
        }

        .card {
            background-color: var(--bg-light);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-md);
            transition: all var(--transition-speed);
            color: var(--text-light); /* Ensure card text is light */
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .stat-card {
            padding: var(--spacing-md);
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-responsive {
            border-radius: var(--border-radius-md);
            overflow: hidden;
        }

        .table {
            color: var(--text-light);
            margin-bottom: 0;
        }

        .table th {
            background-color: rgba(76, 175, 80, 0.2);
            border-bottom: 1px solid var(--border-color);
            color: var(--text-light); /* Table header text */
        }

        .table td, .table th {
            padding: var(--spacing-sm);
            border-top: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-light) !important; /* Badge text */
        }

        .status-active {
            background-color: rgba(76, 175, 80, 0.2);
            color: var(--primary-light);
        }

        .status-pending {
            background-color: rgba(255, 152, 0, 0.2);
            color: var(--accent-color);
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.5rem;
        }

        /* Fix for the land cards specifically */
        .land-card .card-title,
        .land-card .card-text,
        .land-card .list-unstyled,
        .land-card .list-unstyled li,
        .land-card .text-muted {
            color: var(--text-light) !important;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .stat-card {
                margin-bottom: var(--spacing-sm);
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="d-flex flex-column h-100 p-3">
            <div class="sidebar-header mb-4">
                <h4 class="mb-0">Food Trace</h4>
                <small class="text-muted">Farmer Dashboard</small>
            </div>
            
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" data-section="dashboard">
                        <i class="material-icons">dashboard</i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="my-lands">
                        <i class="material-icons">map</i>
                        My Lands
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="lease-requests">
                        <i class="material-icons">assignment</i>
                        Lease Requests
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="rent-land">
                        <i class="material-icons">store</i>
                        Rent Land
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="reports">
                        <i class="material-icons">bar_chart</i>
                        Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="notifications">
                        <i class="material-icons">notifications</i>
                        Notifications
                    </a>
                </li>
            </ul>
            
            <div class="mt-auto pt-3 border-top border-secondary">
                <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=4CAF50&color=fff" 
                         class="rounded-circle me-2" width="40" height="40" alt="Profile">
                    <div>
                        <small class="d-block">John Farmer</small>
                        <small class="text-muted">Farmer</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="mobile-menu-btn me-3" id="mobileMenuBtn">
                    <i class="material-icons">menu</i>
                </button>
                
                <div class="d-flex ms-auto align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
                           id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons me-1">account_circle</i>
                            <span class="d-none d-sm-inline">Account</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="material-icons me-1">settings</i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="material-icons me-1">logout</i> Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="container-fluid p-4">
            <!-- Dashboard Section -->
            <div class="content-section active" id="dashboard-section">
                <h4 class="mb-4">Dashboard Overview</h4>
                
                <div class="row mb-4">
                    <div class="col-md-3 col-6 mb-3">
                        <div class="card stat-card">
                            <div class="stat-value">5</div>
                            <div class="stat-label">Registered Lands</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="card stat-card">
                            <div class="stat-value">12.5</div>
                            <div class="stat-label">Hectares Total</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="card stat-card">
                            <div class="stat-value">3</div>
                            <div class="stat-label">Active Leases</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="card stat-card">
                            <div class="stat-value">2</div>
                            <div class="stat-label">Rented Lands</div>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Recent Activity</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Activity</th>
                                        <th>Land</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2023-06-15</td>
                                        <td>New lease request</td>
                                        <td>North Field</td>
                                        <td><span class="status-badge status-pending">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>2023-06-12</td>
                                        <td>Land registration</td>
                                        <td>South Plot</td>
                                        <td><span class="status-badge status-active">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>2023-06-08</td>
                                        <td>Rental agreement signed</td>
                                        <td>East Gardens</td>
                                        <td><span class="status-badge status-active">Active</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Lands Section -->
            <div class="content-section" id="my-lands-section">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>My Lands</h4>
                    <button class="btn btn-sm btn-primary">
                        <i class="material-icons me-1">add</i> Register New Land
                    </button>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Land Name</th>
                                        <th>Location</th>
                                        <th>Size (ha)</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>North Field</td>
                                        <td>Benue, Nigeria</td>
                                        <td>5.2</td>
                                        <td><span class="status-badge status-active">Active</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-light me-1"><i class="material-icons">visibility</i></button>
                                            <button class="btn btn-sm btn-outline-light"><i class="material-icons">edit</i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>South Plot</td>
                                        <td>Benue, Nigeria</td>
                                        <td>3.8</td>
                                        <td><span class="status-badge status-active">Active</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-light me-1"><i class="material-icons">visibility</i></button>
                                            <button class="btn btn-sm btn-outline-light"><i class="material-icons">edit</i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lease Requests Section -->
            <div class="content-section" id="lease-requests-section">
                <h4 class="mb-4">Lease Requests</h4>
                
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Request ID</th>
                                        <th>Land</th>
                                        <th>Requested By</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#LR-1001</td>
                                        <td>North Field</td>
                                        <td>Agro Farms Ltd</td>
                                        <td>6 months</td>
                                        <td><span class="status-badge status-pending">Pending</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-success me-1">Approve</button>
                                            <button class="btn btn-sm btn-outline-danger">Reject</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#LR-1000</td>
                                        <td>South Plot</td>
                                        <td>Green Fields Co.</td>
                                        <td>1 year</td>
                                        <td><span class="status-badge status-active">Approved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-light">View</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rent Land Section -->
            <div class="content-section" id="rent-land-section">
                <h4 class="mb-4">Available Lands for Rent</h4>
                
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 land-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0">North Plains</h5>
                                    <span class="badge bg-success">Available</span>
                                </div>
                                <p class="card-text">
                                    <i class="material-icons me-1" style="font-size: 1rem;">location_on</i> 
                                    Makurdi, Benue
                                </p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Size:</strong> 4.5 hectares</li>
                                    <li class="mb-2"><strong>Soil Type:</strong> Loamy</li>
                                    <li class="mb-2"><strong>Price:</strong> ₦45,000/ha</li>
                                </ul>
                                <button class="btn btn-primary w-100">Rent This Land</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 land-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0">River Valley</h5>
                                    <span class="badge bg-success">Available</span>
                                </div>
                                <p class="card-text">
                                    <i class="material-icons me-1" style="font-size: 1rem;">location_on</i> 
                                    Gboko, Benue
                                </p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Size:</strong> 3.2 hectares</li>
                                    <li class="mb-2"><strong>Soil Type:</strong> Clay</li>
                                    <li class="mb-2"><strong>Price:</strong> ₦38,000/ha</li>
                                </ul>
                                <button class="btn btn-primary w-100">Rent This Land</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Section -->
            <div class="content-section" id="reports-section">
                <h4 class="mb-4">Reports</h4>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Land Utilization</h5>
                                <div class="placeholder-graph" style="height: 200px; background-color: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; border-radius: var(--border-radius-sm);">
                                    <span class="text-muted">Graph will appear here</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Income Overview</h5>
                                <div class="placeholder-graph" style="height: 200px; background-color: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; border-radius: var(--border-radius-sm);">
                                    <span class="text-muted">Graph will appear here</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Section -->
            <div class="content-section" id="notifications-section">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Notifications</h4>
                    <button class="btn btn-sm btn-outline-light">
                        <i class="material-icons me-1">mark_email_read</i> Mark All as Read
                    </button>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action border-0 bg-transparent">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">New lease request</h6>
                                    <small class="text-muted">1 hour ago</small>
                                </div>
                                <p class="mb-1">Agro Farms Ltd has requested to lease your North Field</p>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 bg-transparent">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Rental payment received</h6>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                                <p class="mb-1">Payment of ₦152,000 received for East Gardens rental</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dashboard Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
            
            // Section switching
            const navLinks = document.querySelectorAll('.nav-link');
            const contentSections = document.querySelectorAll('.content-section');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links and sections
                    navLinks.forEach(navLink => navLink.classList.remove('active'));
                    contentSections.forEach(section => section.classList.remove('active'));
                    
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Show corresponding section
                    const sectionId = this.getAttribute('data-section') + '-section';
                    document.getElementById(sectionId).classList.add('active');
                    
                    // Close mobile sidebar if open
                    if (sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html>