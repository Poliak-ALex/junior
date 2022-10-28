<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    use HasFactory;

    protected $table = 'links';

    protected $guarded = array();
    
    // public $timestamps = false;

    // public function updateStatistics($id)
    // {
    //     $record = static::where('id_banner','=',$id)->where('date','=',date("Y-m-d"))->get();

    //     if(isset($record[0]))
    //     {
    //         $record[0]->update([
    //             'impression_counter' => $record[0]->impression_counter + 1,
    //         ]);
    //     }
        
    //     else
    //     {
    //         static::create([
    //             'id_banner'             => $id,
    //             'impression_counter'    => 1,
    //             'date'                  => date("Y-m-d"),
    //         ]);
    //     }
    // }

    public function getData($id)
    {
        return static::orderBy('id','desc')->where('user_id','=',$id)->get();
    }

    protected $fillable = [
        'user_id',
        'primary_link',
        'generated_link', 
        'count',
    ];
}
