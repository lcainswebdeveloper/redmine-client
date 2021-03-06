<?php

namespace LCainsWebDeveloper;

use LCainsWebDeveloper\Client\Guzzle;

class Redmine
{
    public function __construct($baseUri, $apiKey)
    {
        $this->client = new Guzzle($baseUri, $apiKey);
    }

    public function getUsers()
    {
        $response = $this->client->get('users.json');

        return $response->getApiResponse();
    }

    /*
    Refer to https://www.redmine.org/projects/redmine/wiki/Rest_Issues#Creating-an-issue
    for request details, also LogIssueTest.php for a working example
    */
    public function createIssue($issue)
    {
        $updateData = $issue + [
            'project_id' => env('REDMINE_PROJECT_ID', null),
        ];
        $response = $this->client->post('issues.json', [
            'issue' => $issue,
        ]);

        return $response->getApiResponse();
    }

    /*
    Refer to https://www.redmine.org/projects/redmine/wiki/Rest_Issues#Creating-an-issue
    for request details, also IssueTest.php for a working example
    */
    public function updateIssue(int $issueId, $issue)
    {
        $createData = $issue + [
            'project_id' => env('REDMINE_PROJECT_ID', null),
        ];
        $response = $this->client->put('issues/'.$issueId.'.json', [
            'issue' => $createData,
        ]);

        return $response->getApiResponse();
    }
}
