# AWS Network Architecture Analysis Lab

This lab will help you learn how to use Amazon Q CLI to analyze AWS network architecture and generate network architecture diagrams.

## Lab Overview

In this lab, you will:
1. Use CloudFormation to deploy a VPC with multiple subnets
2. Deploy EC2 instances in different subnets
3. Use Amazon Q CLI to analyze the network architecture
4. Generate network architecture diagrams and understand network connectivity relationships

## Prerequisites

- AWS CLI installed and configured
- Amazon Q CLI installed
- Appropriate AWS permissions to create and manage VPC, subnets, EC2 instances, and other resources

## Lab Steps

### Step 1: Deploy Network Architecture

1. Use the following command to deploy the CloudFormation template:

```bash
aws cloudformation create-stack \
  --stack-name network-analysis-lab \
  --template-body file://template.yaml \
  --capabilities CAPABILITY_IAM
```

2. Wait for the stack creation to complete:

```bash
aws cloudformation wait stack-create-complete --stack-name network-analysis-lab
```

### Step 2: Use Amazon Q CLI to Analyze Network Architecture

1. Start an Amazon Q CLI interactive session:

```bash
q chat
```

2. Ask Amazon Q about your VPC architecture:

```
I just deployed a CloudFormation stack named network-analysis-lab. Please help me analyze the VPC architecture within it.
```

3. Request Amazon Q to generate a network architecture diagram:

```
Please generate a network architecture diagram showing the relationships between subnets, route tables, security groups, and EC2 instances in the VPC.
```

4. Request Amazon Q to generate a draw.io format network architecture diagram file:

```
Please generate a draw.io format network architecture diagram file that includes all resources in the VPC and their relationships, so I can further edit and customize it.
```

5. Ask Amazon Q questions about network connectivity:

```
Please analyze how EC2 instances in private subnets access the internet?
```

```
Please explain how EC2 instances in different subnets communicate with each other?
```

### Step 3: Network Architecture Optimization

1. Request optimization recommendations from Amazon Q:

```
Please analyze the current network architecture and provide optimization recommendations, especially regarding security and availability.
```

2. Consider how to improve your network architecture based on Amazon Q's recommendations.

### Step 4: Clean Up Resources

After completing the lab, delete the CloudFormation stack to avoid unnecessary charges:

```bash
aws cloudformation delete-stack --stack-name network-analysis-lab
```

## Lab Summary

Through this lab, you learned how to:
- Use Amazon Q CLI to analyze AWS network architecture
- Understand the relationships between network components such as VPC, subnets, route tables, and security groups
- Generate network architecture diagrams to visualize network structures
- Obtain network architecture optimization recommendations

These skills are valuable for understanding and optimizing network architectures in AWS environments, helping you design more secure and efficient network structures.
