#  Vehicles24 – Cloud-Native Vehicle Marketplace Platform

## 📖 Overview
Vehicles24 is a cloud-native web platform that allows users to buy, sell, and scrap vehicles.

The project is fully automated using **Terraform**, containerized with **Docker**, and deployed on **AWS EC2**. This setup ensures reliable performance, consistent environments, and easy reproducibility.

---

## 🏗️ Cloud Deployment Architecture
The platform uses a two-container architecture:

### 1. Web Container
* **PHP 8.2 + Apache**
* Hosts the full Vehicles24 application.
* Handles login, user registration, vehicle listings, image uploads, and UI rendering.

### 2. MySQL Database Container
* **MySQL 8.0**
* Persistent storage via Docker volume.
* Auto-imports initial data on first launch.

### Infrastructure Automation
**Terraform** provisions:
* EC2 instance (Amazon Linux 2023)
* Security Groups (Ports 22 & 80 open)
* 20GB EBS volume
* S3 bucket (reserved for future storage needs)

A **cloud-init script** automatically:
* Installs Docker
* Installs Docker Compose
* Deploys the containers
* Imports the database
* Boots the entire app with **zero manual steps**

---

## ⚡ Key Features

### 🔐 Authentication
* User registration
* Login with encrypted credentials
* Secure session handling

### 🚗 Marketplace
* List vehicles for sale
* Scrap vehicle workflow
* Detailed vehicle display
* Image uploads (stored persistently)

### 💾 Persistence
* All uploads preserved using Docker volumes
* Database auto-initialized on first run

### 🔧 Automation
* One-command deployment using Terraform
* Fully automated EC2 bootstrap
* Containers auto-start on reboot

---

## 🛠️ Technology Stack

| Component | Technology |
| :--- | :--- |
| **Cloud Hosting** | AWS EC2 |
| **IaC** | Terraform |
| **Containers** | Docker & Docker Compose |
| **Web Server** | Apache |
| **Backend** | PHP 8.2 |
| **Database** | MySQL 8.0 |
| **OS** | Amazon Linux 2023 |

---