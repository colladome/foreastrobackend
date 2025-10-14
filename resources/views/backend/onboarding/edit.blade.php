@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
            @include('messages')
            <div class="card-header">
                <h5 class="mb-0 h6">Edit Question</h5>
            </div>
            <form class="form-horizontal" action="{{ route('admin.question.update', $question->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Question</label>
                        <div class="col-sm-9">
                            <input type="text" id="title" placeholder="Question" value="{{  $question->question }}" name="question" class="form-control" autocomplete="off" required>
                            @if($errors->has('question'))
                            <span class="text-danger">{{ $errors->first('question') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="purchase_code">Type</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="type" aria-label="Default select example" required>

                                <option value="input" {{ $question->type == 'input' ? 'selected':''}}>Input</option>
                                <option value="textarea" {{ $question->type == 'textarea' ? 'selected':''}}>Textarea</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection