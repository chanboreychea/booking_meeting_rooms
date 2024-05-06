@extends('template.master')

@section('contents')
    <div class="row table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <th class="text-center">ល.រ</th>
                <th class="text-center">កាលបរិច្ឆេទ</th>
                <th class="text-center">ប្រធានបទ</th>
                <th class="text-center">ដឹកនាំដោយ</th>
                <th class="text-center">ឈ្មោះអ្នកដឹកនាំ</th>
                <th class="text-center">កម្រិតប្រជុំ</th>
                <th class="text-center">បន្ទប់</th>
                <th class="text-center">ម៉ោង</th>
                <th class="text-center">គោលបំណង</th>
                <th class="text-center">ការស្នើរ</th>
                <th class="text-center">កែប្រែ</th>
            </thead>
            <tbody>
                @foreach ($booking as $key => $item)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="text-center">{{ $item->date }}</td>
                        <td class="text-center text-oneline">{{ $item->topicOfMeeting }}</td>
                        <td class="text-center">{{ $item->directedBy }}</td>
                        <td class="text-center">{{ $item->nameDirectedBy }}</td>
                        <td class="text-center">
                            <div data-toggle="tooltip" data-html="true" title="{{ $item->interOfficeOrDepartmental }}">
                                {{ $item->meetingLevel }}
                            </div>
                            {{-- <div class="meetingLevelShow">{{ $item->meetingLevel }}</div>
                            <div class="showOfficeAndDepartment">
                                {{ $item->relevantOfficeAndDepartment }}
                            </div> --}}
                        </td>
                        <td class="text-center">{{ $item->room }}</td>
                        <td class="text-center">{{ $item->time }}</td>
                        <td class="text-center cardd">
                            <p class="modernWay">{{ $item->description }}</p>
                        </td>
                        @if ($item->isApprove == 1)
                            <td class="text-center text-success">អនុញ្ញាត</td>
                        @elseif ($item->isApprove == 2)
                            <td class="text-center text-danger">បដិសេធ</td>
                        @else
                            <td class="text-center text-primary">រងចាំ...</td>
                        @endif
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#deleteRecord{{ $item->id }}">
                                បោះបង់
                            </button>
                            <div class="modal fade" id="deleteRecord{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                លុបការកក់បន្ទប់ប្រជុំ</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="/booking/{{ $item->id }}/user" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input class="btn btn-primary btn-sm" type="submit" value="យល់ព្រម">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
