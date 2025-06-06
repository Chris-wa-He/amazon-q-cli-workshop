# Amazon Q CLI Workshop

This repository contains a series of labs designed to help users learn how to use Amazon Q CLI to solve various problems in AWS environments.

## What is Amazon Q CLI?

Amazon Q CLI is a command-line tool that brings the power of Amazon Q to the command-line interface. With Amazon Q CLI, users can:

- Get help and recommendations for AWS services
- Diagnose and solve issues with AWS resources
- Generate and interpret AWS CLI commands
- Receive guidance on AWS best practices
- Interact with an AI assistant in a conversational manner

## Lab List

This workshop includes the following labs:

1. [EC2 Connectivity Lab](./ec2-connectivity-lab/README.en.md) - Learn how to use Amazon Q CLI to diagnose and solve connectivity issues with EC2 instances.
2. [AWS Resource Usage Analysis and Cost Optimization Lab](./cost-optimization-lab/README.en.md) - Learn how to use Amazon Q CLI to analyze AWS resource usage and get cost optimization recommendations.
3. [Automated Operations Lab](./automated-operations-lab/README.en.md) - Learn how to use Amazon Q CLI to assist in developing and deploying automated operations tasks.
4. [AWS Network Architecture Analysis Lab](./network-analysis-lab/README.en.md) - Learn how to use Amazon Q CLI to analyze and visualize AWS network architecture.
5. [Vibe Coding Lab](./vibe-coding-lab/README.en.md) - Experience the process of developing applications through conversational interaction with Amazon Q CLI.
6. [CloudWatch Alarm Configuration Lab](./cloudwatch-alarm-lab/README.en.md) - Learn how to use Amazon Q CLI to configure CPU usage alarms for EC2 instances.
7. [EC2 Full-Stack Operations Master Lab](./ec2-master-lab/README.en.md) - Integrate EC2 connectivity issues, network architecture analysis, and CloudWatch alarm configuration to create an end-to-end practical scenario.

## Prerequisites

Before starting the labs, please ensure:

1. AWS CLI is installed and configured
2. Amazon Q CLI is installed
3. You have appropriate AWS permissions to create and manage resources used in the labs

### Installing Amazon Q CLI

```bash
# Install Amazon Q CLI using pip
pip install amazon-q-cli

# Verify installation
q --version
```

## How to Use This Workshop

Each lab is located in a separate directory and includes:
- README.en.md: Lab instructions and steps in English
- Supporting files: Such as CloudFormation templates, scripts, etc.

Follow the instructions in the README.en.md file in each lab.

## Contributions

Contributions of new labs or improvements to existing labs are welcome. Please submit a Pull Request or create an Issue.
