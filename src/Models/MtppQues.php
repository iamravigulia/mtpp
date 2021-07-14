<?php
namespace Edgewizz\Mtpp\Models;

use Illuminate\Database\Eloquent\Model;

class MtppQues extends Model{
    // public function answers(){
    //     return $this->hasMany('Edgewizz\Mtpp\Models\MtppAns', 'question_id');
    // }
    protected $table = 'fmt_mtpp_ques';
}