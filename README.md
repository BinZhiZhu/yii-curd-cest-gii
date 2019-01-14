# yii-curd-cest-gii
基于yii-gii 实现的模型功能测试的拓展工具

##配置
1.自定义gii模板
 ```
   $config['modules']['gii'] = [
         'class' => 'yii\gii\Module',
         'generators' => [ //这里配置生成器
             'curdCest' => [ // 生成器名称
                 'class' => 'app\myTemplates\modelCest\Generator', // 生成器类
                 'templates' => [ //配置模版文件
                     'my' => '@app/myTemplates/modelCest/default', // 模版名称 => 模版路径
                 ]
             ],
         ],
     ];
 ```
