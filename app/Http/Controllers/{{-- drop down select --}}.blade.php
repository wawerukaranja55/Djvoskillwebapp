{{-- drop down select --}}
$sort=$request->sort;
$url=$request->url;

$categorycount=Merchadisecategory::where(['url'=>$url,'status'=>1])->count();
if($categorycount>0){
    $categorydetails=Merchadisecategory::categorydetails($url);

    $categoryproducts=Merchadise::whereIn('merchcat_id',$categorydetails['catids'])->with('merchadiseattributes')
    ->where('merch_isactive',1);

    if(isset($sort) && !empty($sort)){

        if($sort=="latest_products"){

            $categoryproducts->orderBy('id','Desc');
        }
        elseif($sort=="low_to_high"){
            $categoryproducts->orderBy('merch_price','Asc');
        }
        elseif($sort=="high_to_low"){
            $categoryproducts->orderBy('merch_price','Desc');
        }
        elseif($sort=="most_popular"){
            $categoryproducts->orderBy('product_views','Desc');
        }
        elseif($sort=="product_name_a_z"){
            $categoryproducts->orderBy('merch_name','Asc');
        }
        elseif($sort=="product_name_z_a"){
            $categoryproducts->orderBy('merch_name','Desc');
        }
    }else{
        $categoryproducts->orderBy('id','Desc');
    }
    $categoryproducts=$categoryproducts->paginate(5);

    $events=Events::latest()->take(4)->get();
    return view('frontend.product.productsjson',compact('events','url','categoryproducts'));
    
}else{
    abort (404);
}