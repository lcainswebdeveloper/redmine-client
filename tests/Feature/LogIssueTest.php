<?php

use Redmine\Redmine;
use PHPUnit\Framework\TestCase;

final class LogIssueTest extends TestCase
{
    /** @test **/
    public function we_should_be_able_to_validate_and_create_inbound_messages_for_a_client_via_the_api()
    {
        $client = new Redmine('http://172.17.0.1:8007', '8eeae8ea46345d36379e7d60bef2bd3c1df113f3');

        // $all = $client->user->all();
        // $listing = $client->user->listing();
        $users = $client->getUsers();

        $this->assertTrue(isset($users->users));
    }
}
