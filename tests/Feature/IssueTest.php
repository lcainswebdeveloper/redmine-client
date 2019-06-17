<?php

use LCainsWebDeveloper\Redmine;
use PHPUnit\Framework\TestCase;

final class IssueTest extends TestCase
{
    /** @test **/
    public function we_should_be_able_to_get_redmine_users()
    {
        $client = new Redmine(env('REDMINE_BASE_URL'), env('REDMINE_API_KEY'));

        $users = $client->getUsers();
        $this->assertTrue(isset($users->users));
        $this->assertTrue($users->code == 200);
    }

    /** @test **/
    public function we_should_be_able_to_create_an_issue_in_redmine()
    {
        $client = new Redmine(env('REDMINE_BASE_URL'), env('REDMINE_API_KEY'));
        //PLEASE MAKE SURE ALL REQUIRED VALUES BELOW EXIST
        $validIssue = $client->createIssue([
            'project_id' => 1, //required but defaults to env('REDMINE_PROJECT_ID') if available
            'tracker_id' => 1, //required
            'status_id' => 1, //required
            'priority_id' => 1, //required
            'subject' => 'My test issue', //required
            'description' => 'A test description',
            'assigned_to_id' => 5,
            'estimated_hours' => 3,
        ]);

        $this->assertTrue($validIssue->code == 201);
        $this->assertTrue(!isset($validIssue->data->errors));
    }

    /** @test **/
    public function we_should_be_able_to_update_an_issue_in_redmine()
    {
        $client = new Redmine(env('REDMINE_BASE_URL'), env('REDMINE_API_KEY'));
        //PLEASE MAKE SURE ALL REQUIRED VALUES BELOW EXIST
        $validIssue = $client->updateIssue(1, [
            'notes' => 'Here are some notes from a test',
        ]);
        $this->assertTrue($validIssue->code == 200);
        $this->assertTrue(!isset($validIssue->data->errors));
    }
}

/*
//THE BELOW WILL ONLY WORK IF WE HAVE SETUP THE RELEVANT TRACKERS/STATUSES
// ETC FOR ISSUES IN THE REDMINE UI ITSELF THAT WE ARE POSTING TO

// IN THEORY THE BELOW SHOULD THROW VALIDATION ERRORS BUT REDMINE SENDS BACK A 500 RESPONSE WHICH
// ISNT WHAT WE ARE LOOKING FOR, SO THIS TEST IS COMMENTED OUT FOR NOW
// $invalidIssue = $client->createIssue([
//     'project_id' => '', //required
//     'tracker_id' => '', //required
//     'status_id' => '', //required
//     'priority_id' => '', //required
//     'subject' => '', //required
//     'description' => '',
//     'category_id' => '',
//     'fixed_version_id' => '',
//     'assigned_to_id' => '',
//     'parent_issue_id' => '',
//     'custom_fields' => '',
//     'watcher_user_ids' => '',
//     'is_private' => '',
//     'estimated_hours' => '',
// ]);
// $this->assertTrue($invalidIssue->code == 422);
// $this->assertTrue(isset($invalidIssue->data->errors));
*/
