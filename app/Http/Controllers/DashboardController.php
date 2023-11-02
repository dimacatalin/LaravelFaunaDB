<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\MonthlyStatistic;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{

    public function dashboard(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {

        $response = Http::withToken(env('FAUNA_KEY'))
            ->post('https://db.fauna.com/query/1', [
                'query' => "books.all()",
            ]);

        $booksFauna = collect(json_decode($response->body())->data->data);
        $books = Book::whereIn('fauna_id', $booksFauna->pluck('id'))->paginate(5);

        return view('dashboard', compact('books'));
    }
}
