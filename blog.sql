-- MySQL dump 10.13  Distrib 5.7.13, for Linux (x86_64)
--
-- Host: localhost    Database: homestead
-- ------------------------------------------------------
-- Server version	5.7.13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `artisan`
--

DROP TABLE IF EXISTS `artisan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `artisan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '关联用户id',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联评论id',
  `category_id` int(11) DEFAULT NULL COMMENT '关联类别id',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标签',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态 0：待审核 1：发布 2：草稿 3：审核未通过',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artisan`
--

LOCK TABLES `artisan` WRITE;
/*!40000 ALTER TABLE `artisan` DISABLE KEYS */;
INSERT INTO `artisan` VALUES (6,1,0,1,'20 个 Laravel Eloquent 必备的实用技巧','Laravel / 全栈','<p>Eloquent ORM 看起来是一个简单的机制，但是在底层，有很多半隐藏的函数和鲜为人知的方式来实现更多功能。在这篇文章中，我将演示几个小技巧。</p><h2>1. 递增和递减</h2><p>要代替以下实现：</p><pre style=\"background:#bfbfbf\">$article&nbsp;=&nbsp;Article::find($article_id);$article-&gt;read_count++;$article-&gt;save();</pre><p>你可以这样做：</p><pre style=\"background:#bfbfbf\">$article&nbsp;=&nbsp;Article::find($article_id);\r\n$article-&gt;increment(&#39;read_count&#39;);</pre><p>以下这些方法也可以实现：</p><pre style=\"background:#bfbfbf\">Article::find($article_id)-&gt;increment(&#39;read_count&#39;);\r\nArticle::find($article_id)-&gt;increment(&#39;read_count&#39;,&nbsp;10);&nbsp;//&nbsp;+10\r\nProduct::find($produce_id)-&gt;decrement(&#39;stock&#39;);&nbsp;//&nbsp;-1</pre><hr/><h2>2. 先执行 X 方法，X 方法执行不成功则执行 Y 方法</h2><p>Eloquent 有相当一部分函数可以把两个方法结合在一起使用, 例如 『 请先执行 X 方法， &nbsp;X 方法执行不成功则执行 Y 方法 』。</p><p>实例 1 -- <code>findOrFail()</code>:</p><p>要替代以下代码的实现：</p><pre>$user&nbsp;=&nbsp;User::find($id);\r\nif&nbsp;(!$user)&nbsp;{&nbsp;abort&nbsp;(404);&nbsp;}</pre><p>你可以这样写：</p><pre style=\"background:#bfbfbf\">$user&nbsp;=&nbsp;User::findOrFail($id);</pre><p>实例 2 -- <code>firstOrCreate()</code>:</p><p>要替代以下代码的实现：</p><pre style=\"background:#bfbfbf\">$user&nbsp;=&nbsp;User::where(&#39;email&#39;,&nbsp;$email)-&gt;first();\r\nif&nbsp;(!$user)&nbsp;{\r\n&nbsp;&nbsp;User::create([\r\n&nbsp;&nbsp;&nbsp;&nbsp;&#39;email&#39;&nbsp;=&gt;&nbsp;$email\r\n&nbsp;&nbsp;]);\r\n}</pre><p>这样写就可以了：</p><pre style=\"background:#bfbfbf\">$user&nbsp;=&nbsp;User::firstOrCreate([&#39;email&#39;&nbsp;=&gt;&nbsp;$email]);</pre><hr/><h2>3. 模型的 boot() 方法</h2><p>在一个 Eloquent 模型中，有个神奇的地方，叫 <code>boot()</code>，在那里，你可以覆盖默认的行为：</p><pre style=\"background:#bfbfbf\">class&nbsp;User&nbsp;extends&nbsp;Model\r\n{\r\n&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;static&nbsp;function&nbsp;boot()\r\n&nbsp;&nbsp;&nbsp;&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;parent::boot();\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;static::updating(function($model)\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;写点日志啥的\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;覆盖一些属性，类似这样&nbsp;$model-&gt;something&nbsp;=&nbsp;transform($something);\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});\r\n&nbsp;&nbsp;&nbsp;&nbsp;}\r\n}</pre><p>在创建模型对象时设置某些字段的值，大概是最受欢迎的例子之一了。 一起来看看在创建模型对象时，你想要生成 <a href=\"https://link.zhihu.com/?target=https%3A//github.com/webpatser/laravel-uuid\" class=\" wrap external\" target=\"_blank\">UUID 字段</a> 该怎么做。</p><pre style=\"background:#bfbfbf\">public&nbsp;static&nbsp;function&nbsp;boot()\r\n{\r\n&nbsp;&nbsp;parent::boot();\r\n&nbsp;&nbsp;self::creating(function&nbsp;($model)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;$model-&gt;uuid&nbsp;=&nbsp;(string)Uuid::generate();\r\n&nbsp;&nbsp;});\r\n}</pre><hr/><h2>4. 带条件与排序的关联关系</h2><p>定义关联关系的一般方式：</p><pre style=\"background:#bfbfbf\">public&nbsp;function&nbsp;users()&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$this-&gt;hasMany(&#39;App\\User&#39;);\r\n}</pre><p>你知道吗？也可以在上面的基础上增加 <code>where</code> 或者 <code>orderBy</code>?\\<br/>举个例子，如果你想关联某些类型的用户，同时使用 email 字段排序，你可以这样做：</p><pre style=\"background:#bfbfbf\">public&nbsp;function&nbsp;approvedUsers()&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$this-&gt;hasMany(&#39;App\\User&#39;)-&gt;where(&#39;approved&#39;,&nbsp;1)-&gt;orderBy(&#39;email&#39;);\r\n}</pre><hr/><h2>5. 模型特性：时间、追加等</h2><p>Eloquent模型有些参数，使用类的属性形式。最常用是：</p><pre style=\"background:#bfbfbf\">class&nbsp;User&nbsp;extends&nbsp;Model&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$table&nbsp;=&nbsp;&#39;users&#39;;\r\n&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$fillable&nbsp;=&nbsp;[&#39;email&#39;,&nbsp;&#39;password&#39;];&nbsp;//&nbsp;可以被批量赋值字段，如&nbsp;User::create()&nbsp;新增时，可使用字段\r\n&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$dates&nbsp;=&nbsp;[&#39;created_at&#39;,&nbsp;&#39;deleted_at&#39;];&nbsp;//&nbsp;需要被Carbon维护的字段名\r\n&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$appends&nbsp;=&nbsp;[&#39;field1&#39;,&nbsp;&#39;field2&#39;];&nbsp;//&nbsp;json返回时，附加的字段\r\n}</pre><p>不只这些，还有：</p><pre style=\"background:#bfbfbf\">protected&nbsp;$primaryKey&nbsp;=&nbsp;&#39;uuid&#39;;&nbsp;//&nbsp;更换主键\r\npublic&nbsp;$incrementing&nbsp;=&nbsp;false;&nbsp;//&nbsp;设置&nbsp;不自增长\r\nprotected&nbsp;$perPage&nbsp;=&nbsp;25;&nbsp;//&nbsp;定义分页每页显示数量（默认15）\r\nconst&nbsp;CREATED_AT&nbsp;=&nbsp;&#39;created_at&#39;;\r\nconst&nbsp;UPDATED_AT&nbsp;=&nbsp;&#39;updated_at&#39;;&nbsp;//重写&nbsp;时间字段名\r\npublic&nbsp;$timestamps&nbsp;=&nbsp;false;&nbsp;//&nbsp;设置不需要维护时间字段</pre><p>还有更多,我只列出了一些有意思的特性，具体参考文档 <a href=\"https://link.zhihu.com/?target=https%3A//github.com/laravel/framework/blob/5.6/src/Illuminate/Database/Eloquent/Model.php\" class=\" wrap external\" target=\"_blank\">abstract Model class</a> 了解所有特性.</p><hr/><h2>6. 通过 ID 查询多条记录</h2><p>所有人都知道 &nbsp;<code>find()</code> &nbsp;方法，对吧？</p><pre style=\"background:#bfbfbf\">$user&nbsp;=&nbsp;User::find(1);</pre><p>我十分意外竟然很少人知道这个方法可以接受多个 ID 的数组作为参数：</p><pre style=\"background:#bfbfbf\">$users&nbsp;=&nbsp;User::find([1,2,3]);</pre><hr/><h2>7. WhereX</h2><p>有一种优雅的方式能将这种代码：</p><pre style=\"background:#bfbfbf\">$users&nbsp;=&nbsp;User::where(&#39;approved&#39;,&nbsp;1)-&gt;get();</pre><p>转换成这种：</p><pre style=\"background:#bfbfbf\">$users&nbsp;=&nbsp;User::whereApproved(1)-&gt;get();</pre><p>对，你没有看错，使用字段名作为后缀添加到 <code>where</code> 后面，它就能通过魔术方法运行了。</p><p>另外，在 Eloquent 里也有些和时间相关的预定义方法：</p><pre style=\"background:#bfbfbf\">User::whereDate(&#39;created_at&#39;,&nbsp;date(&#39;Y-m-d&#39;));\r\nUser::whereDay(&#39;created_at&#39;,&nbsp;date(&#39;d&#39;));\r\nUser::whereMonth(&#39;created_at&#39;,&nbsp;date(&#39;m&#39;));\r\nUser::whereYear(&#39;created_at&#39;,&nbsp;date(&#39;Y&#39;));</pre><hr/><h2>8. 通过关系排序</h2><p>一个复杂一点的「技巧」。你想对论坛话题按最新发布的帖子来排序？论坛中最新更新的主题在最前面是很常见的需求，对吧？</p><p>首先，为主题的最新帖子定义一个单独的关系：</p><pre style=\"background:#bfbfbf\">public&nbsp;function&nbsp;latestPost()\r\n{\r\n&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$this-&gt;hasOne(\\App\\Post::class)-&gt;latest();\r\n}</pre><p>然后，在控制器中，我们可以实现这个「魔法」：</p><pre style=\"background:#bfbfbf\">$users&nbsp;=&nbsp;Topic::with(&#39;latestPost&#39;)-&gt;get()-&gt;sortByDesc(&#39;latestPost.created_at&#39;);</pre><hr/><h2>9. Eloquent::when() -- 不再使用 if-else</h2><p>很多人都喜欢使用&quot;if-else&quot;来写查询条件，像这样：</p><pre style=\"background:#bfbfbf\">if&nbsp;(request(&#39;filter_by&#39;)&nbsp;==&nbsp;&#39;likes&#39;)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;$query-&gt;where(&#39;likes&#39;,&nbsp;&#39;&gt;&#39;,&nbsp;request(&#39;likes_amount&#39;,&nbsp;0));\r\n}\r\nif&nbsp;(request(&#39;filter_by&#39;)&nbsp;==&nbsp;&#39;date&#39;)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;$query-&gt;orderBy(&#39;created_at&#39;,&nbsp;request(&#39;ordering_rule&#39;,&nbsp;&#39;desc&#39;));\r\n}</pre><p>有一种更好的方法 -- 使用 <code>when()</code></p><pre style=\"background:#bfbfbf\">$query&nbsp;=&nbsp;Author::query();\r\n$query-&gt;when(request(&#39;filter_by&#39;)&nbsp;==&nbsp;&#39;likes&#39;,&nbsp;function&nbsp;($q)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$q-&gt;where(&#39;likes&#39;,&nbsp;&#39;&gt;&#39;,&nbsp;request(&#39;likes_amount&#39;,&nbsp;0));\r\n});\r\n$query-&gt;when(request(&#39;filter_by&#39;)&nbsp;==&nbsp;&#39;date&#39;,&nbsp;function&nbsp;($q)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$q-&gt;orderBy(&#39;created_at&#39;,&nbsp;request(&#39;ordering_rule&#39;,&nbsp;&#39;desc&#39;));\r\n});</pre><p>它可能看上去不是很优雅，但它强大的功能是传递参数：</p><pre style=\"background:#bfbfbf\">$query&nbsp;=&nbsp;User::query();\r\n$query-&gt;when(request(&#39;role&#39;,&nbsp;false),&nbsp;function&nbsp;($q,&nbsp;$role)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$q-&gt;where(&#39;role_id&#39;,&nbsp;$role);\r\n});\r\n$authors&nbsp;=&nbsp;$query-&gt;get();</pre><hr/><h2>10. 一对多返回默认模型对象</h2><p>假设现在有种情况是要显示文章的作者，然后模板代码是：</p><pre style=\"background:#bfbfbf\">{{&nbsp;$post-&gt;author-&gt;name&nbsp;}}</pre><p>但是如果作者的信息被删除或者因为某些原因没有被设置。代码会返回一个错误，诸如 &quot;property of non-object&quot;。</p><p>当然你可以这样处理：</p><pre style=\"background:#bfbfbf\">{{&nbsp;$post-&gt;author-&gt;name&nbsp;??&nbsp;&#39;&#39;&nbsp;}}</pre><p>你可以通过 Eloquent 关系这样做:</p><pre style=\"background:#bfbfbf\">public&nbsp;function&nbsp;author()\r\n{\r\n&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$this-&gt;belongsTo(&#39;App\\Author&#39;)-&gt;withDefault();\r\n}</pre><p>在此示例中，如果文字没有作者的信息， <code>author()</code> 会返回一个空的 <code>App\\Author</code> 模型对象。</p><p>再者，我们也可以给默认的模型对象里面的属性赋默认值。</p><pre style=\"background:#bfbfbf\">public&nbsp;function&nbsp;author()\r\n{\r\n&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$this-&gt;belongsTo(&#39;App\\Author&#39;)-&gt;withDefault([\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;name&#39;&nbsp;=&gt;&nbsp;&#39;Guest&nbsp;Author&#39;\r\n&nbsp;&nbsp;&nbsp;&nbsp;]);\r\n}</pre><hr/><h2>11. 通过赋值函数进行排序</h2><p>想象一下你有这样的代码:</p><pre style=\"background:#bfbfbf\">function&nbsp;getFullNameAttribute()\r\n{\r\n&nbsp;&nbsp;return&nbsp;$this-&gt;attributes[&#39;first_name&#39;]&nbsp;.&nbsp;&#39;&nbsp;&#39;&nbsp;.&nbsp;$this-&gt;attributes[&#39;last_name&#39;];\r\n}</pre><p>现在,你想要通过 &quot;full_name&quot; 进行排序? 发现是没有效果的:</p><pre style=\"background:#bfbfbf\">$clients&nbsp;=&nbsp;Client::orderBy(&#39;full_name&#39;)-&gt;get();&nbsp;//没有效果</pre><p>解决办法很简单.我们需要在获取结果后对结果进行排序.</p><pre style=\"background:#bfbfbf\">$clients&nbsp;=&nbsp;Client::get()-&gt;sortBy(&#39;full_name&#39;);&nbsp;//&nbsp;成功!</pre><p>注意的是方法名称是不相同的 -- 它不是orderBy,而是sortBy</p><hr/><h2>12. 全局作用域下的默认排序</h2><p>如果你想要 <code>User::all()</code> 总是按照 <code>name</code> 字段来排序呢？ 你可以给它分配一个全局作用域。让我们回到 <code>boot()</code> 这个我们在上文提到过的方法：</p><pre style=\"background:#bfbfbf\">protected&nbsp;static&nbsp;function&nbsp;boot()\r\n{\r\n&nbsp;&nbsp;&nbsp;&nbsp;parent::boot();\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;按照&nbsp;name&nbsp;正序排序\r\n&nbsp;&nbsp;&nbsp;&nbsp;static::addGlobalScope(&#39;order&#39;,&nbsp;function&nbsp;(Builder&nbsp;$builder)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$builder-&gt;orderBy(&#39;name&#39;,&nbsp;&#39;asc&#39;);\r\n&nbsp;&nbsp;&nbsp;&nbsp;});\r\n}</pre><p>扩展阅读 <a href=\"https://link.zhihu.com/?target=https%3A//laravel.com/docs/5.6/eloquent%23query-scopes\" class=\" wrap external\" target=\"_blank\">查询作用域</a> 。</p><hr/><h2>13. 原生查询方法</h2><p>有时候，我们需要在 Eloquent 语句中添加原生查询。 幸运的是，确实有这样的方法。</p><pre style=\"background:#bfbfbf\">//&nbsp;whereRaw\r\n$orders&nbsp;=&nbsp;DB::table(&#39;orders&#39;)\r\n&nbsp;&nbsp;&nbsp;&nbsp;-&gt;whereRaw(&#39;price&nbsp;&gt;&nbsp;IF(state&nbsp;=&nbsp;&quot;TX&quot;,&nbsp;?,&nbsp;100)&#39;,&nbsp;[200])\r\n&nbsp;&nbsp;&nbsp;&nbsp;-&gt;get();\r\n\r\n//&nbsp;havingRaw\r\nProduct::groupBy(&#39;category_id&#39;)-&gt;havingRaw(&#39;COUNT(*)&nbsp;&gt;&nbsp;1&#39;)-&gt;get();\r\n\r\n//&nbsp;orderByRaw\r\nUser::where(&#39;created_at&#39;,&nbsp;&#39;&gt;&#39;,&nbsp;&#39;2016-01-01&#39;)\r\n&nbsp;&nbsp;-&gt;orderByRaw(&#39;(updated_at&nbsp;-&nbsp;created_at)&nbsp;desc&#39;)\r\n&nbsp;&nbsp;-&gt;get();</pre><hr/><h2>14. 复制：复制一行的副本</h2><p>很简单。说明不是很深入，下面是复制数据库实体（一条数据）的最佳方法：</p><pre style=\"background:#bfbfbf\">$task&nbsp;=&nbsp;Tasks::find(1);\r\n$newTask&nbsp;=&nbsp;$task-&gt;replicate();\r\n$newTask-&gt;save();</pre><hr/><h2>15. Chunk() 方法之大块数据</h2><p>与 Eloquent 不完全相关,它更多的关于 Collection (集合),但是对于处理大数据集合,仍然是很有用的。你可以使用 chunk() 将这些数据分割成小数据块</p><p>修改前:</p><pre style=\"background:#bfbfbf\">$users&nbsp;=&nbsp;User::all();\r\nforeach&nbsp;($users&nbsp;as&nbsp;$user)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;...</pre><p>你可以这样做:</p><pre style=\"background:#bfbfbf\">User::chunk(100,&nbsp;function&nbsp;($users)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;foreach&nbsp;($users&nbsp;as&nbsp;$user)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;...\r\n&nbsp;&nbsp;&nbsp;&nbsp;}\r\n});</pre><hr/><h2>16. 创建模型时创建额外的东西</h2><p>我们都知道Artisan命令：</p><pre style=\"background:#bfbfbf\">php&nbsp;artisan&nbsp;make:model&nbsp;Company</pre><p>但是，你知道有三个有用的标记可以为模型生成相关文件吗？</p><pre>php&nbsp;artisan&nbsp;make:model&nbsp;Company&nbsp;-mcr</pre><p><br/></p><ul class=\" list-paddingleft-2\"><li><p>-m 将创建一个迁移文件</p></li><li><p>-c 将创建一个控制器</p></li><li><p>-r 表示控制器应该是一个资源控制器</p></li></ul><hr/><h2>17. 调用 save 方法的时候指定 updated_at</h2><p>你知道 &nbsp;<code>-&gt;save()</code> 方法可以接受参数吗? 我们可以通过传入参数阻止它的默认行为：更新 &nbsp;<code>updated_at</code> &nbsp;的值为当前时间戳。</p><pre style=\"background:#bfbfbf\">$product&nbsp;=&nbsp;Product::find($id);\r\n$product-&gt;updated_at&nbsp;=&nbsp;&#39;2019-01-01&nbsp;10:00:00&#39;;\r\n$product-&gt;save([&#39;timestamps&#39;&nbsp;=&gt;&nbsp;false]);</pre><p>这样，我们成功在 &nbsp;<code>save</code> &nbsp;时指定了 &nbsp;<code>updated_at</code> &nbsp;的值。</p><hr/><h2>18. update() 的结果是什么？</h2><p>你是否想知道这段代码实际上返回什么？</p><pre style=\"background:#bfbfbf\">$result&nbsp;=&nbsp;$products-&gt;whereNull(&#39;category_id&#39;)-&gt;update([&#39;category_id&#39;&nbsp;=&gt;&nbsp;2]);</pre><p>我是说，更新操作是在数据库中执行的，但 <code>$result</code> 会包含什么？</p><p>答案是受影响的行。 因此如果你想检查多少行受影响， 你不需要额外调用其他任何内容 -- <code>update()</code> 方法会给你返回此数字。</p><hr/><h2>19. 把括号转换成 Eloquent 查询</h2><p>如果你有个 <code>and</code> 和 <code>or</code> 混合的 SQL 查询，像这样子的：</p><pre style=\"background:#bfbfbf\">...&nbsp;WHERE&nbsp;(gender&nbsp;=&nbsp;&#39;Male&#39;&nbsp;and&nbsp;age&nbsp;&gt;=&nbsp;18)&nbsp;or&nbsp;(gender&nbsp;=&nbsp;&#39;Female&#39;&nbsp;and&nbsp;age&nbsp;&gt;=&nbsp;65)</pre><p>怎么用 Eloquent 来翻译它呢？ 下面是一种错误的方式：</p><pre style=\"background:#bfbfbf\">$q-&gt;where(&#39;gender&#39;,&nbsp;&#39;Male&#39;);\r\n$q-&gt;orWhere(&#39;age&#39;,&nbsp;&#39;&gt;=&#39;,&nbsp;18);\r\n$q-&gt;where(&#39;gender&#39;,&nbsp;&#39;Female&#39;);\r\n$q-&gt;orWhere(&#39;age&#39;,&nbsp;&#39;&gt;=&#39;,&nbsp;65);</pre><p>顺序就没对。正确的打开方式稍微复杂点，使用闭包作为子查询：</p><pre style=\"background:#bfbfbf\">$q-&gt;where(function&nbsp;($query)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;$query-&gt;where(&#39;gender&#39;,&nbsp;&#39;Male&#39;)\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;where(&#39;age&#39;,&nbsp;&#39;&gt;=&#39;,&nbsp;18);\r\n})-&gt;orWhere(function($query)&nbsp;{\r\n&nbsp;&nbsp;&nbsp;&nbsp;$query-&gt;where(&#39;gender&#39;,&nbsp;&#39;Female&#39;)\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;where(&#39;age&#39;,&nbsp;&#39;&gt;=&#39;,&nbsp;65);\r\n})</pre><hr/><h2>20. 复数参数的 orWhere</h2><p>终于，你可以传递阵列参数给 <code>orWhere()</code>。平常的方式：</p><pre style=\"background:#bfbfbf\">$q-&gt;where(&#39;a&#39;,&nbsp;1);\r\n$q-&gt;orWhere(&#39;b&#39;,&nbsp;2);\r\n$q-&gt;orWhere(&#39;c&#39;,&nbsp;3);</pre><p>你可以这样做：</p><pre style=\"background:#bfbfbf\">$q-&gt;where(&#39;a&#39;,&nbsp;1);\r\n$q-&gt;orWhere([&#39;b&#39;&nbsp;=&gt;&nbsp;2,&nbsp;&#39;c&#39;&nbsp;=&gt;&nbsp;3]);</pre><p><strong>本文来自：<a href=\"https://zhuanlan.zhihu.com/p/35807856\" target=\"_blank\">https://zhuanlan.zhihu.com/p/35807856</a></strong></p>',0,32,'2018-08-10 10:56:43','2018-08-23 17:15:39');
/*!40000 ALTER TABLE `artisan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联用户id',
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '分类名',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,1,'php','2018-08-08 15:04:57','2018-08-08 15:04:57'),(2,1,'H5','2018-08-09 11:55:31','2018-08-09 11:55:31');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `artisan_id` int(11) NOT NULL COMMENT '关联文章id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联用户id',
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '评论内容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,1,2,'1111q\\','2018-08-09 09:32:17','2018-08-09 09:32:17'),(2,1,2,'ceshi','2018-08-09 09:49:31','2018-08-09 09:49:31'),(3,3,2,'很棒的音响，你值得拥有','2018-08-09 10:33:41','2018-08-09 10:33:41'),(4,3,1,'音质不错','2018-08-09 10:44:23','2018-08-09 10:44:23'),(5,6,1,'很棒的文章，学习了。','2018-08-23 17:15:39','2018-08-23 17:15:39');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (8,'2018_05_22_032819_create_aritsan_table',2),(58,'2014_10_12_000000_create_users_table',3),(59,'2014_10_12_100000_create_password_resets_table',3),(60,'2016_06_01_000001_create_oauth_auth_codes_table',3),(61,'2016_06_01_000002_create_oauth_access_tokens_table',3),(62,'2016_06_01_000003_create_oauth_refresh_tokens_table',3),(63,'2016_06_01_000004_create_oauth_clients_table',3),(64,'2016_06_01_000005_create_oauth_personal_access_clients_table',3),(65,'2018_05_22_032819_create_artisan_table',3),(66,'2018_06_29_093732_create_comments_table',3),(67,'2018_07_02_103013_create_category_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮箱',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `is_admin` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是管理员',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片地址',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'mir cheng','cheng@erpboost.com','$2y$10$cFW9M7m/9RMbuq1K1/Tk8.G/p35ad7DI.a98jQWe3k3tEj01kpTbi',1,NULL,'jMZFDNaA0CerBqmms1fsiAnS7W8SphtWld6aUYr5voH2XgxgZQcbneroeR8T','2018-08-07 17:28:41','2018-08-07 17:28:41'),(2,'dawn','dawn@eluotech.com','$2y$10$CteijDqhuINJ3tb6hKZKpe/mrmGbY/FzYvuqsurJvl//OtpLAscEm',0,NULL,'9Gk0FeINeEzwHorB4ww4BVecc3bAyN7pH3K3Q5nNvksfHgNAfMdZrTNiAJjj','2018-08-07 17:53:25','2018-08-07 17:53:25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-25  3:15:18
