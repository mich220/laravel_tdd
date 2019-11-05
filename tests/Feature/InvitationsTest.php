<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function non_owners_may_not_invite_users()
    {
        $this->actingAs(factory(User::class)->create())
            ->post(ProjectFactory::create()->path() . '/invitations')
            ->assertStatus(403);
    }

    /** @test */

    function a_project_owner_can_invite_user()
    {
        $project = ProjectFactory::create();

        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => $userToInvite->email
            ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */

    function the_invited_email_address_must_be_associated_with_a_valid_birdboard_account()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => 'user@mail.com'
            ])
            ->assertSessionHasErrors([
                'email' => 'The user You inviting must have a BirdBoard account.'
            ]);

    }


    /** @test */

    public function invited_users_may_update_project_details()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $newUser = factory(User::class)->create();
        $project->invite($newUser);

        $this->actingAs($newUser)->post(action('ProjectTasksController@store', $project), $task = ['body' => 'Foo task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
