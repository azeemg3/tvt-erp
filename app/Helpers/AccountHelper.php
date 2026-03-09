<?php
namespace App\Helpers;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use DB;
use Session;

class Account{
    //payment types
    public static function payment_type(){
        $list='';
        $array=[1=>'Cash', 2=>'Cheque', 3=>'Online', 4=>'Credit'];
        foreach ($array as $key=>$val) {
            $list.='<option value="'.$key.'">'.$val.'</option>';
        }
        return $list;
    }
    public static function trans_code(){
        $tc=Transaction::max('trans_code');
        if($tc>0){
            return $tc+1;
        }else {
            return 1;
        }
    }
    //@dr or cr
    public static function dc(){
        $list='';
        $array=[1=>'Dr', 2=>'Cr'];
        foreach ($array as $key=>$val) {
            $list.='<option value="'.$key.'">'.$val.'</option>';
        }
        return $list;
    }
    //@trnas code format tcf=trans_code_format
    public static function tcf($number){
        if($number<10){
            return '0'.$number;
        }else{
            return $number;
        }
    }
    //@voucher type rv=receipt voucehr pv=payment voucher jv=journal voucher
    public static function vt($type){
        if($type==1){
            return 'RV';
        }elseif ($type==2){
            return 'PV';
        }elseif($type==3){
            return 'JV';
        }elseif($type==4){
            return 'Ticket';
        }elseif($type==5){
            return 'Hotel';
        }elseif($type==6){
            return 'Visa';
        }elseif($type==7){
            return 'Transport';
        }elseif($type==8){
            return 'Tour';
        }elseif($type==9){
            return 'Ref';
        }elseif($type==10){
            return 'other';
        }elseif($type==11){
            return 'Pcr';
        }
        elseif($type==12){
            return 'Umrah';
        }
    }
    //@opening balance as on date as well while createing account
    public static function ob($date, $tid){
        $df=date('Y-m-d', strtotime('0 day', strtotime('2015-08-10')));
        $dt=date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $ob_res=TransactionAccount::find($tid);
        if($ob_res->OB_Type=='1'){
            $opening_balance=$ob_res->ob;
        }else{
            $opening_balance=-$ob_res->ob;
        }
        $dr=Transaction::where(['trans_acc_id'=>$tid, 'dr_cr'=>1])
            ->where(function($query) use ($df, $dt){
            $query->WhereBetween('trans_date', [$df, $dt]);
        })->sum('amount');
        $cr=Transaction::where(['trans_acc_id'=>$tid, 'dr_cr'=>2])
            ->where(function ($query) use ($df, $dt){
            $query->WhereBetween('trans_date', [$df, $dt]);
        })->sum('amount');
        $ob=$opening_balance+($dr-$cr);
        if($ob>0){
            return $ob;
        }else{
            return $ob;
        }
    }
    //@dr or cr
    public static function show_bal($bal){
        if ($bal>0) {
            return number_format(abs($bal), 2)." Dr";
        }
        elseif($bal<0) {
            return '('.number_format(abs($bal), 2).") Cr";
        }
        elseif($bal==0) {
            return "Nil";
        }
    }
    public static function show_bal_format($bal){
        if ($bal>0) {
            return number_format(abs($bal), 2);
        }
        elseif($bal<0) {
            return '('.number_format(abs($bal), 2).")";
        }
        elseif($bal==0) {
            return "Nil";
        }
    }
    //show currency in words
    public static function convertNumberToWord($num = false){
        $num = str_replace(array(',', ' '), '' , trim($num));
        if(! $num)
        {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list1=array_map('strtoupper',$list1);
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list2=array_map('strtoupper',$list2);
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $list3=array_map('strtoupper',$list3);
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++)
        {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' HUNDRED' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 )
            {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            }
            else
            {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1)
        {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }
    //financial years
    public static function financial_year(){
        // $fy=Session::get('financial_year');
        $fy="2022-07-01/2030-06-30";
        $fy=explode('/',$fy);
        return $fy;
    }
}