#!/bin/bash
set -xe

# 1. Update OS and install Docker + git
dnf update -y
dnf install -y docker git

# 2. Enable and start Docker
systemctl enable --now docker

# Allow ec2-user to run docker (useful if you SSH later)
usermod -aG docker ec2-user || true

# 3. Install docker-compose (standalone v2.27.0)
curl -SL "https://github.com/docker/compose/releases/download/v2.27.0/docker-compose-linux-x86_64" \
  -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

/usr/local/bin/docker-compose version

# 4. Prepare app directory and clone repo as ec2-user
mkdir -p /opt/app
chown ec2-user:ec2-user /opt/app

sudo -u ec2-user bash -lc '
  set -xe
  cd /opt/app

  if [ ! -d .git ]; then
    git clone https://github.com/VineetS46/vehicles24.git .
  else
    git pull
  fi

  # Optional: fix localhost:8080 if still present in login.php
  if [ -f login.php ]; then
    sed -i "s#http://localhost:8080##g" login.php || true
  fi
'

# 5. Ensure docker-compose.yml maps port 80 -> 80 (no 8080 anymore)
cd /opt/app/deployment

if grep -q '"8080:80"' docker-compose.yml; then
  sed -i 's/"8080:80"/"80:80"/' docker-compose.yml || true
fi

# 6. Start the stack with docker-compose
/usr/local/bin/docker-compose pull
/usr/local/bin/docker-compose up -d
