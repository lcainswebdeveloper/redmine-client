# Redmine
Small service for logging errors to Redmine.   
At the moment this is the only functionality but we can expand in due course or feel free to contribute.

### Installation from Composer
- composer ```composer require lcainswebdeveloper/redmine-client```

### Configuration
- All you will need to do is set a ```REDMINE_BASE_URL```for your Redmine instance and your ```REDMINE_API_KEY``` which you can create inside of your Redmine UI. I'd recommend you put this in an env file. Optionally you can also add a `REDMINE_PROJECT_ID` which can be used as a default if we don't provide a `project_id` on any request

### To create an issue
This service delegates straight to the Redmine API itself so arguments can be passed as expected for all calls. Please feel free to look at the tests for usage also.   
Creating an issue (simple example):
```
use LCainsWebdeveloper\Redmine;
$client = new Redmine(REDMINE_BASE_URL, REDMINE_API_KEY);
$validIssue = $client->createIssue([
    'project_id' => 1, //required - must exist also - can default to your REDMINE_PROJECT_ID env var if given'
    'tracker_id' => 1, //required - must exist also
    'status_id' => 1, //required - must exist also
    'priority_id' => 1, //required - must exist also
    'subject' => 'My test issue', //required
    'description' => 'Your description',
    'assigned_to_id' => 1, //a user id that must exist
    'estimated_hours' => 3,
]);
```
The response mirrors the response from the API itself

### To create an issue
This service delegates straight to the Redmine API itself so arguments can be passed as expected for all calls. Please feel free to look at the tests for usage also.   
Creating an issue (simple example):
```
use LCainsWebdeveloper\Redmine;
$client = new Redmine(REDMINE_BASE_URL, REDMINE_API_KEY);
$validIssue = $client->createIssue([
    'project_id' => 1, //required - must exist also
    'tracker_id' => 2,
    'notes' => 'A note that can be added to your issue'
]);
```
The response mirrors the response from the API itself - blanket 200 responses if successful

All Redmine class methods have a link to the Redmine documentation in the method docs.