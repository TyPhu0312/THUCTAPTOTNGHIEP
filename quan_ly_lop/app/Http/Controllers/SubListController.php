<?php

namespace App\Http\Controllers;

use App\Models\SubList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubListController extends Controller
{
    // Lấy danh sách tất cả SubList
    public function index()
    {
        return response()->json(SubList::all());
    }

    // Lấy thông tin chi tiết một SubList
    public function show($id)
    {
        $subList = SubList::find($id);
        if (!$subList) {
            return response()->json(['message' => 'Không tìm thấy SubList!'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($subList);
    }

    // Tạo mới một SubList
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'isShuffle' => 'required|boolean',
        ]);

        $subList = SubList::create($validatedData);

        return response()->json($subList, Response::HTTP_CREATED);
    }

    // Cập nhật thông tin SubList
    public function update(Request $request, $id)
    {
        $subList = SubList::find($id);
        if (!$subList) {
            return response()->json(['message' => 'Không tìm thấy SubList!'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'title' => 'required|string',
            'isShuffle' => 'required|boolean',
        ]);

        $subList->update($validatedData);

        return response()->json($subList);
    }

    // Xóa một SubList
    public function destroy($id)
    {
        $subList = SubList::find($id);
        if (!$subList) {
            return response()->json(['message' => 'Không tìm thấy SubList!'], Response::HTTP_NOT_FOUND);
        }

        $subList->delete();

        return response()->json(['message' => 'SubList đã được xóa thành công!'], Response::HTTP_OK);
    }
}
