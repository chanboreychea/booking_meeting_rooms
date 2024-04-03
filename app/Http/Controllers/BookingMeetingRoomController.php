<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Enum\Status;
use App\Models\User;
use App\Models\Booking;
use App\Enum\Department;
use Illuminate\Http\Request;
use App\Models\BookingMeetingRoom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingMeetingRoomExport;

class BookingMeetingRoomController extends Controller
{
    public function showBookingMeetingRooms()
    {
        if (session('is_user_logged_in')) {
            return redirect('/calendar');
        }

        if (session('is_admin_logged_in')) {
            return redirect('/booking');
        }

        $booking = DB::table('booking_meeting_rooms')
            ->join('users', 'users.id', '=', 'booking_meeting_rooms.userId')
            ->where('booking_meeting_rooms.date', '>=', Carbon::now()->format('Y-m-d'))
            ->where('isApprove', Status::APPROVE)
            ->orderByDesc('date')
            ->select(
                'users.email',
                'users.name',
                'booking_meeting_rooms.id',
                'date',
                'userId',
                'topicOfMeeting',
                'directedBy',
                'meetingLevel',
                'member',
                'description',
                'room',
                'time'
            )->get();

        return view('user.booking.showBookingMeetingRooms', compact('booking'));
    }

    public function index(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $room = $request->input('room');
        $directedBy = $request->input('directedBy');

        $query = DB::table('booking_meeting_rooms')
            ->join('users', 'users.id', '=', 'booking_meeting_rooms.userId')
            ->select(
                'booking_meeting_rooms.id',
                'users.name',
                'users.email',
                'date',
                'topicOfMeeting',
                'directedBy',
                'meetingLevel',
                'member',
                'room',
                'time',
                'description',
                'isApprove'
            );


        $approve = clone $query;
        $pending = clone $query;

        if ($fromDate && $toDate) {
            $approve->whereBetween('date', [Carbon::parse($fromDate)->format('Y-m-d'), Carbon::parse($toDate)->format('Y-m-d')]);
        } else {
            $approve->where('date', '>=', Carbon::now()->format('Y-m-d'));
        }

        if ($room) {
            $approve->where('room', $room);
        }

        if ($directedBy) {
            $approve->where('directedBy', $directedBy);
        }

        $isApproveBooking = $approve->where('isApprove', '!=', Status::PENDING)->orderByDesc('date')->get();

        $booking = $pending->where('date', '>=', Carbon::now()->format('Y-m-d'))->where('isApprove', Status::PENDING)->orderByDesc('date')->get();

        $departments = Department::DEPARTMENTS;

        return view('admin.booking.index', compact('booking', 'isApproveBooking', 'departments'));
    }

    public function showUserBooking()
    {
        // $last_thirtyDay = $this->getDatesByPeriodName('last_30_days', Carbon::now());

        $booking = BookingMeetingRoom::where('userId', session('user_id'))

            // ->whereBetween('date', [$last_thirtyDay[0], $last_thirtyDay[1]])
            // ->where('date', '>=', Carbon::now())
            ->orderByDesc('date')->limit(30)
            ->get();

        return view('user.booking.showUserBooking', compact('booking'));
    }

    public function exportBookingMeetingRoom(Request $request)
    {
        $previousUrl = URL::previous();
        $parsedUrl = parse_url($previousUrl);
        $defaultDate = $this->getDatesByPeriodName('this_month', Carbon::now());

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
            $fromDate = $queryParams['fromDate'];
            $toDate = $queryParams['toDate'];
            $room = $queryParams['room'];
            $directedBy = $queryParams['directedBy'];
            if ($fromDate == "") {
                $fromDate = Carbon::parse($defaultDate[0])->format('Y-m-d');
            }
            if ($toDate == "") {
                $toDate = Carbon::parse($defaultDate[1])->format('Y-m-d');
            }
        } else {
            $fromDate = Carbon::parse($defaultDate[0])->format('Y-m-d');
            $toDate = Carbon::parse($defaultDate[1])->format('Y-m-d');
        }

        $query = DB::table('booking_meeting_rooms')
            ->join('users', 'users.id', '=', 'booking_meeting_rooms.userId')
            ->select(
                'booking_meeting_rooms.id',
                'users.name',
                'users.email',
                'date',
                'topicOfMeeting',
                'directedBy',
                'meetingLevel',
                'member',
                'room',
                'time',
                'description',
            );

        if ($fromDate && $toDate) {
            $query->whereBetween('date', [Carbon::parse($fromDate)->format('Y-m-d'), Carbon::parse($toDate)->format('Y-m-d')]);
        }

        if (isset($room) && $room != null) {
            $query->where('room', $room);
        }

        if (isset($directedBy) && $directedBy != null) {
            $query->where('directedBy', $directedBy);
        }

