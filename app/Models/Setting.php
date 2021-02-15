<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * 获取系统配置的值
     *
     * @param $name
     * @param null $default
     * @return \Illuminate\Database\Concerns\BuildsQueries|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|Model|mixed|object|null
     */
    public static function getValue($name, $default = null)
    {
        $first = self::query()->when('name', $name)->first();
        return $first ? $first->value : $default;
    }

    /**
     * 设置系统配置
     *
     * @param $name
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public static function setValue($name,$value)
    {
        return self::query()->create([
            'name' => $name,
            'value' => $value
        ]);
    }

    /**
     * 获取所有配置
     *
     * @param array $filter
     * @return \Illuminate\Support\Collection
     */
    public static function getAll(array $filter = [])
    {
        if(count($filter) > 0){
            $list = self::query()->whereIn('name',$filter)->get();
        }else{
            $list = self::query()->get();
        }
        return collect(array_column($list->toArray(),'value','name'));
    }
}
