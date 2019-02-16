<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer;
use Auth;

class LawyersController extends Controller
{
    //创建
    public function create(Lawyer $lawyer)
    {
        return view('lawyers.create_and_edit', compact('lawyer'));
    }
    
    //编辑
    public function edit(Lawyer $lawyer)
    {
        return view('lawyers.create_and_edit', compact('lawyer'));
    }
    
    public function store(Request $request, Lawyer $lawyer)
    {
        $lawyer->fill($request->all());
        $lawyer->user_id = Auth::id();
        $lawyer->avatar = '';
        $lawyer->save();
        return redirect()->route('lawyers.edit', $lawyer->id);
    }
    
    public function update(Request $request, Lawyer $lawyer)
    {
        $lawyer->update($request->all());
        return redirect()->route('lawyers.edit', $lawyer->id);
    }
}
