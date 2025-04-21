# Amazon Q CLI Cost Optimization Sample Queries

This document provides a series of sample queries that can be used in Amazon Q CLI to help you analyze AWS resource usage and get cost optimization recommendations.

## Resource Usage Analysis Queries

### EC2 Instance Analysis
- "Analyze my EC2 instance usage and find instances with CPU utilization below 20%"
- "Find EC2 instances with the lowest network traffic over the past 30 days"
- "Identify which EC2 instances can be converted from On-Demand to Savings Plans or Reserved Instances"
- "Show the distribution of my EC2 instances by instance type"

### Storage Analysis
- "Analyze my S3 storage usage trends and predict growth for the next 3 months"
- "Find S3 objects that haven't been accessed for more than 90 days"
- "Identify S3 data that can be moved to lower-cost storage classes"
- "Analyze my EBS volume usage and find unattached or low-utilization volumes"

### Database Analysis
- "Analyze CPU and memory usage of my RDS instances"
- "Find RDS instances with low connection counts"
- "Identify DynamoDB tables that can be resized"
- "Analyze the performance-to-cost ratio of my Aurora clusters"

## Cost Optimization Recommendation Queries

### Instance Optimization
- "Recommend which EC2 instances can be downsized to save costs"
- "Analyze the cost impact of replacing existing instances with Graviton processors"
- "Suggest which workloads are suitable for Spot instances"
- "Calculate potential savings from converting On-Demand instances to Savings Plans"

### Storage Optimization
- "Recommend how to optimize my S3 storage costs"
- "Analyze potential savings from implementing S3 lifecycle policies"
- "Recommend which EBS volumes can be converted to gp3 type to save costs"
- "Suggest how to optimize my EBS snapshot strategy"

### Network Optimization
- "Analyze my data transfer costs and provide optimization recommendations"
- "Suggest how to reduce NAT gateway costs"
- "Evaluate the cost-benefit of using VPC endpoints"
- "Analyze my CloudFront usage and provide optimization recommendations"

## Comprehensive Analysis Queries

- "Analyze my AWS bill from last month and identify the biggest cost drivers"
- "Compare cost trends over the past 3 months and predict next month's bill"
- "Identify the fastest growing service costs in my account"
- "Recommend a comprehensive cost optimization plan, sorted by potential savings"
- "Analyze my tagging strategy and suggest improvements for cost allocation"

## Automation Queries

- "Help me create a script to automatically identify and stop development environments during non-working hours"
- "Design a solution to automatically resize resources to match actual usage"
- "Help me create an AWS Lambda function to periodically clean up unused resources"
- "Design a cost control strategy using AWS Budgets"

## Using These Queries

In Amazon Q CLI, you can use these queries directly or adjust them based on your specific situation. Remember, providing more context information will help Amazon Q generate more accurate and targeted responses.
