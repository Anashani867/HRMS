<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DiscountsType;
use App\Http\Requests\DiscountsTypesRequest;

class DiscountsTypesController extends Controller
{
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_p(new DiscountsType(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PC);
        return view('admin.Discounts_types.index', ['data' => $data]);
    }

    public function create()
    {
        $com_code = auth()->user()->com_code;
        return view('admin.Discounts_types.create');
    }

    public function store(DiscountsTypesRequest $request)
    {
        try {

            $com_code = auth()->user()->com_code;
            $CheckExsists = get_cols_where_row(new DiscountsType(), array("id"), array("com_code" => $com_code, 'name' => $request->name));
            if (!empty($CheckExsists)) {
                return redirect()->back()->with(['error' => 'عفوا هذا الاسم مسجل من قبل '])->withInput();
            }
            DB::beginTransaction();
            $DataToInsert['name'] = $request->name;
            $DataToInsert['active'] = $request->active;
            $DataToInsert['added_by'] = auth()->user()->id;
            $DataToInsert['com_code'] = $com_code;
            insert(new DiscountsType(), $DataToInsert);
            DB::commit();
            return redirect()->route('DiscountsTypes.index')->with(['success' => 'تم تسجيل البيانات بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا  حدث خطأ  ' . $ex->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {

        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row(new DiscountsType(), array("*"), array("com_code" => $com_code, 'id' => $id));
        if (empty($data)) {
            return redirect()->route('DiscountsTypes.index')->with(['error' => 'عفوا غير قادر للوصول الي البيانات المطلوبة']);
        }
        return view('admin.Discounts_types.edit', ['data' => $data]);
    }

    public function update($id, DiscountsTypeRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new DiscountsType(), array("*"), array("com_code" => $com_code, 'id' => $id));
            if (empty($data)) {
                return redirect()->route('DiscountsTypes.index')->with(['error' => 'عفوا غير قادر للوصول الي البيانات المطلوبة']);
            }
            $CheckExsists = DiscountsType::select("id")->where("com_code", "=", $com_code)->where("name", "=", $request->name)->where('id', '!=', $id)->first();
            if (!empty($CheckExsists)) {
                return redirect()->back()->with(['error' => 'عفوا هذا الاسم مسجل من قبل '])->withInput();
            }
            DB::beginTransaction();
            $DataToUpdate['name'] = $request->name;
            $DataToUpdate['active'] = $request->active;
            $DataToUpdate['updated_by'] = auth()->user()->id;
            update(new DiscountsType(), $DataToUpdate, array("com_code" => $com_code, 'id' => $id));
            DB::commit();
            return redirect()->route('DiscountsTypes.index')->with(['success' => 'تم تحديث البيانات بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ  ' . $ex->getMessage()])->withInput();
        }
    }
    public function destroy($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new DiscountsType(), array("*"), array("com_code" => $com_code, 'id' => $id));
            if (empty($data)) {
                return redirect()->route('DiscountsTypes.index')->with(['error' => 'عفوا غير قادر للوصول الي البيانات المطلوبة']);
            }
            DB::beginTransaction();
            destroy(new DiscountsType(), array("com_code" => $com_code, 'id' => $id));
            DB::commit();
            return redirect()->route('DiscountsTypes.index')->with(['success' => 'تم الحذف  البيانات بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ  ' . $ex->getMessage()])->withInput();
        }
    }}
