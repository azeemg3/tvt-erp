<?php
namespace App\Helpers;
class cms{
    public static function incluions($ids=0){
        $list='';
        $inclusions=explode(',', $ids);
        $array=[1=>'Flight', 2=>'Transfer', 3=>'Full Board', '2 PCR Test'];
        foreach ($array as $key=>$val) {
            $list.='<option '.((in_array($key, $inclusions))?'selected':'').' value="'.$key.'">'.$val.'</option>';
        }
        return $list;
    }
    //@tour types list
    public static function tour_types(){
        $array=['Internation Tour'=>1,'Domestic Tour'=>2,
            'Umrah Custom Packages'=>3];
        $list='';
        foreach ($array as $key=>$val){
            $list.='<option value="'.$val.'">'.$key.'</option>';
        }
        return $list;
    }
}