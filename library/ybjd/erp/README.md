# Erppush-ybjd
erp推送

#### 环境：PHP>=5.3

#### composer引入
> composer require yandy/Erppush-xiaowei
#### 示例



#### SDK引入
> composer require yandy/Erppush-xiaowei

#### 示例



#### 说明
1.请将证书文件放到Certificate目录下 然后再创建两个空文件 jiemi.json和jiemi.pem 并保证该目录有写入权限

2.下载证书解密返回的密文需要开启libsodium扩展（PHP >= 7.2 安装包自带这个扩展，去php.ini开启一下就行，< 7.2 的需要去安装这个扩展）

3.调用申请入驻等接口里面需要下载证书接口返回的序列号和需要解密后证书 public_key 来加密敏感信息，所以需要先调用下载证书接口

#### 实现的接口

applyEnter 申请入驻小微商户

submitUpGrade 小微商户升级接口

upGradeIsThrough 小微商户升级接口状态查询

createJsBizPackage  企业付款到用户零钱

enquiryOfApplyStatus 入驻申请状态查询

tenantConfig  关注配置  小微商户关注功能配置API

payTheDirectoryConfig  支付目录配置   小微商户开发配置新增支付目录API

bindAppIdConfig 绑定appid配置  小微商户新增对应APPID关联API

inquireConfig 查询配置

modifyArchives 小微商户修改资料接口-修改结算银行卡

withdrawalState 服务商帮小微商户查询自动提现 - 查询提现状态

withdrawStatusMsg 提现状态单据状态字段的中文描述

reAutoWithdrawByDate 重新发起提现 - 服务商帮小微商户重新发起自动提现

getApplyEnterList 获取入驻列表

getBusiness 获取类目中文意思

 getStoreAddress 传code获取中文地址

