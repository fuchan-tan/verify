<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HashValidation implements ValidationRule
{
    public $hashedArray = array();
    public string $finalstring;
    public string $finalHash;
    public $targetHash;

    public function __construct($targetHash = '288f94aadadf486cfdad84b9f4305f7d51eac62db18376d48180cc1dd2047a0e')
    {
        $this->targetHash = $targetHash;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $this->flattenArray($value, NULL);
        sort($this->hashedArray);
        $finalString='["'.implode('","',$this->hashedArray).'"]';
        $finalHash=$this->hashing($finalString);
        
        if($finalHash!=$this->targetHash)
            $fail('invalid_signature');

    }
    /**
     * Flatten the array and do the first hash for each key value.
     *
     * 
     */
    public function flattenArray(array $data, string $parentKey = NULL) : Void
    { 
        //
        $parent='';
        if (!is_array($data)) { 
            $this->hashedArray[] = 'No data';
        } 
        //Flatten the array and hash
        foreach ($data as $key => $value) { 
            if (is_array($value)) { 
                (empty($parentKey)) ? $parent=$key.'.' : $parent=$parentKey.$key.'.';
                $this->flattenArray($value,$parent);
            } 
            else {   
                $message='{"'.$parentKey.$key.'":"'.$value.'"}';  
                $this->hashedArray[] = $this->hashing($message);
            } 
        } 
    }
    /**
     * Hashing Function
     *
     *  
     */
    public function hashing(string $string) : string
    { 
        //
        return hash('sha256', $string);
    }
}
