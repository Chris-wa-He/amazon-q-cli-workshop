# AWS网络架构分析实验

本实验将帮助您学习如何使用Amazon Q CLI分析AWS网络架构，并生成网络架构图。

## 实验概述

在本实验中，您将：
1. 使用CloudFormation部署一个包含多个子网的VPC
2. 在不同子网中部署EC2实例
3. 使用Amazon Q CLI分析网络架构
4. 生成网络架构图并理解网络连接关系

## 前提条件

- 已安装并配置AWS CLI
- 已安装Amazon Q CLI
- 拥有适当的AWS权限来创建和管理VPC、子网、EC2实例等资源

## 实验步骤

### 步骤1：部署网络架构

1. 使用以下命令部署CloudFormation模板：

```bash
aws cloudformation create-stack \
  --stack-name network-analysis-lab \
  --template-body file://template.yaml \
  --capabilities CAPABILITY_IAM
```

2. 等待堆栈创建完成：

```bash
aws cloudformation wait stack-create-complete --stack-name network-analysis-lab
```

### 步骤2：使用Amazon Q CLI分析网络架构

1. 启动Amazon Q CLI交互式会话：

```bash
q chat
```

2. 向Amazon Q询问有关您的VPC架构的信息：

```
我刚刚部署了一个名为network-analysis-lab的CloudFormation堆栈，请帮我分析其中的VPC架构。
```

3. 请求Amazon Q生成网络架构图：

```
请帮我生成一个网络架构图，展示VPC中的子网、路由表、安全组和EC2实例之间的关系。
```

4. 询问Amazon Q关于网络连接性的问题：

```
请分析一下位于私有子网中的EC2实例如何访问互联网？
```

```
请解释一下不同子网中的EC2实例之间如何通信？
```

### 步骤3：网络架构优化

1. 请求Amazon Q提供网络架构优化建议：

```
请分析当前网络架构并提供优化建议，特别是关于安全性和可用性方面。
```

2. 根据Amazon Q的建议，考虑如何改进您的网络架构。

### 步骤4：清理资源

实验完成后，删除CloudFormation堆栈以避免产生不必要的费用：

```bash
aws cloudformation delete-stack --stack-name network-analysis-lab
```

## 实验总结

通过本实验，您学习了如何：
- 使用Amazon Q CLI分析AWS网络架构
- 理解VPC、子网、路由表、安全组等网络组件之间的关系
- 生成网络架构图以可视化网络结构
- 获取网络架构优化建议

这些技能对于理解和优化AWS环境中的网络架构非常有价值，可以帮助您设计更安全、更高效的网络结构。
