<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $date
 * @property string $shop
 * @property string $article
 * @property float $count
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShop($value)
 * @mixin \Eloquent
 */
class Order extends Model
{

}
