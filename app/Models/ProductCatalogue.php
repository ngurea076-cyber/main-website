<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProductCatalogue extends Model { protected $table='product_catalogue'; protected $guarded=[]; protected function casts(): array { return ['specs'=>'array']; } }
