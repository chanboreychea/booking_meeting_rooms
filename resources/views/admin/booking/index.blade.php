@extends('template.master')

@section('title', 'Booking Room')

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

    <div class="card">
        <div class="card-header bg-muted">
            <h5 class="text-danger">ការស្នើសុំកក់បន្ទប់ប្រជំុ</h5>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered bg-light">
                <thead class="thead-light">
                    <th class="text-center">ល.រ</th>
                    <th class="text-center">កាលបរិច្ឆេទ</th>
                    <th class="text-center">ប្រធានបទ</th>
                    <th class="text-center">ដឹកនាំដោយ</th>
                    <th class="text-center">ឈ្មោះអ្នកដឹកនាំ</th>
                    <th class="text-center">កម្រិតប្រជុំ</th>
                    <th class="text-center">បន្ទប់</th>
                    <th class="text-center">ម៉ោង</th>
                    <th class="text-center">ឈ្មោះអ្នកកក់</th>
                    <th class="text-center">គោលបំណង</th>
                    <th class="text-center">អនុញ្ញាត</th>
                </thead>
                <tbody class="bg-light">
                    @foreach ($booking as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-center">{{ $item->date }}</td>
                            <td class="text-center">{{ $item->topicOfMeeting }}</td>
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
                                                    <input type="submit" name="reject" class="btn btn-danger"
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

    <div class="card mt-20">
        <div class="card-header bg-gray">
            <form action="/booking" action="GET">
                @csrf
                <div class="row d-flex align-items-center">

                    <div class="col-lg-2 col-sm-12">
                        <div class="input-group">
                            <span class="input-group-text text-danger" id="basic-addon1">ដឹកនាំដោយ</span>
                            <select class="form-control" name="directedBy" id="directedBy">
                                <option value="">ជ្រើសរើស</option>
                                <option value="ប្រធានអង្គភាព">
                                    ប្រធានអង្គភាព
                                </option>
                                <option value="អនុប្រធានអង្គភាព">អនុប្រធានអង្គភាព</option>
                                @foreach ($departments as $key => $offices)
                                    <option value="ប្រធាននាយកដ្ឋាន{{ $key }}">
                                        ប្រធាននាយកដ្ឋាន
                                        {{ $key }}</option>
                                    <option value="អនុប្រធាននាយកដ្ឋាន{{ $key }}">
                                        អនុប្រធាននាយកដ្ឋាន
                                        {{ $key }}</option>
                                    @foreach ($offices as $key => $item)
                                        <option value="ប្រធានការិយាល័យ{{ $item }}">ប្រធានការិយាល័យ
                                            {{ $item }}</option>

                                        <option value="អនុប្រធានការិយាល័យ{{ $item }}">អនុប្រធានការិយាល័យ
                                            {{ $item }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="input-group">
                            <span class="input-group-text text-danger" id="basic-addon1">ចាប់ពី</span>
                            <input type="date" name="fromDate" min="{{ now()->subMonths(3)->format('Y-m-d') }}"
                                max="{{ now()->format('Y-m-d') }}" class="form-control" aria-describedby="basic-addon1">
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="input-group">
                            <span class="input-group-text text-danger" id="basic-addon1">ដល់</span>
                            <input type="date" name="toDate" class="form-control" aria-describedby="basic-addon1">
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-12">
                        <div class="input-group">
                            <span class="input-group-text text-danger" id="basic-addon1">បន្ទប់</span>
                            <select class="form-control" name="room" id="basic-addon1">
                                <option value="">ជ្រើសរើសបន្ទប់</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12">
                        <div class="row">
                            <div class="col"><input class="btn btn-success w-100 text-white" type="submit"
                                    value="Filter"></div>
                            <div class="col"><a href="/booking/export/excel"
                                    class="btn btn-success w-100 text-white">Export</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body bg-gray">

            <table class="table table-sm table-bordered">
                <thead class="thead-light">
                    <th class="text-center">ល.រ</th>
                    <th class="text-center">កាលបរិច្ឆេទ</th>
                    <th class="text-center">ប្រធានបទ</th>
                    <th class="text-center">ដឹកនាំដោយ</th>
                    <th class="text-center">ឈ្មោះអ្នកដឹកនាំ</th>
                    <th class="text-center">កម្រិតប្រជុំ</th>
                    <th class="text-center">បន្ទប់</th>
                    <th class="text-center">ម៉ោង</th>
                    <th class="text-center">ឈ្មោះអ្នកកក់</th>
                    <th class="text-center">គោលបំណង</th>
                    <th class="text-center">ការស្នើ</th>
                    <th class="text-center">ពិនិត្យ</th>
                </thead>
                <tbody>
                    @foreach ($isApproveBooking as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-center">{{ $item->date }}</td>
                            <td class="text-center">{{ $item->topicOfMeeting }}</td>
                            <td class="text-center">{{ $item->directedBy }}</td>
                            <td class="text-center">{{ $item->nameDirectedBy }}</td>
                            <td class="text-center">
                                <div data-toggle="tooltip" data-html="true"
                                    title="{{ $item->interOfficeOrDepartmental }}">
                                    {{ $item->meetingLevel }}
                                </div>
                                {{-- <div class="meetingLevelShow">{{ $item->meetingLevel }}</div>
                                <div class="showOfficeAndDepartment">
                                    {{ $item->relevantOfficeAndDepartment }}
                                </div> --}}
                            </td>
                            <td class="text-center">{{ $item->room }}</td>
                            <td class="text-center">{{ $item->time }}</td>
                            <td class="text-center">{{ $item->name }}</td>
                            <td class="text-center">{{ $item->description }}</td>

                            @if ($item->isApprove == 1)
                                <td class="text-center text-success">អនុញ្ញាត</td>
                            @elseif ($item->isApprove == 2)
                                <td class="text-center text-danger">បដិសេធ</td>
                            @else
                            @endif

                            <td class="text-center">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#exampleModal{{ $item->id }}">
                                    កែប្រែ
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
                                                    <input type="submit" name="reject" class="btn btn-danger"
                                                        value="បដិសេធ">
                                                    <input type="submit" name="approve" class="btn btn-primary"
                                                        value="អនុញ្ញាត">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#deleteRecord{{ $item->id }}">
                                    លុប
                                </button>
                                <div class="modal fade" id="deleteRecord{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    លុបការកក់បន្ទប់ប្រជុំ</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="/booking/{{ $item->id }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input class="btn btn-primarយ btn-sm" type="submit" value="យល់ព្រម">
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
    </div>

    <script>
        //message
        $('#success-alert, #error-alert').fadeIn('slow');
        setTimeout(function() {
            $('#success-alert, #error-alert').fadeOut('slow');
        }, 5000);
    </script>

@endsection
