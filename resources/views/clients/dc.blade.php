<div class="col-12">
    <div class="form-group">
        <label for="comments">Comments</label>
        <textarea class="comment-textarea" name="comment" id="comments" cols="10" rows="5" placeholder="Please enter your comments"></textarea>
    </div>
</div>
<input type="hidden" name="wrc_id" value="{{$id}}">
<div class="col-12">
    <button type="submit" class="btn comment-submit-btn" id="commentBTN">
        Submit
    </button>