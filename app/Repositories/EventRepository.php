<?php
namespace App\Repositories;
use App\Models\Event;


class EventRepository {

public function createEvent($title, $type ,$start, $end , $code = 0, $color){
    $event = Event::create([
        'title' => $title,
        'type' => $type,
        'start' => $start,
        'end' => $end,
        'animal_code' => $code,
        'color' => $color
    ]);

    return response()->json($event);
}

public function createAnimalEvent($title, $type ,$start, $end , $code = 0){
    $event = Event::create([
        'title' => $title,
        'type' => $type,
        'start' => $start,
        'end' => $end,
        'animal_code' => $code,
        'color'      => 'green'
    ]);

    return response()->json($event);
}

public function getEvent($id){
    $event = Event::find($id);
    return $event;
}

public function getEvents(){
    $event = Event::all();
    return $event;
}

public function getAnimalRelatedEvents($code){
    $events = Event::where('animal_code', '=', $code)->get();
    return $events ;
}

public function deleteEvent($id){
    $event = Event::find($id)->delete();
    return response()->json($event);
}

public function getNumRelatedPassedEvents($code){
    $events = Event::where('animal_code', '=', $code)
                    ->where('end','<=', date('Y-m-d'))->get();
    $n_events = count($events);                
    return $n_events ;
}

public function updateEvent($title, $type){
    $event = Event::where('title', '=', $title)->first();
    $event->type = $type;
    $event->save();
    return $event;
}

}