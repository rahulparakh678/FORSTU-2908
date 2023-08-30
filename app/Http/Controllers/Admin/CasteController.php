<?php

namespace App\Http\Controllers\Admin;

use App\Caste;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCasteRequest;
use App\Http\Requests\StoreCasteRequest;
use App\Http\Requests\UpdateCasteRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CasteController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('caste_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $castes = Caste::all();

        return view('admin.castes.index', compact('castes'));
    }

    public function create()
    {
        abort_if(Gate::denies('caste_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.castes.create');
    }

    public function store(StoreCasteRequest $request)
    {
        $caste = Caste::create($request->all());

        return redirect()->route('admin.castes.index');
    }

    public function edit(Caste $caste)
    {
        abort_if(Gate::denies('caste_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.castes.edit', compact('caste'));
    }

    public function update(UpdateCasteRequest $request, Caste $caste)
    {
        $caste->update($request->all());

        return redirect()->route('admin.castes.index');
    }

    public function show(Caste $caste)
    {
        abort_if(Gate::denies('caste_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.castes.show', compact('caste'));
    }

    public function destroy(Caste $caste)
    {
        abort_if(Gate::denies('caste_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caste->delete();

        return back();
    }

    public function massDestroy(MassDestroyCasteRequest $request)
    {
        Caste::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}