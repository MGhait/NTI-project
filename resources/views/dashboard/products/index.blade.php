@extends('dashboard/layout')
@section('title', 'Products index')
@section('contents')
    {{ $editorPolicy = \App\Policycheck::pv('editor') }}
    {{ $supervisorPolicy = \App\Policycheck::pv('supervisor') }}
    {{ $adminPolicy = \App\Policycheck::pv('admin') }}

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('failed'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if($editorPolicy && $shownProducts == 0)
        <h3 class="text-center"> No Products Published Yet</h3>
    @endif
    @if (($adminPolicy || $supervisorPolicy) && count($products) == 0)
            <h3 class="text-center"> No Products Saved Yet</h3>
    @else
        @if(($editorPolicy && $shownProducts != 0) || $adminPolicy || $supervisorPolicy )
            <form action="{{route('products.bulk')}}" method="POST" >
                @csrf
                @method('POST')
                <table class="table table-striped table-bordered" style="margin: 0 auto; width: 77%;">
                    <thead>
                        <th>no</th>
                        <th>Product Name</th>
                        <th>Product category</th>
                        <th>Product added by</th>
                        <th>Product price</th>
                        <th>Operations</th>
                        @if(!$editorPolicy)
                        <th><input type="checkbox" id="select-all"></th>
                        @endif
                    </thead>
                    @foreach ($products as $product)
                        @if(($editorPolicy && $product->needReview ==0) || $supervisorPolicy)
                        <tbody style="background-color: {{$product->needReview ? '#0b4348' : '#55ff00'}}">
                            <td>{{ ++$i }}</td>
                            <td>
                                <a href="{{route('products.show',$product->id)}}">{{ $product->name }}</a>
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->addedBy->fullName }} </td>
                            <td>{{ $product->price }}</td>
                            <td>

{{--                                    <a class="btn btn-info" href="{{ route('products.show', $product->id) }}">Show</a>--}}
                                    @if($supervisorPolicy || ($editorPolicy && $product->added_by == Session::get('userId')))
                                        <a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}">Edit</a>
                                    @endif
                                    @if($adminPolicy)
                                        <button type="submit" class="btn btn-warning">Delete</button>
                                    @endif
                                @if($supervisorPolicy && $product-> needReview == 1)
                                    <a class="btn btn-warning" href="{{ route('users.publish', $product->id) }}">publish</a>
                                @endif

                            </td>
                            @if(!$editorPolicy)
                            <td>
                                <input type="checkbox" name="selected[]" value="{{$product->id}}">
                            </td>
                            @endif

                        </tbody>
                        @endif
                    @endforeach
                    @if(!$editorPolicy)
                        <div class="mt-5 text-center">
                            <button type="submit" name="action" value="delete" class="btn btn-danger">Delete  All Selected</button>
                            <button type="submit" name="action" value="publish" class="btn btn-warning">Publish  All Selected</button>
                            <button type="submit" name="action" value="unpublish" class="btn btn-info">Un Publish  All Selected</button>
                        </div>
                    @endif
                </table>
            </form>


        @endif
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

        </script>
    @endif
@endsection
