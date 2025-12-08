
# Shows public info after deployment.
output "ec2_public_ip" {
  description = "Public IP of the Vehicles24 EC2 instance"
  value       = aws_instance.vehicles24_ec2.public_ip
}

output "app_url" {
  description = "Vehicles24 URL on port 8080"
  value       = "http://${aws_instance.vehicles24_ec2.public_ip}:8080"
}

output "s3_bucket_name" {
  description = "Vehicles24 S3 bucket name"
  value       = aws_s3_bucket.vehicles24_bucket.id
}
