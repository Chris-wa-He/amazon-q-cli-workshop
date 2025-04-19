# AWS资源使用状况分析与成本优化实验

本实验将指导您如何使用Amazon Q CLI分析AWS资源使用情况，获取成本优化建议，并实施优化措施。

## 实验目标

通过本实验，您将学习如何：
- 使用Amazon Q CLI查询AWS资源使用情况
- 分析资源利用率和成本数据
- 获取针对性的成本优化建议
- 实施推荐的优化措施
- 评估优化后的成本节约效果

## 前提条件

1. 已安装并配置AWS CLI
2. 已安装Amazon Q CLI
3. 拥有查看AWS Cost Explorer和AWS资源的权限
4. 至少有一个月的AWS使用历史

## 实验步骤

### 步骤1：查询资源使用情况

使用Amazon Q CLI查询您的AWS资源使用情况：

```bash
q chat
```

在对话中，您可以询问类似以下的问题：
- "查询我上个月的EC2实例使用情况"
- "分析我的S3存储使用趋势"
- "显示我账户中最昂贵的服务"
- "查看我的RDS实例利用率"

### 步骤2：获取成本优化建议

继续与Amazon Q对话，获取成本优化建议：

```bash
# 在同一个对话中继续
```

您可以询问：
- "有哪些EC2实例可以调整大小以节省成本？"
- "识别闲置或未充分利用的资源"
- "推荐可以使用Savings Plans或预留实例的资源"
- "分析我的EBS卷使用情况并提供优化建议"

### 步骤3：实施优化措施

根据Amazon Q的建议，实施优化措施。例如：

1. 调整EC2实例大小：
```bash
aws ec2 stop-instances --instance-ids i-1234567890abcdef0
aws ec2 modify-instance-attribute --instance-id i-1234567890abcdef0 --instance-type t3.micro
aws ec2 start-instances --instance-ids i-1234567890abcdef0
```

2. 删除未使用的资源：
```bash
aws ec2 terminate-instances --instance-ids i-1234567890abcdef0
```

3. 设置生命周期策略：
```bash
aws s3api put-bucket-lifecycle-configuration --bucket my-bucket --lifecycle-configuration file://lifecycle-config.json
```

### 步骤4：评估优化效果

实施优化措施后，使用Amazon Q CLI评估优化效果：

```bash
q chat
```

您可以询问：
- "比较优化前后的成本差异"
- "预测下个月的AWS账单"
- "分析优化措施的影响"

## 实验扩展

1. 创建自动化脚本，定期执行资源优化
2. 设置成本预算和警报
3. 探索使用AWS Organizations和SCPs实施成本控制策略

## 总结

通过本实验，您学习了如何使用Amazon Q CLI分析AWS资源使用情况，获取成本优化建议，并实施优化措施。这些技能可以帮助您持续优化AWS环境，降低成本，提高资源利用率。

## 参考资源

- [AWS Cost Explorer 文档](https://docs.aws.amazon.com/cost-management/latest/userguide/ce-what-is.html)
- [AWS 成本优化最佳实践](https://aws.amazon.com/aws-cost-management/aws-cost-optimization/)
- [Amazon Q CLI 文档](https://docs.aws.amazon.com/amazonq/latest/cli-user-guide/what-is.html)
