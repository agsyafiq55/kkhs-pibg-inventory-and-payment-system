<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stream;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    /**
     * Display a listing of the streams.
     */
    public function index()
    {
        return view('admin.streams.index');
    }

    /**
     * Show the form for creating a new stream.
     */
    public function create()
    {
        return view('admin.streams.create');
    }

    /**
     * Display the specified stream.
     */
    public function show(Stream $stream)
    {
        return view('admin.streams.show', compact('stream'));
    }

    /**
     * Show the form for editing the specified stream.
     */
    public function edit(Stream $stream)
    {
        return view('admin.streams.edit', compact('stream'));
    }
} 