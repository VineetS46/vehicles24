<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); 
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en"></html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - vehicles24</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="buy.php">VEHICLES24</a>
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
        <div class="row">
            <div class="col-md-4">
                <div class="profile-section">
                    <h4>Profile Information</h4>
                    <div id="profileInfo" class="profile-info">
                        <div class="loading">Loading...</div>
                    </div>
                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editModal">Edit Profile</button>
                </div>
            </div>
            <div class="col-md-8">
                <ul class="nav nav-tabs" id="vehicleTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="selling-tab" data-bs-toggle="tab" data-bs-target="#selling" type="button">
                            Vehicles I'm Selling <span id="sellingCount" class="badge bg-primary ms-1">0</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="scrap-tab" data-bs-toggle="tab" data-bs-target="#scrap" type="button">
                            Vehicles I've Scrapped <span id="scrapCount" class="badge bg-primary ms-1">0</span>
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="vehicleTabsContent">
                    <div class="tab-pane fade show active" id="selling" role="tabpanel">
                        <div id="sellingVehicles" class="mt-3">
                            <div class="loading">Loading...</div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="scrap" role="tabpanel">
                        <div id="scrapVehicles" class="mt-3">
                            <div class="loading">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="editMessage"></div>
                    <form id="editForm">
                        <div class="mb-3">
                            <label for="editFullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="editFullname" name="fullname" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="editPhone" name="phonenumber" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="updateProfile()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let userData = {};

        // Load user data on page load
        fetch('php/get_user_details.php')
            .then(response => {
                if (response.status === 401) {
                    window.location.href = '../login.php';
                    return;
                }
                return response.json();
            })
            .then(data => {
                userData = data;
                displayProfile(data.userDetails);
                displayVehicles(data.selling, 'sellingVehicles');
                displayScrapVehicles(data.scrap, 'scrapVehicles');
                
                // Update counts
                document.getElementById('sellingCount').textContent = data.selling.length;
                document.getElementById('scrapCount').textContent = data.scrap.length;
            })
            .catch(error => {
                console.error('Error:', error);
            });

        function displayProfile(user) {
            document.getElementById('profileInfo').innerHTML = `
                <p><strong>Name:</strong> ${user.fullname}</p>
                <p><strong>Username:</strong> ${user.username}</p>
                <p><strong>Email:</strong> ${user.email}</p>
                <p><strong>Phone:</strong> ${user.phonenumber}</p>
                <p><strong>Member Since:</strong> ${new Date(user.created_at).toLocaleDateString()}</p>
            `;
            
            // Populate edit form
            document.getElementById('editFullname').value = user.fullname;
            document.getElementById('editPhone').value = user.phonenumber;
        }

        function displayVehicles(vehicles, containerId) {
            const container = document.getElementById(containerId);
            
            if (vehicles.length === 0) {
                container.innerHTML = '<div class="no-vehicles"><p>No vehicles found</p></div>';
                return;
            }

            container.innerHTML = vehicles.map(vehicle => `
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="../upload/${vehicle.image}" class="img-fluid rounded-start vehicle-image" style="height: 160px; object-fit: cover; width: 100%;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="vehicle-title mb-0">${vehicle.year} ${vehicle.make} ${vehicle.model}</h5>
                                    <span class="badge ${vehicle.status === 'available' ? 'status-available' : 'status-sold'}">${vehicle.status}</span>
                                </div>
                                <div class="vehicle-details mb-2">
                                    <div class="row">
                                        <div class="col-6">Mileage: ${vehicle.mileage.toLocaleString()} miles</div>
                                        <div class="col-6">Fuel: ${vehicle.fuel_type}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">State: ${vehicle.state}</div>
                                        <div class="col-6">Type: ${vehicle.vehicle_type}</div>
                                    </div>
                                </div>
                                <div class="price-tag">₹${vehicle.price.toLocaleString()}</div>
                                <small class="text-muted">Listed on ${new Date(vehicle.listed_on).toLocaleDateString()}</small>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function displayScrapVehicles(vehicles, containerId) {
            const container = document.getElementById(containerId);
            
            if (vehicles.length === 0) {
                container.innerHTML = '<div class="no-vehicles"><p>No scrap vehicles found</p></div>';
                return;
            }

            container.innerHTML = vehicles.map(vehicle => `
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="/upload/${vehicle.image}" class="img-fluid rounded-start vehicle-image" style="height: 160px; object-fit: cover; width: 100%;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="vehicle-title mb-0">${vehicle.year} ${vehicle.brand} ${vehicle.model}</h5>
                                    <span class="badge ${vehicle.status === 'pending' ? 'bg-warning' : vehicle.status === 'approved' ? 'bg-success' : 'bg-danger'}">${vehicle.status}</span>
                                </div>
                                <div class="vehicle-details mb-2">
                                    <div class="row">
                                        <div class="col-6">KMs: ${vehicle.kms_driven}</div>
                                        <div class="col-6">Fuel: ${vehicle.fuel_type}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">State: ${vehicle.state}</div>
                                        <div class="col-6">Condition: ${vehicle.vehicle_condition}</div>
                                    </div>
                                </div>
                                <div class="price-tag">₹${vehicle.scrap_value.toLocaleString()}</div>
                                <small class="text-muted">Submitted on ${new Date(vehicle.created_at).toLocaleDateString()}</small>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function updateProfile() {
            const formData = new FormData(document.getElementById('editForm'));
            
            fetch('php/update_user_details.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('editMessage').innerHTML = '<div class="alert alert-success">Profile updated successfully!</div>';
                    // Refresh profile data
                    userData.userDetails.fullname = formData.get('fullname');
                    userData.userDetails.phonenumber = formData.get('phonenumber');
                    displayProfile(userData.userDetails);
                    setTimeout(() => {
                        bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                    }, 1500);
                } else {
                    document.getElementById('editMessage').innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                document.getElementById('editMessage').innerHTML = '<div class="alert alert-danger">Error updating profile</div>';
            });
        }
    </script>
</body>
</html>