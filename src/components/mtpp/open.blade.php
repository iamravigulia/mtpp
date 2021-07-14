<div>
    <style>
        .fmt_box{
            margin: 10px 20px;
            padding: 10px 20px;
            border: 4px solid #eeeeee;
            background: #fff;
            box-shadow: 2px 4px 8px #b1b1b1;
        }
        .fmt_headline{
            font-size: 20px;
            margin:10px 0;
        }
        .fmt_label{
            font-size: 14px;
        }
        .fmt_input{
            padding:4px 10px;
            border:1px solid #707070;
            border-radius: 4px;
            display: block;
            font-size: 16px;
        }
        .fmt_sub_btn{
            padding:6px 20px;
            margin:10px 0;
            border-radius: 8px;
            background:#0047d4;
            color:#fff;
            border:none;
            letter-spacing: 1px;
            cursor: pointer;
        }
        .fmt_checkbox{
            width: 22px;
            height: 22px;
            display: block;
        }
        .fmt_flex{
            display: flex;
            margin: 10px 0;
        }
        #addOption{
            padding: 6px 20px;
            background: #049e04;
            color: #fff;
            cursor: pointer;
        }
    </style>
    <form action="{{route('fmt.mtpp.store')}}" method="post" class="fmt_box" enctype="multipart/form-data">
        <input type="integer" name="problem_set_id" value="{{$pbs72 ?? ''}}" hidden style="border:1px solid #000000;">
        <input type="integer" name="format_type_id" value="{{$fmt72 ?? ''}}" hidden style="border:1px solid #000000;">
        <div class="fmt_headline">Add a Match the pairs with picture Question</div>
        <div>
            <label class="fmt_label" for="">Question</label>
            <textarea class="fmt_input w-100" type="text" name="question" placeholder="Question" ></textarea>
        </div>
        <div class="my-2" style="margin: 20px 0;">
            <label class="bloc" for="">Difficulty Level</label>
            @php $d_levels = DB::table('difficulty_levels')->get(); @endphp
            <select name="difficulty_level_id" id="" class="w-full my-2 px-2 py-2 border border-gray-500 rounded-lg">
                @foreach ($d_levels as $level)
                <option value="{{$level->id}}">{{$level->name}}</option>
                @endforeach
            </select>
        </div>
        <hr>
        @php
            $colls = [1,2,3,4];
        @endphp
        @foreach ($colls as $c => $col)
        <div class="flex flex-items">
            <div>
                <label class="fmt_label" for="">Image {{$col}}</label>
                <input class="fmt_input" type="file"  name="media_{{$col}}" accept="image/*" placeholder="Media" >
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">Text {{$col}}</label>
                <input class="fmt_input" type="text" name="text_{{$col}}" placeholder="Text" >
            </div>
        </div>
        @endforeach
        <div>
            <input type="submit" class="fmt_sub_btn" value="Submit">
        </div>
    </form>
    {{-- <button id="addOption">Add option</button> --}}
    {{--  --}}
    <div class="my-12 py-4 px-4 border border-gray-400 shadow-lg">
        <div>Import csv</div>
        <form class="flex" action="{{route('fmt.mtpp.csv_upload')}}" method="POST" enctype='multipart/form-data'>
            @csrf
            <input type="integer" name="problem_set_id" value="{{$pbs72 ?? ''}}" hidden style="border:1px solid #000000;">
            <input type="integer" name="format_type_id" value="{{$fmt72 ?? ''}}" hidden style="border:1px solid #000000;">
            <div style="display:block; padding:10px; width:100%;">
                <label style="font-size:12px;">Format Title</label>
                <input class="fmt_input" type="text" name="format_title" placeholder="format_title">
            </div>
            <div style="display:block; padding:10px; width:100%;">
                <div style="font-size:12px;">CSV</div>
                <input style="display:block;" type="file" name="file" required>
            </div>
            <div style="display:block; padding:10px; width:100%;">
                <div style="font-size:12px;">Images</div>
                <input style="display:block;" type="file" name="images[]" multiple accept="image/*" placeholder="image" required>
            </div>
            <button type="submit" style="display: inline-block; padding:4px 20px; background:green; color:#fff; text-transform:uppercase; border-radius:4px;">submit</button>
        </form>
    </div>
    {{--  --}}
</div>
{{-- <script>
    var addOption = document.getElementById('addOption');

</script> --}}