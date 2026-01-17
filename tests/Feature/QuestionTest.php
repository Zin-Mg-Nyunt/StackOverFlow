<?php

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// Positive Path
// C
test('authenticated users can create question', function () {
    // Arrange
    $user=User::factory()->create();
    Storage::fake('public');
    $image_url = UploadedFile::fake()->image('question.jpg');

    // Act
    $response=$this->actingAs($user)->post('/questions/store',[
        'title' => 'Laravel မှာ Test code ဘယ်လိုရေးရမလဲ?',
        'slug' => 'test-question',
        'body' => 'ကျွန်တော် Pest testing ကို လေ့လာချင်လို့ပါ။ ရှင်းပြပေးပါဦး။',
        'tags' => [['name'=>'laravel'],['name'=>'testing']],
        'image_url' => $image_url
    ]);

    // Assert
    $response->assertStatus(302);
    $this->assertDatabaseHas('questions',[
        'title' => 'Laravel မှာ Test code ဘယ်လိုရေးရမလဲ?',
        'user_id' => $user->id
    ]);
    Storage::disk('public')->assertExists('questions/'. $image_url->hashName());
});
// R
test('anyone can see question detail', function(){
    $question=Question::factory()->create(['title'=>'How to write test code in laravel?']);
    
    $response=$this->get("/questions/{$question->slug}");

    $response->assertStatus(200);
    $response->assertSee('How to write test code in laravel?');
});
// U
test('it updates a question with valid data',function(){
    $user = User::factory()->create();
    $question = Question::factory()->create(['title'=>'Old Title','user_id'=>$user->id]);
    $updateData = [
        'title'=>'Update Title',
        'slug' => 'update-title',
        'body' => 'This is a long enough body text for validation (min: 20).',
        'tags' => [['name'=>'laravel']],
        'user_id' => $user->id
    ];

    $response = $this->actingAs($user)->put("/questions/{$question->slug}/update",$updateData);

    $response->assertSessionHasNoErrors();
    $response->assertStatus(302);
    $this->assertDatabaseMissing('questions',[
        'title'=>$question->title,
        'slug' => $question->slug
    ]);
    $this->assertDatabaseHas('questions',[
        'title'=>$updateData['title'],
        'slug' => $updateData['slug']
    ]);
});
// D
test('question owner can delte own questions',function(){
    Storage::fake('public');
    $user = User::factory()->create();
    $imageFile = UploadedFile::fake()->image('test.jpg');
    $image_url = $imageFile->store('questions','public');
    $question = Question::factory()->create(['user_id'=>$user->id,'image_url'=>$image_url]);

    $response=$this->actingAs($user)->delete("/questions/{$question->id}/delete");

    $response->assertStatus(302);
    $this->assertModelMissing($question);
    Storage::disk('public')->assertMissing($image_url);
});

// Negative Path
test('it fails update question with invalid data', function(){
    $user = User::factory()->create();
    $question = Question::factory()->create(['user_id'=>$user->id]);

    $response = $this->actingAs($user)->put("/questions/{$question->slug}/update",[
        'title'=>'',
        'body' => 'valid body data',
    ]);

    $response->assertSessionHasErrors(['title','slug','tags']);
    $this->assertDatabaseHas('questions',[
        'title'=>$question->title,
        'body'=>$question->body
    ]);
});

test('it fails update to other else questions',function(){
    $user = User::factory()->create();
    $hacker = User::factory()->create();
    $question = Question::factory()->create(['user_id'=>$user->id]);

    $response=$this->actingAs($hacker)->put("/questions/{$question->slug}/update",[
        'title'=>'Update title'
    ]);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('questions',[
        'title'=>'Update title'
    ]);
    $this->assertDatabaseHas('questions',[
        'title'=>$question->title,
        'user_id' => $user->id
    ]);
});