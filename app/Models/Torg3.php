<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Torg3
 *
 * @property int $id
 * @property string $article
 * @property string $name
 * @property string $tm
 * @property string $groupTT
 * @property string $torg3
 * @method static \Illuminate\Database\Eloquent\Builder|Torg3 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Torg3 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Torg3 query()
 * @method static \Illuminate\Database\Eloquent\Builder|Torg3 whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Torg3 whereGroupTT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Torg3 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Torg3 whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Torg3 whereTm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Torg3 whereTorg3($value)
 * @mixin \Eloquent
 */
class Torg3 extends Model
{
    protected $table = 'torg3';
}
