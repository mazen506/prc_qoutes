<?php

namespace App\Http\Controllers;

use App\Models\Qoute;
use App\Models\QtItem;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class QouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $qoutes = Qoute::with('items')->get();

        return view('qoutes', compact('qoutes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		    //abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		    $packages = Package::all();
        return view('qoute_new',compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function addImage(Request $request){
       // Get the new images
       // Save them into images folder

       $images=array();
/*       $request->validate([
        'item_images' => 'mimes:jpeg,bmp,png' // Only allow .jpg, .bmp and .png file types.
       ]);*/

  /*     if($files=$request->file('item_images')){
            foreach($files as $file){
              
                $name = $file->hashName();
                $file->store('item_images','public');
                $images[]= ['image_name' => $name ];
            }*/
        



        // Testing
        $images[] = ['image_name' => '1LqEA14E05s89pjoxwUzbMq6UHoHT8YNLAOzLYbT.jpg'];
        $images[] = ['image_name' => '9NWuLQT3hdlpQM6nLkDAn3DmMrZQXMZPrzfEY0CV.jpg'];
        $images[] = ['image_name' => 'wPgwRx9c5aDMMdKTm8DXw5TiFrHC6QYKQ5WKKhwA.jpg'];

        
        return response()->json($images);
   // }
    //else 
     //  return response()->json(null);

        //$values = $request->data;
        //return response()->json($values);
    }

    public function delImage(Request $request){
          // Delete from public folder
          if ($request->image_name) {
             try{
                  Storage::delete('public/item_images/' . $request->image_name);
                  //unlink(storage_path('app/public/item_images/' . $request->image_name));
                  return true;
             } catch (Throwable $e) {
                  report($e);
                  return false;
             }
          }
    }

    public function store(Request $request)
    {
		
		
	$request->validate([
		'name' => 'required|unique:qoutes|max:255',
		'note' => 'required',
	 ]);
	 
     DB::beginTransaction();

	  try {
		$qoute = Qoute::create([
				'name' => $request->name,
				'note' => $request->note,
				'user_id' => 1,
				'curr_vr_id' => 0
			]);
		
			$item_names = $request->input('item_names', []);
			$quantities = $request->input('quantities', []);
			$items = [];
			for ($item_number=0; $item_number < count($item_names); $item_number++) {
				if ($item_names[$item_number] != '') {
						$items[] =  new Item(['qoute_id' => $qoute->id,
									'item_name' => $item_names[$item_number], 
									'package_id' => 1, 								
									'qty' => $quantities[$item_number],
									'moq' => 0,
									'note' => '']);
				}
			}
		
			//dd($items);
			$qoute->items()->saveMany($items);
			DB::commit();
			return redirect('/qoutes');
		}
		catch (\Exception $e)
		{
			DB::rollback();
			throw $e;
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Qoute  $qoute
     * @return \Illuminate\Http\Response
     */
    public function show(int $qoute)
    {
		$qoute = Qoute::find($qoute);
        return view('qoute_display',[
			'qoute' => $qoute
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Qoute  $qoute
     * @return \Illuminate\Http\Response
     */
    public function edit(int $qoute)
    {
    $packages = Package::all();
		$qoute = Qoute::with("items")->find($qoute);
        return view('qoute_manu',[
			'qoute' => $qoute,
      'items' => $qoute->items,
      'packages' => $packages
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Qoute  $qoute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qoute $qoute)
    {
        $qoute->update([
			'name' => $request->name,
			'note' => $request->note
		]);
		return redirect('qoute/' . $qoute->id);
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Qoute  $qoute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qoute $qoute)
    {
         $qoute->delete();
		 return redirect('/qoutes');
    }
}
