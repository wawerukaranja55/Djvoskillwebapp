<?php

namespace App\Http\Controllers;

use App\Models\Town;
use App\Models\coupon;
use App\Models\Merchadise;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Productimages;
use App\Models\shipping_charge;
use App\Models\Productattribute;
use App\Models\Merchadisecategory;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class Merchadise_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $merchadise=Merchadise::with(['merchadisecategor'=>function($query)
            {
                $query->select('id','merchadisecat_title');
            }
        ])->where('merch_isactive',1)->get();
        $merchadisecats=Merchadisecategory::all();

        $productfilters=Merchadise::productfilters();
        $fabricarray=$productfilters['fabricarray'];
        $occasionarray=$productfilters['occasionarray'];
    
        return view('backend.merchadise.addmerchadise',['productfilters'=>$productfilters,'fabricarray'=>$fabricarray,'occasionarray'=>$occasionarray,'merchadise'=>$merchadise,'merchadisecats'=>$merchadisecats]);
    }

    // products with attributes
    public function attributes()
    {   //$merchadisedata=Merchadise::find($id);
        $merchadiseattributes=Merchadise::with(['merchadisecategor'=>function($query)
            {
                $query->select('id','merchadisecat_title');
            }
        ])->where('merch_isactive',0)->get();

        return view('backend.merchadise.merchadiseaddattributes',['merchadiseattributes'=>$merchadiseattributes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $data=$request->all();
            $rules=[
                'merch_name'=>'required',
                'merch_code'=>'required',
                'merch_price'=>'required|numeric',
                'merch_details'=>'required',
                // 'merchcat_id'=>'required',
            ];

            $custommessages=[
                'merch_name.required'=>'Enter The Merchadise Name',
                'merch_code.required'=>'Enter The Merchadise Code',
                'merch_price.required'=>'Enter The Merchadise Price',
                'merch_price.numeric'=>'Enter a Valid Amount',
                'merch_details.required'=>'Write Merchadise description here',
                // 'merchcat_id.required'=>'Select the Merchadise Category',
            ];
            $this->validate($request,$rules,$custommessages);

            if(empty($data['is_featured'])){
                $isfeatured='No';
            }else{
                $isfeatured='Yes';
            }

            if(empty($data['is_attribute'])){
                $isattribute=0;
            }else{
                $isattribute=1;
            }
            
            if(isset($data['fabric'])){
                $fabrics=implode(',',$data['fabric']);
                
            }else{
                $fabrics="";
            }


            if($data['is_attribute']==0){
                $merch_isactive=1;
            }elseif($data['is_attribute']==1){
                $merch_isactive=0;
            }

            if(isset($data['occasion'])){
                $occasions=implode(',',$data['occasion']);
                
            }else{
                $occasions="";
            }

            if(empty($data['product_discount'])){
                $data['product_discount']=0;
            }

            if($request->hasFile('merch_image')){
                $imagetmp=$request->file('merch_image');
                if($imagetmp->isValid()){
                    $extension=$imagetmp->getClientOriginalExtension();
                    $image_name=$request->get('merch_name').'-'.rand(111,9999).'.'.$extension;

                    $large_image_path='images/productimages/large/'.$image_name;
                    $medium_image_path='images/productimages/medium/'.$image_name;
                    $small_image_path='images/productimages/small/'.$image_name;

                    Image::make($imagetmp)->save($large_image_path);
                    Image::make($imagetmp)->resize(520,600)->save($medium_image_path);
                    Image::make($imagetmp)->resize(260,300)->save($small_image_path);

                }
            }

            if($request->hasFile('merch_video')){
                $videotmp=$request->file('merch_video');
                if($videotmp->isValid()){
                    $extension=$videotmp->getClientOriginalExtension();
                    $video_name=$request->get('merch_name').'-'.rand(111,9999).'.'.$extension;

                    $video_path='videos/productvideos/';
                    $videotmp->move($video_path,$video_name);
                }
            } else {
                $video_name="";
            }

            $product_slug=str_replace(' ', '_', $data['merch_name']);

            $merchadise=new Merchadise();
            $merchadise->merch_name=$data['merch_name'];
            $merchadise->url=Str::lower($product_slug);
            $merchadise->merch_code=$data['merch_code'];
            $merchadise->merch_price=$data['merch_price'];
            $merchadise->stock=$data['stock'];
            $merchadise->merch_isactive=$merch_isactive;
            $merchadise->merch_details=$data['merch_details'];
            $merchadise->merchcat_id=$data['merchadisecategory'];
            $merchadise->is_featured=$isfeatured;
            $merchadise->product_discount=$data['product_discount'];
            $merchadise->is_attribute=$isattribute;
            $merchadise->merch_image=$image_name;
            $merchadise->merch_video=$video_name;
            $merchadise->meta_name=$data['meta_name'];
            $merchadise->meta_description=$data['meta_description'];
            $merchadise->meta_keywords=$data['meta_keywords'];
            $merchadise->fabric=$fabrics;
            $merchadise->occasion=$occasions;
            $merchadise->save();

            if($isattribute==0){
                return redirect()->route('merchadise.index')->with('success','Merchadise has been added Successfully');
            }elseif($isattribute==1){
                return redirect('admin/merchadise/attributes')->with('success','Merchadise has been added Successfully.Kindly fill the Merchadise attributes');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merchadise  $Merchadise
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $merchadisedata=Merchadise::find($id);
        // // dd($merchadisedata->merchadiseattributes);
        // return view('backend.merchadise.productattributes')->with(compact('merchadisedata'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
        public function edit($id)
        {
            $merchadisedata=Merchadise::find($id);
            $merchadisecats=Merchadisecategory::all();

            $productfilters=Merchadise::productfilters();
            $fabricarray=$productfilters['fabricarray'];
            $occasionarray=$productfilters['occasionarray'];

            return view('backend.merchadise.editmerchadise')->with(compact('merchadisedata','fabricarray','occasionarray','merchadisecats'));
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
            $data=$request->all();
            
            $rules=[
                'merch_name'=>'required',
                'merch_code'=>'required',
                'merch_price'=>'required|numeric',
                'merch_details'=>'required',
                // 'merchcat_id'=>'required',
            ];

            $custommessages=[
                'merch_name.required'=>'Enter The Merchadise Name',
                'merch_code.required'=>'Enter The Merchadise Code',
                'merch_price.required'=>'Enter The Merchadise Price',
                'merch_price.numeric'=>'Enter a Valid Amount',
                'merch_details.required'=>'Write Merchadise description here',
                // 'merchcat_id.required'=>'Select the Merchadise Category',
            ];
            $this->validate($request,$rules,$custommessages);

            if(empty($data['is_featured'])){
                $isfeatured='No';
            }else{
                $isfeatured='Yes';
            }

            if(empty($data['is_attribute'])){
                $isattribute=0;
            }else{
                $isattribute=1;
            }
            
            if(isset($data['fabrics'])){
                $fabrics=implode(',',$data['fabrics']);
                
            }

            if(isset($data['occasions'])){
                $occasions=implode(',',$data['occasions']);
                
            }

            if($request->hasfile('merch_image')){
                $imagetmp=$request->file('merch_image');
                $image_name=$request->get('merch_name').'-'.rand(111,9999).'.'.$imagetmp->getClientOriginalExtension();

                $large_image_path='images/productimages/large/'.$image_name;
                $medium_image_path='images/productimages/medium/'.$image_name;
                $small_image_path='images/productimages/small/'.$image_name;

                Image::make($imagetmp)->save($large_image_path);
                Image::make($imagetmp)->resize(520,600)->save($medium_image_path);
                Image::make($imagetmp)->resize(260,300)->save($small_image_path);
                $imagetmp->move($large_image_path, $image_name);
                $imagetmp->move($medium_image_path, $image_name);
                $imagetmp->move($small_image_path, $image_name);
            } else {
                $image_name=$request->merch_image;
            }

            if($request->hasfile('merch_video')){
                $videotmp=$request->file('merch_video');
                $video_name=$request->get('merch_name').'-'.rand(111,9999).'.'.$videotmp->getClientOriginalExtension();

                $video_path='videos/productvideos/'.$video_name;

                $videotmp->move($video_path,$video_name);
            } else {
                $video_name="";
            }

            $merchadise=Merchadise::find($id);
            $merchadise->merch_name=$data['merch_name'];
            // $merchadise->url=$data['url'];
            $merchadise->merch_code=$data['merch_code'];
            $merchadise->merch_price=$data['merch_price'];
            $merchadise->stock=$data['stock'];
            $merchadise->merch_details=$data['merch_details'];
            $merchadise->merchcat_id=$data['merchadisecategory'];
            $merchadise->is_featured=$isfeatured;
            $merchadise->product_discount=$data['product_discount'];
            $merchadise->is_attribute=$isattribute;
            $merchadise->merch_image=$image_name;
            $merchadise->merch_video=$video_name;
            $merchadise->meta_name=$data['meta_name'];
            $merchadise->meta_description=$data['meta_description'];
            $merchadise->meta_keywords=$data['meta_keywords'];
            $merchadise->fabric=$fabrics;
            $merchadise->occasion=$occasions;
            $merchadise->save();

            return redirect('admin/merchadise')->with('success','The Merchadise has been Updated succesfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function addattributes(Request $request,$id)
        {
            $merchadisedata=Merchadise::select('id','merch_name','merch_code','merch_image')->with('merchadiseattributes')->find($id);
            
            if ($request->isMethod('post')){
                $data=$request->all();
                
                foreach($data['productattr_sku'] as $key=>$value){
                    if(!empty($value)){
                        $attrcountsku=Productattribute::where('productattr_sku',$value)->count();

                        if($attrcountsku>0){
                            $error_message='The Sku already exists.kindly add another one';
                            Session::flash('error_message',$error_message);
                            return redirect()->back();
                        }

                        $attrcountsize=Productattribute::where(['product_id'=>$id,'productattr_size'=>$data['productattr_size'][$key]])->count();
                        if($attrcountsize>0){
                            $success_message='The Sku already exists.kindly add another one';
                            Session::flash('success_message',$success_message);
                            return redirect()->back();
                        }

                        $attribute=new Productattribute;
                        $attribute->product_id=$id;
                        $attribute->productattr_sku=$value;
                        $attribute->productattr_size=$data['productattr_size'][$key];
                        $attribute->productattr_price=$data['productattr_price'][$key];
                        $attribute->productattr_stock=$data['productattr_stock'][$key];
                        $attribute->productattr_status=0;
                        $attribute->save();

                        $updateproductstatus=Merchadise::where(['id'=>$id])->first();
                        Merchadise::where(['id'=>$id])->update(['merch_isactive'=>1]);
                    }
                }
                return redirect('admin/merchadise/')->with('success','The Attribute has been added Successfully');
                // return view('backend.merchadise.productattributes')->with(compact('merchadisedata'));
            }
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Merchadise  $merchadise
     * @return \Illuminate\Http\Response
     */
    public function editattributes(Request $request,$id)
    {
        $merchadisedata=Merchadise::select('id','merch_name','merch_code','merch_image')->find($id);
        
        if ($request->isMethod('post')){
            $data=$request->all();
            foreach($data['attrid'] as $key=>$attr){
                if(!empty($attr)){
                    Productattribute::where(['id'=>$data['attrid'][$key]])
                    ->update([
                        'productattr_price'=>$data['productattr_price'][$key],
                        'productattr_stock'=>$data['productattr_stock'][$key],
                    ]);
                }
            }
            $message='Product attributes have been updated successfully';
                Session::flash('success_message',$message);
                return redirect('admin/merchadise/'.$merchadisedata->id.'/edit');
        }
        
        return view('backend.merchadise.editproductattributes')->with(compact('merchadisedata'));
        
    }

    public function updateattributestatus(Request $request)
    {
        if($request->ajax()){
            $data=$request->all();
            if($data['productattr_status']=="Active"){
                $status=0;
            }else{
                $status=1;
            }

            Productattribute::where('id',$data['attribute_id'])->update(['productattr_status'=>$status]);
            return response()->json(['productattr_status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }

    
        
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Merchadise  $merchadise
     * @return \Illuminate\Http\Response
     */
    public function deletemerchimage(Merchadise $merchadise)
    {
        $merch_image=Merchadise::select('merch_image')->where('id',$merchadise)->first();

        $smallimagepath='images/productimages/large/';
        $mediumimagepath='images/productimages/medium/';
        $largeimagepath='images/productimages/large/';

        if(file_exists($smallimagepath.$merch_image->merch_image)){
            unlink($smallimagepath.$merch_image->merch_image);
        }

        if(file_exists($mediumimagepath.$merch_image->merch_image)){
            unlink($mediumimagepath.$merch_image->merch_image);
        }

        if(file_exists($largeimagepath.$merch_image->merch_image)){
            unlink($largeimagepath.$merch_image->merch_image);
        }

        Merchadise::where('id',$merchadise)->update(['merch_image'=>'']);

        $message='Merchadise Image Deleted Successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }

    /**
     * Display all the shipping charges.
     *
     * @return \Illuminate\Http\Response
     */
    public function shippingcharges()
    {
        
        return view('backend.merchadise.viewshipping');
    }

    // store a transaction type in the db
    public function addshippingprice(Request $request)
    {
        $data=$request->all();

        $shippingtown=Town::where('town',$data['county_town'])->count();
        if($shippingtown>0){
            $message="The Price for this town already  exists.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }else{

            $data=$request->all();

            Town::create([
                'county_id'=>$data['county'],
                'town'=>$data['county_town'],
                'pickuppoint'=>$data['pick_up_point'],
                'shipping_charges'=>$data['town_price']
            ]);

            $message="Shipping Charges Has Been Saved In the DB Successfully.";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);
        }     
    }

    public function get_shippingprices(Request $request)
    {
        $shippingcharges=Town::with('shippingcounty');

        if($request->ajax()){
            $shippingcharges = DataTables::of ($shippingcharges)

            ->addColumn ('county_id',function(Town $town){
                return $town->shippingcounty->county;
            })

            ->addColumn ('status',function($row){
                return 
                '<input class="townshippingstatus" type="checkbox" checked data-toggle="toggle" data-id="'.$row->id.'" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
            })

            ->addColumn ('action',function($row){
                return '
                <a title="Edit Shipping Prices" href="#'.$row->id.'" class="btn btn-primary btn-xs">
                    <i class="fas fa-edit"></i>
                </a>';
            })
            ->rawColumns(['county_id','status','action'])
            ->make(true);

            return $shippingcharges;
        }
    }

    public function get_shippingcounties(Request $request)
    {
        $shippingcounties=shipping_charge::get();

        if($request->ajax()){
            $shippingcounties = DataTables::of ($shippingcounties)

            ->addColumn ('status',function($row){
                return 
                '<input class="countystatus" type="checkbox" checked data-toggle="toggle" data-id="'.$row->id.'" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
            })

            ->rawColumns(['status'])
            ->make(true);

            return $shippingcounties;
        }
    }

    // update the status for a room for a rental house
    public function updatetownshippingstatus(Request $request)
    {
        dd($request->all());die();
        $roomstatus=Town::find($request->id);
        $roomstatus->status=$request->status;
        $roomstatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Room Status changed successfully'
        ]);
    }

    /**
     * Update the shipping charge for the county.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function  editshippingcharge(Request $request,$id)
    {
        $shippingdetails=shipping_charge::where('id',$id)->first();

        if($request->isMethod('post')){
            $data=$request->all();
            // dd($data);die;
            shipping_charge::where('id',$id)->update(['shipping_charges'=>$data['shipping_charges']]);

            $message="Shipping Charges Updated Successfully!";
            Session::put('success_message',$message);
            return redirect()->back();
        }

        return view('backend.merchadise.editshippingcharge',['shippingdetails'=>$shippingdetails]);   
    }

    // update shipping status
    public function updateshippingstatus(Request $request)
    {
        $shippingstatus=shipping_charge::find($request->shipping_id);
        $shippingstatus->is_shipping=$request->status;
        $shippingstatus->save();
        // return response()->json(['success'=>'Shipping Status Changed Successfully']);
    }

    // update Coupon status
    public function updatecouponstatus(Request $request)
    {
        $couponstatus=coupon::find($request->coupon_id);
        $couponstatus->status=$request->status;
        $couponstatus->save();
    }
    
}
