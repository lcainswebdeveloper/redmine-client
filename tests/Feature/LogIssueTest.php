<?php

use Redmine\Redmine;
use PHPUnit\Framework\TestCase;

final class LogIssueTest extends TestCase
{
    /** @test **/
    public function we_should_be_able_to_validate_and_create_inbound_messages_for_a_client_via_the_api()
    {
        $client = new Redmine(env('REDMINE_BASE_URL'), env('REDMINE_API_KEY'));

        $users = $client->getUsers();
        $this->assertTrue(isset($users->users));
        $this->assertTrue($users->code == 200);

        // $client->createIssue([
        // ]);
    }
}
