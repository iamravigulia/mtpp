<style>
    table {
        background: #fff;
        width: 100%;
        border: 0;
    }
    th {}
    td {
        border-top: 1px solid #999;
        padding: 5px;
    }
    tr:nth-child(odd) {
        background: #ddd;
    }
</style>
<table>
    <thead>
        <th>#</th>
        <th>Question</th>
        <th>Answers</th>
        <th>Created at</th>
        <th>Updated at</th>
    </thead>
    <tbody>
        @php
        $fmt_mtpques = DB::table('fmt_matchthepairs_ques')->get();
        @endphp
        @foreach ($fmt_mtpques as $que)
        <tr>
            <td>{{$que->id}}</td>
            <td>{{$que->question}}</td>
            <td>
                @php $fmt_mtp_ans = DB::table('fmt_matchthepairs_ans')->where('question_id', $que->id)->get() @endphp
                <table>
                    @foreach ($fmt_mtp_ans as $ans)
                    @if ($ans->match_id)
                        <tr>
                            <td>{{$ans->answer}}</td>
                        </tr>
                        @else
                        <tr>
                            <td>{{$ans->answer}}</td>
                        </tr>
                    @endif
                    @endforeach
                </table>
            </td>
            <td>{{date('F d, Y',strtotime($que->created_at))}}</td>
            <td>{{date('F d, Y',strtotime($que->updated_at))}}</td>
        </tr>
        <x-mtp.edit :message="$que->id"/>
        @endforeach
    </tbody>
</table>
<script>
    function modalMTP($id){
        var modal = document.getElementById('modalMTP'+$id);
        modal.classList.remove("hidden");
    }
    function closemodalMTP($id){
        var modal = document.getElementById('modalMTP'+$id);
        modal.classList.add("hidden");
    }
</script>