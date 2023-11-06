<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    protected array $projects;
    protected array $contact;

    function __construct(){
        $this->projects = json_decode(Storage::get('data/projects.json'), true);
        $this->contact = json_decode(Storage::get('data/contact.json'), true);
    }

    public function index(){
        $projects = $this->projects;
        $contact = $this->contact;
        return view('project.list', compact('contact','projects'));
    }

    public function detail(Request $request){
        $slug = $request->slug;
        $detail = [];
        foreach ($this->projects as $project) {
            if($project['slug'] == $slug){
                $detail = $project;
            }
        }
        $contact = $this->contact;
        return view('project.detail', compact('contact','detail'));
    }
}
