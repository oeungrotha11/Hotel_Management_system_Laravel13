<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Booking extends Model {
    protected $fillable = ['user_id','room_id','guest_name','guest_email','check_in','check_out','guests','status','total_price'];
    protected function casts(): array { return ['check_in'=>'date','check_out'=>'date','total_price'=>'decimal:2','guests'=>'integer']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function room(): BelongsTo { return $this->belongsTo(Room::class); }
}
