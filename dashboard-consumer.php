<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumer Dashboard - Food Trace</title>
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
            --text-dark: #E0E0E0;
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
            padding-bottom: 80px; /* Space for bottom nav */
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

        .card {
            background-color: var(--bg-light);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-md);
            transition: all var(--transition-speed);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Scan Button */
        .scan-btn {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
            z-index: 1000;
            border: none;
        }

        .scan-btn i {
            font-size: 28px;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: var(--bg-light);
            border-top: 1px solid var(--border-color);
            padding: var(--spacing-sm) 0;
            z-index: 1000;
        }

        .nav-item {
            text-align: center;
        }

        .nav-link {
            color: var(--text-muted);
            font-size: 0.8rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .nav-link.active {
            color: var(--primary-color);
        }

        .nav-link i {
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        /* Food Journey Timeline */
        .timeline {
            position: relative;
            padding-left: var(--spacing-md);
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: var(--primary-color);
        }

        .timeline-item {
            position: relative;
            padding-bottom: var(--spacing-md);
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -19px;
            top: 4px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--primary-color);
            border: 2px solid var(--bg-light);
        }

        .timeline-date {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
        }

        .timeline-content {
            background-color: rgba(76, 175, 80, 0.1);
            padding: var(--spacing-sm);
            border-radius: var(--border-radius-sm);
        }

        /* Scan History */
        .scan-history-item {
            border-left: 3px solid var(--primary-color);
            padding-left: var(--spacing-sm);
            margin-bottom: var(--spacing-md);
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            body {
                padding-bottom: 0;
            }
            
            .bottom-nav {
                display: none;
            }
            
            .scan-btn {
                bottom: 20px;
            }
            
            .sidebar {
                display: block;
                position: fixed;
                width: 250px;
                height: 100vh;
                background-color: var(--bg-light);
                border-right: 1px solid var(--border-color);
                padding: var(--spacing-md);
            }
            
            .main-content {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Top Bar -->
    <nav class="navbar navbar-expand d-md-none navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="material-icons me-1">grass</i>
                Food Trace
            </a>
            <div class="d-flex">
                <button class="btn btn-link text-white">
                    <i class="material-icons">notifications</i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Desktop Sidebar (hidden on mobile) -->
    <div class="sidebar d-none d-md-block">
        <div class="d-flex flex-column h-100">
            <div class="sidebar-header mb-4">
                <h4 class="mb-0">Food Trace</h4>
                <small class="text-muted">Consumer Dashboard</small>
            </div>
            
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="material-icons">dashboard</i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="material-icons">history</i>
                        Scan History
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="material-icons">favorite</i>
                        Saved Items
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="material-icons">insights</i>
                        Nutrition Insights
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="material-icons">settings</i>
                        Settings
                    </a>
                </li>
            </ul>
            
            <div class="mt-auto pt-3 border-top border-secondary">
                <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name=Consumer+User&background=4CAF50&color=fff" 
                         class="rounded-circle me-2" width="40" height="40" alt="Profile">
                    <div>
                        <small class="d-block">Consumer User</small>
                        <small class="text-muted">Member since 2023</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid p-3 p-md-4">
            <!-- Welcome Banner -->
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Welcome back Ngutor!</h4>
                    <p class="card-text">Track your food's journey from farm to fork</p>
                    <button class="btn btn-primary" id="scanBtn">
                        <i class="material-icons me-1">qr_code_scanner</i> Scan Food
                    </button>
                </div>
            </div>

            <!-- Recent Scans -->
            <h5 class="mb-3">Recent Scans</h5>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mb-4">
                <!-- Scan Item 1 -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title mb-0">Organic Tomatoes</h6>
                                <span class="badge bg-success">Verified</span>
                            </div>
                            <p class="card-text text-muted mb-2">
                                <i class="material-icons me-1" style="font-size: 1rem;">store</i> 
                                FreshMart Supermarket
                            </p>
                            <p class="card-text text-muted small mb-3">
                                <i class="material-icons me-1" style="font-size: 1rem;">calendar_today</i> 
                                Scanned: 2 hours ago
                            </p>
                            <a href="#" class="btn btn-sm btn-outline-light w-100">View Journey</a>
                        </div>
                    </div>
                </div>
                
                <!-- Scan Item 2 -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title mb-0">Free-Range Eggs</h6>
                                <span class="badge bg-success">Verified</span>
                            </div>
                            <p class="card-text text-muted mb-2">
                                <i class="material-icons me-1" style="font-size: 1rem;">store</i> 
                                GreenGrocers
                            </p>
                            <p class="card-text text-muted small mb-3">
                                <i class="material-icons me-1" style="font-size: 1rem;">calendar_today</i> 
                                Scanned: 1 day ago
                            </p>
                            <a href="#" class="btn btn-sm btn-outline-light w-100">View Journey</a>
                        </div>
                    </div>
                </div>
                
                <!-- Scan Item 3 -->
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title mb-0">Whole Grain Bread</h6>
                                <span class="badge bg-warning text-dark">Pending Verification</span>
                            </div>
                            <p class="card-text text-muted mb-2">
                                <i class="material-icons me-1" style="font-size: 1rem;">store</i> 
                                Baker's Delight
                            </p>
                            <p class="card-text text-muted small mb-3">
                                <i class="material-icons me-1" style="font-size: 1rem;">calendar_today</i> 
                                Scanned: 3 days ago
                            </p>
                            <a href="#" class="btn btn-sm btn-outline-light w-100">View Details</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Food Journey Example (shown when viewing a specific item) -->
            <div class="card mb-4 d-none" id="foodJourney">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Organic Tomatoes Journey</h5>
                        <button class="btn btn-sm btn-outline-light" id="backToDashboard">
                            <i class="material-icons">arrow_back</i> Back
                        </button>
                    </div>
                    
                    <div class="timeline">
                        <!-- Farm Stage -->
                        <div class="timeline-item">
                            <div class="timeline-date">June 1, 2023</div>
                            <div class="timeline-content">
                                <h6><i class="material-icons me-1">agriculture</i> Farm Origin</h6>
                                <p>Planted at Green Valley Farms, Benue State</p>
                                <p class="small text-muted mb-0">
                                    <i class="material-icons me-1">location_on</i> 
                                    GPS: 7.7325° N, 8.5391° E
                                </p>
                            </div>
                        </div>
                        
                        <!-- Harvest Stage -->
                        <div class="timeline-item">
                            <div class="timeline-date">July 15, 2023</div>
                            <div class="timeline-content">
                                <h6><i class="material-icons me-1">grass</i> Harvest</h6>
                                <p>Harvested and packaged at farm</p>
                                <p class="small text-muted mb-0">
                                    <i class="material-icons me-1">verified</i> 
                                    Organic certification verified
                                </p>
                            </div>
                        </div>
                        
                        <!-- Transport Stage -->
                        <div class="timeline-item">
                            <div class="timeline-date">July 16, 2023</div>
                            <div class="timeline-content">
                                <h6><i class="material-icons me-1">local_shipping</i> Transportation</h6>
                                <p>Shipped via ColdChain Logistics</p>
                                <p class="small text-muted mb-0">
                                    <i class="material-icons me-1">thermostat</i> 
                                    Maintained at 4°C throughout transit
                                </p>
                            </div>
                        </div>
                        
                        <!-- Retail Stage -->
                        <div class="timeline-item">
                            <div class="timeline-date">July 18, 2023</div>
                            <div class="timeline-content">
                                <h6><i class="material-icons me-1">store</i> Retail</h6>
                                <p>Received at FreshMart Supermarket</p>
                                <p class="small text-muted mb-0">
                                    <i class="material-icons me-1">inventory</i> 
                                    Shelf life: 5 more days
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nutrition Info -->
                    <div class="mt-4">
                        <h6><i class="material-icons me-1">nutrition</i> Nutritional Information</h6>
                        <div class="row">
                            <div class="col-6 col-md-3 mb-2">
                                <div class="card bg-transparent border">
                                    <div class="card-body text-center">
                                        <div class="text-primary">52</div>
                                        <small>Calories</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <div class="card bg-transparent border">
                                    <div class="card-body text-center">
                                        <div class="text-primary">2g</div>
                                        <small>Protein</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <div class="card bg-transparent border">
                                    <div class="card-body text-center">
                                        <div class="text-primary">11g</div>
                                        <small>Carbs</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <div class="card bg-transparent border">
                                    <div class="card-body text-center">
                                        <div class="text-primary">0g</div>
                                        <small>Fat</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scan History -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Your Scan History</h5>
                        <a href="#" class="btn btn-sm btn-outline-light">View All</a>
                    </div>
                    
                    <div class="scan-history">
                        <div class="scan-history-item">
                            <div class="d-flex justify-content-between">
                                <strong>Organic Tomatoes</strong>
                                <small class="text-muted">Today, 10:30 AM</small>
                            </div>
                            <p class="mb-1 small">FreshMart Supermarket</p>
                            <span class="badge bg-success">Verified</span>
                        </div>
                        
                        <div class="scan-history-item">
                            <div class="d-flex justify-content-between">
                                <strong>Free-Range Eggs</strong>
                                <small class="text-muted">Yesterday, 4:15 PM</small>
                            </div>
                            <p class="mb-1 small">GreenGrocers</p>
                            <span class="badge bg-success">Verified</span>
                        </div>
                        
                        <div class="scan-history-item">
                            <div class="d-flex justify-content-between">
                                <strong>Whole Grain Bread</strong>
                                <small class="text-muted">3 days ago</small>
                            </div>
                            <p class="mb-1 small">Baker's Delight</p>
                            <span class="badge bg-warning text-dark">Pending</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sustainability Impact -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Your Sustainability Impact</h5>
                    <p class="card-text text-muted">By tracing your food, you're supporting transparent supply chains</p>
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="display-6 text-primary">12</div>
                            <small>Foods Tracked</small>
                        </div>
                        <div class="col-4">
                            <div class="display-6 text-primary">8</div>
                            <small>Local Farms</small>
                        </div>
                        <div class="col-4">
                            <div class="display-6 text-primary">3.2kg</div>
                            <small>CO₂ Saved</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scan Button (Mobile) -->
    <button class="scan-btn d-md-none" id="mobileScanBtn">
        <i class="material-icons">qr_code_scanner</i>
    </button>

    <!-- Bottom Navigation (Mobile) -->
    <nav class="bottom-nav d-md-none">
        <div class="container">
            <div class="row">
                <div class="col nav-item">
                    <a href="#" class="nav-link active">
                        <i class="material-icons">home</i>
                        <span>Home</span>
                    </a>
                </div>
                <div class="col nav-item">
                    <a href="#" class="nav-link">
                        <i class="material-icons">history</i>
                        <span>History</span>
                    </a>
                </div>
                <div class="col nav-item">
                    <a href="#" class="nav-link">
                        <i class="material-icons">favorite</i>
                        <span>Saved</span>
                    </a>
                </div>
                <div class="col nav-item">
                    <a href="#" class="nav-link">
                        <i class="material-icons">person</i>
                        <span>Profile</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Scanner Modal -->
    <div class="modal fade" id="scannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Scan Food QR Code</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="scanner-container" style="width: 100%; height: 300px; background-color: black; margin-bottom: 1rem;">
                        <!-- Scanner would be rendered here -->
                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                            <div>
                                <i class="material-icons mb-2" style="font-size: 3rem;">qr_code_scanner</i>
                                <p>Camera feed would appear here</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted">Point your camera at a Food Trace QR code</p>
                    <button class="btn btn-outline-light">
                        <i class="material-icons me-1">photo_camera</i> Upload Image
                    </button>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button class="btn btn-primary" style="border-radius: 50%; width: 60px; height: 60px;">
                        <i class="material-icons">photo_camera</i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dashboard Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize scanner modal
            const scannerModal = new bootstrap.Modal(document.getElementById('scannerModal'));
            
            // Scan buttons
            document.getElementById('scanBtn').addEventListener('click', function() {
                scannerModal.show();
            });
            
            document.getElementById('mobileScanBtn').addEventListener('click', function() {
                scannerModal.show();
            });
            
            // View food journey (example functionality)
            document.querySelectorAll('.btn-outline-light').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector('.main-content > .container-fluid').querySelectorAll('.card').forEach(card => {
                        card.classList.add('d-none');
                    });
                    document.getElementById('foodJourney').classList.remove('d-none');
                });
            });
            
            // Back to dashboard
            document.getElementById('backToDashboard').addEventListener('click', function() {
                document.getElementById('foodJourney').classList.add('d-none');
                document.querySelector('.main-content > .container-fluid').querySelectorAll('.card').forEach(card => {
                    card.classList.remove('d-none');
                });
            });
            
            // Simulate QR code scanning
            setTimeout(() => {
                // This would be replaced with actual QR scanning logic
                // For demo purposes, we'll simulate a scan after 3 seconds
                // scannerModal.hide();
                // document.getElementById('foodJourney').classList.remove('d-none');
            }, 3000);
        });
    </script>
</body>
</html>