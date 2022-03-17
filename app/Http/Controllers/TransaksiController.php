<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Resources\TransaksiResource;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
   public function index()
   {
      //get data
      $transaksi = Transaksi::latest()->get();

      //return response
      return new TransaksiResource(true, "List Transaksi", $transaksi);
   }

   public function store(Request $request)
   {
      //define validation rules
      $validator = Validator::make($request->all(), [
         'title'  => 'required',
         'amount' => 'required',
         'type'   => 'required',
      ]);

      //check if validation fails
      if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
      }

      //create
      $transaksi = Transaksi::create([
         'title'   => $request->title,
         'amount' => $request->amount,
         'type'    => $request->type,
      ]);

      //return response
      return new TransaksiResource(true, 'Data Transaksi Berhasil Ditambahkan!', $transaksi);
   }

   public function show(Transaksi $transaksi)
   {
      //return single post as a resource
      return new TransaksiResource(true, 'Data Transaksi Ditemukan!', $transaksi);
   }

   public function update(Request $request, Transaksi $transaksi)
   {
      //define validation rules
      $validator = Validator::make($request->all(), [
         'title'  => 'required',
         'amount' => 'required',
         'type'   => 'required',
      ]);

      //check if validation fails
      if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
      }

      //update
      $transaksi->update([
         'title'   => $request->title,
         'amount'  => $request->amount,
         'content' => $request->content,
      ]);

      //return response
      return new TransaksiResource(true, 'Data Transaksi Berhasil Diubah!', $transaksi);
   }

   public function destroy($transaksi)
   {
      //delete
      $transaksi->delete();

      //return response
      return new TransaksiResource(true, 'Data Post Berhasil Dihapus!', null);
   }
}
