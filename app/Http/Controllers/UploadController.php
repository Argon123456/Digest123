<?php
namespace App\Http\Controllers;

ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');

//use App\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class UploadController extends Controller
{
    public function uploadForm()
    {
        return view('upload_form');
    }

    public function uploadSubmit(Request $request)
    {
        $files = [];
        foreach ($request->photos as $file) {

            $filename = $file->store('photos');
            $clientFilename = $file->getClientOriginalName();

/*            $product_photo = Attachment::create([
                'filename' => $filename,
                'client_filename' => $clientFilename
            ]);*/

            $file_object = new \stdClass();
            $file_object->name = str_replace('photos/', '',$file->getClientOriginalName());
            $file_object->size = round(Storage::size($filename) / 1024, 2);
            //$file_object->fileID = $product_photo->id;
            $file_object->url = url('/'.$filename);
            $files[] = $file_object;

            $file->move('photos',$filename);
        }



        return response()->json(array('files' => $files), 200);
    }

    public function postProduct(Request $request)
    {
        // This method will cover whole product submit
    }
}
