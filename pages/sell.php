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
    <title>Sell Vehicle - vehicles24</title>
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
                <a class="nav-link active" href="sell.php">Sell</a>
                <a class="nav-link" href="scrap.php">Scrap</a>
                <a class="nav-link" href="profile.php">Profile</a>
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="mb-0">List Your Vehicle</h3>
                        <p class="mb-0 mt-2" style="font-size: 0.9rem; opacity: 0.9;">Fill out the details to list your vehicle for sale</p>
                    </div>
                    <div class="card-body p-4">
                        <div id="message"></div>
                        <form id="sellForm" enctype="multipart/form-data">
                            
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-car"></i> Vehicle Information</h5>
                                <div class="bg-light p-3 rounded">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="vehicle_type" class="form-label fw-semibold">Vehicle Type</label>
                                                <select class="form-select" id="vehicle_type" name="vehicle_type" required>
                                                    <option value="">Select Type</option>
                                                    <option value="Car">🚗 Car</option>
                                                    <option value="SUV">🚙 SUV</option>
                                                    <option value="Truck">🚚 Truck</option>
                                                    <option value="Motorcycle">🏍️ Motorcycle</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="make" class="form-label fw-semibold">Make</label>
                                                <select class="form-select" id="make" name="make" required>
                                                    <option value="">Select Make</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="model" class="form-label fw-semibold">Model</label>
                                                <select class="form-select" id="model" name="model" required>
                                                    <option value="">Select Model</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="year" class="form-label fw-semibold">Year</label>
                                                <select class="form-select" id="year" name="year" required>
                                                    <option value="">Select Year</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-info-circle"></i> Vehicle Details</h5>
                                <div class="bg-light p-3 rounded">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="vehicle_number" class="form-label fw-semibold">📋 Vehicle Number</label>
                                                <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" placeholder="MH01AB1234" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="color" class="form-label fw-semibold">🎨 Color</label>
                                                <select class="form-select" id="color" name="color" required>
                                                    <option value="">Select Color</option>
                                                    <option value="White">⚪ White</option>
                                                    <option value="Black">⚫ Black</option>
                                                    <option value="Silver">🔘 Silver</option>
                                                    <option value="Red">🔴 Red</option>
                                                    <option value="Blue">🔵 Blue</option>
                                                    <option value="Grey">⚫ Grey</option>
                                                    <option value="Brown">🟤 Brown</option>
                                                    <option value="Green">🟢 Green</option>
                                                    <option value="Yellow">🟡 Yellow</option>
                                                    <option value="Orange">🟠 Orange</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="kms_driven" class="form-label fw-semibold">🛣️ KMs Driven</label>
                                                <input type="number" class="form-control" id="kms_driven" name="kms_driven" placeholder="50000" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="condition" class="form-label fw-semibold">⭐ Vehicle Condition</label>
                                                <select class="form-select" id="condition" name="condition" required>
                                                    <option value="">Select Condition</option>
                                                    <option value="5">⭐⭐⭐⭐⭐ Excellent (5/5)</option>
                                                    <option value="4">⭐⭐⭐⭐ Very Good (4/5)</option>
                                                    <option value="3">⭐⭐⭐ Good (3/5)</option>
                                                    <option value="2">⭐⭐ Fair (2/5)</option>
                                                    <option value="1">⭐ Poor (1/5)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="gear_type" class="form-label fw-semibold">⚙️ Gear Type</label>
                                                <select class="form-select" id="gear_type" name="gear_type" required>
                                                    <option value="">Select Gear Type</option>
                                                    <option value="Manual">🔧 Manual</option>
                                                    <option value="Automatic">🔄 Automatic</option>
                                                    <option value="CVT">⚡ CVT</option>
                                                    <option value="Semi-Automatic">🔀 Semi-Automatic</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="owners" class="form-label fw-semibold">👥 Number of Owners</label>
                                                <select class="form-select" id="owners" name="owners" required>
                                                    <option value="">Select Owners</option>
                                                    <option value="1">1️⃣ 1st Owner</option>
                                                    <option value="2">2️⃣ 2nd Owner</option>
                                                    <option value="3">3️⃣ 3rd Owner</option>
                                                    <option value="4">4️⃣ 4+ Owners</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="mileage" class="form-label fw-semibold">⛽ Mileage (km/l)</label>
                                                <input type="number" class="form-control" id="mileage" name="mileage" placeholder="15" step="0.1" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-map-marker-alt"></i> Location & Specifications</h5>
                                <div class="bg-light p-3 rounded">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="state" class="form-label fw-semibold">📍 State</label>
                                                <select class="form-select" id="state" name="state" required>
                                                    <option value="">Select State</option>
                                                    <option value="Gujarat">Gujarat</option>
                                                    <option value="Maharashtra">Maharashtra</option>
                                                    <option value="Delhi">Delhi</option>
                                                    <option value="Karnataka">Karnataka</option>
                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                    <option value="Rajasthan">Rajasthan</option>
                                                    <option value="West Bengal">West Bengal</option>
                                                    <option value="Telangana">Telangana</option>
                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Punjab">Punjab</option>
                                                    <option value="Haryana">Haryana</option>
                                                    <option value="Kerala">Kerala</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="fuel_type" class="form-label fw-semibold">⛽ Fuel Type</label>
                                                <select class="form-select" id="fuel_type" name="fuel_type" required>
                                                    <option value="">Select Fuel Type</option>
                                                    <option value="Petrol">⛽ Petrol</option>
                                                    <option value="Diesel">🛢️ Diesel</option>
                                                    <option value="Electric">🔋 Electric</option>
                                                    <option value="Hybrid">🔋⛽ Hybrid</option>
                                                    <option value="CNG">💨 CNG</option>
                                                    <option value="LPG">🔥 LPG</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-rupee-sign"></i> Pricing & Insurance</h5>
                                <div class="bg-light p-3 rounded">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="price" class="form-label fw-semibold">💰 Price (₹)</label>
                                                <input type="number" class="form-control" id="price" name="price" step="1" placeholder="500000" required>
                                                <div class="form-text">Enter the selling price in Indian Rupees</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="insurance_valid" class="form-label fw-semibold">🛡️ Insurance Valid Till</label>
                                                <input type="date" class="form-control" id="insurance_valid" name="insurance_valid" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="text-primary mb-3"><i class="fas fa-camera"></i> Vehicle Image</h5>
                                <div class="bg-light p-3 rounded">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="image" class="form-label fw-semibold">📸 Upload Vehicle Photo</label>
                                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                                <div class="form-text">📋 Upload a clear, high-quality photo of your vehicle (JPG, PNG, or GIF format)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                    <i class="fas fa-plus-circle me-2"></i>List My Vehicle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- 1. PRE-LOADED VEHICLE DATA (No Fetch Needed) ---
        const vehicleData = {
            "CAR": {
                "Maruti Suzuki": ["Alto", "Swift", "Baleno", "Dzire", "Brezza", "Ertiga", "WagonR", "Celerio"],
                "Hyundai": ["i10", "i20", "Creta", "Verna", "Venue", "Santro", "Aura", "Tucson"],
                "Tata": ["Nexon", "Punch", "Harrier", "Safari", "Tiago", "Tigor", "Altroz"],
                "Mahindra": ["Thar", "XUV700", "Scorpio", "Bolero", "XUV300"],
                "Honda": ["City", "Amaze", "Civic", "Jazz", "WR-V"],
                "Toyota": ["Innova", "Fortuner", "Glanza", "Urban Cruiser", "Camry"]
            },
            "SUV": {
                "Mahindra": ["Thar", "Scorpio-N", "XUV700"],
                "Tata": ["Harrier", "Safari", "Nexon"],
                "Hyundai": ["Creta", "Alcazar", "Tucson"],
                "Toyota": ["Fortuner", "Land Cruiser"],
                "Jeep": ["Compass", "Meridian"]
            },
            "TRUCK": {
                "Tata": ["Ace", "Intra", "Yodha", "Prima"],
                "Ashok Leyland": ["Dost", "Bada Dost", "Ecomet"],
                "Mahindra": ["Bolero Pickup", "Supro", "Jeeto"],
                "Eicher": ["Pro 2000", "Pro 3000"]
            },
            "MOTORCYCLE": {
                "Hero": ["Splendor", "HF Deluxe", "Glamour", "Passion", "Xpulse"],
                "Honda": ["Shine", "SP 125", "Unicorn", "Activa (Scooter)"],
                "Royal Enfield": ["Classic 350", "Bullet 350", "Meteor", "Himalayan"],
                "Bajaj": ["Pulsar", "Platina", "Avenger", "Dominar"],
                "TVS": ["Apache", "Jupiter", "Raider", "Sport"],
                "Yamaha": ["R15", "MT-15", "FZ"]
            }
        };

        // --- 2. POPULATE YEARS (1990 to Current Year) ---
        const currentYear = new Date().getFullYear();
        const yearSelect = document.getElementById('year');
        for (let year = currentYear; year >= 1990; year--) {
            yearSelect.innerHTML += `<option value="${year}">${year}</option>`;
        }

        // --- 3. HANDLE VEHICLE TYPE CHANGE ---
        document.getElementById('vehicle_type').addEventListener('change', function() {
            const vehicleType = this.value.toUpperCase(); // Matches keys like "CAR", "SUV"
            const makeSelect = document.getElementById('make');
            const modelSelect = document.getElementById('model');
            
            // Reset dropdowns
            makeSelect.innerHTML = '<option value="">Select Make</option>';
            modelSelect.innerHTML = '<option value="">Select Model</option>';
            
            // Populate Make
            if (vehicleType && vehicleData[vehicleType]) {
                Object.keys(vehicleData[vehicleType]).forEach(make => {
                    makeSelect.innerHTML += `<option value="${make}">${make}</option>`;
                });
            }
        });

        // --- 4. HANDLE MAKE CHANGE ---
        document.getElementById('make').addEventListener('change', function() {
            const vehicleType = document.getElementById('vehicle_type').value.toUpperCase();
            const make = this.value;
            const modelSelect = document.getElementById('model');
            
            // Reset Model dropdown
            modelSelect.innerHTML = '<option value="">Select Model</option>';
            
            // Populate Model
            if (vehicleType && make && vehicleData[vehicleType] && vehicleData[vehicleType][make]) {
                vehicleData[vehicleType][make].forEach(model => {
                    modelSelect.innerHTML += `<option value="${model}">${model}</option>`;
                });
            }
        });

        // --- 5. HANDLE FORM SUBMISSION ---
        document.getElementById('sellForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageDiv = document.getElementById('message');
            
            // Note: Ensure the path to process_sell.php is correct
            fetch('php/process_sell.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = '<div class="alert alert-success">Vehicle listed successfully! Redirecting...</div>';
                    // Optional: Redirect after success
                    setTimeout(() => { window.location.href = 'buy.php'; }, 2000);
                    this.reset();
                } else {
                    messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.innerHTML = '<div class="alert alert-danger">Error submitting form. Check console for details.</div>';
            });
        });
    </script>
</body>
</html>