# 学习笔记

###配置数据库  
####命令行形式添加数据表
---
- 数据库迁移

    运行迁移
        
        php artisan migrate

    创建迁移  创建user表
    
        php artisan make:migration create_users_table   
    设置为索引 unique()
        
        $table->string('email')->unique();   
    设置当前字段可空 nullable()
    
        $table->string('email')->nullable();
    设置相当于可空版本的 VARCHAR (100) 的 remember_token 字段
    
        $table->rememberToken();
    设置相当于可空的 created_at 和 updated_at TIMESTAMP
        
        $table->timestamps();
    设置软删除字段 相当于为软删除添加一个可空的 deleted_at 字段   
    
        $table->softDeletes();
    设置字段注释 comment
    
        $table->bigIncrements('id')->comment('文章表主键');
    设置mediumtext类型字段 mediumText
    
        $table->mediumText('markdown')->comment('markdown文章内容');
    设置字段默认值 default
        
        $table->tinyInteger('category_id')->default(0)->comment('分类id');
    设置字段非负数 unsigned
    
        $table->integer('click')->unsigned()->default(0)->comment('点击数');
        
- 数据填充

    创建一个 Seeders
    
        php artisan make:seeder UsersTableSeeder
- 路由 route

    中间件
        
        middleware
        
    

### 路由配置没有生效
 
---
nginx 根目录配置中添加这条匹配
try_files $uri $uri/ /index.php?$query_string;
可以隐藏index.php和使隐藏index.php之后的路由生效，自动带上index.php
        
         if (!-e $request_filename) {
                    rewrite ^/(.*)$ /index.php/$1;
         }
         
之前使用这个配置只能识别首页的路由


- php artisan route:cache
  每次修改路由之后请先清空缓存数据

###  单次查询

- find  first 

检索单个模型 / 集合
这些方法返回单个模型实例，而不是返回模型集合：

-  get

laravel里get()得到的是一组数据，first()得到的是一个model数据。
一个model数据就是一个stdClass，stdClass是一个没有属性和方法的空类

###  dd() 函数

   
    if (!function_exists('dd')) {
        function dd(...$vars)
        {
            foreach ($vars as $v) {
                VarDumper::dump($v);
            }
    
            die(1);
        }
    }

在foreach 中使用dd函数时，因为执行一次之后就直接die结束了，所有只会打印当前循环第一次数据，后面的循环直接die

###  Model  Eloquent ORM

- $fillable 白名单

-  hasOne 一对一关联

        一对一是最基本的关联关系。例如，一个 User 模型可能关联一个 Phone 模型。为了定义这个关联，我们要在 User 模型中写一个 phone 方法。在 phone 方法内部调用 hasOne 方法并返回其结果
        
        默认第二个参数为关联表的id 并且关联表id默认为当前表明加id，如果不是请单独设置
        
        默认第三个参数为当前表对应关联表名加id
        
        Eloquent 假设外键的值是与父级 id (或自定义 $primaryKey) 列的值相匹配的。换句话说，Eloquent 将会在 Phone 记录的 user_id 列中查找与用户表的 id 列相匹配的值。如果您希望该关联使用 id 以外的自定义键名，则可以给 hasOne 方法传递第三个参数
        
        return $this->hasOne(Category::class,'id')
        
        return $this->hasOne('App\Phone', 'foreign_key', 'local_key');
        
- 关联查找指定字段

        //多个字段
        return $this->hasOne('App\Phone', 'foreign_key', 'local_key')->select(['id','name']);
        //单个字段
        
- belongsTo 反向关联
        
        Eloquent 会尝试匹配 Phone 模型上的 user_id 至 User 模型上的 id 。它是通过检查关系方法的名称并使用 _id 作为后缀名来确定默认外键名称的。但是，如果 Phone 模型的外键不是 user_id，那么可以将自定义键名作为第二个参数传递给 belongsTo 方法    
        默认关联表Category 中id值  对应当前表中 关联表Category加_id 值     
        return $this->belongsTo(Category::class);

-  hasMany  一对多关联
        
        『一对多』关联用于定义单个模型拥有任意数量的其它关联模型

- belongsTo反向一对多关联


-  belongsToMany  多对多关联
   
        要定义这种关联，需要三个数据库表
        第三个参数是定义此关联的模型在连接表里的外键名，第四个参数是另一个模型在连接表里的外键名：
        第一个参数，关联表
        第二个参数关联中间表，
        第三个参数当前表在中间表中的外键名，
        第四个参数是关联表在中间表中的外键名
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');


###      服务提供者



###   错误问题

- 添加索引时提示 索引名称太长无法保存
  
        Syntax error or access violation: 1071 Specified key was too long; max key length is 1000 bytes (SQL: alter table `wyj_users` add unique `wyj_users_email_unique`(`email`))
        
    解决方案：   
    编辑 AppServiceProvider.php 文件，并在 boot 方法内设置默认字符串的长度：
    ```
        use Illuminate\Support\Facades\Schema;
        
        public function boot()
        {
            Schema::defaultStringLength(191);
        }
    ```
  
 - 在路由中重定向访问地址 结果范文localhost地址
        
        Route::redirect('/', url('/admin/login/index'));
   
   url()函数默认读取config/app.conf中url 的参数   'url' => env('APP_URL', 'http://localhost'),
   其中在env中设置的APP_URL参数为localhost,未设置的话默认值也为localhost     
   
  
    
    
           
            
     
