<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Base\Admin\AdminController;
use Validator;
use Auth;
use DB;
use View;
use App\Models\ProductImage;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductFabric;
use App\Models\ProductTranslation;
use File;


class ProductController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         try

        {
            if(request()->ajax())
            {

                $lists = $this->ProductTranslation->leftJoin('products', 'products.id', '=', 'product_translation.product_id')->where('product_translation.lang_id', config('app.locale'))->orderBy('products.id','desc');
                if(request('searchtext')){
                    $search = request()->searchtext;
                    $lists->where(function($query) use ($search)
                    {
                        $query->orWhere('product_translation.product_name','like', '%' . $search. '%'); 
                    });
                }

                $lists = $lists->select('product_translation.*','products.*')->paginate(10);
                
                return response()->json(
                   View::make('admin.product.raw',compact('lists'))
                   ->render()
               );
                
            }

            return view('admin.product.index');
        }
        catch(\Exception $e){
            $this->debugLog('#Product'.$e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colors = $this->Color->where('status','active')->pluck('color_name','id');
        $size = $this->Size->where('status','active')->pluck('size_name','id');
        $fabric = $this->Fabric->where('status','active')->pluck('fabric_name','id');

        return view('admin.product.create',compact('colors','size','fabric'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        DB::beginTransaction();
        $data = request()->all();
        
        $rules = [
            'english.product_name' => 'required',
            'english.description' => 'required',
            'arabic.product_name' => 'required',
            'arabic.description' => 'required',
            'manufacturing_price' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'sell_price' => 'required',
            'product_image' => 'required',
        ];
        $msg=[
            'english.product_name.required' => trans('product.product_en_required'),
            'english.description.required' => trans('product.description_en_required'),
            'arabic.product_name.required' => trans('product.product_es_required'),
            'arabic.description.required' => trans('product.description_es_required'),
            'manufacturing_price.required'=>trans('product.manufacturing_price_required'),
            'quantity.required'=>trans('product.quantity_required'),
            'price.required' =>trans('product.price_required'),
            'sell_price.required'=>trans('product.sell_price_required'),
            'product_image.required'=>trans('product.product_image_required'),
            'colors.required'=>trans('product.colors_required'),
            'size.required'=>trans('product.size_required'),
            'fabric.required'=>trans('product.fabric_required'),
        ];

        $validator = Validator::make($data,$rules,$msg);

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
       try 
       {
            
            $slug = strtolower(str_replace(" ","-",$data['english']['product_name']));
            $product = $this->Product;
            $product->slug = $slug; 
            $product->manufacturing_price = $data['manufacturing_price'];
            $product->quantity = $data['quantity'];
            $product->price = $data['price'];
            $product->sell_price = $data['sell_price'];
            $product->gender = $data['gender'];
            $product->type = $request->has('type') ? $data['type'] : null;
            $product->product_type = $data['product_type'];
            $product->status =$request->has('status')  ? 'active' : 'deactive';
            $product->save();

            
            $product_translation_english = new ProductTranslation;
            $product_translation_english->product_id = $product->id;
            $product_translation_english->product_name = $data['english']['product_name'];
            $product_translation_english->description = $data['english']['description'];
            $product_translation_english->lang_id = 'en';
            $product_translation_english->save();
            $product_translation_arabic = new ProductTranslation;
            $product_translation_arabic->product_id = $product->id;
            $product_translation_arabic->product_name = $data['arabic']['product_name'];
            $product_translation_arabic->description = $data['arabic']['description'];
            $product_translation_arabic->lang_id = 'es';
            $product_translation_arabic->save();
            if($request->hasfile('product_image'))
            {   
                $destinationPath = public_path().'/'. \Config::get('admin.image.product').$product->id.'/';

                // Create directory if it does not exist
                if(!is_dir($destinationPath)) {
                    mkdir($destinationPath,0777,true);
                }

                foreach ($data['product_image'] as $key => $image) 
                {
                    $file = $image;
                    $extension = $image->getClientOriginalExtension();
                    $filename = uniqid().'.'.$extension;
        
                    $source_image = $_FILES['product_image']['tmp_name'][$key];
                    $file->move($destinationPath, $filename);
                    
                    $images = new ProductImage();
                    $images->product_id = $product->id;
                    $images->image = $filename;
                    $images->save();
                }
            }
        
            if($request->has('colors'))
            {
                foreach ($data['colors'] as $color) {
                    
                    $product_color = new ProductColor();
                    $product_color->product_id = $product->id;
                    $product_color->color_id = $color;
                    $product_color->save();
                }

            }

            if($request->has('size'))
            {
                foreach ($data['size'] as $size) {
                    
                    $product_size = new ProductSize();
                    $product_size->product_id = $product->id;
                    $product_size->size_id = $size;
                    $product_size->save();
                }

            }

            if($request->has('fabric'))
            {
                foreach ($data['fabric'] as $fabric) {
                    
                    $product_fabric = new ProductFabric();
                    $product_fabric->product_id = $product->id;
                    $product_fabric->fabric_id = $fabric;
                    $product_fabric->save();
                }

            }

            DB::commit();
            $this->success($this->created,trans('sidebar.product'));
           return redirect('admin/product');
           
       } catch (Exception $e) {
          DB::rollBack();
          $this->debugLog('#Product'.$e); 
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $colors = $this->Color->where('status','active')->pluck('color_name','id');
        $size = $this->Size->where('status','active')->pluck('size_name','id');
        $fabric = $this->Fabric->where('status','active')->pluck('fabric_name','id');

        $get_colors = $this->ProductColor->where('product_id',$id)->pluck('color_id');
        $get_size = $this->ProductSize->where('product_id',$id)->pluck('size_id');
        $get_fabric = $this->ProductFabric->where('product_id',$id)->pluck('fabric_id');
        $editProduct = $this->Product->where('id',$id)->first();
        $product_translation = $editProduct->productTranslation;
        foreach ($product_translation as $row) {
           if($row->lang_id == 'en'){

            $editProduct->en_product_name = $row->product_name;
            $editProduct->en_description = $row->description;
           }else{
            $editProduct->es_product_name = $row->product_name;
            $editProduct->es_description = $row->description;
           }
        }
       // dd($editProduct);
        return view('admin.product.edit',compact('colors','size','fabric','editProduct','get_colors','get_size','get_fabric'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  
        $data = request()->all();
        $rules = [
            'english.product_name' => 'required',
            'english.description' => 'required',
            'arabic.product_name' => 'required',
            'arabic.description' => 'required',
            'manufacturing_price' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'sell_price' => 'required',
        ];
        $msg=[
            'english.product_name.required' => trans('product.product_en_required'),
            'english.description.required' => trans('product.description_en_required'),
            'arabic.product_name.required' => trans('product.product_es_required'),
            'arabic.description.required' => trans('product.description_es_required'),
            'manufacturing_price.required'=>trans('product.manufacturing_price_required'),
            'quantity.required'=>trans('product.quantity_required'),
            'price.required' =>trans('product.price_required'),
            'sell_price.required'=>trans('product.sell_price_required'),            
            'colors.required'=>trans('product.colors_required'),
            'size.required'=>trans('product.size_required'),
            'fabric.required'=>trans('product.fabric_required'),
        ];

        
        $validator = Validator::make($data,$rules,$msg);
        
        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
       
       try 
       {
            
            $slug = strtolower(str_replace(" ","-",$data['english']['product_name']));
            $product = $this->Product->where('id',$id)->first();
            $product_details['slug'] = $slug;
            $product_details['manufacturing_price'] = $data['manufacturing_price'];
            $product_details['quantity'] = $data['quantity'];
            $product_details['price'] = $data['price'];
            $product_details['sell_price'] = $data['sell_price'];
            $product_details['gender'] = $data['gender'];
            $product_details['type'] = $request->has('type') ? $data['type'] : null;
            $product_details['product_type'] = $data['product_type'];
            $product_details['status'] = $request->has('status')? 'active' : 'deactive';
            $product->update($product_details);

            $product_translation = $this->ProductTranslation->where('product_id',$id)->where('lang_id','en');
            $product_translation_english['product_name'] = $data['english']['product_name'];
            $product_translation_english['description'] = $data['english']['description'];
            $product_translation-> update($product_translation_english);

            $product_translation = $this->ProductTranslation->where('product_id',$id)->where('lang_id','es');
            $product_translation_arabic['product_name'] = $data['arabic']['product_name'];
            $product_translation_arabic['description'] = $data['arabic']['description'];
            $product_translation->update($product_translation_arabic);

           

            if($request->hasfile('product_image'))
            {   
                $destinationPath = public_path().'/'. \Config::get('admin.image.product').$product->id.'/';

                // Create directory if it does not exist
                if(!is_dir($destinationPath)) {
                    mkdir($destinationPath,0777,true);
                }

                foreach ($data['product_image'] as $key => $image) 
                {
                    $file = $image;
                    $extension = $image->getClientOriginalExtension();
                    $filename = uniqid().'.'.$extension;
        
                    $source_image = $_FILES['product_image']['tmp_name'][$key];
                    $file->move($destinationPath, $filename);
                    
                    $images = new ProductImage();
                    $images->product_id = $product->id;
                    $images->image = $filename;
                    $images->save();
                }
            }

       
        
        
            if($request->has('colors'))
            {
                $delete_colors = $this->ProductColor->where('product_id',$id)->delete();
                foreach ($data['colors'] as $color) {
                    
                    $product_color = new ProductColor();
                    $product_color->product_id = $product->id;
                    $product_color->color_id = $color;
                    $product_color->save();
                }

            }

            if($request->has('size'))
            {
                 $delete_size = $this->ProductSize->where('product_id',$id)->delete();
                foreach ($data['size'] as $size) {
                    
                    $product_size = new ProductSize();
                    $product_size->product_id = $product->id;
                    $product_size->size_id = $size;
                    $product_size->save();
                }

            }

            if($request->has('fabric'))
            {
                $delete_fabric = $this->ProductFabric->where('product_id',$id)->delete();
                foreach ($data['fabric'] as $fabric) {
                    
                    $product_fabric = new ProductFabric();
                    $product_fabric->product_id = $product->id;
                    $product_fabric->fabric_id = $fabric;
                    $product_fabric->save();
                }

            }

           $this->success($this->updated,trans('sidebar.product')); 
           return redirect('admin/product');
           
       } catch (Exception $e) {
          $this->debugLog('#Product'.$e); 
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteProduct = $this->Product->where('id',$id)->delete();
        $destinationPath = public_path(). \Config::get('admin.image.product').$id;
        if(File::exists($destinationPath)) {
            File::deleteDirectory($destinationPath);
        }
        $message = $this->error($this->deleted,trans('sidebar.product'));
        return response()->json(['message'=>$message]);
    }

    public function getImage($id)
    {
        $productImages = $this->ProductImage->where('product_id',$id)->pluck('image','id');

        return response()->json(['images'=>$productImages]);
    }

    public function removeImage($id)
    {
        $deleteProduct = $this->ProductImage->where('id',$id)->first();
        $destinationPath = public_path(). \Config::get('admin.image.product').$deleteProduct->product_id.'/'.$deleteProduct->image;
        
        if(File::exists($destinationPath)) {
            
            File::delete($destinationPath);
        }
        $deleteProduct->delete();
        $message = $this->error($this->deleted,'Product Image');
        return response()->json(['message'=>$message]);
        
    }
}
