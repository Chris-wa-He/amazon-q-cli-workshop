# AWS Resource Usage Analysis and Cost Optimization Lab

This lab will guide you on how to use Amazon Q CLI to analyze AWS resource usage, get cost optimization recommendations, and implement optimization measures.

## Lab Objectives

Through this lab, you will learn how to:
- Use Amazon Q CLI to query AWS resource usage
- Analyze resource utilization and cost data
- Get targeted cost optimization recommendations
- Implement recommended optimization measures
- Evaluate cost savings after optimization

## Prerequisites

1. AWS CLI installed and configured
2. Amazon Q CLI installed
3. Permissions to view AWS Cost Explorer and AWS resources
4. At least one month of AWS usage history

## Lab Steps

### Step 1: Query Resource Usage

Use Amazon Q CLI to query your AWS resource usage:

```bash
q chat
```

In the conversation, you can ask questions like:
- "Query my EC2 instance usage from last month"
- "Analyze my S3 storage usage trends"
- "Show the most expensive services in my account"
- "View my RDS instance utilization"

### Step 2: Get Cost Optimization Recommendations

Continue the conversation with Amazon Q to get cost optimization recommendations:

```bash
# Continue in the same conversation
```

You can ask:
- "Which EC2 instances can be resized to save costs?"
- "Identify idle or underutilized resources"
- "Recommend resources that can use Savings Plans or Reserved Instances"
- "Analyze my EBS volume usage and provide optimization recommendations"

### Step 3: Implement Optimization Measures

Based on Amazon Q's recommendations, implement optimization measures. For example:

1. Resize EC2 instances:
```bash
aws ec2 stop-instances --instance-ids i-1234567890abcdef0
aws ec2 modify-instance-attribute --instance-id i-1234567890abcdef0 --instance-type t3.micro
aws ec2 start-instances --instance-ids i-1234567890abcdef0
```

2. Delete unused resources:
```bash
aws ec2 terminate-instances --instance-ids i-1234567890abcdef0
```

3. Set lifecycle policies:
```bash
aws s3api put-bucket-lifecycle-configuration --bucket my-bucket --lifecycle-configuration file://lifecycle-config.json
```

### Step 4: Evaluate Optimization Effects

After implementing optimization measures, use Amazon Q CLI to evaluate the effects:

```bash
q chat
```

You can ask:
- "Compare costs before and after optimization"
- "Predict next month's AWS bill"
- "Analyze the impact of optimization measures"

## Lab Extensions

1. Create automation scripts to regularly perform resource optimization
2. Set up cost budgets and alerts
3. Explore using AWS Organizations and SCPs to implement cost control policies

## Summary

Through this lab, you learned how to use Amazon Q CLI to analyze AWS resource usage, get cost optimization recommendations, and implement optimization measures. These skills can help you continuously optimize your AWS environment, reduce costs, and improve resource utilization.

## Reference Resources

- [AWS Cost Explorer Documentation](https://docs.aws.amazon.com/cost-management/latest/userguide/ce-what-is.html)
- [AWS Cost Optimization Best Practices](https://aws.amazon.com/aws-cost-management/aws-cost-optimization/)
- [Amazon Q CLI Documentation](https://docs.aws.amazon.com/amazonq/latest/cli-user-guide/what-is.html)
