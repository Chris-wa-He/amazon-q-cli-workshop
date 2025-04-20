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
