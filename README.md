### 开发文档
1. 按照需求开发
2. 实现了功能，其他有点粗糙，模板只是几个输入框，包括一些验证没有写
3. 配置可以直接在数据库配置，根据用户id来配置
4. 路由：
    * 可以直接使用 php artisan serve 来进行http访问
    * 注册：http://127.0.0.1:8000/register
    * 获取无限极用户：http://127.0.0.1:8000/user/{id?}
5. Artisan 命令： php artisan user:top_ten 已经加到任务调度中 
