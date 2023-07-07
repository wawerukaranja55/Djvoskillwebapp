<?php

namespace App\Models;

use App\Models\Merchadise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchadisecategory extends Model
{
    use HasFactory;
    protected $table = 'merchadisecategories';

    protected $fillable = ['merchadisecat_title','parent_id','section_id','status','category_discount','url'];

    public function subcategories()
    {
        return $this->hasMany(Merchadisecategory::class,'parent_id')->where('status',1);
    }

    public function products()
    {
        return $this->hasMany(Merchadise::class,'merchcat_id');
    }

    public static function categorydetails($url)
    {
        $categorydetails=Merchadisecategory::select('id','merchadisecat_title','url')->
        with
            ([
                'subcategories'=>function($query){
                    
                    $query->select('id','merchadisecat_title','url','parent_id')->where('status',1);
                }
            ])->
        where('url',$url)->first();

        $catids=array();
        $catids[]=$categorydetails['id'];

        foreach($categorydetails['subcategories'] as $key=>$subcart)
        {
            $catids[]=$subcart['id'];
        }

        // show breadcrumbs in the listing page
        if($categorydetails['parent_id']==0){
            $breadcrumbs='<a href="'.url($categorydetails['url']).'">'.$categorydetails['merchadisecat_title'].'</a>';
        }else{
            $parentcategory=Merchadisecategory::select('merchadisecat_title','url')->where('id',$categorydetails['parent_id'])->first();

            $breadcrumbs='<a href="'.url($parentcategory['url']).'">'.$parentcategory['merchadisecat_title'].'</a>&nbsp;<span class="divider"></span>
            &nbsp;<a href="'.url($categorydetails['url']).'">'.$categorydetails['merchadisecat_title'].'</a>';
        }

        return array('catids'=>$catids,'breadcrumbs'=>$breadcrumbs,'categorydetails'=>$categorydetails);
    }
    
}
