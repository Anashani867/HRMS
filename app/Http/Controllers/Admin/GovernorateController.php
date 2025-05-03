<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\governorates;
use App\Models\Countries;
use Illuminate\Support\Facades\DB;


class GovernorateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
      $data = get_cols_where_p(new governorates(), array("*"), array("com_code" => $com_code), "id", "DESC", PC);
     return view('admin.governorates.index', ['data' => $data]);
    }

    public function create()
    {
        $countries = get_cols(new countries(), ['id', 'name'], 'id', 'ASC');
        return view('admin.governorates.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'countires_id' => 'required|exists:countires,id',
        ]);

        try {
            $com_code = auth()->user()->com_code;
            $checkExsists = get_cols_where_row(new governorates(), array("id"), array("com_code" => $com_code, 'name' => $request->name));
            if (!empty($checkExsists)) {
            return redirect()->back()->with(['error' => 'عفوا اسم الفرع مسجل من قبل !'])->withInput();
            }
            DB::beginTransaction();
            $dataToInsert['name'] = $request->name;
            $dataToInsert['active'] = $request->active;
            $dataToInsert['countires_id'] = $request->countires_id;
            $dataToInsert['added_by'] = auth()->user()->id;
            $dataToInsert['com_code'] = $com_code;
            insert(new governorates(), $dataToInsert);
            DB::commit();
            return redirect()->route('governorates.index')->with(['success' => 'تم ادخال البيانات بنجاح']);
            } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ ما ' . $ex->getMessage()])->withInput();
    }
}
    public function edit($id)
    {
        $com_code = auth()->user()->com_code;
    
        $data = get_cols_where_row(new governorates(), array("*"), array("id" => $id, 'com_code' => $com_code));
    
        if (empty($data)) {
            return redirect()->route('governorates.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
        }
    
        $countries = get_cols(new countries(), ['id', 'name'], 'id', 'ASC');

        return view('admin.governorates.edit', [
            'data' => $data,
            'countries' => $countries
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
            $data = get_cols_where_row(new governorates(), array("*"), array("id" => $id, 'com_code' => $com_code));
            if (empty($data)) {
            return redirect()->route('governorates.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }
            DB::beginTransaction();
            $dataToUpdate['name'] = $request->name;
            $dataToUpdate['active'] = $request->active;
            $dataToUpdate['countires_id'] = $request->countires_id;
            $dataToUpdate['added_by'] = auth()->user()->id;
            $dataToUpdate['com_code'] = $com_code;
            update(new governorates(),$dataToUpdate,array("id" => $id, 'com_code' => $com_code));
            DB::commit();
            return redirect()->route('governorates.index')->with(['success' => 'تم تحديث البيانات بنجاح']);
            }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->back()->with(['error'=>'عفوا حدث خطا  '.$ex->getMessage()])->withInput();
            }
            } 

    public function destroy($id)
    {
        try{
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new governorates(), array("*"), array("id" => $id, 'com_code' => $com_code));
            if (empty($data)) {
            return redirect()->route('governorates.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }
            DB::beginTransaction();
            destroy(new governorates(),array("id" => $id, 'com_code' => $com_code));
            DB::commit();
            return redirect()->route('governorates.index')->with(['success' => 'تم حذف البيانات بنجاح']);
            }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->route('governorates.index')->with(['error'=>'عفوا حدث خطا  '.$ex->getMessage()]);
            }
            }  
    }

