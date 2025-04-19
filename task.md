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
