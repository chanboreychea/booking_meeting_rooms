@extends('template.master')
@section('title', 'User')
@section('contents')

    <div class="card">
        <div class="card-header">
            <h5 class="m-0"><a href="/users/create" class="btn btn-success btn-sm">បន្ថែមមន្ត្រី</a></h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th class="nowrap">ល.រ</th>
                        <th class="nowrap">ឈ្មោះ</th>
                        <th class="nowrap">អ៊ីម៉ែល</th>
                        <th class="nowrap">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td scope="row">{{ $key + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <form class="me-2" action="/users/{{ $user->id }}/edit">
                                        @csrf
                                        <input class="btn btn-primary btn-sm" type="submit" value="កែសម្រួល">
                                    </form>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteRecord{{ $user->id }}">
                                        លុប
                                    </button>
                                </div>
                            </td>
                            <div class="modal fade" id="deleteRecord{{ $user->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                {{ 'លុបមន្ត្រី​' }} {{ $user->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="/users/{{ $user->id }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input class="btn btn-primary btn-sm" type="submit" value="យល់ព្រម">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



@endsection
