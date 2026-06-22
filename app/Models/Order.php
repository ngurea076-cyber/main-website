<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Order extends Model { use HasUuids; public $incrementing=false; protected $keyType='string'; protected $guarded=[]; protected function casts(): array { return ['items'=>'array','total'=>'decimal:2']; } }
