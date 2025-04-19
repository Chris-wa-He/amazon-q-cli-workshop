创建 Amazon Q CLI 的workshop。每一个实验将放置在不同的子目录中，目录中包含实验的辅助文件，实验说明与步骤写在readme文件中。

## 任务列表

- [x] 解决EC2无法连通问题实验
  - 实验描述：使用CloudFormation创建一个在公网的EC2，实例上的安全组没有开放SSH访问，同时网络ACL限制了公网访问。
  - 实验任务：先运行CloudFormation部署资源，然后使用Amazon Q CLI解决问题，使得最终可以通过SSH连接到实例。
  - 实验目标：学习如何使用Amazon Q CLI诊断和解决EC2连接问题。
  - 状态：已完成 ✓ (创建了ec2-connectivity-lab目录，包含README.md和template.yaml)

- [x] AWS资源使用状况分析与成本优化实验
  - 实验描述：通过Amazon Q CLI获取上一个月的AWS资源使用状况，分析并获取成本优化建议。
  - 实验任务：使用Amazon Q CLI查询资源使用情况，获取成本优化建议，并实施优化措施。
  - 实验目标：学习如何使用Amazon Q CLI进行成本分析和优化。
  - 状态：已完成 ✓ (创建了cost-optimization-lab目录，包含README.md和sample-queries.md)

- [ ] 自动化运维实验
  - 实验描述：编写一个Lambda函数，用于每天检查是否有EC2实例超过30天未启动，如果发现这些实例，则向用户配置的SNS topic发送一个提醒信息。
  - 实验任务：使用Amazon Q CLI帮助编写Lambda函数代码、创建必要的IAM角色和权限、配置SNS通知，并设置CloudWatch Events触发器。
  - 实验目标：学习如何使用Amazon Q CLI辅助自动化运维任务的开发和部署。
  - 状态：待测试 (创建了automated-operations-lab目录，包含README.md、lambda_function.py和template.yaml)
