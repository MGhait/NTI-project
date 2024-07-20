@extends('dashboard/layout')

@section('contents')
    <h1>
        Products index
    </h1>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <a class="btn btn-success" href="{{ route('products.create') }}">Create New Product</a>
    @if (count($products) == 0)
        <h3>no Products saved yet</h3>
    @else
        <table class="table table-striped table-bordered" style="margin: 0 auto; width: 77%;">
            <tr>
                <th>no</th>
                <th>Product Name</th>
                <th>Product category</th>
                <th>Product added by</th>
                <th>Product price</th>
                <th>Operations</th>
                <th><input type="checkbox" id="select-all"></th>
            </tr>
            @foreach ($products as $product)
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
                        {{ $product->addedBy->fullName }} {{ ( $product->addedBy->role) }}
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
{{--                            @if(\App\Policycheck::pv('supervisor'))--}}
{{--                                <a class="btn btn-primary" href="{{ route('products.publish', $product->id) }}">Edit</a>--}}
{{--                            @endif--}}
                            @csrf
                            @method('DELETE')
                            @if(\App\Policycheck::pv('admin'))
                                <button type="submit" class="btn btn-danger">Delete</button>
                            @endif
                        </form>
                        @if(\App\Policycheck::pv('supervisor'))
                        <a class="btn btn-info" href="{{ route('products.publish', $product->id) }}">publish</a>
                        @endif

                    </td>
                    <td>
                        <input type="checkbox" name="selected[]" value="{{$product->id}}">
                    </td>

                </tr>
            @endforeach
            <div class="mt-5 text-center">
                <button type="submit" name="action" value="unread" class="btn btn-secondary">publish</button>
            </div>
        </table>

        <div id="paginationNumbers">
            {!! $products->links('pagination::bootstrap-4') !!}
        </div>
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

            {{--document.querySelectorAll('.toggle-read').forEach(button => {--}}
            {{--    button.addEventListener('click', function() {--}}
            {{--        fetch(`{{ route('messages.isRead', '') }}/${this.dataset.id}`, {--}}
            {{--            method: 'POST',--}}
            {{--            headers: {--}}
            {{--                'X-CSRF-TOKEN': '{{ csrf_token() }}',--}}
            {{--            },--}}
            {{--        }).then(() => location.reload());--}}
            {{--    });--}}
            {{--});--}}
        </script>
    @endif
@endsection
