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
    <title>Scrap Vehicle - vehicles24</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="buy.html">VEHICLES24</a>
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
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"><i class="fas fa-recycle me-2"></i>Scrap Your Vehicle</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="php/process_scrap.php" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="vehicleType" class="form-label">Vehicle Type</label>
                                    <select class="form-select" id="vehicleType" name="VehicleType" required>
                                        <option value="">-- Select Vehicle Type --</option>
                                        <option value="CAR">Car</option>
                                        <option value="BIKE">Bike</option>
                                        <option value="RICKSHAW">Rickshaw</option>
                                        <option value="TRUCK">Truck</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Brand" class="form-label">Vehicle Brand</label>
                                    <select class="form-select" id="Brand" name="Brand" required>
                                        <option value="">-- Select Brand --</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Model" class="form-label">Vehicle Model</label>
                                    <select class="form-select" id="Model" name="Model" required>
                                        <option value="">-- Select Model --</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Year" class="form-label">Year</label>
                                    <select class="form-select" id="Year" name="Year" required>
                                        <option value="">-- Select Year --</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                        <option value="2021">2021</option>
                                        <option value="2020">2020</option>
                                        <option value="2019">2019</option>
                                        <option value="2018">2018</option>
                                        <option value="2017">2017</option>
                                        <option value="2016">2016</option>
                                        <option value="2015">2015</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="vehicleNumber" class="form-label">Vehicle Number</label>
                                    <input type="text" class="form-control" id="vehicleNumber" name="vehicleNumber" placeholder="e.g., MH12AB1234" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Kms" class="form-label">Kilometers Driven</label>
                                    <select class="form-select" id="Kms" name="Kms" required>
                                        <option value="">-- Select Kilometers Driven --</option>
                                        <option value="0-5000">0-5,000 km</option>
                                        <option value="5001-10000">5,001-10,000 km</option>
                                        <option value="10001-20000">10,001-20,000 km</option>
                                        <option value="20001-50000">20,001-50,000 km</option>
                                        <option value="50001-100000">50,001-100,000 km</option>
                                        <option value="100001+">100,001+ km</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-select" id="state" name="state" required>
                                        <option value="">-- Select State --</option>
                                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                        <option value="Assam">Assam</option>
                                        <option value="Bihar">Bihar</option>
                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                        <option value="Goa">Goa</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Haryana">Haryana</option>
                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Manipur">Manipur</option>
                                        <option value="Meghalaya">Meghalaya</option>
                                        <option value="Mizoram">Mizoram</option>
                                        <option value="Nagaland">Nagaland</option>
                                        <option value="Odisha">Odisha</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Rajasthan">Rajasthan</option>
                                        <option value="Sikkim">Sikkim</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Telangana">Telangana</option>
                                        <option value="Tripura">Tripura</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="Uttarakhand">Uttarakhand</option>
                                        <option value="West Bengal">West Bengal</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fuel" class="form-label">Fuel Type</label>
                                    <select class="form-select" id="fuel" name="fuel" required>
                                        <option value="">-- Select Fuel Type --</option>
                                        <option value="Petrol">Petrol</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="CNG">CNG</option>
                                        <option value="Electric">Electric</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="condition" class="form-label">Vehicle Condition</label>
                                    <select class="form-select" id="condition" name="condition" required>
                                        <option value="">-- Select Condition --</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Good">Good</option>
                                        <option value="Fair">Fair</option>
                                        <option value="Poor">Poor</option>
                                        <option value="Damaged">Damaged</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="scrapValue" class="form-label">Expected Scrap Value (₹)</label>
                                    <input type="number" class="form-control" id="scrapValue" name="scrapValue" placeholder="Enter expected value" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Vehicle Photo</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                <div class="form-text">Upload a clear photo of your vehicle</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason for Scrapping</label>
                                <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Why are you scrapping this vehicle?"></textarea>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="fas fa-recycle me-2"></i>Submit for Scrap
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const vehicleOptions = {
            "CAR": {
                "Maruti Suzuki": ["Swift", "Alto 800", "Baleno", "Expresso", "Celerio"],
                "Hyundai": ["i10", "i20", "Creta", "Venue", "Tuscon"],
                "Tata": ["City", "Punch", "Tiago", "Safari", "Harrier"],
                "Honda": ["City", "Accord", "Amaze"]
            },
            "BIKE": {
                "Honda": ["Activa 5g", "Aviator", "Activa 4g", "Activa125"],
                "TVS": ["Raider 125", "Radeon", "Glamour", "Jupiter125"],
                "Hero": ["Splendour plus", "HF Deluxe", "Glamour", "Passion Plus"],
                "Bajaj": ["Pulsar NS200", "Dominar400", "Platina200"]
            },
            "RICKSHAW": {},
            "TRUCK": {}
        };

        document.getElementById("vehicleType").addEventListener("change", function() {
            const vehicleTypeValue = this.value;
            const brandSelect = document.getElementById("Brand");
            brandSelect.innerHTML = `<option value="">-- Select Brand --</option>`;
            if (vehicleOptions[vehicleTypeValue]) {
                Object.keys(vehicleOptions[vehicleTypeValue]).forEach(function(brand) {
                    const opt = document.createElement("option");
                    opt.value = brand;
                    opt.text = brand;
                    brandSelect.appendChild(opt);
                });
            }
        });

        document.getElementById("Brand").addEventListener("change", function() {
            const vehicleTypeValue = document.getElementById("vehicleType").value;
            const brandValue = this.value;
            const modelSelect = document.getElementById("Model");
            modelSelect.innerHTML = `<option value="">-- Select Model --</option>`;
            if (vehicleOptions[vehicleTypeValue] && vehicleOptions[vehicleTypeValue][brandValue]) {
                vehicleOptions[vehicleTypeValue][brandValue].forEach(function(model) {
                    const opt = document.createElement("option");
                    opt.value = model;
                    opt.text = model;
                    modelSelect.appendChild(opt);
                });
            }
        });
        
        // Handle form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('php/process_scrap.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    this.reset();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                alert('Error submitting form');
            });
        });
    </script>
</body>
</html>