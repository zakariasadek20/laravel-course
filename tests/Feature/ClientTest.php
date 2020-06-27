<?php

namespace Tests\Feature;

use App\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testIndexValide()
    // {
    //     $response = $this->get('/clients');

    //     $response->assertSeeText('List of Client');
    // }
    // public function testCreateValide(){
    //     $response=$this->get('clients/create');
    //     $response->assertSeeText('New post');
    // }
    public function testSavePost(){
        $client=new Client();
        $client->nom='Sadek';
        $client->prenom='Pren';
        $client->email='emaiil';
        $client->tele='06769785';
        $client->save();
        $this->assertDatabaseHas('clients',['nom'=>'Sadek']);
    }
    // public function testStoreClient(){
    //     $data=[
    //         'nom'=>'Sadek',
    //         'prenom'=>'zakaria',
    //         'email'=>'zakaria@gmail.com',
    //         'tele'=>'067697'
    //     ];
    //     $this->post('/clients',$data)
    //     ->assertStatus(302)
    //     ->assertSessionHas('status');
    //     $this->assertEquals(session('status'),'client was created');

    // }
    // public function testStoreClientFail(){
    //     $data=[
    //         'nom'=>'',
    //         'prenom'=>'',
    //         'email'=>'',
    //         'tele'=>''
    //     ];
    //     $this->post('clients',$data)
    //     ->assertStatus(302)
    //     ->assertSessionHas('status');
    //     $messages=session('errors');
    //     $this->assertEquals($messages['nom'][0],'The nom field is required.');
    // }
}
