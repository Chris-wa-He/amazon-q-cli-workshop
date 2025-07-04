# Amazon Q CLI Workshop

这个仓库包含了一系列实验，旨在帮助用户学习如何使用Amazon Q CLI来解决AWS环境中的各种问题。

## 什么是Amazon Q CLI?

Amazon Q CLI是一个命令行工具，它将Amazon Q的强大功能带到了命令行界面。通过Amazon Q CLI，用户可以：

- 获取AWS服务的帮助和建议
- 诊断和解决AWS资源的问题
- 生成和解释AWS CLI命令
- 获取AWS最佳实践的指导
- 以对话方式与AI助手交互

## 实验列表

本workshop包含以下实验：

1. [EC2连通性问题实验](./ec2-connectivity-lab/README.md) - 学习如何使用Amazon Q CLI诊断和解决EC2实例的连接问题。
2. [AWS资源使用状况分析与成本优化实验](./cost-optimization-lab/README.md) - 学习如何使用Amazon Q CLI分析AWS资源使用情况并获取成本优化建议。
3. [自动化运维实验](./automated-operations-lab/README.md) - 学习如何使用Amazon Q CLI辅助自动化运维任务的开发和部署。
4. [AWS网络架构分析实验](./network-analysis-lab/README.md) - 学习如何使用Amazon Q CLI分析和可视化AWS网络架构。
5. [氛围编程(Vibe Coding)实验](./vibe-coding-lab/README.md) - 体验通过与Amazon Q CLI进行对话式交流来开发应用程序的流程。
6. [CloudWatch告警配置实验](./cloudwatch-alarm-lab/README.md) - 学习如何使用Amazon Q CLI为EC2实例配置CPU使用率告警。
7. [全栈EC2运维大师实验](./ec2-master-lab/README.md) - 整合EC2连通性问题、网络架构分析和CloudWatch告警配置，创建一个端到端的实践场景。

## 准备工作

在开始实验之前，请确保：

1. 安装并配置了AWS CLI
2. 安装了Amazon Q CLI
3. 拥有适当的AWS权限来创建和管理实验中使用的资源

### 安装Amazon Q CLI

```bash
# 使用pip安装Amazon Q CLI
pip install amazon-q-cli

# 验证安装
q --version
```

## 如何使用本Workshop

每个实验都位于独立的目录中，包含：
- README.md：实验说明和步骤
- 支持文件：如CloudFormation模板、脚本等

按照每个实验中的README.md文件中的说明进行操作。

## 贡献

欢迎贡献新的实验或改进现有实验。请提交Pull Request或创建Issue。
