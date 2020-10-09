<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Message;
use App\Events\ChatEvent;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index()
    {
        return Message::with('user')->get();
    }

    public function totalMessage()
    {
        return Message::count();
    }

    public function newMessage()
    {
        $today = date("Y-m-d");
        return Message::where('created_at','LIKE', "%$today%")->count();
    }

    public function contacts()
    {
        $contacts = User::where('id', '!=', auth('api')->user()->id)->get();

        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
                    ->where('to', auth('api')->id())
                    ->where('read', false)
                    ->groupBy('from')
                    ->get();
        $contacts = $contacts->map(function($contact) use ($unreadIds){
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });
        return response()->json($contacts);
    }

    public function findContact(){
        if($search = \Request::get('q')){
            $users = User::with(['blood', 'profession'])
                        ->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orWhere('id', '!=', auth('api')->user()->id)
                        ->get();
        }else{
            $users = User::with(['blood', 'profession'])->where('id', '!=', auth('api')->user()->id)->get();
        }
        return $users;
    }

    public function conversation($id)
    {
        Message::where('from', $id)
                ->where('to', auth('api')->id())
                ->update(['read' => true]);

        return Message::where(function($q) use ($id){
            $q->where('from', auth('api')->id());
            $q->where('to', $id);
        })->orWhere(function($q) use ($id){
            $q->where('from', $id);
            $q->where('to', auth('api')->id());
        })->get();
        // return Message::where('from', $id)->orwhere('to', $id)->get();
    }



    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        
    }

    public function send(Request $request)
    {
        $message = Message::create([
            'from' => auth('api')->user()->id,
            'to' => $request['contact_id'],
            'text' => $request['text'],
        ]);

        broadcast(new NewMessage($message));

        return response()->json($message);
    }


    public function sendMessage(Request $request)
    {
        $message = auth('api')->user()->messages()->create(['text' => $request->text]);

        broadcast(new ChatEvent(auth('api')->user(), $message->load('user')))->toOthers();

        return response(['message' => 'Message sent successfully']);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $pro = Message::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|unique:Messages,name,'.$pro->id,
        ]);

        $pro->update($request->all());
    }

    public function destroy($id)
    {
        $pro = Message::findOrFail($id);
        $pro->delete();
    }
}
