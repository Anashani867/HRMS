<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_p(new countries(), array("*"), array("com_code" => $com_code), "id", "DESC", PC);
       return view('admin.countries.index', [
        'data' => $data,
    ]);
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        try {
            $com_code = auth()->user()->com_code;
            $checkExsists = get_cols_where_row(new countries(), array("id"), array("com_code" => $com_code, 'name' => $request->name));
            if (!empty($checkExsists)) {
            return redirect()->back()->with(['error' => 'عفوا اسم الفرع مسجل من قبل !'])->withInput();
            }
            DB::beginTransaction();
            $dataToInsert['name'] = $request->name;
            $dataToInsert['active'] = $request->active;
            $dataToInsert['added_by'] = auth()->user()->id;
            $dataToInsert['com_code'] = $com_code;
            insert(new countries(), $dataToInsert);
            DB::commit();
            return redirect()->route('countries.index')->with(['success' => 'تم ادخال البيانات بنجاح']);
            } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ ما ' . $ex->getMessage()])->withInput();
            }
    }

    public function edit($id)
    {
        $com_code = auth()->user()->com_code;
    
        $data = get_cols_where_row(new countries(), array("*"), array("id" => $id, 'com_code' => $com_code));
        
        if (empty($data)) {
            return redirect()->route('countries.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
        }

        return view('admin.countries.edit', [
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        try{
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new countries(), array("*"), array("id" => $id, 'com_code' => $com_code));
            if (empty($data)) {
            return redirect()->route('countries.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }
            DB::beginTransaction();
            $dataToUpdate['name'] = $request->name;
            $dataToUpdate['active'] = $request->active;
            $dataToUpdate['added_by'] = auth()->user()->id;
            $dataToUpdate['com_code'] = $com_code;
            update(new countries(),$dataToUpdate,array("id" => $id, 'com_code' => $com_code));
            DB::commit();
            return redirect()->route('countries.index')->with(['success' => 'تم تحديث البيانات بنجاح']);
            }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->back()->with(['error'=>'عفوا حدث خطا  '.$ex->getMessage()])->withInput();
            }
            } 

    public function destroy($id)
    {
        try{
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new countries(), array("*"), array("id" => $id, 'com_code' => $com_code));
            if (empty($data)) {
            return redirect()->route('countries.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }
            DB::beginTransaction();
            destroy(new countries(),array("id" => $id, 'com_code' => $com_code));
            DB::commit();
            return redirect()->route('countries.index')->with(['success' => 'تم حذف البيانات بنجاح']);
            }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->route('countries.index')->with(['error'=>'عفوا حدث خطا  '.$ex->getMessage()]);
            }
            }  
}
