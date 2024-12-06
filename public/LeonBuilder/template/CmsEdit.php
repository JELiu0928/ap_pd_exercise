{{-- 表名跟哪一筆資料 --}}
<input type="hidden" name="modelName" value="{{ $model }}">
<input type="hidden" name="dataId" value="{{ $data['id'] ?? '' }}" class="editContentDataId">
<input type="hidden" name="{{$model}}[branch_id]" value="{{$baseBranchId}}">
<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="menu_id" value="{{$menu_id}}">
<input type="hidden" name="{{$model}}[temp_url]" value="">
<!--內容-->
<div class="backEnd_quill">
    <article class="work_frame">
        <section class="content_box">
            <div class="for_ajax_content">
                <section class="content_a">
                    <ul class="frame">
                        
                    </ul>
                </section>
            </div>
        </section>
    </article>
</div>
