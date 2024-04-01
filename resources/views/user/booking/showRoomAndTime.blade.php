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
    <div class="row mb-3">
        <div class="card w-100 p-0">
            <h6 class="card-header bg-info text-light">
                ជ្រើសរើសបន្ទប់ និង ម៉ោង
            </h6>
            <div class="card-body bg-light">
                <div class="container-fluid" id="myGroup">
                    <div class="row">
                        <div class="col-lg-6">
                            <button id="room1" style="font-family: khmer mef1,arial;" class="btn btn-primary w-100"
                                data-toggle="collapse" value="A" href="#collapseExample" role="button"
                                aria-expanded="false" aria-controls="collapseExample">បន្ទប់ A
                            </button>
                        </div>
                        <div class="col-lg-6">
                            <button id="room2" style="font-family: khmer mef1,arial;" class="btn btn-primary w-100"
                                data-toggle="collapse" value="B" data-target="#collapseExample2" aria-expanded="false"
                                aria-controls="collapseExample2">បន្ទប់ B
                            </button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="collapse" id="collapseExample" data-parent="#myGroup">
                                <div class="card card-body">
                                    <div class="container" id="room1">
                                        <div class="row ">
                                            @for ($i = 8; $i < 12; $i++)
                                                <div class="col nowrap">
                                                    <button type="button" value="A {{ $i }}-{{ $i + 1 }}"
                                                        data-value="A {{ $i }}-{{ $i + 1 }}"
                                                        class="items btn btn-sm btn-secondary w-100 times mt-2">
                                                        {{ $i }}-{{ $i + 1 }}
                                                    </button>
                                                </div>
                                            @endfor
                                        </div>

                                        <div class="row">
                                            @for ($i = 1; $i < 5; $i++)
                                                <div class="col nowrap">
                                                    <button type="button" value="A {{ $i }}-{{ $i + 1 }}"
                                                        data-value="A {{ $i }}-{{ $i + 1 }}"
                                                        class="items btn btn-sm btn-secondary w-100 times mt-2">
                                                        {{ $i }}-{{ $i + 1 }}
                                                    </button>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="collapse" id="collapseExample2" data-parent="#myGroup">
                                <div class="card card-body">
                                    <div class="container">
                                        <div class="row">
                                            @for ($i = 8; $i < 12; $i++)
                                                <div class="col nowrap">
                                                    <button type="button"
                                                        value="B {{ $i }}-{{ $i + 1 }}"
                                                        data-value="B {{ $i }}-{{ $i + 1 }}"
                                                        class="items btn btn-sm btn-secondary w-100 times mt-2">
                                                        {{ $i }}-{{ $i + 1 }}
                                                    </button>
                                                </div>
                                            @endfor
                                        </div>
                                        <div class="row">
                                            @for ($i = 1; $i < 5; $i++)
                                                <div class="col nowrap">
                                                    <button type="button"
                                                        value="B {{ $i }}-{{ $i + 1 }}"
                                                        data-value="B {{ $i }}-{{ $i + 1 }}"
                                                        class="items btn btn-sm btn-secondary w-100 times mt-2">
                                                        {{ $i }}-{{ $i + 1 }}
                                                    </button>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- <div class="row mt-2">
                            <table class="table table-sm table-bordered fontKef1">
                                <thead style="font-size:12px">
                                    <th class="text-center">ល.រ</th>
                                    <th class="text-center">ប្រធានបទ</th>
                                    <th class="text-center">ដឹកនាំដោយ</th>
                                    <th class="text-center">កម្រិតប្រជុំ</th>
                                    <th class="text-center">បន្ទប់</th>
                                    <th class="text-center">ម៉ោង</th>
                                    <th class="text-center">ឈ្មោះអ្នកកក់</th>
                                </thead>
                                <tbody style="font-size:12px">
                                    @foreach ($booking as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">{{ $item->topicOfMeeting }}</td>
                                            <td class="text-center">{{ $item->directedBy }}</td>
                                            <td class="text-center">{{ $item->meetingLevel }}</td>
                                            <td class="text-center">{{ $item->room }}</td>
                                            <td class="text-center">{{ $item->time }}</td>
                                            <td class="text-center">{{ $item->lastNameKh }}
                                                {{ $item->firstNameKh }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card p-0">
            <h6 class="card-header bg-danger text-light">ព័ត៌មានលម្អិត</h6>
            <form action="/booking" method="POST">
                @csrf
                <div class="card-body bg-light">
                    <div class="container">
                        <input type="hidden" value="{{ $now }}" id="dateInput" name="date">
                        <input type="hidden" name="userId" value="">
                        <input type="hidden" id="roomInput" name="room">
                        <input type="hidden" id="timeInput" name="times">

                        <div class="form-group text-muted m-0">
                            <label for="inputEmail3">កាលបរិច្ឆេទ:</label>
                            <h5 id="inputEmail3" class="text-success">
                                {{ $date }}</h5>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row text-muted">
                                    <label for="roomDiv" class="col-form-label col-lg-3 ">បន្ទប់:</label>
                                    <div class="col-lg-9 p-0">
                                        <div id="roomDiv"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row text-muted">
                                    <label for="timeDiv" class="col-form-label col-lg-3 ">ម៉ោង:</label>
                                    <div class="col-lg-9 p-0">
                                        <div class="mb-0" id="timeDiv"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="topic">ប្រធានបទ:</label>
                                <input type="text" class="form-control" name="topic" id="topic"
                                    placeholder="ប្រធានបទ">
                                @error('topic')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="directedBy">ដឹកនាំដោយ:</label>

                                <input type="text" class="form-control" name="directedBy" id="directedBy"
                                    placeholder="ឈ្មោះ">

                                {{-- <select class="form-control" name="directedBy" id="directedBy">
                                    <option value="">ប្រធានអង្គភាព</option>
                                    <option value="">អនុប្រធានអង្គភាព</option>
                                    @foreach ($departments as $key => $offices)
                                        <option value="">ប្រធាននាយកដ្ឋាន {{ $key }}</option>
                                        @foreach ($offices as $item)
                                            <option value="">ប្រធានការិយាល័យ {{ $item }}</option><br>
                                        @endforeach
                                    @endforeach
                                </select> --}}
                                
                                @error('directedBy')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="meetingLevel" class="col-form-label">កម្រិតប្រជុំ:</label>
                                <select class="form-control" name="meetingLevel" id="meetingLevel">
                                    <option value="ការិយាល័យ">ការិយាល័យ</option>
                                    <option value="អន្តរការិយាល័យ">អន្តរការិយាល័យ</option>
                                    <option value="នាយកដ្ឋាន">នាយកដ្ឋាន</option>
                                    <option value="អន្តរនាយកដ្ឋាន">អន្តរនាយកដ្ឋាន</option>
                                    <option value="អង្គភាព">អង្គភាព</option>
                                    <option value="ផ្សេងៗ">ផ្សេងៗ</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="member" class="col-form-label">ចំនួនសមាជិក:</label>
                                <input type="number" min="2" max="50" class="form-control w-100"
                                    name="member" id="member" placeholder="ចំនួន">
                                @error('member')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="description" class="col-form-label">គោលបំណង:</label>
                                <div>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted d-flex justify-content-between">
                    <a href="/calendar" class="btn btn-secondary" style="font-family: khmer mef1,arial;">បោះបង់</a>
                    <input type="submit" class="btn btn-success" style="font-family: khmer mef1,arial;"
                        value="ធ្វើការកក់">
                </div>
            </form>
        </div>
    </div>

    <script>
        var room1 = document.getElementById("room1");
        var room2 = document.getElementById("room2");
        var times = document.querySelectorAll('.times');
        var timeArray = [];
        var dataFromBookingController = {!! json_encode($verifyTimesBooking) !!};

        room1.addEventListener('click', function() {
            const value = room1.value;
            timeArray.length = 0;
            document.getElementById("timeDiv").innerHTML = timeArray.join(', ');
            document.getElementById("timeInput").value = timeArray.join(', ');
            for (let i = 0; i < times.length; i++) {
                times[i].classList.remove("btn-success");
            }

            if (room1.classList.contains('btn-success')) {
                room1.classList.remove("btn-success");
                if (timeArray.length == 0) {
                    document.getElementById("roomInput").value = '';
                    document.getElementById("roomDiv").innerHTML = '';
                }
            } else {
                room1.classList.add("btn-success");
                room2.classList.remove("btn-success");
                document.getElementById("roomDiv").innerHTML = value;
                document.getElementById("roomInput").value = value;
            }

        });

        room2.addEventListener('click', function() {
            const value = room2.value;
            timeArray.length = 0;
            document.getElementById("timeDiv").innerHTML = timeArray.join(', ');
            document.getElementById("timeInput").value = timeArray.join(', ');
            for (let i = 0; i < times.length; i++) {
                times[i].classList.remove("btn-success");
            }
            if (room2.classList.contains('btn-success')) {
                room2.classList.remove("btn-success");
                if (timeArray.length == 0) {
                    document.getElementById("roomInput").value = '';
                    document.getElementById("roomDiv").innerHTML = '';
                }
            } else {
                room2.classList.add("btn-success");
                room1.classList.remove("btn-success");
                document.getElementById("roomDiv").innerHTML = value;
                document.getElementById("roomInput").value = value;
            }
        });

        for (let i = 0; i < times.length; i++) {

            for (let j = 0; j < dataFromBookingController.length; j++) {
                var explodedArray = dataFromBookingController[j]['time'].split(', ');
                // Output each substring
                explodedArray.forEach(function(substring) {
                    if (times[i].value == substring) {
                        times[i].classList.add("btn-danger");
                        times[i].disabled = true;
                    }
                });
            }
            times[i].addEventListener('click', function(event) {
                const value = event.target.value;
                var index = timeArray.indexOf(value);
                if (index !== -1) {
                    timeArray.splice(index, 1);
                } else {
                    timeArray.push(value);
                }
                document.getElementById("timeDiv").innerHTML = timeArray.join(', ');
                document.getElementById("timeInput").value = timeArray.join(', ');
                times[i].classList.toggle("btn-success");
            });
        }
    </script>
@endsection
