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
    <title>Vehicle Details - vehicles24</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="buy.php">vehicles24</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="buy.php">Browse</a>
                <a class="nav-link" href="sell.php">Sell</a>
                <a class="nav-link" href="scrap.php">Scrap</a>
                <a class="nav-link" href="profile.php">Profile</a>
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div id="vehicleDetails" class="loading">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2">Loading vehicle details...</p>
            </div>
        </div>
    </div>

    <script>
        function getVehicleId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id');
        }

        function loadVehicleDetails() {
            const vehicleId = getVehicleId();
            if (!vehicleId) {
                document.getElementById('vehicleDetails').innerHTML = '<div class="alert alert-danger">Vehicle not found</div>';
                return;
            }

            // Fetch from the PHP backend
            fetch(`php/get_vehicle_details.php?id=${vehicleId}`)
                .then(response => {
                    // Security Check
                    if (response.status === 401) {
                        window.location.href = '../login.php';
                        return;
                    }
                    return response.json();
                })
                .then(vehicle => {
                    if (!vehicle) return; 

                    if (vehicle.error) {
                        document.getElementById('vehicleDetails').innerHTML = `<div class="alert alert-danger">${vehicle.error}</div>`;
                        return;
                    }
                    displayVehicleDetails(vehicle);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('vehicleDetails').innerHTML = '<div class="alert alert-danger">Error loading vehicle details. Check if get_vehicle_details.php exists.</div>';
                });
        }

        function displayVehicleDetails(vehicle) {
            // Helper to generate stars
            const stars = '⭐'.repeat(Math.round(vehicle.condition_rating || 0));

            document.getElementById('vehicleDetails').innerHTML = `
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="position-relative">
                                <img src="../upload/${vehicle.image}" class="card-img-top" style="height: 400px; object-fit: cover; border-radius: 8px 8px 0 0;" alt="${vehicle.year} ${vehicle.make} ${vehicle.model}">
                                <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2">${vehicle.status.toUpperCase()}</span>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h2 class="mb-1" style="color: #2c3e50; font-weight: 700;">${vehicle.year} ${vehicle.make} ${vehicle.model}</h2>
                                        <p class="text-muted mb-0"><i class="fas fa-map-marker-alt me-1"></i>${vehicle.state}</p>
                                    </div>
                                    <div class="text-end">
                                        <div class="price-tag mb-0" style="font-size: 2rem;">₹${Number(vehicle.price).toLocaleString()}</div>
                                        <small class="text-success">Best Price</small>
                                    </div>
                                </div>
                                
                                <hr class="my-4">
                                
                                <h5 class="mb-3" style="color: #2c3e50;">Vehicle Specifications</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="spec-item p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #007bff;">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-car text-primary me-3" style="font-size: 1.2rem;"></i>
                                                <div>
                                                    <small class="text-muted d-block">Vehicle Type</small>
                                                    <strong>${vehicle.vehicle_type}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="spec-item p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #007bff;">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-palette text-primary me-3" style="font-size: 1.2rem;"></i>
                                                <div>
                                                    <small class="text-muted d-block">Color</small>
                                                    <strong>${vehicle.color}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="spec-item p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #28a745;">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-road text-success me-3" style="font-size: 1.2rem;"></i>
                                                <div>
                                                    <small class="text-muted d-block">KMs Driven</small>
                                                    <strong>${Number(vehicle.kms_driven).toLocaleString()} km</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="spec-item p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #28a745;">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-gas-pump text-success me-3" style="font-size: 1.2rem;"></i>
                                                <div>
                                                    <small class="text-muted d-block">Fuel Type</small>
                                                    <strong>${vehicle.fuel_type}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="spec-item p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #ffc107;">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-cogs text-warning me-3" style="font-size: 1.2rem;"></i>
                                                <div>
                                                    <small class="text-muted d-block">Transmission</small>
                                                    <strong>${vehicle.gear_type}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="spec-item p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid #ffc107;">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-users text-warning me-3" style="font-size: 1.2rem;"></i>
                                                <div>
                                                    <small class="text-muted d-block">Owners</small>
                                                    <strong>${vehicle.owners} Owner${vehicle.owners > 1 ? 's' : ''}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Seller Information</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="text-center mb-3">
                                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-user text-white" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <h6 class="mt-2 mb-0">${vehicle.seller_username}</h6>
                                    <small class="text-muted">Verified Seller</small>
                                </div>
                                
                                <div class="seller-stats mb-4">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="border-end">
                                                <strong class="d-block text-primary">${vehicle.seller_rating ? vehicle.seller_rating.toFixed(1) : 'N/A'}</strong>
                                                <small class="text-muted">Rating</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <strong class="d-block text-primary">${vehicle.seller_sold_vehicles || 0}</strong>
                                            <small class="text-muted">Vehicles Sold</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="contact-info mb-4">
                                    <h6 class="mb-3">Vehicle Details</h6>
                                    <div class="mb-2">
                                        <small class="text-muted">Vehicle Number</small>
                                        <div class="fw-semibold">${vehicle.vehicle_number}</div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Condition</small>
                                        <div class="fw-semibold">${stars} (${vehicle.condition_rating}/5)</div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Insurance Valid Till</small>
                                        <div class="fw-semibold">${new Date(vehicle.insurance_valid).toLocaleDateString()}</div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Mileage</small>
                                        <div class="fw-semibold">${vehicle.mileage} km/l</div>
                                    </div>
                                </div>
                                
                                <div class="contact-details mb-3">
                                    <h6 class="mb-3">Contact Details</h6>
                                    <div class="mb-2">
                                        <small class="text-muted">Full Name</small>
                                        <div class="fw-semibold">${vehicle.seller_fullname}</div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Phone</small>
                                        <div class="fw-semibold">
                                            <a href="tel:${vehicle.seller_phone}" class="text-decoration-none">
                                                <i class="fas fa-phone me-1"></i>${vehicle.seller_phone}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Email</small>
                                        <div class="fw-semibold">
                                            <a href="mailto:${vehicle.seller_email}" class="text-decoration-none">
                                                <i class="fas fa-envelope me-1"></i>${vehicle.seller_email}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        document.addEventListener('DOMContentLoaded', loadVehicleDetails);
    </script>
</body>
</html>