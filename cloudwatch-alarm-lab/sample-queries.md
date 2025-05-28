# Amazon Q CLI 示例查询

以下是在CloudWatch告警配置实验中可以使用的Amazon Q CLI示例查询：

## 查询EC2实例

```
列出我当前账户中的所有EC2实例及其状态
```

```
查找标签名称包含"CloudWatch-Alarm-Lab"的EC2实例
```

```
获取我刚刚部署的EC2实例的公共DNS名称
```

## 创建CloudWatch告警

```
为实例ID为i-xxxxxxxxxx和i-yyyyyyyyyy的EC2实例批量创建CloudWatch告警，当CPU使用率超过20%持续1分钟时触发
```

```
如何使用AWS CLI为多个EC2实例批量创建CloudWatch告警？
```

```
创建一个CloudWatch告警，当EC2实例的CPU使用率超过20%持续1分钟时发送通知
```

## 创建SNS主题和订阅

```
创建一个名为"EC2-CPU-Alarm"的SNS主题，并添加我的邮箱example@example.com作为订阅
```

```
如何将SNS主题与CloudWatch告警关联？
```

```
如何检查SNS主题的订阅状态？
```

## 查询和管理CloudWatch告警

```
列出我账户中所有的CloudWatch告警及其状态
```

```
如何查看CloudWatch告警的状态历史？
```

```
如何修改现有CloudWatch告警的阈值？
```

## 清理资源

```
如何删除所有与"CloudWatch-Alarm-Lab"相关的CloudWatch告警？
```

```
如何删除SNS主题及其所有订阅？
```

```
如何使用CloudFormation删除我部署的所有资源？
```
