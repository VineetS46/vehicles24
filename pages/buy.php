<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); 
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Vehicles - vehicles24</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="buy.php">VEHICLES24</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link active" href="buy.php">Browse</a>
                <a class="nav-link" href="sell.php">Sell</a>
                <a class="nav-link" href="scrap.php">Scrap</a>
                <a class="nav-link" href="profile.php">Profile</a>
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Available Vehicles</h2>
            <div class="text-muted">
                <span id="vehicleCount">Loading...</span>
            </div>
        </div>
        <div id="vehiclesContainer" class="row">
            <div class="loading">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p>Loading vehicles...</p>
            </div>
        </div>
    </div>

    <script>
        // Check if user is logged in
        fetch('php/fetch_vehicles.php')
            .then(response => {
                if (response.status === 401) {
                    window.location.href = '../login.php';
                    return;
                }
                return response.json();
            })
            .then(data => {
                displayVehicles(data);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('vehiclesContainer').innerHTML = 
                    '<div class="col-12"><div class="alert alert-danger">Error loading vehicles. Please check if php/fetch_vehicles.php exists.</div></div>';
            });

        function displayVehicles(vehicles) {
            const container = document.getElementById('vehiclesContainer');
            const countElement = document.getElementById('vehicleCount');
            
            countElement.textContent = `${vehicles.length} vehicle${vehicles.length !== 1 ? 's' : ''} found`;
            
            if (vehicles.length === 0) {
                container.innerHTML = '<div class="no-vehicles"><h4>No vehicles available</h4><p>Check back later for new listings!</p></div>';
                return;
            }

            container.innerHTML = vehicles.map(vehicle => `
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card vehicle-card h-100" style="border: 1px solid #e3e6f0; border-radius: 12px; overflow: hidden; transition: all 0.3s ease;">
                        <div class="position-relative">
                            <img src="/upload/${vehicle.image}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="${vehicle.year} ${vehicle.make} ${vehicle.model}">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-success px-2 py-1" style="font-size: 0.75rem;">${vehicle.status.toUpperCase()}</span>
                            </div>
                            <div class="position-absolute bottom-0 start-0 end-0" style="height: 1px; background: linear-gradient(90deg, #007bff 0%, #0056b3 50%, #007bff 100%); opacity: 0.6;"></div>
                        </div>
                        
                        <div class="card-body p-4" style="background: #ffffff;">
                            <div class="mb-3">
                                <h5 class="card-title mb-1" style="color: #2c3e50; font-weight: 600; font-size: 1.1rem;">${vehicle.year} ${vehicle.make} ${vehicle.model}</h5>
                                <div style="width: 30px; height: 2px; background: linear-gradient(90deg, #007bff, #0056b3); margin: 8px 0;"></div>
                            </div>
                            
                            <div class="vehicle-info mb-3">
                                <div class="row g-0 mb-2">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-road text-primary me-2" style="font-size: 0.8rem; width: 12px;"></i>
                                            <div>
                                                <div style="font-size: 0.7rem; color: #6c757d; line-height: 1;">KMs Driven</div>
                                                <div style="font-size: 0.85rem; font-weight: 600; color: #2c3e50;">${vehicle.kms_driven ? vehicle.kms_driven.toLocaleString() : 'N/A'}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-gas-pump text-primary me-2" style="font-size: 0.8rem; width: 12px;"></i>
                                            <div>
                                                <div style="font-size: 0.7rem; color: #6c757d; line-height: 1;">Fuel Type</div>
                                                <div style="font-size: 0.85rem; font-weight: 600; color: #2c3e50;">${vehicle.fuel_type}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-0">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-map-marker-alt text-primary me-2" style="font-size: 0.8rem; width: 12px;"></i>
                                            <div>
                                                <div style="font-size: 0.7rem; color: #6c757d; line-height: 1;">Location</div>
                                                <div style="font-size: 0.85rem; font-weight: 600; color: #2c3e50;">${vehicle.state}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-cogs text-primary me-2" style="font-size: 0.8rem; width: 12px;"></i>
                                            <div>
                                                <div style="font-size: 0.7rem; color: #6c757d; line-height: 1;">Transmission</div>
                                                <div style="font-size: 0.85rem; font-weight: 600; color: #2c3e50;">${vehicle.gear_type || 'Manual'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="border-top: 1px solid #f1f3f4; margin: 16px 0; padding-top: 16px;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="price-section">
                                        <div style="font-size: 1.4rem; font-weight: 700; color: #28a745; line-height: 1;">₹${Number(vehicle.price).toLocaleString()}</div>
                                        <div style="font-size: 0.7rem; color: #6c757d;">Best Price</div>
                                    </div>
                                    <div class="text-end">
                                        <div style="font-size: 0.75rem; color: #6c757d;">Seller</div>
                                        <div style="font-size: 0.85rem; font-weight: 600; color: #2c3e50;">${vehicle.seller_username}</div>
                                    </div>
                                </div>
                                
                                <button class="btn btn-primary w-100" style="border-radius: 8px; font-weight: 500; padding: 10px; font-size: 0.9rem;" onclick="window.location.href='vehicle_details.php?id=${vehicle.vehicle_id}'">
                                    <i class="fas fa-eye me-2"></i>View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    </script>
</body>
</html>