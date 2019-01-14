<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

/**
 * This is the model cest for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "{$data['type']} \${$property}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?>Cest
{
    /**
    *
    * @param FunctionalTester $I
    * @throws Throwable
    * @throws \yii\base\Exception
    * @throws \yii\db\StaleObjectException
    */
    public function tryToTest<?= $className?>Curd(FunctionalTester $I)
    {
        //创建一个测试模型实例
        $model = new \app\models\<?=$className?>;
        <?="\n"?>
        <?php
        //该model的所有字段
        $modelColumns = [];
        foreach ($labels as $column =>$label):?>
$I->assertEmpty($model-><?=$column?>, "<?=$column?> 初始值为null");
            <?="\n"?>
        <?php endforeach; ?>
<?php
        foreach ($labels as $column =>$label):?>
$<?=$column?> = \app\common\Helper::random(9, true);
<?php
if($column === 'id'){
echo "
        //todo 判断随机生成的主键是否已经存在
";
}
?>
        $model-><?=$column?> =$<?=$column?>;
        $I->assertEquals($model-><?=$column?>,$<?=$column?>);
            <?="\n"?>
        <?php endforeach; ?>
//ensure Create
        $model->save();
        <?="\n"?>
        $I->assertNotEmpty($model->id)
        <?="\n"?>
<?php
foreach ($labels as $column =>$label):?>
        $I->assertEquals($model-><?=$column?>,$<?=$column?>);
    <?="\n"?>
<?php endforeach; ?>
        <?="\n"?>
        $I->assertTrue($model->refresh());
        <?="\n"?>
        // ensure Update
<?php
foreach ($labels as $column =>$label):?>
        $<?=$column?> = \app\common\Helper::random(9, true);
        $model-><?=$column?> =$<?=$column?>;
        $I->assertEquals($model-><?=$column?>,$<?=$column?>);
        <?="\n"?>
<?php endforeach; ?>
        <?="\n"?>
        $model->save();
        <?="\n"?>
<?php
foreach ($labels as $column =>$label):?>
        $I->assertEquals($model-><?=$column?>,$<?=$column?>);
    <?="\n"?>
<?php endforeach; ?>
        <?="\n"?>
        $I->assertTrue($model->refresh());
        <?="\n"?>

        // ensure Retrieve
        $primaryKey = $model->primaryKey;
        $modelRecord = $model::findOne($primaryKey);
        $I->assertNotEmpty($modelRecord);
        $I->assertEquals($model::className(), get_class($modelRecord));
        <?="\n"?>
<?php
foreach ($labels as $column =>$label):?>
        $I->assertEquals($model-><?=$column?>,$<?=$column?>);
    <?="\n"?>
<?php endforeach; ?>
        <?="\n"?>
        //ensure del
        $model->delete();
        $I->assertFalse($model->refresh());
}

<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * {@inheritdoc}
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
}
