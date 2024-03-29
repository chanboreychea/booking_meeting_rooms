@extends('template.master')

@section('message')
    @if ($message = Session::get('message'))
        <div class="position-absolute top-0 end-0 success-alert" id="success-alert" style="z-index:999;">
            <div class="toast show ">

                <div class="toast-header">

                    <strong class="me-auto">ការកក់បន្ទប់ប្រជុំ</strong>

                    <button type="button" class="btn-close text-white" data-bs-dismiss="toast"></button>

                </div>

                <div class="toast-body text-success">

                    <b>{{ $message }}</b>

                </div>

            </div>
        </div>
    @endif
@endsection

@section('contents')
    <div class="d-flex justify-content-center align-items-start">
        <h4>{{ $date }}</h4>
    </div>
    <div class="row mb-2 d-flex justify-content-center align-items-center">
        <div class="col">
            <form action="/calendar" method="GET">
                @csrf
                <input type="hidden" name="previous" value="{{ $month - 1 }}">
                <input type="submit" class="btn btn-sm" value="<< Previous">
            </form>
        </div>
        <div class="col d-flex justify-content-end">
            <form action="/calendar" method="GET">
                @csrf
                <input type="hidden" name="next" value="{{ $month + 1 }}">
                <input type="submit" class="btn btn-sm" value="Next >>">
            </form>
        </div>
    </div>
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
                                        <a href="/days/{{ $day }}/{{ $month }}"
                                            class="btn btn-info btn-sm days w-100">
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
