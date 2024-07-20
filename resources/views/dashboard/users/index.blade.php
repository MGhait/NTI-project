@extends('dashboard/layout')

@section('contents')
    <h1 class="text-center">
        {{ucfirst(Session::get('userRole'))}} index
    </h1>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
@if(\App\Policycheck::pv('admin'))
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

{{--                            <button type="submit" class="btn btn-danger">Delete</button>--}}
                        </form>
                        <form action="{{ route('users.isActive', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('POST')
                            <a class="btn btn-primary m-2" href="{{ route('users.edit', $user->id) }}">Edit</a>
                            @if ($user->isActive == 0)
                                <button type="submit" class="btn btn-secondary">Active</button>
                            @else
                                <button type="submit" class="btn btn-warning">DeActive</button>
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
@if(\App\Policycheck::pv('supervisor'))
    @if (count($products) == 0)
        <h3>no Categories saved yet</h3>
    @else
        <table class="table table-striped table-bordered" style="margin: 0 auto; width: 77%;">
            <tr>
                <th>no</th>
                <th>Product Name</th>
                <th>Product Category</th>
                <th>Product Creator</th>
                <th>Operations</th>
                <th><input type="checkbox" id="select-all"></th>
            </tr>
            @foreach ($products as $product)
                @if($product->needReview)
                <tr>
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
                        {{ $product->addedBy->fullName }}
                    </td>

                    <td>

                        <form action="{{ route('users.isActive', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('POST')
                            <a class="btn btn-primary m-2" href="{{ route('users.edit', $user->id) }}">Edit</a>
                            @if ($user->isActive == 0)
                                <button type="submit" class="btn btn-secondary">Active</button>
                            @else
                                <button type="submit" class="btn btn-warning">DeActive</button>
                            @endif
                        </form>


                    </td>
                    <td>
                        <input type="checkbox" name="selected[]" value="{{$message->id}}">
                    </td>
                </tr>
                @endif
            @endforeach
        </table>

        <div id="paginationNumbers">
            {!! $users->links('pagination::bootstrap-4') !!}
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
{{--@endif--}}
{{--    add to needAgree to dashboard [route or somthing]--}}
{{--    edit product table (add column to make it need agree or not [forign key to supervisor
table ..... think of it later])--}}
@endsection
