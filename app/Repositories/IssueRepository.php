<?php
namespace App\Repositories;
use App\Models\Issue;
use App\Models\User;

class IssueRepository {

    public function getIssue(int $id){
        return Issue::find($id);
    }

    public function getCountIssues(){
        return Issue::where('status', '=', 'pending')->count();
    }

    public function createIssue(int $id, string $title, string $description, string $type){
        $issue = Issue::create([
            'reported_by_id' => request()->user()->id,
            'title' => request('title'),
            'description' => request('description'),
            'type'  => request('type'),
            'status' => 'pending',
            'reported_on' => date("Y-m-d H:i:s")
        ]);

        return $issue;
    }

    public function getAnimalPendingIssues(){
        $issues =   Issue::orderBy('created_at', 'desc')->where('status', '=', 'pending')->where('type', '=', 'animals')->get();
        return $issues;
    }

    public function getMachinePendingIssues(){
        $issues =   Issue::orderBy('created_at', 'desc')->where('status', '=', 'pending')->where('type', '=', 'machines')->get();
        return $issues;
    }

    public function getFieldPendingIssues(){
        $issues =   Issue::orderBy('created_at', 'desc')->where('status', '=', 'pending')->where('type', '=', 'field')->get();
        return $issues;
    }

    public function getOtherPendingIssues(){
        $issues =   Issue::orderBy('created_at', 'desc')->where('status', '=', 'pending')->where('type', '=', 'other')->get();
        return $issues;
    }

    public function getAnimalClosedIssues(){
        $issues =   Issue::orderBy('updated_at', 'desc')->where('status', '=', 'closed')->where('type', '=', 'animals')->get();
        return $issues;
    }

    public function getMachineClosedIssues(){
        $issues =   Issue::orderBy('updated_at', 'desc')->where('status', '=', 'closed')->where('type', '=', 'machines')->get();
        return $issues;
    }

    public function getFieldClosedIssues(){
        $issues =   Issue::orderBy('updated_at', 'desc')->where('status', '=', 'closed')->where('type', '=', 'field')->get();
        return $issues;
    }

    public function getOtherClosedIssues(){
        $issues =   Issue::orderBy('updated_at', 'desc')->where('status', '=', 'closed')->where('type', '=', 'other')->get();
        return $issues;
    }

    public function close($id){
        $issue = $this->getIssue($id);
        $issue->status = 'closed';
        $issue->save();
        return $issue;
    }


}