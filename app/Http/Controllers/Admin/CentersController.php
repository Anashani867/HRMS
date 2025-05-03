<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\centers;
use App\Models\countries;
use App\Models\governorates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CentersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $com_code = auth()->user()->com_code;
        $data = get_cols_where_p(new centers(), array("*"), array("com_code" => $com_code), "id", "DESC", PC);
       return view('admin.centers.index', [
         'data' => $data 
     ]);
    }

    public function create()
    {
        $governorates = get_cols(new governorates(), ['id', 'name'], 'id', 'ASC');
        return view('admin.centers.create', compact( 'governorates'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'active' => 'required|boolean',
            'governorates_id' => 'required|exists:governorates,id',

        ]);

        try {
            $com_code = auth()->user()->com_code;
            $checkExsists = get_cols_where_row(new centers(), array("id"), array("com_code" => $com_code, 'name' => $request->name));
            if (!empty($checkExsists)) {
            return redirect()->back()->with(['error' => 'عفوا اسم الفرع مسجل من قبل !'])->withInput();
            }
            DB::beginTransaction();
            $dataToInsert['name'] = $request->name;
            $dataToInsert['active'] = $request->active;
            $dataToInsert['governorates_id'] = $request->governorates_id;
            $dataToInsert['added_by'] = auth()->user()->id;
            $dataToInsert['com_code'] = $com_code;
            insert(new centers(), $dataToInsert);
            DB::commit();
            return redirect()->route('centers.index')->with(['success' => 'تم ادخال البيانات بنجاح']);
            } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ ما ' . $ex->getMessage()])->withInput();
            }
    }

    public function edit($id)
    {
        $com_code = auth()->user()->com_code;
    
        $data = get_cols_where_row(new centers(), array("*"), array("id" => $id, 'com_code' => $com_code));
    
        if (empty($data)) {
            return redirect()->route('centers.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
        }
    
        $governorates = get_cols(new governorates(), ['id', 'name'], 'id', 'ASC');

        return view('admin.centers.edit', [
            'data' => $data,
            'governorates' => $governorates
        ]);
    }
    

    public function update(Request $request, $id)
    {
        try{
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row(new centers(), array("*"), array("id" => $id, 'com_code' => $com_code));
        if (empty($data)) {
        return redirect()->route('centers.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
        }
        DB::beginTransaction();
        $dataToUpdate['name'] = $request->name;
        $dataToUpdate['active'] = $request->active;
        $dataToUpdate['governorates_id'] = $request->governorates_id;
        $dataToUpdate['updated_by'] = auth()->user()->id;
        $dataToUpdate['com_code'] = $com_code;
        update(new centers(),$dataToUpdate,array("id" => $id, 'com_code' => $com_code));
        DB::commit();
        return redirect()->route('centers.index')->with(['success' => 'تم تحديث البيانات بنجاح']);
        }catch(\Exception $ex){
        DB::rollBack();
        return redirect()->back()->with(['error'=>'عفوا حدث خطا  '.$ex->getMessage()])->withInput();
        }
        } 

    public function destroy($id)
    {
        try{
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new centers(), array("*"), array("id" => $id, 'com_code' => $com_code));
            if (empty($data)) {
            return redirect()->route('centers.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }
            DB::beginTransaction();
            destroy(new centers(),array("id" => $id, 'com_code' => $com_code));
            DB::commit();
            return redirect()->route('centers.index')->with(['success' => 'تم حذف البيانات بنجاح']);
            }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->route('centers.index')->with(['error'=>'عفوا حدث خطا  '.$ex->getMessage()]);
            }
            }  
}
