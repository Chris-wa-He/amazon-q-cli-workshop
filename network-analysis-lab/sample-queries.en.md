# Amazon Q CLI Network Architecture Analysis Sample Queries

Below are sample queries you can use with Amazon Q CLI to help analyze and understand AWS network architecture.

## Basic Network Architecture Analysis

```
Please describe the VPC architecture in my current AWS account, including subnets, route tables, and security groups.
```

```
Please analyze the network configuration in the VPC named "Network-Analysis-VPC" and explain its design principles.
```

```
What subnets do I have in my VPC? How are they configured?
```

## Network Connectivity Analysis

```
Please explain how EC2 instances in private subnets of my VPC access the internet?
```

```
How do EC2 instances in different subnets communicate with each other? Are there any limitations?
```

```
Are there any security risks in my VPC's security group configurations? What improvements would you suggest?
```

## Network Architecture Visualization

```
Please generate a network architecture diagram showing the relationships between subnets, route tables, security groups, and EC2 instances in the VPC.
```

```
Please show the traffic paths in my VPC in diagram form, especially the path from private subnets to the internet.
```

## Network Architecture Optimization

```
Please analyze my current network architecture and provide optimization recommendations, especially regarding security and availability.
```

```
Does my VPC architecture comply with AWS best practices? What areas need improvement?
```

```
How should I adjust my network architecture if I want to implement high availability?
```

## Troubleshooting

```
My EC2 instances in private subnets cannot access the internet. What are the possible causes? How can I troubleshoot this?
```

```
I cannot connect to my EC2 instances in public subnets via SSH. Please analyze possible causes and solutions.
```

```
The NAT gateway in my VPC doesn't seem to be working. How can I diagnose and resolve this issue?
```

## Cost Optimization

```
Which components in my network architecture might be causing unnecessary costs? How can I optimize them?
```

```
NAT gateways are relatively expensive. What alternatives could reduce costs while maintaining functionality?
```

## Security Enhancement

```
How can I enhance the security of my VPC? What best practices would you recommend?
```

```
How should I implement VPC flow logs to monitor network traffic?
```

```
How can I use network ACLs and security groups to implement defense in depth?
```
