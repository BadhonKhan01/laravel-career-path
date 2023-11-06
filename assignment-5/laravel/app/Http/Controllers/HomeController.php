<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    protected array $hero;
    protected array $bio;
    protected array $contact;

    function __construct(){
        $this->hero = json_decode(Storage::get('data/hero.json'), true);
        $this->bio = json_decode(Storage::get('data/bio.json'), true);
        $this->contact = json_decode(Storage::get('data/contact.json'), true);
    }

    public function index(){
        $hero = $this->hero;
        $bio = $this->bio;
        $contact = $this->contact;
        return view('home', compact('hero','bio','contact'));
    }
}
