@extends('common::layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/plugins/forms/form-validation.css">
@endsection
@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"></h4>انشاء خدمة جديد</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" enctype="multipart/form-data" action="{{ url('admin/service/') }}"
                    method="POST">
                    {{ csrf_field() }}
                    <div class="row">


                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon">الوصف</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <textarea class="form-control " minlength="6" name="description" rows="20" style="direction: rtl !important;"></textarea>
                                        @error('description')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon">اسم العميل</label>
                                </div>
                                <div class="col-sm-9">
                                    {{-- <div class="input-group input-group-merge col-12"> --}}
                                    <select class="select2 form-select " name="client_id" id="default-select">

                                        @foreach ($viewModel->clients() as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach

                                    </select>
                                    {{-- </div> --}}
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> نوع الخدمة</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <select class="select form-select " name="service_type_id" id="default-select">

                                            @foreach ($viewModel->serviceTypes() as $servicetype)
                                                <option value="{{ $servicetype->id }}">{{ $servicetype->title }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon">النوع</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <select class="select form-select " name="type">
                                            <option value="offer">عرض
                                            </option>
                                            <option value="request">طلب</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> الصور</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input multiple type="file" class="form-control" name="source[]"
                                            placeholder="صوره" value="{{ old('source') }}" />
                                        {{-- @error('source')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9 offset-sm-3">
                            <div class="mb-1">
                                <div class="form-check">
                                    <input type="checkbox" value="1" name="is_active" class="form-check-input"
                                        id="customCheck2" />
                                    <label class="form-check-label" for="customCheck2">تفعيل</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary me-1">اضافة</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('') }}admin/vendors/js/forms/validation/jquery.validate.min.js"></script>

    <script src="{{ asset('') }}admin/js/scripts/forms/form-validation.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/extensions/sweetalert2.all.min.js"></script>
@endsection
