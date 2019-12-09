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

    中间件 保护路由   只允许通过认证的用户访问给定的路由
        
        middleware
    默认跳转地址？？  认证通过默认跳转地址
        
        redirectTo
    Auth::routes();
        自动注册一套基于auth的路由（包括登录，注册，登录）
    
        
    

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
        
-   isDirty()

        检查模型是否被修改
        使用 isDirty() 方法确定模型或给定属性是否已被修改


#####   分页

-   paginate  

        paginate 方法根据用户浏览的当前页码，自动设置恰当的偏移量 offset 和限制数 limit

-   simaplePaginate

        如果你只需要在分页视图中简单地显示「下一页」和「上一页」的链接，
        你可以使用 simaplePaginate 方法来执行更高效地查询。
        这在数据量很大且不需要在渲染视图时显示每页的页码时非常有用
###      服务提供者

-   observer   观察者模式
        
        基于model  在使用model处理是会触发到observer 在观察者模式中进行业务操作
        中间件是在route中出发，在路由中
        使用该模式要在服务提供者（Providers）中创建该服务，然后在
        **config/app.php中创建引入**
        



###   Composer

- ide_helper 插件

        要想把别的拓展加载到该插件中，要在app.php 'aliases' => []中添加当前拓展
        比如  'Markdown' => GrahamCampbell\Markdown\Facades\Markdown::class,
        这样再执行  php artisan ide-helper:generate
        就能够自动加载到ide_helper 中，当要使用该拓展的时候只要use Markdowm 
        当前拓展就能够直接使用
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
  - 路由中使用middleware  报错类找不到
        
        要在app/Http/Kernel.php 中$routeMiddleware添加自定义的middleware
        
        protected $routeMiddleware = [
                'auth' => \App\Http\Middleware\Authenticate::class,
                'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
                'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
                'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
                'can' => \Illuminate\Auth\Middleware\Authorize::class,
                'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
                'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
                'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
                'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
                'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        
                'admin.auth' => \App\Http\Middleware\AdminAuth::class,
                'admin.login' => \App\Http\Middleware\AdminLogin::class,
            ]; 
   -  在Auth 控制器模块中创建新控制器启用  admin 验证  但是没有登录成功
   
           protected function guard()
           {
               return Auth::guard('admin');
           }
           
           在项目中更改了自带的UserModel 类目录结构（位置），要在auth中重新定义User类路径
           
           'providers' => [
                   'users' => [
                       'driver' => 'eloquent',
           //            'model' => App\User::class,
                       'model' => App\Models\User::class,
                   ],
           ]
           
   -  设置表自增主键
   
            alter table wlcms_user AUTO_INCREMENT=11;
   -  withTrashed()  报找不到
   
            一开始只在class 外use了use Illuminate\Database\Eloquent\SoftDeletes;
            要在class内再use SoftDeletes 才可以使用
   - 在class 内use class外是导入命名空间，class外是导入命名空间，class内是trait，function后的是变量捕获。，function后的是变量捕获。
   
  -  trait
        其实说通俗一点，就是能把重复的方法拆分到一个文件，通过 use 引入以达到代码复用的目的。
        更方便的能够复用方法，使用的时候直接ues 相关trait类，就能够使用相关特性，继承也能够实现相关功能，但是耦合度很高，而且后面新增功能会显得很臃肿，阅读性也不是很方便，还要点进去看，
        
           
           
### 设计模式

- 依赖注入

- 门面

- 观察者模式
  
    
    
           
            
     
