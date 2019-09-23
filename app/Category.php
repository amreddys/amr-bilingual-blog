<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table="categories";
    public function posts()
    {
        return $this->belongsToMany('App\Post','posts_categories');
    }
    public function getLinkAttribute()
    {
        return route('category_view',['slug' => $this->slug]);
    }
    public function getBadgeBackground()
    {
        $strlen = strlen($this->name);

        $char1 = ord(strtolower(substr($this->name,0,1)))-97;
        $char2 = ord(strtolower(substr($this->name,1,1)))-97;
        $char3 = ord(strtolower(substr($this->name,2,1)))-97;
        
        $factor = 8;
        $sum = 1000;

        do
        {
            $nchar1 = $char1 * $factor;
            $nchar2 = $char2 * $factor;
            $nchar3 = $char2 * $factor;
            $sum = $nchar1 + $nchar2 + $nchar3;
            $factor--;
        }while($sum > 500 && $factor > 0);

        $char1 = $nchar1;
        $char2 = $nchar2;
        $char3 = $nchar3;

        $r = str_pad( dechex( $char1 ), 2, '0', STR_PAD_LEFT);
        $g = str_pad( dechex( $char2 ), 2, '0', STR_PAD_LEFT);
        $b = str_pad( dechex( $char3 ), 2, '0', STR_PAD_LEFT);
        return '#'.$r.$g.$b;
        //$strlen = ($strlen%3 == 0)?$strlen:($strlen-($strlen%3));
    }
    public function getBadgeTextColor()
    {
        return '#FFFFFF';
    }
    private function coldiff($R1,$G1,$B1,$R2,$G2,$B2){ //Suggested > 500
        return max($R1,$R2) - min($R1,$R2) +
               max($G1,$G2) - min($G1,$G2) +
               max($B1,$B2) - min($B1,$B2);
    }
    private function brghtdiff($R1,$G1,$B1,$R2,$G2,$B2){ //Suggested > 125
        $BR1 = (299 * $R1 + 587 * $G1 + 114 * $B1) / 1000;
        $BR2 = (299 * $R2 + 587 * $G2 + 114 * $B2) / 1000;
     
        return abs($BR1-$BR2);
    }
    private function lumdiff($R1,$G1,$B1,$R2,$G2,$B2){ //Suggested >5
        $L1 = 0.2126 * pow($R1/255, 2.2) +
              0.7152 * pow($G1/255, 2.2) +
              0.0722 * pow($B1/255, 2.2);
     
        $L2 = 0.2126 * pow($R2/255, 2.2) +
              0.7152 * pow($G2/255, 2.2) +
              0.0722 * pow($B2/255, 2.2);
     
        if($L1 > $L2){
            return ($L1+0.05) / ($L2+0.05);
        }else{
            return ($L2+0.05) / ($L1+0.05);
        }
    }
}
