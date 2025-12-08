#!/bin/bash
set -xe

# 1. Update OS and install Docker + git
dnf update -y
dnf install -y docker git

# 2. Enable and start Docker
systemctl enable --now docker
usermod -aG docker ec2-user || true

# 3. Install docker-compose
curl -SL "https://github.com/docker/compose/releases/download/v2.27.0/docker-compose-linux-x86_64" \
  -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

# 4. Get your app code (repo with vehicle.sql)
mkdir -p /opt/app
chown ec2-user:ec2-user /opt/app
cd /opt/app

git clone https://github.com/VineetS46/vehicles24.git .
chown -R ec2-user:ec2-user /opt/app

# 5. Start the stack (MySQL will auto-import vehicle.sql on first run)
cd /opt/app/deployment
/usr/local/bin/docker-compose up -d --remove-orphans
