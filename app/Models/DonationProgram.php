<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationProgram extends Model
{
  protected $fillable = [
    'user_id',
    'title',
    'summary',
    'description',
    'category',
    'target_amount',
    'end_date',
    'cover_image_path',
    'status',
  ];
}
