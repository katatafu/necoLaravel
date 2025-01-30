<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::all(); // Načte všechny fotky z databáze
        return view('welcome', compact('photos')); // Pošle je do view
    }
}