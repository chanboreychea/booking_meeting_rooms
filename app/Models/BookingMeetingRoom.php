<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingMeetingRoom extends Model
{
    use HasFactory;
    protected $table = 'booking_meeting_rooms';
    protected $fillable = [
        'userId',
        'date',
        'topicOfMeeting',
        'directedBy',
        'nameDirectedBy',
        'meetingLevel',
        'interOfficeOrDepartmental',
        'member',
        'room',
        'time',
        'description',
        'isApprove'
    ];
}
