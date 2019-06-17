# Redmine
Small service for logging errors to Redmine.   
At the moment this is the only functionality but we can expand in due course or feel free to contribute.

### Installation from Composer
- composer ```composer require lcainswebdeveloper/redmine-client```

### Configuration
- All you will need to do is set a ```BASE_URL```for your Redmine instance and your ```REDMINE_API_KEY``` which you can create inside of your Redmine UI. I'd recommend you put this in an env file

### To create an issue
This service delegates straight to the Redmine API itself so arguments can be passed as expected for all calls. Please feel free to look at the tests for usage also.   
Creating an issue (simple example):
```
use Redmine\Redmine;
$client = new Redmine(REDMINE_BASE_URL, REDMINE_API_KEY);
$validIssue = $client->createIssue([
    'project_id' => 1, //required - must exist also
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
