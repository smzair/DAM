<?php

namespace App\Models\NotificationModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientNotification extends Model
{
    use HasFactory;
    protected $table = 'client_notifications';
    protected $fillable = [ 'user_id', 'brand_id' , 'subject', 'discription'];

}
