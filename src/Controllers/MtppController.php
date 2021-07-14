<?php

namespace edgewizz\Mtpp\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Edgewizz\Edgecontent\Models\ProblemSetQues;
use Edgewizz\Mtpp\Models\MtppQues;
use Edgewizz\Mtpp\Models\MtppPic;
use Edgewizz\Mtpp\Models\MtppText;
use Illuminate\Http\Request;

class MtppController extends Controller
{
    //
    public function test(){
        dd('hello');
    }
    public function store(Request $request){

        $mQues = new MtppQues();
        $mQues->question = $request->question;
        $mQues->difficulty_level_id = $request->difficulty_level_id;
        $mQues->save();
        
        for($v = 1; $v <= 4; $v++){
            $imgVar     = 'media_'.$v;
            $textVar    = 'text_'.$v;
            if($request->$imgVar && $request->$textVar){
                // $imgName    = $request->$imgVar->getClientOriginalName();
                $imgName    = str_replace(' ', '_', $request->$imgVar->getClientOriginalName());
                // dd($imgName);
                $pic        = new MtppPic();
                $media      = new Media();
                $request->$imgVar->storeAs('public/answers', time() . $imgName);
                $media->url = 'answers/' . time() . $imgName;
                $media->save();
                $pic->question_id   = $mQues->id;
                $pic->media_id      = $media->id;
                $pic->save();
    
                $mtpp_text          = new MtppText();
                $mtpp_text->text    = $request->$textVar;
                $mtpp_text->pic_id  = $pic->id;
                $mtpp_text->ques_id = $mQues->id;
                $mtpp_text->save();
            }
            // dd(1);
        }
        
        if($request->problem_set_id && $request->format_type_id){
            $pbq = new ProblemSetQues();
            $pbq->problem_set_id = $request->problem_set_id;
            $pbq->question_id = $mQues->id;
            $pbq->format_type_id = $request->format_type_id;
            $pbq->save();
        }
        return back();
    }
    public function update($id, Request $request){
        $q = MtppQues::where('id', $id)->first();
        $q->question = $request->question;
        $q->difficulty_level_id = $request->difficulty_level_id;
        // $q->level = $request->question_level;
        // $q->score = $request->question_score;
        $q->hint = $request->question_hint;
        $q->save();
        $answers = MtppPic::where('question_id', $q->id)->get();
        foreach($answers as $ans){
            $inputMedia = 'image'.$ans->id;
            $inputText = 'text'.$ans->id;
            if($request->$inputMedia){
                $media = new Media();
                $request->$inputMedia->storeAs('public/answers', time() . $request->$inputMedia->getClientOriginalName());
                $media->url = 'answers/' . time() . $request->$inputMedia->getClientOriginalName();
                $media->save();
                $ans->media_id = $media->id;
            }
            $ans->save();
            $text = MtppText::where('pic_id', $ans->id)->first();
            $text->text = $request->$inputText;
            $text->save();
        }
        return back();
    }

    public function imagecsv($question_image, $images){
        foreach($images as $valueImage){
            $uploadImage = explode(".", $valueImage->getClientOriginalName());
            if($uploadImage[0] == $question_image){
                // dd($valueImage);
                $media = new Media();
                $valueImage->storeAs('public/question_images', time() . $valueImage->getClientOriginalName());
                $media->url = 'question_images/' . time() . $valueImage->getClientOriginalName();
                $media->save();
                return $media->id;
            }
        }
    }

    public function csv_upload(Request $request){
        
        $file       = $request->file('file');
        $filename   = time().$file->getClientOriginalName();
        $extension  = $file->getClientOriginalExtension();
        $tempPath   = $file->getRealPath();
        $fileSize   = $file->getSize();
        $mimeType   = $file->getMimeType();

        $images = $request->file('images');
        // Valid File Extensions
        $valid_extension = array("csv");
        // 2MB in Bytes
        $maxFileSize = 2097152;
        // Check file extension
        if (in_array(strtolower($extension), $valid_extension)) {
            // Check file size
            if ($fileSize <= $maxFileSize) {
                // File upload location
                $location = 'uploads/mtpp';
                // Upload file
                $file->move($location, $filename);
                // Import CSV to Database
                $filepath = public_path($location . "/" . $filename);
                // Reading file
                $file = fopen($filepath, "r");
                $importData_arr = array();
                $i = 0;
                while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                    $num = count($filedata);
                    // Skip first row (Remove below comment if you want to skip the first row)
                    if($i == 0){
                        $i++;
                        continue;
                    }
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata[$c];
                    }
                    $i++;
                }
                fclose($file);
                // Insert to MySQL database
                // dd($insertData);
                foreach ($importData_arr as $importData) {
                    $insertData = array(
                        "question"      => $importData[1],
                        "answer1"       => $importData[2],
                        "image1"        => $importData[3],
                        "eng_word1"     => $importData[4],

                        "answer2"       => $importData[5],
                        "image2"        => $importData[6],
                        "eng_word2"     => $importData[7],

                        "answer3"       => $importData[8],
                        "image3"        => $importData[9],
                        "eng_word3"     => $importData[10],

                        "answer4"       => $importData[11],
                        "image4"        => $importData[12],
                        "eng_word4"     => $importData[13],

                        "level"         => $importData[14],
                        "comment"       => $importData[15],
                    );
                    
                        // var_dump($insertData['answer1']); 
                        /*  */
                        if ($insertData['question']) {
                            $fill_Q = new MtppQues();
                            $fill_Q->question = $insertData['question'];
                            // if($request->format_title){
                            //     $fill_Q->format_title = $request->format_title;
                            // }
                            // if ($insertData['comment']) {
                            //     // $fill_Q->hint = $insertData['comment'];
                            // }
                            if(!empty($insertData['level'])){
                                if($insertData['level'] == 'easy'){
                                    $fill_Q->difficulty_level_id = 1;
                                }else if($insertData['level'] == 'medium'){
                                    $fill_Q->difficulty_level_id = 2;
                                }else if($insertData['level'] == 'hard'){
                                    $fill_Q->difficulty_level_id = 3;
                                }else{
                                    $fill_Q->difficulty_level_id = 1;
                                }
                            }
                            $fill_Q->save();
                            if($request->problem_set_id && $request->format_type_id){
                                $pbq = new ProblemSetQues();
                                $pbq->problem_set_id = $request->problem_set_id;
                                $pbq->question_id = $fill_Q->id;
                                $pbq->format_type_id = $request->format_type_id;
                                $pbq->save();
                            }
    
                            for ($x = 1; $x <= 4; $x++) {
                                $f_answer   = $insertData['answer'.$x];
                                $f_image    = $insertData['image'.$x];
                                
                                if ($f_answer == '-') {
                                } else {
                                    $f_Ans1 = new MtppPic();
                                    $f_Ans1->question_id = $fill_Q->id;
                                    if (!empty($f_image) && $f_image != '') {
                                        $media_id = $this->imagecsv($f_image, $images);
                                        $f_Ans1->media_id = $media_id;
                                    }
                                    $f_Ans1->save();
                                    $f_txt = new MtppText();
                                    $f_txt->pic_id  = $f_Ans1->id;
                                    $f_txt->text    = $f_answer;
                                    $f_txt->ques_id = $fill_Q->id;
                                    $f_txt->save();
                                }
                            }
                        }
                        /*  */
                    }
                // Session::flash('message', 'Import Successful.');
            } else {
                // Session::flash('message', 'File too large. File must be less than 2MB.');
            }
        } else {
            // Session::flash('message', 'Invalid File Extension.');
        }
    return back();
}
}
