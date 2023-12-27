<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiHelpers;
use App\Http\Controllers\Controller;
use App\Models\Books;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    public function index()
    {
        $data = Books::all();

        if($data) {
            return ApiHelpers::createApi(200, 'Successfully', $data);
        }else {
            return ApiHelpers::createApi(400, 'Failed');
        }
    }

    public function storeBooks(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'judul_buku' => 'required',
                'pengarang' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required',
            ]);

            if ($validator->fails()) {
                return ApiHelpers::createApi(400, 'Validation Error', $validator->errors());
            }

            $book = Books::create([
                'judul_buku' => $request->judul_buku,
                'pengarang' => $request->pengarang,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
            ]);

            $data = Books::find($book->id);
            if ($data) {
                return ApiHelpers::createApi(200, 'Added Succesfully', $data);
            } else {
                return ApiHelpers::createApi(400, 'Failed To Add');
            }
        } catch (Exception $error) {
            return ApiHelpers::createApi(500, 'Internal Server Error');
        }
    }

    public function showBooks($id)
    {
        $data = Books::where('id', '=', $id)->get();

        if($data){
            return ApiHelpers::createApi(200, 'Successfully', $data);
        } else {
            return ApiHelpers::createApi(400, 'Failed');
        }
    }

    public function updateBooks(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'judul_buku' => 'required',
                'pengarang' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required',
            ]);

            if ($validator->fails()) {
                return ApiHelpers::createApi(400, 'Validation Error', $validator->errors());
            }

            $book = Books::find($id);

            if (!$book) {
                return ApiHelpers::createApi(404, 'Book not found');
            }

            $book->update([
                'judul_buku' => $request->judul_buku,
                'pengarang' => $request->pengarang,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
            ]);

            $data = Books::find($id);
                return ApiHelpers::createApi(200, 'Updated Successfully', $data);
        } catch (Exception $error) {
            return ApiHelpers::createApi(500, 'Internal Server Error');
        }
    }

    public function destroyBooks($id)
    {
        try {
            $books = Books::FindOrFail($id);

            $data = $books->delete();

            if($data) {
                return ApiHelpers::createApi(200, 'Deleted Successfully');
            } else {
                return ApiHelpers::createApi(400, 'Failed To delete');
            }
        } catch (Exception $error) {
            return ApiHelpers::createApi(500, 'Internal server Error');
        }
    }
}
