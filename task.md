创建 Amazon Q CLI 的workshop。每一个实验将放置在不同的子目录中，目录中包含实验的辅助文件，实验说明与步骤写在readme文件中。

## 任务列表

- [x] 解决EC2无法连通问题实验
  - 实验描述：使用CloudFormation创建一个在公网的EC2，实例上的安全组没有开放SSH访问，同时网络ACL限制了公网访问。
  - 实验任务：先运行CloudFormation部署资源，然后使用Amazon Q CLI解决问题，使得最终可以通过SSH连接到实例。
  - 实验目标：学习如何使用Amazon Q CLI诊断和解决EC2连接问题。
  - 状态：已完成 ✓ (创建了ec2-connectivity-lab目录，包含README.md和template.yaml)
