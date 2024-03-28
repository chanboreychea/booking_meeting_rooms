@extends('template.master')

@section('title', 'Booking Room')

@section('contents')

    @if ($message = Session::get('message'))
        <div class="container position-relative" id="success-alert">

            <div class="position-absolute top-0 end-0 p-3 success-alert" style="z-index:999;margin-top:-90px; ">

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

        </div>
    @endif

    <div class="card">
        <div class="card-header bg-info">
            <h5>រងចាំ</h5>
        </div>
        <div class="card-body">

            <table class="table table-sm table-bordered">
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
                    <th class="text-center">អនុញ្ញាត</th>
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
                            <td class="text-center">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#exampleModal{{ $item->id }}">
                                    ពិនិត្យ
                                </button>

                                <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    ការអនុញ្ញាត</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/booking/approve/{{ $item->id }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group row text-muted text-center">
                                                        <label for="description"
                                                            class="form-label col-lg-4 text-info">គោលបំណង:</label>
                                                        <div class="col-lg-8">
                                                            <textarea name="description" id="description" class="form-control" cols="30" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" name="reject" class="btn btn-primary"
                                                        value="បដិសេធ">
                                                    <input type="submit" name="approve" class="btn btn-primary"
                                                        value="អនុញ្ញាត">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header bg-primary">
            <h5>អនុញ្ញាត</h5>
        </div>
        <div class="card-body">

            <table class="table table-sm table-bordered">
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
                    <th class="text-center">អនុញ្ញាត</th>
                    <th class="text-center">កែប្រែ</th>
                </thead>
                <tbody>
                    @foreach ($isApproveBooking as $key => $item)
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

                            @if ($item->isApprove == 1)
                                <td class="text-center text-green">អនុញ្ញាត</td>
                            @elseif ($item->isApprove == 2)
                                <td class="text-center text-red">បដិសេធ</td>
                            @else
                            @endif

                            <td class="text-center">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#exampleModal{{ $item->id }}">
                                    ពិនិត្យ
                                </button>

                                <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    ការអនុញ្ញាត</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="/booking/approve/{{ $item->id }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group row text-muted text-center">
                                                        <label for="description"
                                                            class="form-label col-lg-4 text-info">គោលបំណង:</label>
                                                        <div class="col-lg-8">
                                                            <textarea name="description" id="description" class="form-control" cols="30" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" name="reject" class="btn btn-primary"
                                                        value="បដិសេធ">
                                                    <input type="submit" name="approve" class="btn btn-primary"
                                                        value="អនុញ្ញាត">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <script>
        //message
        $('#success-alert, #error-alert').fadeIn('slow');
        setTimeout(function() {
            $('#success-alert, #error-alert').fadeOut('slow');
        }, 5000);
    </script>

@endsection
