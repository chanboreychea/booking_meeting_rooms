@extends('template.master')

@section('contents')
    <div class="row table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <th class="text-center">ល.រ</th>
                <th class="text-center">កាលបរិច្ឆេទ</th>
                <th class="text-center">ប្រធានបទ</th>
                <th class="text-center">ដឹកនាំដោយ</th>
                <th class="text-center">កម្រិតប្រជុំ</th>
                <th class="text-center">បន្ទប់</th>
                <th class="text-center">ម៉ោង</th>
                <th class="text-center">ឈ្មោះអ្នកកក់</th>
                <th class="text-center">គោលបំណង</th>
            </thead>
            <tbody>
                @foreach ($booking as $key => $item)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="text-center">{{ $item->date }}</td>
                        <td class="text-center">{{ $item->topicOfMeeting }}</td>
                        <td class="text-center">{{ $item->directedBy }}</td>
                        <td class="text-center">{{ $item->meetingLevel }}</td>
                        <td class="text-center">{{ $item->room }}</td>
                        <td class="text-center">{{ $item->time }}</td>
                        <td class="text-center">{{ $item->name }}</td>
                        <td class="text-center">{{ $item->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
