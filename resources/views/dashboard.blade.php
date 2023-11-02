<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-6">

                <h2 class="dark:bg-gray-800 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>

            </div>
            <div class="col-md-6 text-right">

                <a href="{{route('books.create')}}" class="btn btn-primary"> Add book </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Content Wrapper. Contains page content -->
                    <div class="content-wrapper">
                        <!-- Main content -->
                        <section class="content dark:bg-gray-800">

                            <!-- Default box -->
                            <div class="card dark:bg-gray-800">
                                <div class="card-body p-0 dark:bg-gray-800">
                                    <table class="table table-striped table-borderless text-gray-900 dark:text-gray-100">
                                        <thead>
                                        <tr>
                                            <th class="text-center" style="width: 20%">Name</th>
                                            <th class="text-center" style="width: 20%">Author</th>
                                            <th class="text-center" style="width: 20%">Price</th>
                                            <th class="text-center" style="width: 20%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($books as $book)
                                            <tr>
                                                <td class="text-center">{{ $book->name }}</td>
                                                <td class="text-center">{{ $book->author }}</td>
                                                <td class="text-center">{{ $book->price }}</td>
                                                <td class="text-right">
                                                    <a href="{{route('books.edit', [$book])}}" class="btn btn-info btn-sm" title="Edit item">
                                                        edit
                                                    </a>
{{--                                                    {!! Form::model($book, ['url' => route('books.destroy', [$book]), 'method' => 'DELETE', 'class' => 'd-inline']) !!}--}}
{{--                                                    <button class="btn btn-danger btn-sm d-inline" title="Delete item"--}}
{{--                                                            onclick="return confirm('Are you sure you want to delete this book?')">--}}
{{--                                                        delete--}}
{{--                                                    </button>--}}
                                                </td>
                                                {{--                                @endif--}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </section>
                        <!-- /.content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
