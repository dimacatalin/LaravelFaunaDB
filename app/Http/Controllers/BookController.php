<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorebookRequest;
use App\Http\Requests\UpdatebookRequest;
use App\Models\Book;
use App\Models\Project;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $book = null;
        $route = 'books.store';

        return view('books.create', compact('book', 'route'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorebookRequest $request)
    {
        try {
            $data = [
                'create' => [
                    'collection' => 'books'
                ],
                'params' => [
                    'object' => [
                        'data' => [
                            'object' => [
                                'name' => $request->input('name'),
                                'owner' => $request->input('author'),
                                'price' => $request->input('price'),
                            ]
                        ]
                    ]
                ]
            ];

            $response = Http::withToken(env('FAUNA_KEY'))
                ->post('https://db.fauna.com/', $data);

            if ($response->successful()){

                $book = json_decode($response->body())->resource;

                foreach ($book->ref as $value){
                    $faunaId = $value->id;
                }

                Book::create([
                    'name' => $book->data->name,
                    'author' => $book->data->owner,
                    'price' => $book->data->price,
                    'fauna_id' => $faunaId,
                ]);

                $request->session()->flash('alert-success', 'Data saved successfully!');
            }

            return Redirect::route('dashboard');
        } catch (Exception $e) {
            $request->session()->flash('alert-error', 'Could not save data! ' . $e->getMessage());
        }
        return Redirect::back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $route = 'books.update';

        return view('books.create', compact('book', 'route'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatebookRequest $request, Book $book)
    {
        try {
            $book->update($request->input());

            $data = [
                'update' => [
                    '@ref' => 'classes/books/' . $book->fauna_id
                ],
                'params' => [
                    'object' => [
                        'data' => [
                            'object' => [
                                'name' => $book->name,
                                'owner' => $book->author,
                                'price' => $book->price,
                            ]
                        ]
                    ]
                ]
            ];

            $response = Http::withToken(env('FAUNA_KEY'))
                ->post('https://db.fauna.com/', $data);

            if ($response->successful()){
                $request->session()->flash('alert-success', 'Data saved successfully!');
            }

            return Redirect::route('books.edit', [$book]);
        } catch (Exception $e) {
            $request->session()->flash('alert-error', 'Could not save data! ' . $e->getMessage());
        }
        return Redirect::back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
//    public function destroy(Book $book)
//    {
//        $data = [
//            'delete' => [
//                '@ref' => 'classes/books/' . $book->fauna_id
//            ]
//        ];
//
//        $response = Http::withToken(env('FAUNA_KEY'))
//            ->post('https://db.fauna.com/', $data);
//
//        if ($response->successful()){
//            $book->delete();
//        }
//
//        return Redirect::route('dashboard');
//    }
}
