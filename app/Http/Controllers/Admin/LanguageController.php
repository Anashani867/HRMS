<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_p(new Language(), array("*"), array("com_code" => $com_code), "id", "DESC", PC);
       return view('admin.Language.index', [
         'data' => $data 
     ]);    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'active' => 'required|boolean',

        ]);

        try {
            $com_code = auth()->user()->com_code;
            $checkExsists = get_cols_where_row(new Language(), array("id"), array("com_code" => $com_code, 'name' => $request->name));
            if (!empty($checkExsists)) {
            return redirect()->back()->with(['error' => 'عفوا اسم الفرع مسجل من قبل !'])->withInput();
            }
            DB::beginTransaction();
            $dataToInsert['name'] = $request->name;
            $dataToInsert['active'] = $request->active;
            $dataToInsert['added_by'] = auth()->user()->id;
            $dataToInsert['com_code'] = $com_code;
            insert(new Language(), $dataToInsert);
            DB::commit();
            return redirect()->route('languages.index')->with(['success' => 'تم ادخال البيانات بنجاح']);
            } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ ما ' . $ex->getMessage()])->withInput();
            }    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $com_code = auth()->user()->com_code;
    
        $data = get_cols_where_row(new Language(), array("*"), array("id" => $id, 'com_code' => $com_code));
    
        if (empty($data)) {
            return redirect()->route('languages.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
        }
    

        return view('admin.Language.edit', [
            'data' => $data,
        ]);    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new Language(), array("*"), array("id" => $id, 'com_code' => $com_code));
            if (empty($data)) {
            return redirect()->route('languages.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }
            DB::beginTransaction();
            $dataToUpdate['name'] = $request->name;
            $dataToUpdate['active'] = $request->active;
            $dataToUpdate['updated_by'] = auth()->user()->id;
            update(new Language(),$dataToUpdate,array("id" => $id, 'com_code' => $com_code));
            DB::commit();
            return redirect()->route('languages.index')->with(['success' => 'تم تحديث البيانات بنجاح']);
            }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->back()->with(['error'=>'عفوا حدث خطا  '.$ex->getMessage()])->withInput();
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new Language(), array("*"), array("id" => $id, 'com_code' => $com_code));
            if (empty($data)) {
            return redirect()->route('languages.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }
            DB::beginTransaction();
            destroy(new Language(),array("id" => $id, 'com_code' => $com_code));
            DB::commit();
            return redirect()->route('languages.index')->with(['success' => 'تم حذف البيانات بنجاح']);
            }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->route('languages.index')->with(['error'=>'عفوا حدث خطا  '.$ex->getMessage()]);
            }
            }      
}
