<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ClientActivityLog extends Model
{
    use HasFactory;
    protected $fillable=['log_name',
    'description',
    'event',
    'subject_type',
    'subject_id',
    'causer_type',
    'causer_id',
    'properties'
    ];

    protected $table = 'client_activity_logs';

    // Function for Get WRC list for allocation 
    public static function saveClient_activity_logs($data_array = [])
    {
        if(count($data_array) > 0){
            $ClientActivityLog = new ClientActivityLog();
            $ClientActivityLog->log_name = $data_array['log_name'];
            $ClientActivityLog->description = $data_array['description'];
            $ClientActivityLog->event = $data_array['event'];
            $ClientActivityLog->subject_type = $data_array['subject_type'];
            $ClientActivityLog->subject_id = $data_array['subject_id'];
            $ClientActivityLog->causer_type = 'App\Models\User';
            $ClientActivityLog->causer_id = Auth::id();
            $ClientActivityLog->properties = json_encode($data_array['properties']);
            $ClientActivityLog->save();
        }
    }
}
?>
