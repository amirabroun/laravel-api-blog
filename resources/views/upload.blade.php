@extends('layouts.app')

<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <h2>Upload your file</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <form action="{{ route('postFile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                        @isset($error)
                        <div class="col-3 mt-3">
                            <label>
                                {{ $error }}
                            </label>
                        </div>
                        @endisset
                    </div>
                </form>
            </div>
        </div>

        @isset($path)
        <div class="m-3">
            <label>
                {{ str_replace('public', 'storage', $path) }}
            </label>
        </div>
        @endisset
    </div>
</div>