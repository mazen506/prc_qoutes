<?php

namespace App\Http\Controllers;

use App\Models\Qoute;
use App\Models\QtItem;
use App\Models\Unit;
use App\Models\User;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use PDF;




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

        $qoutes = Qoute::with('items')->where('user_id', Auth::user()->id)->get();

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
		    $units = Unit::all();
        $currencies = Currency::all();
        return view('qoute_new',compact('units','currencies'));
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

       $images = array();
       try {
       $validator = $request->validate([
         //'item_name' => 'required'
        'item_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Only allow .jpg, .bmp and .png file types.
       ]);

          if ($files=$request->file('item_images')){
            foreach($files as $file){
                //$file->store('item_images','public');
                $path = Storage::disk('s3')->put('images',$file);
                $image = explode('/', $path)[1];
                //$path = Storage::disk('s3')->url($path);
                $images[]= ['image_name' => $image ];
            }
        
        // Testing
        //$images[] = ['image_name' => '1LqEA14E05s89pjoxwUzbMq6UHoHT8YNLAOzLYbT.jpg'];
        //$images[] = ['image_name' => 'cAnXNHc7bDwODjW14RpnU4YhzKE6Mc1OImurTzHw.jpg'];
        //$images[] = ['image_name' => 'ma1ONseX6p2GY1vmXd48rfz7wNwzDrYolr3XsoWJ.jpg'];
        
              return response()->json($images);
            }
      }
      catch (\Illuminate\Validation\ValidationException $e)
      {
        $errors = $e->errors();
        return response()->json($errors);
      }
    }

    public function delImage(Request $request){
          // Delete from public folder
          if ($request->image_name) {
             try{
                  Storage::disk('s3')->delete('images/' . $request->image_name);
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
	    	'name' => 'required',
        'currency' => 'required',
	    ]);
	 
      DB::beginTransaction();

	    try {
		    $qoute = Qoute::create([
				  'name' => $request->name,
				  'note' => $request->note ? $request->note : '',
				  'user_id' => Auth::user()->id,
          'currency_id' => $request->currency,
				  'curr_vr_id' => 0,
          'locale'  => app()->getLocale()
			  ]);
		
      $item_images_str = $request->input('item_images_str', []);
      $item_names = $request->input('item_names', []);
      $item_units = $request->input('item_units', []);
      $item_package_qtys = $request->input('item_package_qtys', []);
      $item_package_units = $request->input('item_package_units', []);
      $item_prices = $request->input('item_prices', []);
      $item_cpms = $request->input('item_cpms', []);
      $item_qtys = $request->input('item_qtys', []);
      $item_notes = $request->input('item_notes', []);
			$items = [];
			for ($item_number=0; $item_number < count($item_names); $item_number++) {
				if ($item_names[$item_number] != '') {
						$items[] =  new QtItem([
                   'item_name' => $item_names[$item_number],
                   'unit_id' => $item_units[$item_number],
                   'package_qty' => $item_package_qtys[$item_number],
                   'package_unit_id' => $item_package_units[$item_number],
                   'price' => $item_prices[$item_number],
                   'cpm' => $item_cpms[$item_number],
                   'qty' => $item_qtys[$item_number],
                   'note' => $item_notes[$item_number],
                   'images' => $item_images_str[$item_number],
                ]);
				}
			}
		
			//dd($items);
			$qoute->items()->saveMany($items);
			DB::commit();
			return redirect()->route('qoutes.edit', $qoute->id );

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
		    $qoute = Qoute::with(['items' => function($query){
            $query->where('qty', '!=' , 0);
        }])->find($qoute);
        $units = Unit::all();
        $vendor = User::find($qoute->user_id);
        $currency = Currency::find($qoute->currency_id)['code_' . app()->getLocale()];
        if (($qoute->locale) && ($qoute->locale != app()->getLocale()))
        {  App::setLocale($qoute->locale);
            return response(view('qoute_display', compact('qoute','units','vendor','currency')))
            ->withCookie(cookie()->forever('applocale', $qoute->locale));

        }
        else
            return view('qoute_display', compact('qoute','units','vendor','currency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Qoute  $qoute
     * @return \Illuminate\Http\Response
     */
    public function edit(int $qoute)
    {
    $units = Unit::all();
    $currencies = Currency::all();
		$qoute = Qoute::with("items")->find($qoute);
        return view('qoute_manu',[
			  'qoute' => $qoute,
        'units' => $units,
        'currencies' => $currencies
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
      $request->validate([
	    	'name' => 'required',
        'currency' => 'required',
	    ]);

        DB::beginTransaction();
        try {

          $qoute->update(['name' => $request->name, 
                          'note'=> $request->note, 
                          'currency_id' => $request->currency,
                          'updated_at'=> date('Y-m-d H:i:s'), 
                          'locale' => app()->getLocale()]
                        );

          $item_ids = $request->input('item_ids', []);
          $is_edited_flags = $request->input('is_edited_flags', []);
          $item_names = $request->input('item_names', []);
          $item_images_str = $request->input('item_images_str', []);
          $item_units = $request->input('item_units', []);
          $item_package_qtys = $request->input('item_package_qtys', []);
          $item_package_units = $request->input('item_package_units', []);
          $item_prices = $request->input('item_prices', []);
          $item_cpms = $request->input('item_cpms', []);
          $item_qtys = $request->input('item_qtys', []);
          $item_notes = $request->input('item_notes', []);


          // Delete removed items
          if (count($item_ids)){
            QtItem::where('qoute_id',$qoute->id)
            ->whereNotIn('id', $item_ids)
            ->delete();
          }

          $items=[];
          for ($index=0; $index < count($item_names); $index++) {
                // Update existing
                if (isset($item_ids[$index]) && ($item_ids[$index] != '0'))
                {
                  if ($is_edited_flags[$index] == 1)
                  {   $item = QtItem::where('id', $item_ids[$index])->first();
                      $item->item_name = $item_names[$index];
                      $item->unit_id = $item_units[$index];
                      $item->package_qty = $item_package_qtys[$index];
                      $item->package_unit_id = $item_package_units[$index];
                      $item->price = $item_prices[$index];
                      $item->cpm = $item_cpms[$index];
                      $item->qty = $item_qtys[$index];
                      $item->note = $item_notes[$index];
                      $item->images = $item_images_str[$index];
                      array_push($items, $item);
                  }
                    
                } else //New Item 
                {
                    $item = new QtItem(
                      ['item_name' => $item_names[$index],
                        'unit_id' => $item_units[$index],
                        'package_qty' => $item_package_qtys[$index],
                        'package_unit_id' => $item_package_units[$index],
                        'price' => $item_prices[$index],
                        'cpm' => $item_cpms[$index],
                        'qty' => $item_qtys[$index],
                        'note' => $item_notes[$index],
                        'images' => $item_images_str[$index]
                      ]);
                      array_push($items,$item);
                }
          }
            $qoute->items()->saveMany($items);
            DB::commit();
            return response()->json(['items' => $qoute->items]);
        }
        catch (\Exception $e)
		    {
    			  DB::rollback();
			      return response()-json(['error' => $e->getMessage()], 500);
		    }
    }

    public function createPdf(int $qoute){

      $qoute = Qoute::with(['items' => function($query){
        $query->where('qty', '!=' , 0);
    }])->find($qoute);
      $units = Unit::all();
      $vendor = User::find($qoute->user_id);
      $currency = Currency::find($qoute->currency_id)['code_' . app()->getLocale()];
      //return view('qoute_pdf', compact('qoute','units','vendor','currency'));
      $pdf = PDF::loadView('qoute_pdf', compact('qoute','units','vendor','currency'));
      $pdf->setOption('enable-javascript', true);
      $pdf->setOption('margin-top', 10);
      $pdf->setOption('margin-bottom', 10);
      return $pdf->download('qoute_' . $qoute->id . '.pdf');

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
