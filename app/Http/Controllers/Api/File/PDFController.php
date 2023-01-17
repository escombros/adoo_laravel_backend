<?php

namespace App\Http\Controllers\Api\File;


use App\Models\Pdf;

use Illuminate\Http\Request;
use App\Http\Facades\Utilities;
use App\Http\Traits\ResponseApi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\ApiValidatorException;

use Validator;

class PdfController extends Controller
{

    use ResponseApi;


    public function store(Request $request){
        $input = $request->all();

            $rules = array(
                'id' => 'required|string',
                'folio' => 'required|string',
                'pdf' => 'required|mimes:pdf|max:5120'
            );

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return $this->sendError('PdfController Validator', $validator->errors()->all(), 422);
            }
            
            if(!($request->hasFile("pdf"))){
                return $this->sendResponse('PDFController','Pdf is missing');
            }

            $pdf = Pdf::where('id', $input['id'])->where('folio', $input['folio'])->first();


            if (!empty($pdf)) return $this->sendResponse('PDFController','The record is already in db');


            $file=$request->file("pdf");
            $nombre = "id:".$input['id']."_"."folio:".$input['folio'].".".$file->guessExtension();
            $ruta = public_path("./../storage/registros/".$nombre);

            if (is_file($ruta)){
                return $this->sendError('PdfController', 'This file is already at storage', 300);
            }

            if(!($file->guessExtension()=="pdf")){
                return $this->sendResponse('PDFController','File is not a PDF');
            }
                
            copy($file,$ruta);
            $pdf = Pdf::create(['id'=>$input['id'],'folio'=>$input['folio'],'pdf'=>$ruta]);
           
           // DB::connection('mysql')->table('Pdf')->insert(['folio'=>$input['folio'],'pdf'=>$contenido]);


           return $this->sendResponse($pdf,'Pdf saved');
        }


    public function download(Request $request){
        $input = $request->all();

            $rules = array(
                'id' => 'required|string',
                'folio' => 'required|string',
            );
            Log::info('inputsss');
            Log::info($input);
            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return $this->sendError('PdfController Validator', $validator->errors()->all(), 422);
            }
            
            $nombre = "id:".$input['id']."_"."folio:".$input['folio']."."."pdf";
            $ruta = public_path("./".$nombre);

            if (!(is_file($ruta))){
                return $this->sendError('PdfController', 'pdf not found', 404);

            }
          return response()->download($ruta);

          //return $this->sendResponse( ,'Pdf saved');
       
    }
}
    