variable "aws_region" {
  description = "AWS region"
  type        = string
}

variable "project_name" {
  description = "Project name used for tagging"
  type        = string
}

variable "instance_type" {
  description = "EC2 instance type"
  type        = string
  default     = "t3.micro"
}

variable "key_name" {
  description = "Name of the existing EC2 key pair"
  type        = string
}

/*
These two are currently unused if we use the default VPC.
You can keep them for future custom VPC work.
*/
variable "vpc_cidr" {
  description = "CIDR for a custom VPC (unused in default VPC setup)"
  type        = string
  default     = "10.0.0.0/16"
}

variable "public_subnet_cidr" {
  description = "CIDR for a custom public subnet (unused in default VPC setup)"
  type        = string
  default     = "10.0.1.0/24"
}
