<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model { protected $guarded=[]; protected function casts(): array { return ['items'=>'array','total'=>'decimal:2']; } }
