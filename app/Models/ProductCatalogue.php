<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class ProductCatalogue extends Model { use HasUuids; public $incrementing=false; protected $keyType='string'; protected $table='product_catalogue'; protected $guarded=[]; protected function casts(): array { return ['specs'=>'array']; } }
