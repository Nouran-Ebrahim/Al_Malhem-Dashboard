@extends('common::layouts.master')


@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">تعديل البيانات الخاصه بــ {{ $welcomemessage['title'] }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{ url('admin/welcomeMessages/' . $welcomemessage->id) }}"
                    method="POST" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> الاسم</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" id="fname-icon" value="{{ $welcomemessage->title }}"
                                            class="form-control" name="title" placeholder="العنوان" />
                                        @error('title')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-iconn"> الوصف</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" id="fname-icon" value="{{ $welcomemessage->description }}"
                                            class="form-control" name="description" placeholder="العنوان" />
                                        @error('description')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3 text-center">
                                        <label class="col-form-label" for="pass-icon">الصوره</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i data-feather="image"></i></span>
                                            <input type="file" id="pass-icon" class="form-control" name="image"
                                                placeholder="image" />
                                           
                                        </div>
                                    </div>
                                </div>

                                @if ($welcomemessage->image != null)
                                    <div class="images-container  d-flex flex-row flex-wrap"
                                        style="display: flex !important;margin-right:25%">

                                        <div class="image-container position-relative"
                                            style="width: 100px; height: 100px;margin: 2px 7px;margin-top:10px">
                                            <img style="width: 100%; height: 100%"
                                                src="{{ asset($welcomemessage->image) }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-sm-9 offset-sm-3 mt-2">
                                <div class="mb-1">
                                    <div class="form-check">
                                        <input type="checkbox" value="1"
                                            @if ($welcomemessage->is_active == 1) checked @endif name="is_active"
                                            class="form-check-input" id="customCheck2" />
                                        <label class="form-check-label" for="customCheck2">تفعيل</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary me-1">تعديل</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>
@endsection
