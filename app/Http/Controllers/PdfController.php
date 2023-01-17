<?php

namespace App\Http\Controllers;

use App\Http\Facades\Utilities;
use App\Models\Pdf;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseApi;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiValidatorException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Validator;

class PdfController extends Controller
{

    use ResponseApi;

    public function store(Request $request){
        $input = $request->all();

            $rules = array(
                'folio' => 'required|string',
                'pdf' => 'required|mimes:pdf|max:5120'
            );
            
            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return $this->sendError('PdfController Validator', $validator->errors()->all(), 422);
            }
            Log::info('input tiene:');
            Log::info($input);

            $tamanio = $request->file("pdf")->getSize();

            $filename = $request->file('pdf');

            $fp = fopen($filename, "rb");
            $contenido = fread($fp, $tamanio);
            //$contenido = addslashes($contenido);
            fclose($fp); 

            DB::connection('mysql')->table('Pdf')->insert(['folio'=>$input['folio'],'pdf'=>$contenido]);

            Log::info('this works! ');
            

           return $this->sendResponse($filename,'Pdf saved');
        }


    public function download(Request $request, $folio){

        Log::info('this is folio! ');
        Log::info($folio);
        

        $expediente =  DB::connection('mysql')->table('Pdf')->where('folio', $folio)->first();

        if(empty($expediente))  return $this->sendError('PdfController Validator', 'no se encontró el registro', 422);

        
            
            //$file = $expediente->pdf;
            //Log::info('this is FILE! ');
            //$content = base64_decode($expediente->pdf);

            $b64= $expediente->pdf;
            Log::info('this is FILE! ');
            Log::info($expediente->pdf);
            //file_put_contents('file.pdf', $bin);
            $bin = base64_decode($b64, true);
            file_put_contents('~file.pdf', $bin);
            //$content = base64_decode($content);
            


            //$pdf = $file->loadView('downloadReceipt', compact('file'))->setOptions(['defaultFont' => 'arial']);
             //return $pdf->download('data.pdf');
           // Log::info($expediente);
            /*
            
            header("Content-type:text/plain");

            header("Content-Disposition: attachment; filename='miarchivo.txt'");

            echo $row["campoBlob"];

            
            $tamanio = $request->file("pdf")->getSize();

            $filename = $request->file('pdf');

            $fp = fopen($filename, "rb");
            $contenido = fread($fp, $tamanio);
            $contenido = addslashes($contenido);
            fclose($fp); 

            DB::connection('mysql')->table('Pdf')->insert(['folio'=>$input['folio'],'pdf'=>$contenido]);

            Log::info('this works! ');*/
            

           return $this->sendResponse('hecho','Pdf saved');
        }
}
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /* public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   /* public function index()
    {
        return view('home');
    }

    public function createPDF(Request $request){

    }

}*/
