<x-homepage>
@section('css')
 <link rel="stylesheet" href="{{asset('css/chat.css')}}">
 <style>
    #comment{
        display: block;
      min-height: 60px;
      max-height: 98px;
      overflow-x: auto;
      width: 99%;
      line-height: 21px;
      padding: 10px;
      font-size: 15px;
      line-height: 25px;
      float: left; 
     border: 2px solid gray;
    }
 </style>
@endsection
    <div class="card" style="margin-top: 50px">
        <div class="card-body">
            <h6>{{$issue->title}}</h6>
            <p>{{$issue->description}}</p>
        </div>
    </div>
        <div class="chat" style="margin-top: 10px">
            <div class="row">
                <div style="overflow-y:scroll; overflow-x:hidden; height: 400px; width:99%; margin:5px; margin-top:20px; background-color:rgba(194, 132, 40, 0.651)">
                    @foreach($comments as $comment)
                            @if($comment->user_id == auth()->user()->id)
                                <div class="chat-message-right pb-4">
                            @else
                                <div class="chat-message-left pb-4">
                            @endif
        
                            @foreach($users as $user)
                                @if($user->id == $comment->user_id)
                                    <div>
                                    <img src="{{asset($user->avatar)}}" class="rounded-circle mr-1" alt="" width="40" height="40" style="margin: 10px">
                                @endif
                            @endforeach
                            <div class="text-muted small text-nowrap mt-2" style="margin: 10px">{{ $comment->created_at->format('g:i a')}}</div>
                                    </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3" style="margin: 10px">
                                 <div class="font-weight-bold mb-1">
                                     <strong>{{ $comment->author->username }}</strong>
                                 </div>
                                      {{ $comment->comment }}
                            </div>
                                </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                @if($issue->status == "pending")
                <form method="POST" action="{{ $issue->id }}" style="text-align: center">
                    @csrf
                    <div class="cont">
                        <div class="row">
                        <div class="col-8 col-md-10">
                            <textarea name="comment" id="comment" cols="50" rows="5" placeholder="{{ __('messages.issue_comment_why')}}"
                              required></textarea>
                        @error('description')
                        <span
                            style="margin: 3px;background-color: #2d3748; border-radius: 5px; color: white">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="col-4 col-md-2" style="text-align: center">
                            <button  type="submit" class="btn btn-dark" data-mdb-ripple-color="dark"
                                style="margin:20px" data-bs-dismiss="modal"> <i class="fa-solid fa-comments"></i> {{ __('messages.issue_comment')}}
                        </button>
                        </div>
                    </div>
                    </div>
                </form>
                @endif
            </div>
        <div>

</x-homepage>
