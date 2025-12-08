#############################
# Default VPC + Subnets
#############################

data "aws_vpc" "default" {
  default = true
}

data "aws_subnets" "default" {
  filter {
    name   = "vpc-id"
    values = [data.aws_vpc.default.id]
  }
}

#############################
# Security Group for EC2
#############################

resource "aws_security_group" "vehicles24_sg" {
  name   = "${var.project_name}-sg"
  vpc_id = data.aws_vpc.default.id

  # SSH (22)
  ingress {
    description = "SSH"
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  # HTTP (80)
  ingress {
    description = "HTTP"
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  # Outbound: allow all
  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name    = "${var.project_name}-sg"
    Project = var.project_name
  }
}

#############################
# AMI: Amazon Linux 2023
#############################

data "aws_ami" "amazon_linux_2023" {
  owners = ["amazon"]

  filter {
    name   = "name"
    values = ["al2023-ami-*-x86_64"]
  }

  filter {
    name   = "architecture"
    values = ["x86_64"]
  }

  filter {
    name   = "root-device-type"
    values = ["ebs"]
  }

  filter {
    name   = "virtualization-type"
    values = ["hvm"]
  }

  most_recent = true
}

#############################
# Random suffix for S3 bucket
#############################

resource "random_id" "bucket_suffix" {
  byte_length = 5
}

#############################
# S3 bucket for Vehicles24
#############################

resource "aws_s3_bucket" "vehicles24_bucket" {
  bucket        = "${var.project_name}-${random_id.bucket_suffix.hex}"
  force_destroy = true

  tags = {
    Name    = "${var.project_name}-bucket"
    Project = var.project_name
  }
}

#############################
# EC2 instance for Vehicles24
#############################

resource "aws_instance" "vehicles24_ec2" {
  ami           = data.aws_ami.amazon_linux_2023.id
  instance_type = var.instance_type

  subnet_id              = data.aws_subnets.default.ids[0]
  vpc_security_group_ids = [aws_security_group.vehicles24_sg.id]

  key_name = var.key_name

  # Root volume: must be >= snapshot size (error said >= 30GB)
  root_block_device {
    volume_size = 30
    volume_type = "gp3"
  }

  # Bootstrap script
  user_data = file("${path.module}/user_data.sh")

  tags = {
    Name    = "${var.project_name}-ec2"
    Project = var.project_name
  }
}
