@extends('dashboard/layout')
{{--                 green  55ff00           red f81f4f       transparent    --}}
{{--     class="{{$product->needReview ?'bg-info' : ''}}"    --}}
{{ $editorPolicy = \App\Policycheck::pv('editor') }}
{{ $supervisorPolicy = \App\Policycheck::pv('supervisor') }}
{{ $adminPolicy = \App\Policycheck::pv('admin') }}
@if($editorPolicy)
    {{ $needReviewCount = $userProducts->where('needReview', 1)->count() }}
@endif
@section('contents')
    <h1 class="text-center">
        {{ucfirst(Session::get('userRole'))}} index
        @if($editorPolicy)
            <br> Added By YOU
        @elseif($supervisorPolicy)
            <br> Need Review
        @endif
    </h1>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('failed'))
        <div class="alert alert-danger">
            <p>{{$message}}</p>
        </div>
    @endif
        @if($adminPolicy)
        @if (count($users) == 0)
            <h3>no Categories saved yet</h3>
        @else
            <table class="table table-striped table-bordered" style="margin: 0 auto; width: 77%;">
            <tr>
                <th>no</th>
                <th>User Full Name</th>
                <th>User Log Name</th>
                <th>User Role</th>
                <th>Operations</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>
                        {{ ++$i }}
                    </td>
                    <td>
                        {{ $user->fullName }}
                    </td>
                    <td>
                        {{ $user->logName }}
                    </td>
                    <td>
                        {{ $user->role }}
                    </td>

                    <td>
                        <form action="{{ route('users.destroy',$user->id) }}" method="POST" style="display: inline;">
                                {{--                            <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Show</a>--}}
                                {{--                            <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>--}}
                            @csrf
                            @method('DELETE')
                                {{--                            if isActive = 1 then delete not shown --}}
                            @if($user->role != 'admin' && $user->isActive != 1 )
                                <button type="submit" class="btn btn-danger">Delete {{var_dump($user->isActive)}}</button>
                                @endif
                        </form>
                        <form action="{{ route('users.isActive', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('POST')
                            <a class="btn btn-primary m-2" href="{{ route('users.edit', $user->id) }}">Edit</a>
                            @if($user->role != 'admin')
                                @if ($user->isActive == 0)
                                    <button type="submit" class="btn btn-secondary">Active</button>
                                    @else
                                    <button type="submit" class="btn btn-warning">DeActive</button>
                                    @endif
                                @endif
                        </form>


                    </td>

                </tr>
                @endforeach
        </table>

            <div id="paginationNumbers">
            {!! $users->links('pagination::bootstrap-4') !!}
        </div>

        @endif
    @endif
        {{--    for supervisor make product like messages--}}
        @if($supervisorPolicy)
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
        @if (count($products) == 0)
            <h3>No Products Need Review</h3>
        @else
            <form action="{{route('products.bulk')}}" method="POST">
                @csrf
                @method('POST')
                <table class="table table-striped table-bordered" style="margin: 0 auto; width: 77%;">
                    <thead>
                        <th>no</th>
                        <th>Product Name</th>
                        <th>Product Category</th>
                        <th>Product Creator</th>
                        <th>Operations</th>
                        <th><input type="checkbox" id="select-all"></th>
                    </thead>

                    @foreach ($products as $product)
                        @if($product->needReview)
                            <tbody>
                                <td>{{ ++$i }}</td>
                                <td>
                                    <a href="{{route('products.show',$product->id)}}">{{ $product->name }}</a>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->addedBy->fullName }}</td>
                                <td>

                                    <a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}">Edit</a>
                                    <a class="btn btn-primary" href="{{ route('products.publish', $product->id) }}">publish</a>

                                </td>
                                <td>
                                    <input type="checkbox" name="selected[]" value="{{$product->id}}">
                                </td>
                            </tbody>
                        @endif
                    @endforeach
                    <div class="mt-5 text-center">
                        <button type="submit" name="action" value="publish" class="btn btn-warning">Publish All Selected</button>
                    </div>
                </table>
            </form>


            <div id="paginationNumbers">
            {!! $products->links('pagination::bootstrap-4') !!}
        </div>

        @endif
        <script>
        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.getElementsByName('selected[]');
                for (var checkbox of checkboxes) {
                    checkbox.checked = this.checked;
            }
        });
        {{--document.querySelectorAll('.delete-message').forEach(button => {--}}
        {{--    button.addEventListener('click', function() {--}}
        {{--        if (confirm('Are you sure you want to delete this message?')) {--}}
        {{--            fetch(`{{ route('messages.destroy', '') }}/${this.dataset.id}`, {--}}
        {{--                method: 'DELETE',--}}
        {{--                headers: {--}}
        {{--                    'X-CSRF-TOKEN': '{{ csrf_token() }}',--}}
        {{--                },--}}
        {{--            }).then(() => location.reload());--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

    </script>
    @endif

        @if(\App\Policycheck::pv('editor'))

    @if (count($userProducts) == 0)
        <h3>no Products saved yet</h3>
    @else
        @if($editorPolicy)
            <table class="table table-striped table-bordered" style="margin: 0 auto; width: 77%;">
                <tr>
                    <th>no</th>
                    <th>Product Name</th>
                    <th>Product category</th>
                    <th>Product price</th>
                    <th>Operations</th>
                </tr>
                @foreach ($products as $product)
                @if($product->added_by == Session::get('userId'))
                <tr style="background-color: {{$product->needReview ? 'rgba(255,60,60,0.50)' : '#55ff00'}}">
                    <td>
                        {{ ++$i }}
                    </td>
                    <td>
                        {{ $product->name }}
                    </td>
                    <td>
                        {{ $product->category->name }}
                    </td>

                    <td>
                        {{ $product->price }}
                    </td>

                    <td>
                        <form action="{{ route('products.destroy',$product->id) }}" method="POST" style="display: inline;">

                            <a class="btn btn-info" href="{{ route('products.show', $product->id) }}">Show</a>
                            @if(\App\Policycheck::pv('supervisor') || (\App\Policycheck::pv('editor') && $product->added_by == Session::get('userId')))
                                <a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}">Edit</a>
                            @endif

                            @csrf
                            @method('DELETE')
                            @if(\App\Policycheck::pv('admin'))
                                <button type="submit" class="btn btn-danger">Delete</button>
                            @endif
                        </form>

                    </td>


                </tr>
                @endif
            @endforeach
            </table>
        @endif

        <div id="paginationNumbers">
            {!! $products->links('pagination::bootstrap-4') !!}
        </div>

    @endif
@endif
{{--@endif--}}
{{--    edit product table (add column to make it need agree or not [forign key to supervisor
table ..... think of it later])--}}
@endsection
