<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkExperienceController extends Controller
{
    protected array $experience;
    protected array $contact;

    function __construct(){
        $this->experience = json_decode(Storage::get('data/experience.json'), true);
        $this->contact = json_decode(Storage::get('data/contact.json'), true);
    }

    public function index(){
        $experience = $this->experience;
        $contact = $this->contact;
        return view('workExp', compact('experience','contact'));
    }
}
