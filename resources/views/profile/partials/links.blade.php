<a href="{{route('story.edit',['story' => $oneStory->id])}}" class="card-link">Edit</a>
{{--<a href="{{route('story.share',['story' => $oneStory->id])}}" class="card-link">Share</a>--}}
<a href="" class="card-link"
   onclick="event.preventDefault();
               document.getElementById('make_share_link_for_story').submit();">
    edit</a>
<a href="" class="card-link"
   onclick="event.preventDefault();
               document.getElementById('delete_own_user_story_form').submit();">
    Delete</a>
<form id="make_share_link_for_story" action="{{ route('story.share',['story' => $oneStory->id]) }}" method="POST">
    @csrf
    @method('PUT')
</form>
<form id="delete_own_user_story_form" action="{{ route('story.destroy',['story' => $oneStory->id]) }}" method="POST">
    @csrf
    @method('DELETE')
</form>