        $booking = $query->where('isApprove', '=', Status::APPROVE)->orderByDesc('date')->get();

        return Excel::download(new BookingMeetingRoomExport($booking), 'booking_meeting_rooms.xlsx');
    }

    public function userDestroy(Request $request, string $bookingId)
    {
        $booking = BookingMeetingRoom::find($bookingId);
        $booking->delete();
        return redirect()->back()->with('message', 'Update Successfully');
    }

    public function adminDestroy(Request $request, string $bookingId)
    {
        $booking = BookingMeetingRoom::find($bookingId);
        $booking->delete();
        return redirect('/booking')->with('message', 'Update Successfully');
    }

    public function adminApprove(Request $request, string $bookingId)
    {
        $booking = BookingMeetingRoom::find($bookingId);

        $request->validate([
            'description' => 'max:255'
        ]);

        if ($request->input('description')) {
            $booking->description = $request->input('description');
        }
        if ($request->input('approve')) {
            $booking->isApprove = Status::APPROVE;
            $message = "បន្ទប់ទំនេរ" . PHP_EOL . "ប្រធានបទស្តីពី៖ $booking->topicOfMeeting" . PHP_EOL .
                "ប្រភេទបន្ទប់ប្រជុំ៖ បន្ទប់ប្រជុំ $booking->room" . PHP_EOL . "ម៉ោង៖ $booking->time";
        }
        if ($request->input('reject')) {
            $booking->isApprove = Status::REJECT;
            $message = "បន្ទប់ជាប់រវល់" . PHP_EOL . "ប្រធានបទស្តីពី៖ $booking->topicOfMeeting" . PHP_EOL .
                "ប្រភេទបន្ទប់ប្រជុំ៖ បន្ទប់ប្រជុំ $booking->room" . PHP_EOL . "ម៉ោង៖ $booking->time";
        }

        $booking->save();

        $this->sendMessage(-1002100151991, $message, "6914906518:AAH3QI2RQRA2CVPIL67B9p6mFtQm3kZwyvU");

        return redirect()->back()->with('message', 'Update Successfully');
    }

    public function calendar(Request $request)
    {
        $date = Carbon::now();

        if ($request->input('next')) {
            $next = $request->input('next');
            //version2
            // if ($next == 13) {
            //     $next = 1;
            //     $newDate = Carbon::now();
            //     $newYear = $newDate->format('Y');
            //     $date = Carbon::parse($date->format($newYear + 1 . '-' . $next . '-01'));

            // }
            if ($next > 12) {
                $date = Carbon::now()->format('Y-m-d');
            } else {
                $date = Carbon::parse($date->format('Y-' . $next . '-01'));
            }
        }

        if ($request->input('previous')) {
            $previous = $request->input('previous');
            if ($previous <= Carbon::now()->format('m')) {
                $date = Carbon::now();
            } else {
                $date = Carbon::parse($date->format('Y-' . $previous . '-01'));
            }
        }

        $dday = Carbon::parse($date)->format('d');
        $month = Carbon::parse($date)->format('m');
        $year = Carbon::parse($date)->format('y');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
        $firstDay = date('N', strtotime("$year-$month-01"));

        if ($firstDay == 7) $firstDay = 0;

        $calendar = [];
        $week = [];

        for ($i = 0; $i < $firstDay; $i++) {
            $week[] = '';
        }

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $week[] = $i;
            if (count($week) === 7) {
                $calendar[] = $week;
                $week = [];
            }
        }

        if (count($week) > 0) {
            $calendar[] = $week;
        }

        $now = Carbon::now()->format('Y');
        $now = Carbon::parse($now . '-' . $month . '-' . $dday);
        $day = $this->getDayKhmer($now->format('D'));
        $monthKh = $this->getMonthKhmer($now->format("M"));
        $date = "ថ្ងៃ $day ទី " . $now->format('d') . " ខែ $monthKh ឆ្នាំ " . $now->format('Y');

        return view('user.booking.calendar', compact('dday', 'date', 'month', 'calendar'));
    }

    public function showRoomAndTime(Request $request, string $day, int $month)
    {
        $departments = Department::DEPARTMENTS;
        $now = Carbon::now()->format('Y');
        $now = Carbon::parse($now . '-' . $month . '-' . $day);
        $day = $this->getDayKhmer($now->format('D'));
        $monthKh = $this->getMonthKhmer($now->format("M"));
        $date = "ថ្ងៃ $day ទី " . $now->format('d') . " ខែ $monthKh ឆ្នាំ " . $now->format('Y');

        $booking = DB::table('booking_meeting_rooms')
            ->join('users', 'users.id', '=', 'booking_meeting_rooms.userId')
            ->where('date', $now->format('Y-m-d'))
            ->where('isApprove', Status::APPROVE)
            ->where('userId', session('user_id'))
            ->select(
                'users.name',
                'date',
                'topicOfMeeting',
                'directedBy',
                'meetingLevel',
                'member',
                'description',
                'room',
                'time',
            )->get();

        $verifyTimesBooking = DB::table('booking_meeting_rooms')
            ->where('date', $now->format('Y-m-d'))
            ->where('isApprove', Status::APPROVE)
            ->select(
                'room',
                'time',
            )->get();

        return view('user.booking.showRoomAndTime', compact('departments', 'verifyTimesBooking', 'booking', 'now', 'date', 'day'));
    }

    public function bookingRoom(Request $request)
    {
        $request->validate([
            'topic' => 'bail|required|max:100',
            'directedBy' => 'bail|required|max:100',
            'member' => 'bail|required|digits_between:1,2',
            'description' => 'max:255',
            'room' => 'required',
            'times' => 'required'
        ], [
            'topic.required' => 'សូមបញ្ចូលនូវឈ្មោះប្រធានបទ',
            'topic.max' => 'អក្សរអនុញ្ញាតត្រឹម​ ១០០​ តួរ',
            'directedBy.required' => 'សូមបញ្ចូលនូវឈ្មោះអ្នកដឹកនាំ',
            'directedBy.max' => 'អក្សរអនុញ្ញាតត្រឹម​ ១០០​ តួរ',
            'member.required' => 'សូមបញ្ចូលនូវចំនួនសមាជិក',
            'member.min' => 'អក្សរអនុញ្ញាតតិចបំផុតត្រឹម​ ២ តួរ',
            'member.max' => 'អក្សរអនុញ្ញាតត្រឹម​ ១០០​ តួរ',
            'description.max' => 'អក្សរអនុញ្ញាតត្រឹម​ ២៥៥​ តួរ',
            'room.required' => 'សូមជ្រើសរើសបន្ទប់',
            'times.required' => 'សូមជ្រើសរើសម៉ោង',
        ]);

        $topic = $request->input('topic');
        $directedBy = $request->input('directedBy');
        $meetingLevel = $request->input('meetingLevel');
        $member = $request->input('member');
        $date = Carbon::parse($request->input('date'))->format("Y-m-d");
        $room = $request->input('room');
        $times = $request->input('times');
        $description = $request->input('description');

        $userId = session('user_id');

        $user = User::find($userId);

        DB::beginTransaction();
        try {

            BookingMeetingRoom::create([
                'userId' => $userId,
                'date' => $date,
                'topicOfMeeting' => $topic,
                'directedBy' => $directedBy,
                'meetingLevel' => $meetingLevel,
                'member' => $member,
                'room' => $room,
                'time' => $times,
                'description' => $description,
                'isApprove' => Status::PENDING
            ]);

            $today = Carbon::now();

            $user = User::find($userId);

            $message = "សំណើសុំប្រើប្រាស់បន្ទប់ប្រជុំ" . PHP_EOL . "ដឹកនាំដោយ៖ $directedBy " . PHP_EOL . "ប្រធានបទស្តីពី៖ $topic" . PHP_EOL .
                "ចំនួនសមាជិកចូលរួម៖ $member រូប" . PHP_EOL . "ប្រភេទបន្ទប់ប្រជុំ៖ បន្ទប់ប្រជុំ $room" . PHP_EOL . "កម្រិតប្រជុំ៖ $meetingLevel" . PHP_EOL .
                "កាលបរិច្ឆេទកិច្ចប្រជុំ៖ $date " . PHP_EOL .
                "ម៉ោង៖ $times" . PHP_EOL . "កាលបរិច្ឆេទស្នើសុំ៖ $today" . PHP_EOL . "អ៊ីមែល: $user->email" . PHP_EOL . "ឈ្មោះមន្រ្តីស្នើសុំ៖ $user->name";

            // $this->sendMessage(1499573227, $message, "7016210108:AAFqqisOdt9lCixJ7Hg1y9HYJosomMam2fc");
            $this->sendMessage(-1002100151991, $message, "6914906518:AAH3QI2RQRA2CVPIL67B9p6mFtQm3kZwyvU");

            DB::commit();
            return redirect('/calendar')->with('message', 'Booking Successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/calendar')->with('message', 'Please try again!!');
        }
    }

    public function sendMessage($chatId, $message, $token)
    {
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatId;
        $url = $url . "&text=" . urlencode($message);
        $ch = curl_init();
        $opt_array = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification
        );
        curl_setopt_array($ch, $opt_array);
        $result = curl_exec($ch);

        if ($result === false) {
            $error = curl_error($ch);
            // Handle the error, e.g., log it or display an error message
            // echo "cURL Error: " . $error;
            return redirect()->back()->with('message', 'Please try again!!.');
        } else {
            // Request successful, you can process the result here
            echo "Message sent successfully!";
        }

        curl_close($ch);
    }
}
