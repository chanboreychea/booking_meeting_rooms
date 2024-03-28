@extends('template.master')

@section('message')
    @if ($message = Session::get('message'))
        <div class="position-absolute top-0 end-0 p-2 success-alert" id="success-alert" style="z-index:999;">

            <div class="toast show ">

                <div class="toast-header">

                    <strong class="me-auto">Booking</strong>

                </div>

                <div class="toast-body text-success">

                    <b>{{ $message }}</b>

                </div>

            </div>

        </div>
    @endif
@endsection

@section('contents')
    <div class="row table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th style="text-align: center">Sun</th>
                    <th style="text-align: center">Mon</th>
                    <th style="text-align: center">Tue</th>
                    <th style="text-align: center">Wed</th>
                    <th style="text-align: center">Thu</th>
                    <th style="text-align: center">Fri</th>
                    <th style="text-align: center">Sat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($calendar as $week)
                    <tr>
                        @foreach ($week as $key => $day)
                            @if ($key == 0 || $key == 6)
                                <td style="text-align: center">
                                    {{ $day }}
                                </td>
                            @else
                                <td>
                                    @if ($day == '')
                                    @elseif ($day >= $dday)
                                        <a href="/days/{{ $day }}" class="btn btn-info btn-sm days w-100">
                                            {{ $day }}
                                        </a>
                                    @else
                                        <div style="text-align: center">{{ $day }}</div>
                                    @endif
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
