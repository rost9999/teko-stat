<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Remainder
 *
 * @property int $id
 * @property string $shop
 * @property string $article
 * @property string $date
 * @property float $count
 * @method static \Illuminate\Database\Eloquent\Builder|Remainder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Remainder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Remainder query()
 * @method static \Illuminate\Database\Eloquent\Builder|Remainder whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remainder whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remainder whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remainder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remainder whereShop($value)
 * @mixin \Eloquent
 */
class Remainder extends Model
{
    use HasFactory;
}
