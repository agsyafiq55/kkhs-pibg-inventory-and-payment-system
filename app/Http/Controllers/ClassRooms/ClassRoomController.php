<?php

namespace App\Http\Controllers\ClassRooms;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function index()
    {
        return view('admin.classrooms.index');
    }

    public function create()
    {
        return view('admin.classrooms.form');
    }

    public function show(Classroom $classroom)
    {
        return view('admin.classrooms.show', compact('classroom'));
    }

    public function edit(Classroom $classroom)
    {
        return view('admin.classrooms.form', compact('classroom'));
    }
} 