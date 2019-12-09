<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

//use SoftDeletes;



class Base extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * 批量更新的方法
     * 示例参数
     * $multipleData = [
     *    [
     *        'name' => 'name 1' ,
     *        'date' => 'date 1'
     *     ],
     *     [
     *        'name' => 'name 2' ,
     *        'date' => 'date 2'
     *      ]
     *   ]
     *
     * @param array $multipleData
     * @param bool  $flash        是否需要成功或者失败的提示
     *
     * @return bool|int
     */
    public function updateBatch(array $multipleData, $flash = true)
    {
        if (count($multipleData) <= 0) {
            return false;
        }
        $tableName = config('database.connections.mysql.prefix') . $this->getTable();
        //获取更新字段
        $updateColumn = array_keys($multipleData[0]);
        //获取更新条件字段
        $referenceColumn = $updateColumn[0];
        //删除更新数据中的更新条件
        unset($updateColumn[0]);
        //拼接 SQL 语句

        $sql = 'UPDATE ' . $tableName . ' SET ';
        foreach ($updateColumn as $uCloumn)
        {
            //更新字段
            $sql .= $uCloumn . ' = CASE';
            //更新数值
            foreach ($multipleData as $data)
            {
                $sql .= ' WHEN ' . $referenceColumn . ' = ' . $data[$referenceColumn] . ' THEN ' . $data[$uCloumn];
            }
            $sql .= ' ELSE ' . $uCloumn . ' END';
        }
        $whereIn = '';
        foreach ($multipleData as $data)
        {
            $whereIn .= "'" . $data[$referenceColumn] . "', ";
        }
        $sql .= ' WHERE ' . $referenceColumn . ' IN (' . rtrim($whereIn, ', ') . ')';

//        DB::UPDATE($sql);
        $result = DB::update(DB::raw($sql));

        $result ? flash_success('操作成功', $flash) : flash_error('操作失败', $flash);

        return $result;
//        dump($sql);
    }


}
